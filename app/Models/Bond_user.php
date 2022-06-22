<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bond_user extends Model
{
    use HasFactory;
    protected $fillable = ['name','amount','description','user_id','bond_id'];
}
