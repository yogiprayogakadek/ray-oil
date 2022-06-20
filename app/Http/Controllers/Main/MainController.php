<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Http\Requests\PendaftaranRequest;
use App\Models\Jabatan;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Image;

class MainController extends Controller
{
    public function index()
    {
        $produk = Produk::all();
        return view('main.index')->with([
            'data' => $produk
        ]);
    }

    // public function paginate($items, $perPage = 8, $page = null, $options = [])
    // {
    //     $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
    //     $items = $items instanceof Collection ? $items : Collection::make($items);
    //     return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    // }

    public function login()
    {
        return view('main.login');
    }

    public function register(PendaftaranRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $data = [
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'nama' => $request->nama,
                    'tempat_lahir' => $request->tempat_lahir,
                    'tanggal_lahir' => $request->tanggal_lahir,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'alamat' => $request->alamat,
                    'telp' => $request->telp,
                    'is_admin' => false,
                ];

                if($request->hasFile('foto')) {
                    $filenamewithextension = $request->file('foto')->getClientOriginalName();
                    $extension = $request->file('foto')->getClientOriginalExtension();

                    $filenametostore = str_replace(' ', '', $request->nama) . '-' . time() . '.' . $extension;
                    $save_path = 'assets/uploads/users/';

                    if (!file_exists($save_path)) {
                        mkdir($save_path, 666, true);
                    }
                    // $request->file('foto')->move($save_path, $filenametostore);
                    $img = Image::make($request->file('foto')->getRealPath());
                    $img->resize(300, 300);
                    $img->save($save_path . $filenametostore);

                    $data += [
                        'foto' => $save_path . $filenametostore,
                    ];
                }
                User::create($data);
            });
            // session(['success' => 'Pendaftaran berhasil']);
            // return redirect()->route('main');
            return redirect()->back()->with([
                'success' => 'Pendaftaran berhasil'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'error' => $e->getMessage()
                // 'error' => 'Pendaftaran gagal'
            ]);
            // return $e->getMessage();
            // return redirect()->route('main')->with('error', 'Pendaftaran gagal');
        }
    }
}

