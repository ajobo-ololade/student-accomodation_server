<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccommodationTour extends Model
{
    use HasFactory;
    protected $fillable = [
        'tour_datetime', 'notes', 'accomodation_id'
    ];
}
