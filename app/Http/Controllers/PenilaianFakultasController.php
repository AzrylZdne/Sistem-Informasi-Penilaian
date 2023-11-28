<?php

namespace App\Http\Controllers;

use App\Exports\PenilaianFakultasExport;
use App\Models\DetailKategori;
use App\Models\Fakultas;
use App\Models\PenilaianFakultas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class PenilaianFakultasController extends Controller
{
    public function buatKodeOtomatis()
    {
        $iduser = Auth::user()->id;
        $hasil = DB::table('penilaian_fakultas')->select(DB::raw('max(penilaian_kode) as penilaian_kode'))->where('iduser', '=', $iduser)->limit(1)->first();
        $data  = $hasil->penilaian_kode;

        $lastNoUrut = substr($data, -4);
        $nextNoUrut = intval($lastNoUrut) + 1;
        $kodePenilaian = 'PLF-' . $iduser . substr(time(), -5) . sprintf('%04s', $nextNoUrut);

        return $kodePenilaian;
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if (Auth::user()->role == 'admin') {
                $data = DB::table('penilaian_fakultas')
                    ->select(
                        'penilaian_kodefakultas',
                        'penilaian_fakultas.masuk_nilai',
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
                    ->get()
                    ->each(function ($row) {
                        $details = DB::table('penilaian_fakultas')
                            ->select('masuk_nilai', 'score', 'users.fullname')
                            ->join('users', 'penilaian_fakultas.iduser', '=', 'users.id')
                            ->where('penilaian_kodefakultas', $row->penilaian_kodefakultas)
                            ->get();

                        $datas = [];
                        foreach ($details->groupBy('fullname') as $key => $items) {
                            array_push($datas, [
                                "nama_juri" => $key,
                                "total_nilai" => number_format($items->sum('masuk_nilai')),
                                "total_score" => number_format($items->sum('score')),
                            ]);
                        }
                        $row->detail = $datas;
                    });
            } elseif (Auth::user()->role == 'juri') {
                $iduser = Auth::user()->id;
                $data = DB::table('penilaian_fakultas')
                    ->select(
                        'penilaian_kodefakultas',
                        'penilaian_fakultas.masuk_nilai',
                        'penilaian_kode',
                        'penilaian_tgl',
                        DB::raw('fakultas.nama_fakultas AS namafakultas'),
                        DB::raw('SUM(sub_kategori.bobot) AS totalbobot'),
                        DB::raw('SUM(masuk_nilai) as totalnilai'),
                        DB::raw('SUM(score) as totalscore'),
                    )
                    ->leftJoin('fakultas', 'fakultas.kode_fakultas', '=', 'penilaian_kodefakultas')
                    ->leftJoin('sub_kategori', 'sub_kategori.id', '=', 'penilaian_idsubkategori')
                    ->where('iduser', '=', $iduser)
                    ->groupBy('penilaian_kode', 'penilaian_tgl', 'namafakultas')
                    ->get();
            }

            return Datatables::of($data)->addIndexColumn()
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
                ->rawColumns(['namafakultas', 'totalbobot', 'totalnilai', 'totalscore', 'action'])
                ->make(true);
        }

        return view('page.penilaianfakultas.index');
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
        return view('page.penilaianfakultas.formtambah')->with($data);
    }

    public function edit(Request $request, $id)
    {
        $id = Crypt::decryptString($id);
        $datapenilaian = DB::table('penilaian_fakultas')->where('penilaian_kode', '=', $id)->get()->first();
        $query_datapenilaian = DB::table('penilaian_fakultas')
            ->select('nama_kategori', DB::raw('kategori.id AS idkategori'), DB::raw('kategori.`jumlahbobot` AS jmlbobotkategori'), DB::raw('sub_kategori.id AS iddetailkategori'), DB::raw('sub_kategori.`kategori_detail` AS nmkategoridetail'), DB::raw('sub_kategori.`bobot` AS jmlbobotdetail'), DB::raw('penilaian_fakultas.id AS idpenilaian'), 'penilaian_kode', DB::raw('masuk_nilai AS nilai'), 'score')
            ->join('kategori', 'penilaian_fakultas.penilaian_idkategori', '=', 'kategori.id')
            ->join('sub_kategori', 'penilaian_fakultas.penilaian_idsubkategori', '=', 'sub_kategori.id')
            ->where('penilaian_kode', '=', $id)
            ->get();
        $data = [
            'kodepenilaian' => $id,
            'datapenilaian' => $datapenilaian,
            'datafakultas' => DB::table('fakultas')->where('kode_fakultas', $datapenilaian->penilaian_kodefakultas)->first(),
            'datadetailpenilaian' => $query_datapenilaian
        ];
        return view('page.penilaianfakultas.formedit')->with($data);
    }


    public function simpan(Request $request)
    {
        if ($request->ajax()) {
            $kodepenilaian = $request->post('kodepenilaian');
            $idfakultas = $request->post('idfakultas');
            $tanggal = $request->post('tanggal');

            $idkategori = $request->post('idkategori');
            $jmlbobot = $request->post('jmlbobot');
            $iddetailkategori = $request->post('iddetailkategori');
            $masuknilai = $request->post('masuknilai');

            $validation = $request->validate(
                [
                    'idfakultas' => 'required',
                    'tanggal' => 'required',


                ],
                [
                    'idfakultas.required' => ':attribute Tidak Boleh Kosong',
                    'tanggal.required' => ':attribute Tidak Boleh Kosong',
                ],
                [
                    'idfakultas' => 'Pilih Fakultas',
                    'tanggal' => 'Tanggal Penilaian',
                ]
            );

            $jmldata = count($idkategori);
            $iduser = Auth::user()->id;

            for ($i = 0; $i < $jmldata; $i++) {
                // Simpan data
                // Hitung Score
                $hitung_score = ($jmlbobot[$i] * $masuknilai[$i]) / 100;

                $penilaian_fakultas = new PenilaianFakultas();
                $penilaian_fakultas->penilaian_kode = $kodepenilaian;
                $penilaian_fakultas->penilaian_tgl = $tanggal;
                $penilaian_fakultas->penilaian_kodefakultas = $idfakultas;
                $penilaian_fakultas->penilaian_idkategori = $idkategori[$i];
                $penilaian_fakultas->penilaian_idsubkategori = $iddetailkategori[$i];
                $penilaian_fakultas->masuk_nilai = $masuknilai[$i];
                $penilaian_fakultas->score = $hitung_score;
                $penilaian_fakultas->iduser = $iduser;
                $penilaian_fakultas->save();
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
            $kodepenilaian = $request->post('kodepenilaian');
            $idfakultas = $request->post('idfakultas');
            $tanggal = $request->post('tanggal');

            $idkategori = $request->post('idkategori');
            $jmlbobot = $request->post('jmlbobot');
            $iddetailkategori = $request->post('iddetailkategori');
            $masuknilai = $request->post('masuknilai');
            $idpenilaian = $request->post('idpenilaian');

            $jmldata = count($idkategori);
            $iduser = Auth::user()->id;

            for ($i = 0; $i < $jmldata; $i++) {
                // Simpan data
                // Hitung Score
                $hitung_score = ($jmlbobot[$i] * $masuknilai[$i]) / 100;

                $penilaian_fakultas = PenilaianFakultas::find($idpenilaian[$i]);
                $penilaian_fakultas->masuk_nilai = $masuknilai[$i];
                $penilaian_fakultas->score = $hitung_score;
                $penilaian_fakultas->save();
            }


            $json = [
                'sukses' => 'Penilaian berhasil di-Update !'
            ];
            return response()->json($json);
        }
    }

    public function deleteDetail(Request $request, $id)
    {
        if ($request->ajax()) {
            $penilaian_fakultas = PenilaianFakultas::find($id);
            $penilaian_fakultas->delete();

            $json = [
                'sukses' => 'Data detail berhasil dihapus !'
            ];

            return response()->json($json);
        }
    }
    public function deleteData(Request $request, $id)
    {
        if ($request->ajax()) {
            DB::table('penilaian_fakultas')->where('penilaian_kode', '=', $id)->delete();

            $json = [
                'sukses' => 'Data penilaiaan berhasil dihapus !'
            ];

            return response()->json($json);
        }
    }

    public function doExportExcel()
    {
        return Excel::download(new PenilaianFakultasExport, 'penilaian-fakultas-' . time() . '.xlsx');
    }
}