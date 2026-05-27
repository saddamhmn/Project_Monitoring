<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Carbon\Carbon;

class LogsExport implements WithEvents, WithTitle
{
    protected $request;
    protected $data;

    public function __construct($request)
    {
        $this->request = $request;
        $this->data    = $this->fetchData();
    }

    public function title(): string
    {
        return 'Log CCTV';
    }

    protected function fetchData()
    {
        $r = $this->request;

        $maintenance = DB::table('cctv_maintenance_logs')
            ->leftJoin('cctvs','cctv_maintenance_logs.cctv_id','=','cctvs.id')
            ->leftJoin('buildings','cctvs.building_id','=','buildings.id')
            ->leftJoin('building_floors','cctvs.building_floor_id','=','building_floors.id')
            ->select(
                DB::raw("COALESCE(buildings.name, '[Gedung Dihapus]') as building"),
                DB::raw("COALESCE(CAST(building_floors.floor_number AS TEXT), '-') as floor"),
                DB::raw("COALESCE(cctvs.name, '[CCTV Dihapus]') as cctv_name"),
                DB::raw("COALESCE(cctvs.cctv_type, '-') as cctv_type"),
                DB::raw("'maintenance' as type"),
                'cctv_maintenance_logs.technician_name as petugas',
                'cctv_maintenance_logs.note as keterangan',
                'cctv_maintenance_logs.photo as photo',
                'cctv_maintenance_logs.performed_at as created_at',
                DB::raw("CASE WHEN cctvs.deleted_at IS NOT NULL THEN 1 ELSE 0 END as cctv_deleted"),
                DB::raw("CASE WHEN buildings.deleted_at IS NOT NULL THEN 1 ELSE 0 END as building_deleted")
            );

        $error = DB::table('cctv_error_logs')
            ->leftJoin('cctvs','cctv_error_logs.cctv_id','=','cctvs.id')
            ->leftJoin('buildings','cctvs.building_id','=','buildings.id')
            ->leftJoin('building_floors','cctvs.building_floor_id','=','building_floors.id')
            ->select(
                DB::raw("COALESCE(buildings.name, '[Gedung Dihapus]') as building"),
                DB::raw("COALESCE(CAST(building_floors.floor_number AS TEXT), '-') as floor"),
                DB::raw("COALESCE(cctvs.name, '[CCTV Dihapus]') as cctv_name"),
                DB::raw("COALESCE(cctvs.cctv_type, '-') as cctv_type"),
                DB::raw("'error' as type"),
                'cctv_error_logs.technician_name as petugas',
                'cctv_error_logs.description as keterangan',
                'cctv_error_logs.photo as photo',
                'cctv_error_logs.reported_at as created_at',
                DB::raw("CASE WHEN cctvs.deleted_at IS NOT NULL THEN 1 ELSE 0 END as cctv_deleted"),
                DB::raw("CASE WHEN buildings.deleted_at IS NOT NULL THEN 1 ELSE 0 END as building_deleted")
            );

        if ($r->filled('building')) {
            $maintenance->where('buildings.id', $r->building);
            $error->where('buildings.id', $r->building);
        }
        if ($r->filled('floor')) {
            $maintenance->where('building_floors.floor_number', $r->floor);
            $error->where('building_floors.floor_number', $r->floor);
        }
        if ($r->filled('cctv_type')) {
            $maintenance->where('cctvs.cctv_type', $r->cctv_type);
            $error->where('cctvs.cctv_type', $r->cctv_type);
        }

        $logs = DB::query()->fromSub($maintenance->unionAll($error), 'logs');

        if ($r->filled('petugas'))  $logs->where('petugas', 'like', '%'.$r->petugas.'%');
        if ($r->filled('log_type')) $logs->where('type', $r->log_type);

       if ($r->filled('status')) {
            if ($r->status === 'active') {
                $logs->where('cctv_deleted', 0)->where('building_deleted', 0);
            } elseif ($r->status === 'deleted') {
                $logs->where(function($q) {
                    $q->where('cctv_deleted', 1)->orWhere('building_deleted', 1);
                });
            }
        }

        if ($r->filled('date_from') && $r->filled('date_to')) {
            $logs->whereDate('created_at', '>=', $r->date_from)
                 ->whereDate('created_at', '<=', $r->date_to);
        } elseif ($r->filled('date_from')) {
            $logs->whereDate('created_at', '>=', $r->date_from);
        } elseif ($r->filled('range')) {
            match($r->range) {
                'week'    => $logs->where('created_at', '>=', now()->subWeek()),
                'month'   => $logs->where('created_at', '>=', now()->startOfMonth()),
                '3months' => $logs->where('created_at', '>=', now()->subMonths(3)),
                default   => null,
            };
        }

        return $logs->orderBy('created_at', 'desc')->get();
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $data  = $this->data;

                // ── Judul ──────────────────────────────────────────
                $sheet->mergeCells('A1:J1');
                $sheet->setCellValue('A1', 'LOG CCTV MAINTENANCE & ERROR');
                $sheet->getStyle('A1')->applyFromArray([
                    'font'      => ['bold' => true, 'size' => 14, 'color' => ['argb' => 'FFFFFFFF']],
                    'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF1E3A5F']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                ]);
                $sheet->getRowDimension(1)->setRowHeight(36);

