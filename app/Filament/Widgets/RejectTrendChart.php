<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\RejectReportDetail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RejectTrendChart extends ChartWidget
{
    protected ?string $heading = 'Trend Reject Hari ini';
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = '1/2';
    protected ?string $pollingInterval = '10s';
    protected function getData(): array
    {
        $today = Carbon::today();

        // Ambil total reject hari ini per reject_type + asal
        $data = RejectReportDetail::select(
            'reject_types.nama_reject',
            'reject_types.asal_reject',
            DB::raw('SUM(reject_report_details.qty_reject) as total_reject')
        )
            ->join('reject_types', 'reject_report_details.reject_type_id', '=', 'reject_types.id')
            ->join('reject_reports', 'reject_report_details.reject_report_id', '=', 'reject_reports.id')
            ->where('reject_report_details.status_reject', 'NG') // filter hanya NG
            ->whereDate('reject_reports.created_at', $today)
            ->groupBy('reject_types.nama_reject', 'reject_types.asal_reject')
            ->orderBy('reject_types.nama_reject')
            ->get();

        // Labels = "Nama Reject (Asal)"
        $labels = $data->map(fn($item) => $item->nama_reject . ' (' . $item->asal_reject . ')')->toArray();
        $totals = $data->pluck('total_reject')->toArray();
        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Reject',
                    'data' => $totals,
                    'borderColor' => '#ef4444', // merah
                    'backgroundColor' => 'rgba(239,68,68,0.1)',
                    'fill' => true,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'ticks' => [
                        'stepSize' => 1,
                        'precision' => 0,
                    ],
                    'beginAtZero' => true,
                ],
            ],
        ];
    }
}
