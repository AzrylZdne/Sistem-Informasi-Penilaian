<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianFakultas extends Model
{
    use HasFactory;

    protected $table = 'penilaian_fakultas';
    protected $primaryKey = 'id';

    protected $fillable = [
        'penilaian_kode',
        'penilaian_tgl',
        'penilaian_kodefakultas',
        'penilaian_idkategori',
        'penilaian_idsubkategori',
        'masuk_nilai',
        'score',
        'iduser'
    ];

    // public $incrementing = false;
    public $timestamps = true;
}
