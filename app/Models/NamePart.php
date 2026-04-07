<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NamePart extends Model
{
    use HasFactory;
    protected $table = 'name_parts';
    protected $fillable = [
        'part_name',
        'customer',
        'part_image'
    ];

    public function reject_reports()
    {
        return $this->hashMany(RejectReport::class);
    }
}
