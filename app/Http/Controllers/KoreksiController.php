<?php

namespace App\Http\Controllers;

use App\Models\ScallingImport;
use App\Models\Koreksi;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use Illuminate\Http\Request;

class KoreksiController extends Controller
{
    private const HEADER_ROW     = 1;
    private const DATA_START_ROW = 2;
    private const MAX_COL        = 5;

    private array $columnMap = [
        'NO'              => 'no',
        'NAMA PELANGGAN'  => 'nama_pelanggan',
        'NILAI KOMITMEN'  => 'nilai_komitmen',
        'PROGRESS'        => 'progress',
        'REALISASI'       => 'realisasi',
    ];

    public function koreksiGov()
    {
        $logs     = ScallingImport::where('type', 'koreksi')->where('segment', 'government')->latest()->paginate(10);
        $projects = Koreksi::with('scallingImport')->latest()->paginate(20);
        $currentPeriode = request()->get('periode', date('Y-m'));
        return view('admin.scalling.gov.koreksi', compact('logs', 'projects', 'currentPeriode'));
    }
    public function koreksiPrivate()
    {
        $logs     = ScallingImport::where('type', 'koreksi')->where('segment', 'private')->latest()->paginate(10);
        $projects = Koreksi::with('scallingImport')->latest()->paginate(20);
        $currentPeriode = request()->get('periode', date('Y-m'));
        return view('admin.scalling.private.koreksi', compact('logs', 'projects', 'currentPeriode'));
    }
    public function koreksiSme()
    {
        $logs     = ScallingImport::where('type', 'koreksi')->where('segment', 'sme')->latest()->paginate(10);
        $projects = Koreksi::with('scallingImport')->latest()->paginate(20);
        $currentPeriode = request()->get('periode', date('Y-m'));
        return view('admin.scalling.sme.koreksi', compact('logs', 'projects', 'currentPeriode'));
    }
    public function koreksiSoe()
    {
        $logs     = ScallingImport::where('type', 'koreksi')->where('segment', 'soe')->latest()->paginate(10);
        $projects = Koreksi::with('scallingImport')->latest()->paginate(20);
        $currentPeriode = request()->get('periode', date('Y-m'));
        return view('admin.scalling.soe.koreksi', compact('logs', 'projects', 'currentPeriode'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => ['required', 'file', 'mimes:xlsx,xls,csv', 'max:10240'],
            'periode'    => ['required', 'date_format:Y-m'],
            'segment'    => ['required'],
        ], [
            'excel_file.required' => 'File Excel wajib diunggah.',
            'excel_file.mimes'    => 'File harus berformat .xlsx, .xls, atau .csv.',
            'excel_file.max'      => 'Ukuran file maksimal 10 MB.',
        ]);

        $periodeDate      = $request->periode . '-01';
        $file             = $request->file('excel_file');
        $originalFilename = $file->getClientOriginalName();
        $tempPath         = $file->getRealPath();

        try {
            $spreadsheet = IOFactory::load($tempPath);
            $sheet       = $spreadsheet->getActiveSheet();

            $headerMap  = $this->readAndValidateHeaders($sheet);
            $highestRow = $sheet->getHighestRow();

            $rows = [];

            for ($rowIndex = self::DATA_START_ROW; $rowIndex <= $highestRow; $rowIndex++) {
                if ($this->isTotalRow($sheet, $rowIndex)) {
                    break;
                }

                $rowData = $this->readRow($sheet, $rowIndex, $headerMap);

                if ($this->isRowEmpty($rowData)) {
                    continue;
                }

                $rows[] = $rowData;
            }

            if (empty($rows)) {
                throw new \Exception('Tidak ada data valid yang ditemukan di dalam file Excel.');
            }

            DB::transaction(function () use ($rows, $originalFilename, $request, $periodeDate) {
                $log = ScallingImport::updateOrCreate(
                    [
                        'periode' => $periodeDate,
                        'segment' => $request->segment,
                        'type'    => 'koreksi',
                    ],
                    [
                        'original_filename'   => $originalFilename,
                        'status'              => 'active',
                        'total_rows_imported' => count($rows),
                        'uploaded_by'         => auth()->user()->name ?? request()->ip(),
                    ]
                );

                $log->koreksi()->delete();

                $timestamp  = now();
                $insertRows = array_map(function ($row) use ($log, $timestamp) {
                    return array_merge($row, [
                        'imports_log_id' => $log->id,
                        'created_at'     => $timestamp,
                        'updated_at'     => $timestamp,
                    ]);
                }, $rows);

                foreach (array_chunk($insertRows, 500) as $chunk) {
                    Koreksi::insert($chunk);
                }
            });

            return back()->with(
                'success',
                "Import koreksi berhasil! " . count($rows) . " baris diimpor dari \"{$originalFilename}\"."
            );

        } catch (\Throwable $e) {
            return back()->with('error', 'Import gagal: ' . $e->getMessage());
        }
    }

