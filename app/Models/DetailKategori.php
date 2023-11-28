<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailKategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nama_kategori',
        'jumlahbobot'
    ];

    public $timestamps = true;
}
