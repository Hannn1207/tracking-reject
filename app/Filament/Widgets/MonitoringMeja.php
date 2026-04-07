<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class MonitoringMeja extends StatsOverviewWidget
{
    protected ?string $pollingInterval = '5s';
    protected ?string $heading = 'Monitoring Pendapatan Harian Visual Inspection ';
    protected static bool $isDiscovered = false;
    protected function getStats(): array
    {
        $today = Carbon::today();

        $data = cache()->remember('production_meja_today', 60, function () use ($today) {
            return DB::table('production_reports')
                ->join(
                    'production_report_details',
                    'production_reports.id',
                    '=',
                    'production_report_details.production_report_id'
                )
                ->whereDate('production_reports.tanggal', $today)
                ->selectRaw('
            production_reports.meja,
            SUM(production_report_details.qty_scan) as total_aktual
        ')
                ->groupBy('production_reports.meja')
                ->orderByRaw("
            CASE 
                WHEN production_reports.meja REGEXP '^[0-9]+$'
                THEN CAST(production_reports.meja AS UNSIGNED)
                ELSE 999
            END ASC,
            production_reports.meja DESC
        ")
                ->get();
        });

        return $data->map(function ($item) {
            return Stat::make('Meja ' . $item->meja, $item->total_aktual)
                ->description('Pcs');
        })->toArray();
    }
}
