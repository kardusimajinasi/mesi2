<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use App\Models\Instansi;
use App\Models\Level;
use App\Models\User;
use Illuminate\Validation\Rules\Unique;

class UserController extends Controller
{
    protected $level;

    public function __construct(Level $level )
    {
        $this->level = $level;
    }

    public function index()
    {
        $levels = Level::all();
        $instansi = Instansi::all();
        // $instansi = DB::table('tbl_instansi')->where('id', $user->instansi_id)->first();
        return view('user.data-user', compact('levels', 'instansi'));
    }

    public function getDataUser(Request $request)
    {
        if ($request->ajax()) {
            $data = User::join('tbl_lvl', 'users.level_id', '=', 'tbl_lvl.id')
            ->join('tbl_instansi', 'users.instansi_id', '=', 'tbl_instansi.id')
            ->select('users.*', 'tbl_lvl.level as level', 'tbl_instansi.instansi as instansi')
            ->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('aksi', function($row) {
                    $editBtn = '<button class="btn btn-warning btn-sm" data-id="'.$row->id.'" onclick="editUser(this)">Edit</button>';
                    $deleteBtn = '<button class="btn btn-danger btn-sm" data-id="'.$row->id.'" onclick="deleteUser(this)">Hapus</button>';
                    return $editBtn . ' ' . $deleteBtn;
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }
    }

    public function simpanDataUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'username' => 'required|string|max:255|unique:users,username',
            'level_id' => 'required|exists:tbl_lvl,id',
            'instansi_id' => 'required|exists:tbl_instansi,id',
            'telepon' => 'required|regex:/^[0-9]{10,15}$/',
            'email' => 'required|email',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[A-Z]/',
                'regex:/[a-z]/',
                'regex:/[!@#$%^&*(),.?":{}|<>]/'
            ],
        ]);

        try {
            $level_id = Level::find($request->level);
            $instansi_id = Instansi::find($request->instansi);

            User::create([
                'name' => strtoupper($request->name),
                'username' => strtoupper($request->username),
                'level_id' => $request->level_id,
                'instansi_id' => $request->instansi_id,
                'telepon' => $request->telepon,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            return response()->json(['success' => true, 'message' => 'Data User berhasil disimpan!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat menyimpan data!'], 500);
        }
    }

    public function editDataUser($id)
    {
        $user = User::find($id);
        if ($user) {
            return response()->json($user);
        }
        return response()->json(['success' => false, 'message' => 'Data tidak ditemukan!'], 404);
    }

    public function updateDataUser(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'level' => 'required|string|max:36',
            'instansi' => 'required|string|max:36',
            'telepon' => 'required|regex:/^[0-9]{10,15}$/',
            'email' => 'required|email',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[A-Z]/',
                'regex:/[a-z]/',
                'regex:/[!@#$%^&*(),.?":{}|<>]/'
            ],
        ]);

        $user = User::find($id);

        if ($user) {
            try {
                $user->update([
                    'name' => $request->name,
                    'username' => $request->username,
                    'level' => $request->level_id,
                    'instansi' => $request->instansi_id,
                    'telepon' => $request->telepon,
                    'email' => $request->email,
                    'password' => $request->password ? Hash::make($request->password) : $user->password,
                ]);
                return response()->json(['success' => true, 'message' => 'Data User berhasil diperbarui!']);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat memperbarui data!'], 500);
            }
        }
        return response()->json(['success' => false, 'message' => 'Data tidak ditemukan!'], 404);
    }

    public function hapusDataUser($id)
    {
        $user = User::find($id);

        if ($user) {
            try {
                $user->delete();
                return response()->json(['success' => true, 'message' => 'Data User berhasil dihapus!']);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat menghapus data!'], 500);
            }
        }

        return response()->json(['success' => false, 'message' => 'Data tidak ditemukan!'], 404);
    }
}
