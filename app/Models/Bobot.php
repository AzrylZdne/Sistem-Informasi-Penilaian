<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bobot extends Model
{
    use HasFactory;
    protected $table = 'sub_kategori';
    protected $primaryKey = 'id';

    protected $fillable = [
        'ide_kategori', 'kategori_detail', 'bobot'
    ];

    // public $incrementing = false;
    public $timestamps = true;
}
