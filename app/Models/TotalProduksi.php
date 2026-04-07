<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\RejectReportProcess;


class TotalProduksi extends Model
{
    protected $table = 'total_produksi';

    protected $fillable = [
        'reject_report_id',
        'name_part_id',
        'total_reject_fg',
        'total_reject_stl_htr',
        'total_reject_mc',
        'total_qty_proses',
        'total_reject_inpk',
        'total_reject',
        'total_repair',
        'keterangan',
    ];
    // Relasi dengan model RejectReport
    public function rejectReport(): BelongsTo
    {
        return $this->belongsTo(RejectReport::class, 'reject_report_id');
    }
    // Relasi dengan model NamePart

    // Relasi dengan model RejectReportProcess
    public function rejectReportProcesses(): HasMany
    {
        return $this->hasMany(
            RejectReportProcess::class,
            'reject_report_id',      // foreign key di tabel child
            'reject_report_id'       // local key di tabel ini
        );
    }
    public function details(): HasMany
    {
        return $this->hasMany(RejectReportDetail::class);
    }
    // Untuk menghitung total_reject secara otomatis setiap kali model disimpan (Backend)
    protected static function booted()
    {
        static::saving(function ($model) {
            // Hitung total repair otomatis di backend
            $model->total_repair = $model->rejectReport
                ->details()
                ->where('status_reject', 'REP')
                ->sum('qty_reject');

            // Contoh tambahan: hitung total_reject otomatis juga
            $model->total_reject =
                ($model->total_reject_fg ?? 0) +
                ($model->total_reject_stl_htr ?? 0) +
                ($model->total_reject_mc ?? 0) +
                ($model->total_reject_inpk ?? 0);
        });
    }
}
