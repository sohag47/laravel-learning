<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VWUsers extends Model
{
    use HasFactory;
    protected $table = 'vw_users';
    public $timestamps = false;
}
