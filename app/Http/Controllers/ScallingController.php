<?php

namespace App\Http\Controllers;

use App\Models\ScallingData;
use App\Models\ScallingImport;
use App\Models\FunnelTracking;
use App\Models\TaskProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ScallingController extends Controller
{
    // ── LAYOUT EXCEL ─────────────────────────────────────────────────────────
    private const HEADER_ROW     = 3;  // Baris ke-5: header kolom (NO, PROJECT, dst.)
    private const DATA_START_ROW = 7;  // Baris ke-7: data pertama
    private const MAX_COL        = 9;  // Kolom A(1) s/d I(9)

    // ── MAPPING HEADER EXCEL → KOLOM DATABASE ────────────────────────────────
    private array $columnMap = [
        'NO'                       => 'no',
        'PROJECT'                  => 'project',
        'ID LOP'                   => 'id_lop',
        'CC'                       => 'cc',
        'NIPNAS'                   => 'nipnas',
        'AM'                       => 'am',
        'MITRA'                    => 'mitra',
        'PLAN BULAN BILLCOMP 2025' => 'plan_bulan_billcomp_2025',
        'EST NILAI BC'             => 'est_nilai_bc',
    ];

    // ── HALAMAN ───────────────────────────────────────────────────────────────

    public function indexGov()
    {
        return view('admin.scalling.gov.gov', $this->sharedViewData());
    }

    public function indexSoe()
    {
        return view('admin.scalling.soe.soe', $this->sharedViewData());
    }

    public function indexSme()
    {
        return view('admin.scalling.sme.sme', $this->sharedViewData());
    }

    public function indexPrivate()
    {
        return view('admin.scalling.private.private', $this->sharedViewData());
    }

    public function onHandGov()
    {
        $logs= ScallingImport::where('type', 'on-hand')->where('segment', 'government')->latest()->paginate(10);
        $projects = ScallingData::with('scallingImport')->latest()->paginate(20);
        return view('admin.scalling.gov.onHand', compact('logs', 'projects'));
    }
    public function koreksiGov()
    {
        $logs= ScallingImport::where('type', 'koreksi')->where('segment', 'government')->latest()->paginate(10);
        $projects = ScallingData::with('scallingImport')->latest()->paginate(20);
        return view('admin.scalling.gov.koreksi', compact('logs', 'projects'));
    }
    public function qualifiedGov()
    {
        $logs= ScallingImport::where('type', 'qualified')->where('segment', 'government')->latest()->paginate(10);
        $projects = ScallingData::with('scallingImport')->latest()->paginate(20);
        return view('admin.scalling.gov.qualified', compact('logs', 'projects'));
    }

    public function onHandSme()
    {
        return view('admin.scalling.sme.onHand', $this->sharedViewData());
    }

    public function onHandSoe()
    {
        return view('admin.scalling.soe.onHand', $this->sharedViewData());
    }

    public function onHandPrivate()
    {
        $logs= ScallingImport::where('type', 'on-hand')->where('segment', 'private')->latest()->paginate(10);
        $projects = ScallingData::with('scallingImport')->latest()->paginate(20);
        return view('admin.scalling.private.onHand', compact('logs', 'projects'));
    }
    public function koreksiPrivate()
    {
        $logs= ScallingImport::where('type', 'koreksi')->where('segment', 'private')->latest()->paginate(10);
        $projects = ScallingData::with('scallingImport')->latest()->paginate(20);
        return view('admin.scalling.private.koreksi', compact('logs', 'projects'));
    }
    public function qualifiedPrivate()
    {
        $logs= ScallingImport::where('type', 'qualified')->where('segment', 'private')->latest()->paginate(10);
        $projects = ScallingData::with('scallingImport')->latest()->paginate(20);
        return view('admin.scalling.private.qualified', compact('logs', 'projects'));
    }

    // ── IMPORT ────────────────────────────────────────────────────────────────

    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => ['required', 'file', 'mimes:xlsx,xls,csv', 'max:10240'],
        ], [
            'excel_file.required' => 'File Excel wajib diunggah.',
            'excel_file.mimes'    => 'File harus berformat .xlsx, .xls, atau .csv.',
            'excel_file.max'      => 'Ukuran file maksimal 10 MB.',
        ]);
        $request->validate([
            'periode'     => 'required|date_format:Y-m',
            'type'       => 'required|nullable',
            'segment'    => 'required|nullable',
        ]);
        $periodeDate = $request->periode . '-01';

        $file             = $request->file('excel_file');
        $originalFilename = $file->getClientOriginalName();
        $tempPath         = $file->getRealPath();

        try {
            // ── 1. Baca & parsing Excel dulu — SEBELUM menyentuh database ──
            $spreadsheet = IOFactory::load($tempPath);
            $sheet       = $spreadsheet->getActiveSheet();

            $headerMap  = $this->readAndValidateHeaders($sheet);
            $rows       = [];
            $highestRow = $sheet->getHighestRow();

            for ($rowIndex = self::DATA_START_ROW; $rowIndex <= $highestRow; $rowIndex++) {
                if ($this->isTotalRow($sheet, $rowIndex)) {
                    break;
                }

                $rowData = $this->readRow($sheet, $rowIndex, $headerMap);

                if ($this->isRowEmpty($rowData)) {
                    continue;
                }

                $rows[] = $rowData; // belum ada log id, ditambahkan setelah log dibuat
            }

            if (empty($rows)) {
                throw new \Exception('Tidak ada data valid yang ditemukan di dalam file Excel.');
            }

            // ── 2. Semua parsing berhasil — baru simpan ke database ──
            DB::transaction(function () use ($rows, $originalFilename, $request, $periodeDate) {
                // cek apakah sudah ada log dengan periode yang sama
                $log = ScallingImport::where('periode', $periodeDate)->where('type', $request->type)->where('segment', $request->segment)->first();

                if ($log) {
                    // gunakan kembali log yang ada dan hapus data lama
                    $log->update([
                        'original_filename'   => $originalFilename,
                        'status'              => 'active',
                        'type'                => $request->type,
                        'segment'             => $request->segment,
                        'total_rows_imported' => count($rows),
                        'uploaded_by'         => auth()->user()->name ?? $request->ip(),
                    ]);

                    // hapus data scalling yang lama, tetapi kumpulkan id baris terlebih dahulu
                    $scallingIds = ScallingData::where('imports_log_id', $log->id)->pluck('id')->toArray();
                    $funnelIds = FunnelTracking::where('data_id', $log->id)->pluck('id')->toArray();
                    ScallingData::where('imports_log_id', $log->id)->delete();

                    // tambahan: hapus entri taskProgress dan FunnelTracking berdasarkan id scallingData
                    if (!empty($scallingIds)) {
                        FunnelTracking::whereIn('data_id', $scallingIds)->delete();
                        TaskProgress::whereIn('task_id', $funnelIds)->delete();
                    }
                } else {
                    // buat log baru
                    $log = ScallingImport::create([
                        'original_filename'   => $originalFilename,
                        'status'              => 'active',
                        'type'                => $request->type,
                        'segment'             => $request->segment,
                        'periode'             => $periodeDate,
                        'total_rows_imported' => count($rows),
                        'uploaded_by'         => auth()->user()->name ?? $request->ip(),
                    ]);
                }

                // Sisipkan foreign key ke setiap baris
                $timestamp  = now();
                $insertRows = array_map(fn($row) => array_merge($row, [
                    'imports_log_id' => $log->id,
                    'created_at'     => $timestamp,
                    'updated_at'     => $timestamp,
                ]), $rows);

                foreach (array_chunk($insertRows, 500) as $chunk) {
                    ScallingData::insert($chunk);
                }
            });

            // ── 3. Hapus file setelah semua berhasil ──
            @unlink($tempPath);

            $count = count($rows);
            return redirect()->route('admin.scalling.gov.on-hand')
                ->with('success', "Import berhasil! {$count} baris diimpor dari \"{$originalFilename}\".");

        } catch (\Throwable $e) {
            // Tidak ada log yang disimpan — hapus file lalu tampilkan pesan error saja
            @unlink($tempPath);

            return redirect()->route('admin.scalling.gov.on-hand')
                ->with('error', 'Import gagal: ' . $e->getMessage());
        }
    }

    // ── SHOW / DESTROY ────────────────────────────────────────────────────────

    public function show(ScallingImport $scallingImport)
    {
        $projects = $scallingImport->scallingData()->paginate(20);
        return view('admin.scalling.show', compact('scallingImport', 'projects'));
    }

    public function destroy(ScallingImport $scallingImport)
    {
        DB::transaction(function () use ($scallingImport) {
            $scallingImport->scallingData()->delete();
            $scallingImport->delete();
        });

        return redirect()->route('admin.scalling.index')
            ->with('success', 'Log dan data terkait berhasil dihapus.');
    }

    // ── PRIVATE HELPERS ───────────────────────────────────────────────────────

    private function sharedViewData(): array
    {
        return [
            'logs'     => ScallingImport::latest()->paginate(10),
            'projects' => ScallingData::with('scallingImport')->latest()->paginate(20),
        ];
    }

    /**
     * Baca header dari baris HEADER_ROW.
     * Salin konstanta ke variable lokal dulu sebelum digunakan sebagai string.
     */
    private function readAndValidateHeaders(Worksheet $sheet): array
    {
        $headerMap    = [];
        $foundHeaders = [];
        $headerRow    = self::HEADER_ROW; // wajib disalin ke variable

        for ($col = 1; $col <= self::MAX_COL; $col++) {
            $coordinate = Coordinate::stringFromColumnIndex($col) . $headerRow; // "A5", "B5", dst.
            $rawValue   = $sheet->getCell($coordinate)->getValue();
            $normalized = preg_replace('/\s+/', ' ', strtoupper(trim((string) $rawValue)));

            if (isset($this->columnMap[$normalized])) {
                $headerMap[$col] = $this->columnMap[$normalized];
                $foundHeaders[]  = $normalized;
            }
        }

        if (!in_array('NO', $foundHeaders) || !in_array('PROJECT', $foundHeaders)) {
            $found = implode(', ', $foundHeaders) ?: '(tidak ada)';
            throw new \Exception(
                "Header tidak ditemukan di baris ke-" . self::HEADER_ROW . ". " .
                "Kolom terbaca: {$found}. Pastikan header NO dan PROJECT ada di baris " . self::HEADER_ROW . "."
            );
        }

        return $headerMap;
    }

    /**
     * Cek apakah baris $rowIndex adalah baris TOTAL.
     * Menerima Worksheet + nomor baris — bukan array rowData.
     * Loop di-break saat ini ditemukan, sehingga baris TOTAL tidak pernah masuk DB.
     */
    private function isTotalRow(Worksheet $sheet, int $rowIndex): bool
    {
        $rowNum = $rowIndex; // salin ke variable biasa

        for ($col = 1; $col <= self::MAX_COL; $col++) {
            $coordinate = Coordinate::stringFromColumnIndex($col) . $rowNum;
            $value      = strtoupper(trim((string) $sheet->getCell($coordinate)->getValue()));

            if (str_contains($value, 'TOTAL')) {
                return true;
            }
        }

        return false;
    }

    /**
     * Baca satu baris. Gunakan getValue() agar nilai numerik tidak berubah format.
     */
    private function readRow(Worksheet $sheet, int $rowIndex, array $headerMap): array
    {
        $rowData = [];
        $rowNum  = $rowIndex; // salin ke variable biasa

        for ($col = 1; $col <= self::MAX_COL; $col++) {
            if (!isset($headerMap[$col])) continue;

            $dbColumn   = $headerMap[$col];
            $coordinate = Coordinate::stringFromColumnIndex($col) . $rowNum; // "A7", dst.
            $raw        = $sheet->getCell($coordinate)->getValue();
            $cellValue  = trim((string) $raw);

            if (in_array($dbColumn, ['no', 'plan_bulan_billcomp_2025'])) {
                $cellValue = is_numeric($cellValue) ? (int) $cellValue : null;

            } elseif ($dbColumn === 'est_nilai_bc') {
                // Nilai sudah float dari Excel? langsung pakai
                if (is_numeric($raw)) {
                    $cellValue = (float) $raw;
                } else {
                    // Fallback: parse format Indonesia 457.854.960
                    $clean = preg_replace('/[^\d,.]/', '', $cellValue);
                    $clean = str_replace('.', '', $clean);
                    $clean = str_replace(',', '.', $clean);
                    $cellValue = is_numeric($clean) ? (float) $clean : null;
                }

            } else {
                $cellValue = ($cellValue === '') ? null : $cellValue;
            }

            $rowData[$dbColumn] = $cellValue;
        }

        return $rowData;
    }

    /** True jika semua nilai di baris kosong/null. */
    private function isRowEmpty(array $rowData): bool
    {
        foreach ($rowData as $value) {
            if ($value !== null && $value !== '') return false;
        }
        return true;
    }
}