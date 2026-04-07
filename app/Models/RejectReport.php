<?php

namespace App\Models;

use Faker\Guesser\Name;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\TotalProduksi;

class RejectReport extends Model
{
    protected $fillable = [
        'tanggal',
        'meja',
        'line',
        'shift',
        'lot_number',
        'status',
        'part_id',
        'user_id',
        'keterangan',
    ];
    // Relasi dengan model RejectReportDetail
    public function details(): HasMany
    {
        return $this->hasMany(RejectReportDetail::class);
    }
    // Relasi dengan model User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    // Relasi dengan model NamePart
    public function part(): BelongsTo
    {
        return $this->belongsTo(NamePart::class, 'part_id');
    }
    // Relasi dengan model RejectReportProcess
    public function processes()
    {
        return $this->hasMany(RejectReportProcess::class,  'reject_report_id');
    }
    // Relasi dengan model TotalProduksi
    public function totalProduksi(): HasOne
    {
        return $this->hasOne(TotalProduksi::class);
    }
    // Relasi dengan model TotalProduksi berdasarkan reject_report_id
    public function name_part()
    {
        return $this->belongsTo(NamePart::class, 'part_id');
    }
    // Method untuk submit report
    public function submit()
    {
        // cek apakah detail sudah diisi
        if ($this->details()->count() === 0) {
            throw new \Exception('Reject Report Detail belum diisi.');
        }

        $this->update([
            'status' => 'submitted',
        ]);
    }
    // Accessor untuk menghitung total reject berdasarkan asal_reject
    public function getNgTotalsAttribute()
    {
        return $this->details()
            ->selectRaw('reject_types.asal_reject, SUM(reject_report_details.qty_reject) as total')
            ->join(
                'reject_types',
                'reject_report_details.reject_type_id',
                '=',
                'reject_types.id'
            )
            ->where('reject_report_details.status_reject', 'NG')
            ->groupBy('reject_types.asal_reject')
            ->pluck('total', 'reject_types.asal_reject')
            ->toArray();
    }
    // Accessor untuk menghitung total repair
    public function getTotalRepairAttribute()
    {
        return $this->details()
            ->where('status_reject', 'REP')
            ->sum('qty_reject');
    }
    // Method untuk menghitung total reject
    public function getTotalRejectAAttribute()
    {
        return ($this->total_reject_fg ?? 0) +
            ($this->total_reject_stl_htr ?? 0) +
            ($this->total_reject_mc ?? 0) +
            ($this->total_reject_inpk ?? 0);
    }

    public function getFullTitleAttribute()
    {
        return $this->part->part_name . ' '  . $this->lot_number;
    }
}