    private function readAndValidateHeaders(Worksheet $sheet): array
    {
        $headerMap    = [];
        $foundHeaders = [];

        for ($col = 1; $col <= self::MAX_COL; $col++) {
            $coordinate = Coordinate::stringFromColumnIndex($col) . self::HEADER_ROW;
            $rawValue   = $sheet->getCell($coordinate)->getValue();
            $normalized = preg_replace('/\s+/', ' ', strtoupper(trim((string) $rawValue)));

            if (isset($this->columnMap[$normalized])) {
                $headerMap[$col] = $this->columnMap[$normalized];
                $foundHeaders[]  = $normalized;
            }
        }

        // Validasi minimal NO dan NAMA PELANGGAN harus ada
        if (!in_array('NO', $foundHeaders) || !in_array('NAMA PELANGGAN', $foundHeaders)) {
            $found = implode(', ', $foundHeaders) ?: '(tidak ada)';
            throw new \Exception(
                "Header tidak ditemukan di baris ke-" . self::HEADER_ROW . ". " .
                "Kolom terbaca: {$found}. Pastikan header NO dan NAMA PELANGGAN ada di baris " . self::HEADER_ROW . "."
            );
        }

        return $headerMap;
    }

    private function isTotalRow(Worksheet $sheet, int $rowIndex): bool
    {
        for ($col = 1; $col <= self::MAX_COL; $col++) {
            $coordinate = Coordinate::stringFromColumnIndex($col) . $rowIndex;
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

        for ($col = 1; $col <= self::MAX_COL; $col++) {
            if (!isset($headerMap[$col])) continue;

            $dbColumn   = $headerMap[$col];
            $coordinate = Coordinate::stringFromColumnIndex($col) . $rowIndex;
            $raw        = $sheet->getCell($coordinate)->getValue();
            $cellValue  = trim((string) $raw);

            if ($dbColumn === 'no') {
                $cellValue = is_numeric($cellValue) ? (int) $cellValue : null;
            } elseif (in_array($dbColumn, ['nilai_komitmen', 'realisasi'])) {
                if (is_numeric($raw)) {
                    $cellValue = (float) $raw;
                } else {
                    $clean     = preg_replace('/[^\d,.]/', '', $cellValue);
                    $clean     = str_replace('.', '', $clean);
                    $clean     = str_replace(',', '.', $clean);
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

    public function storeData(Request $request)
    {
        $request->validate([
            'status'                   => 'required|in:active,inactive',
            'periode'                  => 'required|date_format:Y-m',
            'nama_pelanggan'           => 'required|string|max:255',
            'nilai_komitmen'           => 'required|string|max:100',
            'realisasi'                => 'required|string|max:100',
        ], [
            'status.required'                   => 'Status wajib diisi',
            'status.in'                         => 'Status harus berupa "active" atau "inactive"',
            'periode.required'                  => 'Periode wajib diisi',
            'periode.date_format'               => 'Format periode harus berupa bulan dan tahun (contoh: 2025-03)',
            'nama_pelanggan.required'           => 'Nama pelanggan wajib diisi',
            'nilai_komitmen.required'           => 'Nilai komitmen wajib diisi',
            'realisasi.required'                => 'Realisasi wajib diisi',
        ]);

        $periodeDate = $request->periode . '-01';

        $log = ScallingImport::where('periode', $periodeDate)
            ->where('type', $request->type)
            ->where('segment', $request->segment)
            ->first();

        if($log) {   
            $data = Koreksi::create([
            'imports_log_id'           => $log->id,
            'no'                       => $log->koreksi()->count() + 1,
            'nama_pelanggan'           => $request->nama_pelanggan,
            'nilai_komitmen'           => $request->nilai_komitmen,
            'realisasi'                => $request->realisasi,
        ]);
        } else {
            $import = ScallingImport::create([
                'original_filename'   => 'manual-input',
                'status'              => $request->status,
                'type'                => $request->type,
                'segment'             => $request->segment,
                'periode'             => $periodeDate,
                'total_rows_imported' => 0,
                'uploaded_by'         => auth()->user()->name ?? $request->ip(),
            ]);

            $data = Koreksi::create([
            'imports_log_id'           => $import->id,
            'no'                       => 1,
            'nama_pelanggan'           => $request->nama_pelanggan,
            'nilai_komitmen'           => $request->nilai_komitmen,
            'realisasi'                => $request->realisasi,
        ]);
        }

        return redirect()->back()->with('success', "Data untuk project \"{$data->project}\" berhasil disimpan.");
    }
}