<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PenilaianFakultasExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    private $rowNumber = 0;
    public function collection()
    {
        $this->rowNumber = 0; // Set nomor urut ke 0
        // return DB::table('penilaian_fakultas')->select('penilaian_kode', 'penilaian_tgl')->get();
        return DB::table('penilaian_fakultas')
            ->select(
                'penilaian_kode',
                'penilaian_tgl',
                DB::raw('fakultas.nama_fakultas AS namafakultas'),
                DB::raw('SUM(sub_kategori.bobot) AS totalbobot'),
                DB::raw('SUM(masuk_nilai) as totalnilai'),
                DB::raw('SUM(score) as totalscore'),
            )
            ->leftJoin('fakultas', 'fakultas.kode_fakultas', '=', 'penilaian_kodefakultas')
            ->leftJoin('sub_kategori', 'sub_kategori.id', '=', 'penilaian_idsubkategori')
            ->groupBy('namafakultas')
            ->orderByDesc(DB::raw('SUM(score)'))
            ->get();
    }

    public function headings(): array
    {
        return ["No", "Kode Penilaian", "Tanggal", "Nama Fakultas", "Total Bobot", "Total Nilai", "Total Score"];
    }

    public function map($row): array
    {
        return [
            ++$this->rowNumber, // Nomor urut
            $row->penilaian_kode,
            $row->penilaian_tgl,
            $row->namafakultas,
            $row->totalbobot,
            $row->totalnilai,
            $row->totalscore
        ];
    }
}
