<?php

namespace App\Http\Controllers;

use App\Models\Fakultas;
use App\Models\Prodi as ModelsProdi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ProdiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('prodi')
                ->select('kode_prodi', 'nama_fakultas', 'nama_prodi', DB::raw('prodi.link_web as webprodi'))
                ->leftJoin('fakultas', 'fakultas.kode_fakultas', '=', 'prodi_kodefakultas')->get();

            return Datatables::of($data)->addIndexColumn()
                ->editColumn('webprodi', function ($row) {
                    return '<a href="' . $row->webprodi . '" target="_blank">' . $row->webprodi . '</a>';
                })
                ->rawColumns(['action', 'webprodi'])
                ->addColumn('action', function ($row) {
                    return '<button onclick="removedata(\'' . $row->kode_prodi . '\')" type="button" class="btn btn-sm btn-danger" title="Remove Data">
                    <i id="deleteIcon_' . $row->kode_prodi . '" class="fas fa-trash-alt"></i>
                        <span id="deleteSpinner_' . $row->kode_prodi . '" class="fas fa-spinner fa-spin" style="display: none;"></span>
                    </button>&nbsp<button onclick="editdata(\'' . $row->kode_prodi . '\')" type="button" class="btn btn-sm btn-info" title="Edit Data">
                    <i id="editIcon_' . $row->kode_prodi . '" class="fas fa-edit"></i>
                        <span id="editSpinner_' . $row->kode_prodi . '" class="fas fa-spinner fa-spin" style="display: none;"></span>
                    </button>';
                })
                ->make(true);
        }
        return view('page.prodi.index');
    }

    public function formAdd(Request $request)
    {
        if ($request->ajax()) {
            $data = [
                'datafakultas' => DB::table('fakultas')->select('*')->get()
            ];
            $json = [
                'data' => view('page.prodi.modal_tambah')->with($data)->render()
            ];

            return response()->json($json);
        }
    }
    public function editData(Request $request, $kode)
    {
        if ($request->ajax()) {
            $data = [
                'datafakultas' => DB::table('fakultas')->select('*')->get(),
                'data' => ModelsProdi::find($kode),
                'kodeprodi' => $kode
            ];
            $json = [
                'data' => view('page.prodi.modal_edit')->with($data)->render()
            ];

            return response()->json($json);
        }
    }

    public function saveData(Request $request)
    {
        // if ($request->ajax()) {
        $namaprodi = $request->post('namaprodi');
        $kodeprodi = $request->post('kodeprodi');
        $idfakultas = $request->post('idfakultas');
        $linkweb = $request->post('linkweb');


        $validation = $request->validate(
            [
                'kodeprodi' => 'required|unique:prodi,kode_prodi',
                'namaprodi' => 'required',
                'idfakultas' => 'required',
                'linkweb' => 'required|url'
            ],
            [
                'kodeprodi.required' => ':attribute Tidak Boleh Kosong',
                'kodeprodi.unique' => ':attribute sudah ada',
                'namaprodi.required' => ':attribute Tidak Boleh Kosong',
                'idfakultas.required' => ':attribute Tidak Boleh Kosong',
                'linkweb.required' => ':attribute Tidak Boleh Kosong',
                'linkweb.url' => ':attribute harus alamat url yang valid',
            ],
            [
                'kodeprodi' => 'Kode Prodi',
                'namaprodi' => 'Nama Prodi',
                'idfakultas' => 'Fakultas',
                'linkweb' => 'Alamat Web'
            ]
        );

        $prodi = new ModelsProdi();
        $prodi->kode_prodi = $kodeprodi;
        $prodi->nama_prodi = $namaprodi;
        $prodi->prodi_kodefakultas = $idfakultas;
        $prodi->link_web = $linkweb;
        $prodi->save();

        $json = [
            'sukses' => 'Data Berhasil Tersimpan'
        ];
        return response()->json($json);
        // }
    }
    public function updateData(Request $request)
    {
        if ($request->ajax()) {
            $kodeprodi = $request->post('kodeprodi');
            $namaprodi = $request->post('namaprodi');
            $kodeprodi = $request->post('kodeprodi');
            $idfakultas = $request->post('idfakultas');
            $linkweb = $request->post('linkweb');

            $validation = $request->validate(
                [
                    'namaprodi' => 'required',
                    'idfakultas' => 'required',
                    'linkweb' => 'required|url'
                ],
                [
                    'namaprodi.required' => ':attribute Tidak Boleh Kosong',
                    'idfakultas.required' => ':attribute Tidak Boleh Kosong',
                    'linkweb.required' => ':attribute Tidak Boleh Kosong',
                    'linkweb.url' => ':attribute harus alamat url yang valid',
                ],
                [
                    'namaprodi' => 'Nama Prodi',
                    'idfakultas' => 'Fakultas',
                    'linkweb' => 'Alamat Web'
                ]
            );

            $prodi = ModelsProdi::find($kodeprodi);
            $prodi->nama_prodi = $namaprodi;
            $prodi->prodi_kodefakultas = $idfakultas;
            $prodi->link_web = $linkweb;
            $prodi->save();

            $json = [
                'sukses' => 'Data Berhasil di-Update'
            ];
            return response()->json($json);
        }
    }

    public function deleteData(Request $request, $kode)
    {
        if ($request->ajax()) {
            $prodi = ModelsProdi::find($kode);
            $prodi->delete();
            $json = [
                'sukses' => 'Data prodi berhasil dihapus !'
            ];

            return response()->json($json);
        }
    }
}
