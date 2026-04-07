<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\RejectReportDetail;
use Carbon\Carbon;

class RejectChart extends ChartWidget
{
    protected static ?int $sort = 3;
    protected ?string $heading = 'Reject Hari Ini';
    protected int | string | array $columnSpan = '1/2';
    protected function getData(): array
    {
        $today = Carbon::today();

        $fg = (int) RejectReportDetail::whereDate('created_at', $today)
            ->whereHas('rejectType', fn($q) => $q->where('asal_reject', 'FG'))
            ->sum('qty_reject');

        $stl = (int) RejectReportDetail::whereDate('created_at', $today)
            ->whereHas('rejectType', fn($q) => $q->where('asal_reject', 'STL/HTR'))
            ->sum('qty_reject');

        $mc = (int) RejectReportDetail::whereDate('created_at', $today)
            ->where('status_reject', 'NG')
            ->whereHas('rejectType', fn($q) => $q->where('asal_reject', 'MC'))
            ->sum('qty_reject');
        return [
            'datasets' => [
                [
                    'label' => 'Reject',
                    'data' => [$fg, $stl, $mc],
                ],
            ],
            'labels' => ['FG', 'STL/HTR', 'MC'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
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
