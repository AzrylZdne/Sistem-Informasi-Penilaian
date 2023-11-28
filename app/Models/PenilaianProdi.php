<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianProdi extends Model
{
    use HasFactory;

    protected $table = 'penilaian_prodi';
    protected $primaryKey = 'id';

    protected $fillable = [
        'penilaian_kode',
        'penilaian_tgl',
        'penilaian_kodeprodi',
        'penilaian_idkategori',
        'penilaian_idsubkategori',
        'masuk_nilaip',
        'score',
        'iduser'
    ];

    // public $incrementing = false;
    public $timestamps = true;
}
