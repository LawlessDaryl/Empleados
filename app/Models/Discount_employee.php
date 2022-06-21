<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount_employee extends Model
{
    use HasFactory;
    protected $fillable = ['observation','employee_id','discount_id'];
}
