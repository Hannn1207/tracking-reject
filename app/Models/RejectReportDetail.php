<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Log;

class RejectReportDetail extends Model
{
    protected $fillable = [
        'reject_report_id',
        'reject_type_id',
        'status_reject',
        'qty_reject',
        'user_id',
    ];

    public function report(): BelongsTo
    {
        return $this->belongsTo(RejectReport::class);
    }
    public function rejectType(): BelongsTo
    {
        return $this->belongsTo(RejectType::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        // When a detail is created, ensure the parent report becomes "submitted" if it was draft
        // Only do this when qty_proses is provided and greater than zero
        static::created(function (self $detail) {
            if (isset($detail->qty_proses) && (int) $detail->qty_proses > 0) {
                $report = $detail->report()->first();
                if ($report && $report->status === 'draft') {
                    $report->update(['status' => 'submitted']);
                }
            }
        });

        // If a detail is deleted and no details remain, revert report to draft (optional behavior)
        static::deleted(function (self $detail) {
            $report = $detail->report()->first();
            if ($report && $report->details()->count() === 0 && $report->status === 'submitted') {
                $report->update(['status' => 'draft']);
            }
        });

        // When qty_proses is updated from 0/null to >0, set parent report to submitted
        static::updated(function (self $detail) {
            $original = (int) $detail->getOriginal('qty_proses', 0);
            $current = (int) $detail->qty_proses;

            Log::info('RejectReportDetail updated hook', ['id' => $detail->id, 'original' => $original, 'current' => $current]);

            if ($original <= 0 && $current > 0) {
                $report = $detail->report()->first();
                if ($report && $report->status === 'draft') {
                    $report->update(['status' => 'submitted']);
                }
            }
        });
    }
}
