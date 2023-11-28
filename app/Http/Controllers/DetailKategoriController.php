<?php

namespace App\Http\Controllers;

use App\Models\Bobot;
use App\Models\DetailKategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class DetailKategoriController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('kategori')->select('*')->get();

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
        return view('page.detailkategori.index');
    }

    public function formAdd(Request $request)
    {
        if ($request->ajax()) {
            $data = [
                'databobot' => Bobot::all()
            ];
            $json = [
                'data' => view('page.detailkategori.modal_tambah')->with($data)->render()
            ];

            return response()->json($json);
        }
    }

    public function editData(Request $request, $id)
    {
        if ($request->ajax()) {
            $data = [
                'data' => DetailKategori::find($id),
                'idkategori' => $id,
            ];
            $json = [
                'data' => view('page.detailkategori.modal_edit')->with($data)->render()
            ];

            return response()->json($json);
        }
    }

    public function saveData(Request $request)
    {
        if ($request->ajax()) {
            $namakategori = $request->post('namakategori');
            $jumlahbobot = $request->post('jumlahbobot');

            $validation = $request->validate(
                [
                    'namakategori' => 'required',
                    'jumlahbobot' => 'required'
                ],
                [
                    'namakategori.required' => ':attribute Tidak Boleh Kosong',
                    'jumlahbobot.required' => ':attribute Tidak Boleh Kosong',
                ],
                [
                    'jumlahbobot' => 'Jumlah Bobot',
                    'namakategori' => 'Detail Kategori',
                ]
            );

            $detail_kategori = new DetailKategori();
            $detail_kategori->nama_kategori = $namakategori;
            $detail_kategori->jumlahbobot = $jumlahbobot;
            $detail_kategori->save();

            $json = [
                'sukses' => 'Data Berhasil Tersimpan'
            ];
            return response()->json($json);
        }
    }
    public function updateData(Request $request)
    {
        if ($request->ajax()) {
            $idkategori = $request->post('idkategori');
            $namakategori = $request->post('namakategori');
            $jumlahbobot = $request->post('jumlahbobot');

            $validation = $request->validate(
                [
                    'namakategori' => 'required',
                    'jumlahbobot' => 'required',

                ],
                [
                    'namakategori.required' => ':attribute Tidak Boleh Kosong',
                    'jumlahbobot.required' => ':attribute Tidak Boleh Kosong',
                ],
                [
                    'jumlahbobot' => 'Jumlah Bobot',
                    'namakategori' => 'Nama Kategori',
                ]
            );

            $detail_kategori = DetailKategori::find($idkategori);
            $detail_kategori->nama_kategori = $namakategori;
            $detail_kategori->jumlahbobot = $jumlahbobot;
            $detail_kategori->save();

            $json = [
                'sukses' => 'Data Berhasil di-Update'
            ];
            return response()->json($json);
        }
    }

    public function deleteData(Request $request, $id)
    {
        if ($request->ajax()) {
            $detailkategori = DetailKategori::find($id);
            $detailkategori->delete();
            $json = [
                'sukses' => 'Data berhasil dihapus !'
            ];

            return response()->json($json);
        }
    }
}
