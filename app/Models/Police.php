<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Police extends Model
{
    use HasFactory;

    protected $table = 'polices';
    //We want to insert all columns values
    protected $guarded = []; //
}
