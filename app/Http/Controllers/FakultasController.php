<?php

namespace App\Http\Controllers;

use App\Models\Fakultas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class FakultasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // $data = Kategori::select('nmkat,idkat')->get();
            $data = DB::table('fakultas')->select('kode_fakultas', 'nama_fakultas', 'link_web')->get();
            return Datatables::of($data)->addIndexColumn()
                ->editColumn('link_web', function ($row) {
                    return '<a href="' . $row->link_web . '" target="_blank">' . $row->link_web . '</a>';
                })
                ->rawColumns(['action', 'link_web'])
                ->addColumn('action', function ($row) {
                    return '<button onclick="removedata(\'' . $row->kode_fakultas . '\')" type="button" class="btn btn-sm btn-danger" title="Remove Data">
                    <i id="deleteIcon_' . $row->kode_fakultas . '" class="fas fa-trash-alt"></i>
                        <span id="deleteSpinner_' . $row->kode_fakultas . '" class="fas fa-spinner fa-spin" style="display: none;"></span>
                    </button>&nbsp<button onclick="editdata(\'' . $row->kode_fakultas . '\')" type="button" class="btn btn-sm btn-info" title="Edit Data">
                    <i id="editIcon_' . $row->kode_fakultas . '" class="fas fa-edit"></i>
                        <span id="editSpinner_' . $row->kode_fakultas . '" class="fas fa-spinner fa-spin" style="display: none;"></span>
                    </button>';
                })
                ->make(true);
        }
        return view('page.fakultas.index');
    }

    public function formAdd(Request $request)
    {
        if ($request->ajax()) {
            $json = [
                'data' => view('page.fakultas.modal_tambah')->render()
            ];

            return response()->json($json);
        }
    }
    public function editData(Request $request, $id)
    {
        if ($request->ajax()) {
            $fakultas = Fakultas::find($id);
            $data = [
                'data' => $fakultas,
                'kodefakultas' => $id
            ];
            $json = [
                'data' => view('page.fakultas.modal_edit')->with($data)->render()
            ];

            return response()->json($json);
        }
    }
    public function deleteData(Request $request, $id)
    {
        if ($request->ajax()) {
            $fakultas = Fakultas::find($id);
            $fakultas->delete();
            $json = [
                'sukses' => 'Data fakultas berhasil dihapus !'
            ];

            return response()->json($json);
        }
    }

    public function saveData(Request $request)
    {
        if ($request->ajax()) {
            $namafakultas = $request->post('namafakultas');
            $kodefakultas = $request->post('kodefakultas');
            $linkweb = $request->post('linkweb');

            $validation = $request->validate(
                [
                    'kodefakultas' => 'required|unique:fakultas,kode_fakultas',
                    'namafakultas' => 'required',
                    'linkweb' => 'required|url'
                ],
                [
                    'kodefakultas.required' => ':attribute Tidak Boleh Kosong',
                    'namafakultas.required' => ':attribute Tidak Boleh Kosong',
                    'linkweb.required' => ':attribute Tidak Boleh Kosong',
                    'linkweb.url' => ':attribute harus alamat url yang valid',
                ],
                [
                    'kodefakultas' => 'Kode Fakultas',
                    'namafakultas' => 'Nama Fakultas',
                    'linkweb' => 'Alamat Web'
                ]
            );

            $fakultas = new Fakultas();
            $fakultas->kode_fakultas = $kodefakultas;
            $fakultas->nama_fakultas = $namafakultas;
            $fakultas->link_web = $linkweb;
            $fakultas->save();

            $json = [
                'sukses' => 'Data Berhasil Tersimpan'
            ];
            return response()->json($json);
        }
    }
    public function updateData(Request $request)
    {
        if ($request->ajax()) {
            $namafakultas = $request->post('namafakultas');
            $kodefakultas = $request->post('kodefakultas');
            $idfakultas = $request->post('idfakultas');
            $linkweb = $request->post('linkweb');

            $validation = $request->validate(
                [
                    'namafakultas' => 'required',
                    'linkweb' => 'required|url'
                ],
                [
                    'namafakultas.required' => ':attribute Tidak Boleh Kosong',
                    'linkweb.required' => ':attribute Tidak Boleh Kosong',
                    'linkweb.url' => ':attribute harus alamat url yang valid',
                ],
                [
                    'namafakultas' => 'Nama Fakultas',
                    'linkweb' => 'Alamat Web'
                ]
            );

            $fakultas = Fakultas::find($kodefakultas);
            $fakultas->nama_fakultas = $namafakultas;
            $fakultas->link_web = $linkweb;
            $fakultas->save();

            $json = [
                'sukses' => 'Data Berhasil di-Update'
            ];
            return response()->json($json);
        }
    }
}
