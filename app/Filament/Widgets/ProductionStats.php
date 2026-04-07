<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\RejectReport;
use App\Models\ProductionReportDetail;
use App\Models\RejectReportDetail;
use App\Models\TotalProduksi;
use App\Models\RejectReportProcess;

use Carbon\Carbon;


class ProductionStats extends StatsOverviewWidget
{
    protected static ?int $sort = 1;
    protected static bool $isLazy = true;
    protected function getStats(): array
    {

        $today = Carbon::today();

        $totalProduksi = RejectReportProcess::whereDate('created_at', $today)
            ->sum('qty_proses');

        $totalReject = RejectReportDetail::whereDate('created_at', $today)
            ->where('status_reject', 'NG')
            ->sum('qty_reject');

        $totalRepair = RejectReportDetail::whereDate('created_at', $today)
            ->where('status_reject', 'REP')
            ->sum('qty_reject');

        $totalPendapatan = ProductionReportDetail::whereDate('created_at', $today)
            ->sum('qty_scan');
        return [
            Stat::make('Total Produksi Hari Ini', $totalProduksi)
                ->description('Pcs')
                ->color('success'),

            Stat::make('Total Reject Hari Ini', $totalReject)
                ->description('Pcs')
                ->color('danger'),

            Stat::make('Total Repair Hari Ini', $totalRepair)
                ->description('Pcs')
                ->color('warning'),

            Stat::make('Total Pendapatan Hari Ini', $totalPendapatan)
                ->description('Pcs')
                ->color('primary'),
        ];
    }
}
