<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\RejectReport;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class ProductionChart extends ChartWidget
{
    protected static ?int $sort = 4;
    protected ?string $heading = 'Produksi 7 Hari Terakhir';
    protected static bool $isLazy = true;
    protected int | string | array $columnSpan = '1/2';

    protected function getData(): array
    {
        $start = Carbon::now()->subDays(6)->startOfDay();
        $end = Carbon::now()->endOfDay();

        $rows = cache()->remember('production_chart_7days', 60, function () use ($start, $end) {
            return RejectReport::query()
                ->join('reject_report_processes', 'reject_reports.id', '=', 'reject_report_processes.reject_report_id')
                ->whereBetween('reject_reports.created_at', [$start, $end])
                ->selectRaw('DATE(reject_reports.created_at) as date, SUM(reject_report_processes.qty_proses) as total')
                ->groupBy(DB::raw('DATE(reject_reports.created_at)'))
                ->pluck('total', 'date');
        });

        $labels = [];
        $data = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->toDateString();

            $labels[] = Carbon::parse($date)->translatedFormat('d-m-y');
            $data[] = $rows[$date] ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Produksi',
                    'data' => $data,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
