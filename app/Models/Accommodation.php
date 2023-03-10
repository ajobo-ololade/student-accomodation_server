<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accommodation extends Model
{
    use HasFactory;
    protected $fillable = [
        'hostel_address', 'amount', 'image', 'info', 'facilities',
    ];

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'accommodation_id', 'id');
    }
}
