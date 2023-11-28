<?php

namespace App\Http\Controllers;

use App\Exports\PenilaianFakultasExport;
use App\Exports\PenilaianProdiExport;
use App\Models\DetailKategori;
use App\Models\Fakultas;
use App\Models\PenilaianProdi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class PenilaianProdiController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $iduser = Auth::user()->id;
            if (Auth::user()->role == 'admin') {
                $data = DB::table('penilaian_prodi')
                ->select('penilaian_kodeprodi', 'penilaian_prodi.masuk_nilaip', 'penilaian_kode', 'penilaian_tgl', DB::raw('prodi.nama_prodi AS namaprodi'), DB::raw('fakultas.nama_fakultas AS namafakultas'), DB::raw('SUM(sub_kategori.bobot) AS totalbobot'), DB::raw('SUM(masuk_nilaip) as totalnilai'), DB::raw('SUM(score) as totalscore'))
                ->leftJoin('prodi', 'prodi.kode_prodi', '=', 'penilaian_kodeprodi')
                ->leftJoin('fakultas', 'fakultas.kode_fakultas', '=', 'prodi.prodi_kodefakultas')
                ->leftJoin('kategori', 'kategori.id', '=', 'penilaian_idkategori')
                ->leftJoin('sub_kategori', 'sub_kategori.id', '=', 'penilaian_idsubkategori')
                ->groupBy('namafakultas')
                    ->orderByDesc(DB::raw('SUM(masuk_nilaip)'))
                    ->get()
                ->each(function($row){
                    $details = DB::table('penilaian_prodi')
                                    ->select('masuk_nilaip','score','users.fullname')
                                    ->join('users','penilaian_prodi.iduser','=','users.id')
                                    ->where('penilaian_kodeprodi',$row->penilaian_kodeprodi)
                                    ->get();

                    $datas = [];
                    foreach($details->groupBy('fullname') as $key => $items){
                        array_push($datas, [
                            "nama_juri"=>$key,
                            "total_nilai"=>$items->sum('masuk_nilaip'),
                            "total_score"=>$items->sum('score'),
                        ]);
                    }
                    $row->detail = $datas;
                });
            } elseif (Auth::user()->role == 'juri') {
                $data = DB::table('penilaian_prodi')
                    ->select('penilaian_kodeprodi', 'penilaian_prodi.masuk_nilaip', 'penilaian_kode', 'penilaian_tgl', DB::raw('prodi.nama_prodi AS namaprodi'), DB::raw('fakultas.nama_fakultas AS namafakultas'), DB::raw('SUM(sub_kategori.bobot) AS totalbobot'), DB::raw('SUM(masuk_nilaip) as totalnilai'), DB::raw('SUM(score) as totalscore'))
                    ->leftJoin('prodi', 'prodi.kode_prodi', '=', 'penilaian_kodeprodi')
                    ->leftJoin('fakultas', 'fakultas.kode_fakultas', '=', 'prodi.prodi_kodefakultas')
                    ->leftJoin('kategori', 'kategori.id', '=', 'penilaian_idkategori')
                    ->leftJoin('sub_kategori', 'sub_kategori.id', '=', 'penilaian_idsubkategori')
                    ->where('iduser', '=', $iduser)
                    ->groupBy('penilaian_kode', 'penilaian_tgl', 'namaprodi', 'namafakultas')->get();
            }


            return Datatables::of($data)->addIndexColumn()
                ->rawColumns(['action', 'totalbobot', 'namaprodi', 'namafakultas'])
                ->editColumn('totalscore', function ($row) {
                    return "<span class=\"badge badge-success\">" . number_format($row->totalscore, 0, ",", ".") . "</span>";
                })
                ->editColumn('totalbobot', function ($row) {
                    return "<span class=\"badge badge-primary\">" . number_format($row->totalbobot, 0, ",", ".") . "</span>";
                })
                ->editColumn('totalnilai', function ($row) {
                    return "<span class=\"badge badge-info\">" . number_format($row->totalnilai, 0, ",", ".") . "</span>";
                })
                ->addColumn('action', function ($row) {
                    return '<button onclick="removedata(\'' . $row->penilaian_kode . '\')" type="button" class="btn btn-sm btn-danger" title="Remove Data">
                    <i id="deleteIcon_' . $row->penilaian_kode . '" class="fas fa-trash-alt"></i>
                        <span id="deleteSpinner_' . $row->penilaian_kode . '" class="fas fa-spinner fa-spin" style="display: none;"></span>
                    </button>&nbsp<button onclick="editdata(\'' . Crypt::encryptString($row->penilaian_kode) . '\')" type="button" class="btn btn-sm btn-info" title="Edit Data">
                    <i id="editIcon_' . $row->penilaian_kode . '" class="fas fa-edit"></i>
                        <span id="editSpinner_' . $row->penilaian_kode . '" class="fas fa-spinner fa-spin" style="display: none;"></span>
                    </button>';
                })
                ->rawColumns(['namaprodi', 'namafakultas', 'totalbobot', 'totalnilai', 'totalscore', 'action'])
                ->make(true);
        }

        return view('page.penilaianprodi.index');
    }

    public function buatKodeOtomatis()
    {
        $iduser = Auth::user()->id;
        $hasil = DB::table('penilaian_prodi')->select(DB::raw('max(penilaian_kode) as penilaian_kode'))->where('iduser', '=', $iduser)->limit(1)->first();
        $data  = $hasil->penilaian_kode;

        $lastNoUrut = substr($data, -4);
        $nextNoUrut = intval($lastNoUrut) + 1;
        $kodePenilaian = 'PLP-' . $iduser . substr(time(), -5) . sprintf('%04s', $nextNoUrut);

        return $kodePenilaian;
    }
    public function add(Request $request)
    {
        $query_datapenilaian = DB::table('sub_kategori')
            ->select('nama_kategori', DB::raw('kategori.id AS idkategori'), DB::raw('kategori.`jumlahbobot` AS jmlbobotkategori'), DB::raw('sub_kategori.id AS iddetailkategori'), DB::raw('sub_kategori.`kategori_detail` AS nmkategoridetail'), DB::raw('sub_kategori.`bobot` AS jmlbobotdetail'))
            ->join('kategori', 'sub_kategori.id_kategori', '=', 'kategori.id')
            ->get();
        $data = [
            'datafakultas' => DB::table('fakultas')->select('*')->get(),
            'kodepenilaian' => $this->buatKodeOtomatis(),
            'datapenilaian' => $query_datapenilaian
        ];
        return view('page.penilaianprodi.formtambah')->with($data);
    }

    public function pilihProdi(Request $request)
    {
        if ($request->ajax()) {
            $idfakultas = $request->post('idfakultas');

            $getDataProdi = DB::table('prodi')->select('kode_prodi', 'nama_prodi', DB::raw('prodi.kode_prodi AS idprodi'))->where('prodi_kodefakultas', '=', $idfakultas)->get();

            if ($getDataProdi) {
                foreach ($getDataProdi as $d) :
                    echo "<option value=\"$d->kode_prodi\">" . $d->nama_prodi . "</option>";
                endforeach;
            }
        }
    }

    // public function tampilDataDetail(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $kodepenilaian = $request->post('kodepenilaian');

    //         $query_data = DB::table('penilaian_prodi')->select([
    //             'penilaian_prodi.id AS idpenilaian',
    //             'detail_kategori.nama_kategori AS namakategori',
    //             'bobot.kategori_detail AS detailkategori',
    //             'bobot.bobot AS jmlbobot',
    //             'masuk_nilaip',
    //             'score'
    //         ])->leftJoin('detail_kategori', 'detail_kategori.id', '=', 'penilaian_iddetailkategori')
    //             ->leftJoin('bobot', 'bobot.id', '=', 'penilaian_idbobot')
    //             ->where('penilaian_kode', '=', $kodepenilaian)->get();

    //         $json = [
    //             'data' => view('page.penilaianprodi.datadetail')->with([
    //                 'datadetail' => $query_data
    //             ])->render()
    //         ];

    //         return response()->json($json);
    //     }
    // }

    // public function deleteDetail(Request $request, $id)
    // {
    //     if ($request->ajax()) {
    //         $penilaian_prodi = PenilaianProdi::find($id);
    //         $penilaian_prodi->delete();

    //         $json = [
    //             'sukses' => 'Data detail berhasil dihapus !'
    //         ];

    //         return response()->json($json);
    //     }
    // }

    // public function modalCariBobot(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $kategoriPenilaian = $request->post('kategoriPenilaian');

    //         $getDataBobot = DB::table('bobot')->where('id_kategori', '=', $kategoriPenilaian)->get();

    //         $json = [
    //             'data' => view('page.penilaianprodi.modalcaridetailbobot')->with([
    //                 'dataBobot' => $getDataBobot
    //             ])->render()
    //         ];

    //         return response()->json($json);
    //     }
    // }

    public function simpan(Request $request)
    {
        if ($request->ajax()) {
            $kodepenilaian = $request->post('kodepenilaian');
            $idfakultas = $request->post('idfakultas');
            $idprodi = $request->post('idprodi');
            $tanggal = $request->post('tanggal');

            $idkategori = $request->post('idkategori');
            $jmlbobot = $request->post('jmlbobot');
            $iddetailkategori = $request->post('iddetailkategori');
            $masuknilai = $request->post('masuknilai');


            $validation = $request->validate(
                [
                    'idfakultas' => 'required',
                    'idprodi' => 'required',
                    'tanggal' => 'required',


                ],
                [
                    'idfakultas.required' => ':attribute Tidak Boleh Kosong',
                    'idprodi.required' => ':attribute Tidak Boleh Kosong',
                    'tanggal.required' => ':attribute Tidak Boleh Kosong',
                ],
                [
                    'idfakultas' => 'Pilih Fakultas',
                    'idprodi' => 'Pilih Prodi',
                    'tanggal' => 'Tanggal Penilaian',
                ]
            );

            $jmldata = count($idkategori);
            $iduser = Auth::user()->id;

            for ($i = 0; $i < $jmldata; $i++) {
                // Simpan data
                // Hitung Score
                $hitung_score = ($jmlbobot[$i] * $masuknilai[$i]) / 100;

                $penilaian_prodi = new PenilaianProdi();
                $penilaian_prodi->penilaian_kode = $kodepenilaian;
                $penilaian_prodi->penilaian_tgl = $tanggal;
                $penilaian_prodi->penilaian_kodeprodi = $idprodi;
                $penilaian_prodi->penilaian_idkategori = $idkategori[$i];
                $penilaian_prodi->penilaian_idsubkategori = $iddetailkategori[$i];
                $penilaian_prodi->masuk_nilaip = $masuknilai[$i];
                $penilaian_prodi->score = $hitung_score;
                $penilaian_prodi->iduser = $iduser;
                $penilaian_prodi->save();
            }

            $json = [
                'sukses' => 'Penilaian berhasil disimpan !'
            ];
            return response()->json($json);
        }
    }
    public function updateData(Request $request)
    {
        if ($request->ajax()) {
            $idpenilaian = $request->post('idpenilaian');
            $idkategori = $request->post('idkategori');
            $jmlbobot = $request->post('jmlbobot');
            $iddetailkategori = $request->post('iddetailkategori');
            $masuknilai = $request->post('masuknilai');


            $jmldata = count($idkategori);
            $iduser = Auth::user()->id;

            for ($i = 0; $i < $jmldata; $i++) {
                // Simpan data
                // Hitung Score
                $hitung_score = ($jmlbobot[$i] * $masuknilai[$i]) / 100;

                $penilaian_prodi = PenilaianProdi::find($idpenilaian[$i]);
                $penilaian_prodi->masuk_nilaip = $masuknilai[$i];
                $penilaian_prodi->score = $hitung_score;
                $penilaian_prodi->save();
            }

            $json = [
                'sukses' => 'Penilaian berhasil di-Update !'
            ];
            return response()->json($json);
        }
    }
    public function deleteData(Request $request, $id)
    {
        if ($request->ajax()) {
            DB::table('penilaian_prodi')->where('penilaian_kode', '=', $id)->delete();

            $json = [
                'sukses' => 'Data penilaiaan berhasil dihapus !'
            ];

            return response()->json($json);
        }
    }

    public function edit(Request $request, $id)
    {
        $id = Crypt::decryptString($id);
        $datapenilaian = DB::table('penilaian_prodi')->where('penilaian_kode', '=', $id)->get()->first();
        $dataProdi = DB::table('prodi')->where('kode_prodi', '=', $datapenilaian->penilaian_kodeprodi)->get()->first();

        $query_datapenilaian = DB::table('penilaian_prodi')
            ->select('nama_kategori', DB::raw('kategori.id AS idkategori'), DB::raw('kategori.`jumlahbobot` AS jmlbobotkategori'), DB::raw('sub_kategori.id AS iddetailkategori'), DB::raw('sub_kategori.`kategori_detail` AS nmkategoridetail'), DB::raw('sub_kategori.`bobot` AS jmlbobotdetail'), DB::raw('penilaian_prodi.id AS idpenilaian'), 'penilaian_kode', DB::raw('masuk_nilaip AS nilai'), 'score')
            ->join('kategori', 'penilaian_prodi.penilaian_idkategori', '=', 'kategori.id')
            ->join('sub_kategori', 'penilaian_prodi.penilaian_idsubkategori', '=', 'sub_kategori.id')
            ->where('penilaian_kode', '=', $id)
            ->get();
        $data = [
            'kodepenilaian' => $id,
            'datapenilaian' => $datapenilaian,
            'dataprodi' => $dataProdi,
            'datafakultas' =>  DB::table('fakultas')->where('kode_fakultas', '=', $dataProdi->prodi_kodefakultas)->get()->first(),
            'datadetailpenilaian' => $query_datapenilaian
        ];
        return view('page.penilaianprodi.formedit')->with($data);
    }

    public function doExportExcel()
    {
        return Excel::download(new PenilaianProdiExport, 'penilaian-prodi-' . time() . '.xlsx');
    }
}