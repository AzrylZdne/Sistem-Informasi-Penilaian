<?php

namespace App\Http\Controllers;

use App\Models\Bobot;
use App\Models\DetailKategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class BobotController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('sub_kategori')
                ->select(DB::raw('sub_kategori.id AS id'), DB::raw('kategori.nama_kategori AS namakategori'), 'kategori_detail', DB::raw('sub_kategori.bobot as bobot'))
                ->leftJoin('kategori', 'kategori.id', '=', 'id_kategori')
                ->get();
            // $data = Kategori::select('nmkat,idkat')->get();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '<button onclick="removedata(' . $row->id . ')" type="button" class="btn btn-sm btn-danger" title="Remove Data">
                    <i id="deleteIcon_' . $row->id . '" class="fas fa-trash-alt"></i>
                        <span id="deleteSpinner_' . $row->id . '" class="fas fa-spinner fa-spin" style="display: none;"></span>
                    </button>&nbsp<button onclick="editdata(' . $row->id . ')" type="button" class="btn btn-sm btn-info" title="Edit Data">
                    <i id="editIcon_' . $row->id . '" class="fas fa-edit"></i>
                        <span id="editSpinner_' . $row->id . '" class="fas fa-spinner fa-spin" style="display: none;"></span>
                    </button>';
                })
                ->make(true);
        }
        return view('page.bobot.index');
    }

    public function formAdd(Request $request)
    {
        if ($request->ajax()) {
            $json = [
                'data' => view('page.bobot.modal_tambah')->with(['databobot' => DetailKategori::all()])->render(),
            ];

            return response()->json($json);
        }
    }
    public function editData(Request $request, $id)
    {
        if ($request->ajax()) {
            $bobot = Bobot::find($id);
            $data = [
                'datadetail' => $bobot,
                'datakategori' => DetailKategori::all()
            ];
            $json = [
                'data' => view('page.bobot.modal_edit')->with($data)->render()
            ];

            return response()->json($json);
        }
    }

    public function saveData(Request $request)
    {
        if ($request->ajax()) {
            $idkategori = $request->idkategori;
            $detailkategori = $request->kategori_detail;
            $inputbobot = $request->bobot;

            $validation = $request->validate(
                [
                    'kategori_detail' => 'required',
                    'bobot' => 'required',
                ],
                [
                    'kategori_detail.required' => ':attribute Tidak Boleh Kosong',
                    'bobot.required' => ':attribute Tidak Boleh Kosong',
                ],
                [
                    'idkategori' => 'ID Kategori',
                    'kategori_detail' => 'Nama Kategori',
                    'bobot' => 'Input Bobot'
                ]
            );



            $data = new Bobot();
            $data->id_kategori = $idkategori;
            $data->kategori_detail = $detailkategori;
            $data->bobot = $inputbobot;
            $data->save();

            $json = [
                'sukses' => 'Data Berhasil Tersimpan'
            ];
            return response()->json($json);
        }
    }
    public function updateData(Request $request)
    {
        if ($request->ajax()) {
            $idbobot = $request->post('idbobot');
            $idkategori = $request->post('idkategori');
            $kategori_detail = $request->post('detailkategori');
            $nilaibobot = $request->post('bobot');

            $validation = $request->validate(
                [
                    'detailkategori' => 'required',
                    'bobot' => 'required',
                ],
                [
                    'detailkategori.required' => ':attribute Tidak Boleh Kosong',
                    'bobot.required' => ':attribute Tidak Boleh Kosong',
                ],
                [
                    'detailkategori' => 'Nama Kategori',
                    'bobot' => 'Nilai Bobot',
                ]
            );

            $bobot = Bobot::find($idbobot);
            $bobot->id_kategori = $idkategori;
            $bobot->kategori_detail = $kategori_detail;
            $bobot->bobot = $nilaibobot;
            $bobot->save();

            $json = [
                'sukses' => 'Data Berhasil di-Update'
            ];
            return response()->json($json);
        }
    }

    public function deleteData(Request $request, $id)
    {
        if ($request->ajax()) {
            $bobot = Bobot::find($id);
            $bobot->delete();
            $json = [
                'sukses' => 'Data bobot berhasil dihapus !'
            ];

            return response()->json($json);
        }
    }
}