                // Sub-judul tanggal export
                $sheet->mergeCells('A2:J2');
                $sheet->setCellValue('A2', 'Diekspor pada: ' . Carbon::now()->format('d M Y H:i'));
                $sheet->getStyle('A2')->applyFromArray([
                    'font'      => ['italic' => true, 'size' => 10, 'color' => ['argb' => 'FF555555']],
                    'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFF0F4F8']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);
                $sheet->getRowDimension(2)->setRowHeight(20);

                // Baris kosong
                $sheet->getRowDimension(3)->setRowHeight(8);

                // ── Header kolom ───────────────────────────────────
                $headers = ['No', 'Gedung', 'Lantai', 'Nama CCTV', 'Tipe CCTV', 'Tipe Log', 'Petugas', 'Keterangan', 'Foto', 'Tanggal'];
                $cols    = ['A','B','C','D','E','F','G','H','I','J'];

                foreach ($headers as $i => $header) {
                    $cell = $cols[$i] . '4';
                    $sheet->setCellValue($cell, $header);
                }

                $sheet->getStyle('A4:J4')->applyFromArray([
                    'font'      => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                    'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF2D6A9F']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                    'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FFAAAAAA']]],
                ]);
                $sheet->getRowDimension(4)->setRowHeight(24);

                // ── Data baris ─────────────────────────────────────
                foreach ($data as $i => $log) {
                    $row       = $i + 5;
                    $isMaint   = $log->type === 'maintenance';
                    $isDeleted = $log->cctv_deleted || $log->building_deleted;
                    $rowBg     = $isDeleted ? 'FFFFF0F0' : ($i % 2 === 0 ? 'FFFFFFFF' : 'FFF8FAFC');

                    // Isi sel
                    $sheet->setCellValue("A$row", $i + 1);
                    $sheet->setCellValue("B$row", $log->building . ($log->building_deleted ? ' [Dihapus]' : ''));
                    $sheet->setCellValue("C$row", 'Lantai ' . $log->floor);
                    $sheet->setCellValue("D$row", $log->cctv_name . ($log->cctv_deleted ? ' [Dihapus]' : ''));
                    $sheet->setCellValue("E$row", strtoupper($log->cctv_type));
                    $sheet->setCellValue("F$row", $isMaint ? 'Maintenance' : 'Error');
                    $sheet->setCellValue("G$row", $log->petugas);
                    $sheet->setCellValue("H$row", $log->keterangan ?? '-');
                    $sheet->setCellValue("I$row", ''); // placeholder foto
                    $sheet->setCellValue("J$row", Carbon::parse($log->created_at)->format('d M Y H:i'));

                    // Tinggi baris
                    $sheet->getRowDimension($row)->setRowHeight(70);

                    // Style baris
                    $sheet->getStyle("A$row:J$row")->applyFromArray([
                        'fill'    => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => $rowBg]],
                        'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FFDDDDDD']]],
                        'alignment' => ['vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
                    ]);

                    // Warna badge tipe log
                    $badgeColor = $isMaint ? 'FF166534' : 'FF991B1B';
                    $badgeBg    = $isMaint ? 'FFDCFCE7' : 'FFFEE2E2';
                    $sheet->getStyle("F$row")->applyFromArray([
                        'font'      => ['bold' => true, 'color' => ['argb' => $badgeColor]],
                        'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => $badgeBg]],
                        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                    ]);

                    // Center kolom tertentu
                    $sheet->getStyle("A$row")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle("C$row")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle("E$row")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle("J$row")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                    // ── Foto ──────────────────────────────────────
                    if ($log->photo) {
                        $path = Storage::disk('public')->path($log->photo);
                        if (file_exists($path)) {
                            try {
                                $drawing = new Drawing();
                                $drawing->setPath($path);
                                $drawing->setCoordinates("I$row");
                                $drawing->setOffsetX(4);
                                $drawing->setOffsetY(4);
                                $drawing->setWidth(80);
                                $drawing->setHeight(62);
                                $drawing->setWorksheet($sheet);
                            } catch (\Exception $e) {
                                $sheet->setCellValue("I$row", 'Gagal muat foto');
                            }
                        } else {
                            $sheet->setCellValue("I$row", 'File tidak ada');
                        }
                    } else {
                        $sheet->setCellValue("I$row", '-');
                        $sheet->getStyle("I$row")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    }
                }

                // ── Lebar kolom ────────────────────────────────────
                $widths = ['A'=>6, 'B'=>22, 'C'=>10, 'D'=>20, 'E'=>12, 'F'=>14, 'G'=>18, 'H'=>30, 'I'=>14, 'J'=>18];
                foreach ($widths as $col => $width) {
                    $sheet->getColumnDimension($col)->setWidth($width);
                }

                // Freeze header
                $sheet->freezePane('A5');
            },
        ];
    }
}