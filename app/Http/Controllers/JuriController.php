<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class JuriController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // $data = Kategori::select('nmkat,idkat')->get();
            $data = DB::table('users')
                ->select('id', 'fullname', 'email')
                ->where('role', 'juri')->get();

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
        return view('page.userjuri.index');
    }

    public function formAdd(Request $request)
    {
        if ($request->ajax()) {
            $json = [
                'data' => view('page.userjuri.modal_tambah')->render()
            ];

            return response()->json($json);
        }
    }
    public function editData(Request $request, $id)
    {
        if ($request->ajax()) {
            $data = [
                'data' => User::find($id),
                'iduser' => $id,
            ];
            $json = [
                'data' => view('page.userjuri.modal_edit')->with($data)->render()
            ];

            return response()->json($json);
        }
    }

    public function saveData(Request $request)
    {
        if ($request->ajax()) {
            $fullname = $request->post('fullname');
            $email = $request->post('email');
            $pass = $request->post('pass');
            $confirmpass = $request->post('confirmpass');

            $validation = $request->validate(
                [
                    'email' => 'required|unique:users,email',
                    'fullname' => 'required',
                    'pass' => 'required|min:6',
                    'confirmpass' => 'required_with:pass|same:pass|min:6'
                ],
                [
                    'email.required' => ':attribute Tidak Boleh Kosong',
                    'email.unique' => ':attribute tidak boleh ada yang sama',
                    'fullname.required' => ':attribute Tidak Boleh Kosong',
                    'pass.required' => ':attribute Tidak Boleh Kosong',
                    'confirpass.required' => ':attribute Tidak Boleh Kosong',
                ],
                [
                    'email' => 'E-Mail',
                    'fullname' => 'Nama Lengkap',
                    'pass' => 'Inputan Password',
                    'confirmpass' => 'Confirm Password'
                ]
            );

            $users = new User();
            $users->fullname = $fullname;
            $users->email = $email;
            $users->role = 'juri';
            $users->password = Hash::make($pass);
            $users->save();

            $json = [
                'sukses' => 'Data Juri Berhasil Tersimpan'
            ];
            return response()->json($json);
        }
    }
    public function updateData(Request $request)
    {
        if ($request->ajax()) {
            $iduser = $request->post('iduser');
            $fullname = $request->post('fullname');
            $email = $request->post('email');
            $pass = $request->post('pass');
            $confirmpass = $request->post('confirmpass');

            $validation = $request->validate(
                [
                    'email' => [
                        'required',
                        Rule::unique('users', 'email')->ignore($request->iduser)
                    ],
                    'fullname' => 'required',
                    'confirmpass' => 'same:pass'
                ],
                [
                    'email.required' => ':attribute Tidak Boleh Kosong',
                    'email.unique' => ':attribute tidak boleh ada yang sama',
                    'fullname.required' => ':attribute Tidak Boleh Kosong',
                ],
                [
                    'email' => 'E-Mail',
                    'fullname' => 'Nama Lengkap',
                    'pass' => 'Inputan Password',
                    'confirmpass' => 'Confirm Password'
                ]
            );

            $users = User::find($iduser);
            $users->fullname = $fullname;
            $users->email = $email;
            $users->password = Hash::make($pass);
            $users->save();

            $json = [
                'sukses' => 'Data Juri Berhasil di-Update'
            ];
            return response()->json($json);
        }
    }

    public function deleteData(Request $request, $id)
    {
        if ($request->ajax()) {
            $user = User::find($id);
            $user->delete();
            $json = [
                'sukses' => 'Data user berhasil dihapus !'
            ];

            return response()->json($json);
        }
    }
}
