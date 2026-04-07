<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductionReportDetail extends Model
{
    protected $fillable = [
        'production_report_id',
        'target_id',
        'qty_target',
        'kode',
        'qty_scan',
        'no_lot',
        'ok',
        'ng',
        'repair',
        'keterangan',
        'user_id'
    ];
    // Relasi dengan model ProductionReport
    public function productionReport()
    {
        return $this->belongsTo(ProductionReport::class);
    }
    // Relasi dengan model Target
    public function target()
    {
        return $this->belongsTo(Target::class);
    }
    // Relasi dengan model user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
