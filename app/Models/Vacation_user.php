<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacation_user extends Model
{
    use HasFactory;
    protected $fillable = ['departure_date','return_date', 'observation','user_id','vacation_id'];
}
