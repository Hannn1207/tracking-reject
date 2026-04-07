<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProductionReportDetail;
use Carbon\Carbon;

class ProductionReport extends Model
{
    protected $table = 'production_reports';
    protected $fillable = [
        'tanggal',
        'meja',
        'line',
    ];
    // Relasi dengan model ProductionReportDetail
    public function details()
    {
        return $this->hasMany(ProductionReportDetail::class);
    }

    // Accessor untuk mendapatkan full title
    public function getFullTitleAttribute()
    {
        return 'Meja ' . $this->meja
            . ' - Line ' . $this->line
            . ' - ' . Carbon::parse($this->tanggal)->translatedFormat('d F Y');
    }
}
