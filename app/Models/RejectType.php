<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RejectType extends Model
{
    use HasFactory;

    protected $table = 'reject_types';

    protected $fillable = [
        'nama_reject',
        'asal_reject'
    ];

    public function reject_reports()
    {
        return $this->hasMany(RejectReport::class);
    }

    // Provide a 'name' accessor for compatibility with Filament defaults
    public function getNameAttribute(): string
    {
        return $this->nama_reject;
    }
}
