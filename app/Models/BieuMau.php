<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bieumau extends Model
{
    use HasFactory;

    protected $table = 'bieumau';
      protected $fillable = [
        'tenbieumau',
        'tentaptin',
        'create_at'
    ];

    public $timestamps = false;
}
