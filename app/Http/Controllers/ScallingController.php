<?php

namespace App\Http\Controllers;

use App\Models\ScallingData;
use App\Models\ScallingImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class ScallingController extends Controller
{
    /**
     * Baris header yang berisi nama kolom di Excel (baris ke-5 di spreadsheet).
     * Baris sebelumnya (1-4) adalah judul/deskripsi, bukan data.
     * Baris data mulai dari baris ke-7 hingga sebelum baris TOTAL.
     */
    private const HEADER_ROW    = 5;   // Baris header kolom (NO, PROJECT, ID LOP, ...)
    private const DATA_START_ROW = 7;   // Baris pertama data aktual
    private const MAX_COL       = 9;   // Kolom A (1) s/d I (9)

    /**
     * Mapping header Excel -> nama kolom database
     * Key: nilai header (uppercase, trimmed)
     * Value: nama kolom di tabel government_projects
     */
    private array $columnMap = [
        'NO'                     => 'no',
        'PROJECT'                => 'project',
        'ID LOP'                 => 'id_lop',
        'CC'                     => 'cc',
        'NIPNAS'                 => 'nipnas',
        'AM'                     => 'am',
        'MITRA'                  => 'mitra',
        'PLAN BULAN BILLCOMP 2025' => 'plan_bulan_billcomp_2025',
        'EST NILAI BC'           => 'est_nilai_bc',
    ];

    /**
     * Tampilkan halaman upload
     */
    public function indexGov()
    {
        $logs    = ScallingImport::latest()->paginate(10);
        $projects = ScallingData::with('scallingImport')->latest()->paginate(20);

        return view('admin.scalling.gov.gov', compact('logs', 'projects'));
    }
    public function indexSoe()
    {
        $logs    = ScallingImport::latest()->paginate(10);
        $projects = ScallingData::with('scallingImport')->latest()->paginate(20);

        return view('admin.scalling.soe.soe', compact('logs', 'projects'));
    }
    public function indexSme()
    {
        $logs    = ScallingImport::latest()->paginate(10);
        $projects = ScallingData::with('scallingImport')->latest()->paginate(20);

        return view('admin.scalling.sme.sme', compact('logs', 'projects'));
    }
    public function indexPrivate()
    {
        $logs    = ScallingImport::latest()->paginate(10);
        $projects = ScallingData::with('scallingImport')->latest()->paginate(20);

        return view('admin.scalling.private.private', compact('logs', 'projects'));
    }
    public function onHandGov()
    {
        $logs    = ScallingImport::latest()->paginate(10);
        $projects = ScallingData::with('scallingImport')->latest()->paginate(20);

        return view('admin.scalling.gov.onHand', compact('logs', 'projects'));
    }
    public function onHandSme()
    {
        $logs    = ScallingImport::latest()->paginate(10);
        $projects = ScallingData::with('scallingImport')->latest()->paginate(20);

        return view('admin.scalling.sme.onHand', compact('logs', 'projects'));
    }
    public function onHandSoe()
    {
        $logs    = ScallingImport::latest()->paginate(10);
        $projects = ScallingData::with('scallingImport')->latest()->paginate(20);

        return view('admin.scalling.soe.onHand', compact('logs', 'projects'));
    }
    public function onHandPrivate()
    {
        $logs    = ScallingImport::latest()->paginate(10);
        $projects = ScallingData::with('scallingImport')->latest()->paginate(20);

        return view('admin.scalling.private.onHand', compact('logs', 'projects'));
    }

    /**
     * Proses upload dan import Excel
     */
    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => [
                'required',
                'file',
                'mimes:xlsx,xls,csv',
                'max:10240', // maks 10 MB
            ],
        ], [
            'excel_file.required' => 'File Excel wajib diunggah.',
            'excel_file.mimes'    => 'File harus berformat .xlsx, .xls, atau .csv.',
            'excel_file.max'      => 'Ukuran file maksimal 10 MB.',
        ]);

        $file             = $request->file('excel_file');
        $originalFilename = $file->getClientOriginalName();
        $tempPath         = $file->getRealPath();

        $log = ScallingImport::create([
            'original_filename'   => $originalFilename,
            'status'              => 'processing',
            'total_rows_imported' => 0,
            'uploaded_by'         => auth()->user()->name ?? $request->ip(),
        ]);

        try {
            $spreadsheet = IOFactory::load($tempPath);
            $sheet       = $spreadsheet->getActiveSheet();

            // ── 1. Baca & validasi header (baris ke-5) ─────────────────────
            $headerMap = $this->readAndValidateHeaders($sheet);

            // ── 2. Baca data dari baris DATA_START_ROW hingga akhir ─────────
            $rows        = [];
            $highestRow  = $sheet->getHighestRow();

            for ($rowIndex = self::DATA_START_ROW; $rowIndex <= $highestRow; $rowIndex++) {
                $rowData = $this->readRow($sheet, $rowIndex, $headerMap);

                // Lewati baris kosong
                if ($this->isRowEmpty($rowData)) {
                    continue;
                }

                // Lewati baris TOTAL atau baris non-data (NO bukan angka)
                if ($this->isTotalRow($rowData)) {
                    continue;
                }

                $rows[] = array_merge($rowData, [
                    'import_log_id' => $log->id,
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ]);
            }

            if (empty($rows)) {
                throw new \Exception('Tidak ada data valid yang ditemukan di dalam file Excel.');
            }

            // ── 3. Simpan ke database dalam satu transaksi ──────────────────
            DB::transaction(function () use ($rows, $log) {
                // Sisipkan data dalam batch 500
                foreach (array_chunk($rows, 500) as $chunk) {
                    ScallingData::insert($chunk);
                }

                $log->update([
                    'status'              => 'success',
                    'total_rows_imported' => count($rows),
                ]);
            });

            // ── 4. Hapus file sementara ─────────────────────────────────────
            @unlink($tempPath);

            return redirect()->route('admin.scalling.gov.on-hand')
                ->with('success', "Import berhasil! {$log->total_rows_imported} baris data berhasil diimpor dari file \"{$originalFilename}\".");

        } catch (\Throwable $e) {
            // Tandai log sebagai gagal
            $log->update([
                'status' => 'failed',
                'notes'  => $e->getMessage(),
            ]);

            // Tetap hapus file temp
            @unlink($tempPath);

            return redirect()->route('admin.scalling.gov.on-hand')
                ->with('error', 'Import gagal: ' . $e->getMessage());
        }
    }

    /**
     * Baca header dari baris HEADER_ROW (kolom A s/d I saja).
     * Kembalikan array [kolom_index => nama_db_kolom].
     */
    private function readAndValidateHeaders($sheet): array
    {
        $headerMap   = [];
        $foundHeaders = [];

        for ($col = 1; $col <= self::MAX_COL; $col++) {
            $cellValue = $sheet->getCellByColumnAndRow($col, self::HEADER_ROW)->getValue();
            $normalized = strtoupper(trim((string) $cellValue));

            // Bersihkan newline yang muncul pada header multi-baris Excel
            $normalized = preg_replace('/\s+/', ' ', $normalized);

            if (isset($this->columnMap[$normalized])) {
                $headerMap[$col]     = $this->columnMap[$normalized];
                $foundHeaders[]      = $normalized;
            }
        }

        // Pastikan minimal ada kolom NO dan PROJECT
        if (!in_array('NO', $foundHeaders) || !in_array('PROJECT', $foundHeaders)) {
            throw new \Exception('Format Excel tidak sesuai. Pastikan header kolom berada di baris ke-5 dan mengandung kolom NO serta PROJECT.');
        }

        return $headerMap;
    }

    /**
     * Baca satu baris data berdasarkan headerMap.
     * Hanya kolom A s/d I (1-9) yang dibaca.
     */
    private function readRow($sheet, int $rowIndex, array $headerMap): array
    {
        $rowData = [];

        for ($col = 1; $col <= self::MAX_COL; $col++) {
            if (!isset($headerMap[$col])) {
                continue; // Kolom tidak terdaftar di header, lewati
            }

            $dbColumn  = $headerMap[$col];
            $cellValue = $sheet->getCellByColumnAndRow($col, $rowIndex)->getFormattedValue();
            $cellValue = trim((string) $cellValue);

            // Konversi numerik untuk kolom tertentu
            if (in_array($dbColumn, ['no', 'plan_bulan_billcomp_2025'])) {
                $cellValue = is_numeric($cellValue) ? (int) $cellValue : null;
            } elseif ($dbColumn === 'est_nilai_bc') {
                // Hilangkan titik ribuan dan koma desimal (format Indonesia)
                $clean     = preg_replace('/[^\d,.]/', '', $cellValue);
                $clean     = str_replace('.', '', $clean);  // hapus pemisah ribuan
                $clean     = str_replace(',', '.', $clean); // ubah koma desimal ke titik
                $cellValue = is_numeric($clean) ? (float) $clean : null;
            } else {
                $cellValue = $cellValue === '' ? null : $cellValue;
            }

            $rowData[$dbColumn] = $cellValue;
        }

        return $rowData;
    }

    /**
     * Cek apakah baris benar-benar kosong (semua kolom null/kosong).
     */
    private function isRowEmpty(array $rowData): bool
    {
        foreach ($rowData as $value) {
            if ($value !== null && $value !== '') {
                return false;
            }
        }
        return true;
    }

    /**
     * Cek apakah baris adalah baris TOTAL atau baris non-data.
     * Kriteria: kolom 'no' bukan angka positif, atau kolom 'project' mengandung kata 'TOTAL'.
     */
    private function isTotalRow(array $rowData): bool
    {
        // Baris dengan project berisi "TOTAL" atau sejenisnya
        if (isset($rowData['project']) && str_contains(strtoupper((string) $rowData['project']), 'TOTAL')) {
            return true;
        }

        // Baris di mana 'no' ada tapi bukan integer positif
        if (array_key_exists('no', $rowData)) {
            $no = $rowData['no'];
            if ($no !== null && (!is_int($no) || $no <= 0)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Tampilkan detail log upload beserta datanya
     */
    public function show(ScallingImport $scallingImport)
    {
        $projects = $scallingImport->scallingdata()->paginate(20);
        return view('admin.scalling.gov.show', compact('scallingImport', 'projects'));
    }

    /**
     * Hapus semua data terkait satu log upload
     */
    public function destroy(ScallingImport $scallingImport)
    {
        DB::transaction(function () use ($scallingImport) {
            $scallingImport->scallingdata()->delete();
            $scallingImport->delete();
        });

        return redirect()->route('admin.scalling.gov.on-hand')
            ->with('success', 'Log dan data terkait berhasil dihapus.');
    }
}