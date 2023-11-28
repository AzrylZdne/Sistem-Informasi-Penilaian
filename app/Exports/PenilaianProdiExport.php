<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PenilaianProdiExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    private $rowNumber = 0;
    public function collection()
    {
        $this->rowNumber = 0; // Set nomor urut ke 0
        return DB::table('penilaian_prodi')
            ->select('penilaian_kode', 'penilaian_tgl', DB::raw('prodi.nama_prodi AS namaprodi'), DB::raw('fakultas.nama_fakultas AS namafakultas'), DB::raw('SUM(sub_kategori.bobot) AS totalbobot'), DB::raw('SUM(masuk_nilaip) as totalnilai'), DB::raw('SUM(score) as totalscore'))
            ->leftJoin('prodi', 'prodi.kode_prodi', '=', 'penilaian_kodeprodi')
            ->leftJoin('fakultas', 'fakultas.kode_fakultas', '=', 'prodi.prodi_kodefakultas')
            ->leftJoin('kategori', 'kategori.id', '=', 'penilaian_idkategori')
            ->leftJoin('sub_kategori', 'sub_kategori.id', '=', 'penilaian_idsubkategori')
            ->groupBy('namafakultas')
            ->orderByDesc(DB::raw('SUM(masuk_nilaip)'))
            ->get();
    }

    public function headings(): array
    {
        return ["No", "Kode Penilaian", "Tanggal", "Prodi", "Fakultas", "Total Bobot", "Total Nilai", "Total Score"];
    }

    public function map($row): array
    {
        return [
            ++$this->rowNumber, // Nomor urut
            $row->penilaian_kode,
            $row->penilaian_tgl,
            $row->namaprodi,
            $row->namafakultas,
            $row->totalbobot,
            $row->totalnilai,
            $row->totalscore
        ];
    }
}
