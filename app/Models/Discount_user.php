<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount_user extends Model
{
    use HasFactory;
    protected $fillable = ['observation','user_id','discount_id'];
}
