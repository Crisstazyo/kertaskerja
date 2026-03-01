<?php

namespace App\Http\Controllers;

use App\Models\ScallingData;
use App\Models\ScallingImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ScallingController extends Controller
{
    // ── LAYOUT EXCEL ─────────────────────────────────────────────────────────
    private const HEADER_ROW     = 5;
    private const DATA_START_ROW = 7;
    private const MAX_COL        = 9;

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
        return view('admin.scalling.gov.onHand', $this->sharedViewData());
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
        return view('admin.scalling.private.onHand', $this->sharedViewData());
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
            DB::transaction(function () use ($rows, $originalFilename, $request) {
                // Buat log hanya jika tidak ada error
                $log = ScallingImport::create([
                    'original_filename'   => $originalFilename,
                    'status'              => 'success',
                    'total_rows_imported' => count($rows),
                    'uploaded_by'         => auth()->user()->name ?? $request->ip(),
                ]);

                // Sisipkan foreign key ke setiap baris
                $timestamp  = now();
                $insertRows = array_map(fn($row) => array_merge($row, [
                    'imports_log_id' => $log->id,   // ← sesuaikan nama FK dengan migration
                    'created_at'         => $timestamp,
                    'updated_at'         => $timestamp,
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

    private function readAndValidateHeaders(Worksheet $sheet): array
    {
        $headerMap    = [];
        $foundHeaders = [];
        $headerRow    = self::HEADER_ROW;

        for ($col = 1; $col <= self::MAX_COL; $col++) {
            $coordinate = Coordinate::stringFromColumnIndex($col) . $headerRow;
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
                "Kolom terbaca: {$found}."
            );
        }

        return $headerMap;
    }

    private function isTotalRow(Worksheet $sheet, int $rowIndex): bool
    {
        $rowNum = $rowIndex;

        for ($col = 1; $col <= self::MAX_COL; $col++) {
            $coordinate = Coordinate::stringFromColumnIndex($col) . $rowNum;
            $value      = strtoupper(trim((string) $sheet->getCell($coordinate)->getValue()));

            if (str_contains($value, 'TOTAL')) {
                return true;
            }
        }

        return false;
    }

    private function readRow(Worksheet $sheet, int $rowIndex, array $headerMap): array
    {
        $rowData = [];
        $rowNum  = $rowIndex;

        for ($col = 1; $col <= self::MAX_COL; $col++) {
            if (!isset($headerMap[$col])) continue;

            $dbColumn   = $headerMap[$col];
            $coordinate = Coordinate::stringFromColumnIndex($col) . $rowNum;
            $raw        = $sheet->getCell($coordinate)->getValue();
            $cellValue  = trim((string) $raw);

            if (in_array($dbColumn, ['no', 'plan_bulan_billcomp_2025'])) {
                $cellValue = is_numeric($cellValue) ? (int) $cellValue : null;

            } elseif ($dbColumn === 'est_nilai_bc') {
                if (is_numeric($raw)) {
                    $cellValue = (float) $raw;
                } else {
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

    private function isRowEmpty(array $rowData): bool
    {
        foreach ($rowData as $value) {
            if ($value !== null && $value !== '') return false;
        }
        return true;
    }
}