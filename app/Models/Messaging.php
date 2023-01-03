<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Messaging extends Model
{
    use HasFactory;
    protected $fillable = [
        'agent_id', 'message', 'user_id'
    ];
}
