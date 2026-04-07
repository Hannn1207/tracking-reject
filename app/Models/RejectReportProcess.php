<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RejectReportProcess extends Model
{
    protected $fillable = [
        'reject_report_id',
        'qty_proses',
        'user_id',
    ];
    public function report(): BelongsTo
    {
        return $this->belongsTo(RejectReport::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
