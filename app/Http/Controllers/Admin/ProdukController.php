<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProdukRequest;
use App\Http\Requests\UpdateFotoRequest;
use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;
use Image;

class ProdukController extends Controller
{
    public function index()
    {
        return view('admin.produk.index');
    }

    public function render()
    {
        $data = Produk::all();

        $view = [
            'data' => view('admin.produk.render', compact('data'))->render()
        ];

        return response()->json($view);
    }

    public function print()
    {
        $data = Produk::all();

        $view = [
            'data' => view('admin.produk.print', compact('data'))->render()
        ];

        return response()->json($view);
    }

    public function create()
    {
        $data = Kategori::pluck('nama', 'id_kategori')->prepend('Pilih Kategori', '');
        $view = [
            'data' => view('admin.produk.create', compact('data'))->render()
        ];

        return response()->json($view);
    }

    public function store(ProdukRequest $request)
    {
        try {
            $data = [
                'nama' => $request->nama,
                'id_kategori' => $request->id_kategori,
                'harga' => preg_replace('/[^0-9]/', '', $request->harga),
                // 'stok' => $request->stok,
                // 'deskripsi' => $request->deskripsi,
            ];

            if($request->hasFile('foto')) {
                $filenamewithextension = $request->file('foto')->getClientOriginalName();

                //get file extension
                $extension = $request->file('foto')->getClientOriginalExtension();

                //filename to store
                $filenametostore = $request->nama . '-' . time() . '.' . $extension;
                $save_path = 'assets/uploads/media/produk';

                if (!file_exists($save_path)) {
                    mkdir($save_path, 666, true);
                }

                $img = Image::make($request->file('foto')->getRealPath());
                $img->resize(410, 410);
                $img->save($save_path . '/' . $filenametostore);
                $data['foto'] = $save_path . '/' . $filenametostore;
            }

            if($request->has('deskripsi')) {
                $contentPath = public_path('assets/uploads/deskripsi/');
                if (!file_exists($contentPath)) {
                    mkdir($contentPath, 666, true);
                }
                $dom = new \DOMDocument();
                libxml_use_internal_errors(true);
                $dom->loadHTML($request->deskripsi, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NOIMPLIED);
                libxml_clear_errors();
                $images = $dom->getElementsByTagName('img');
                foreach($images as $img) {
                    $src = $img->getAttribute('src');
                    if(preg_match('/data:image/', $src)) {
                        //get the mimetype
                        preg_match('/data:image\/(?<mime>.*?)\;/', $src, $groups);
                        $mimetype = $groups['mime'];
        
                        //Generating a random filename
                        $filename = uniqid();
                        $filepath = "/assets/uploads/deskripsi/$filename.$mimetype";
        
                        // @see http://image.intervention.io/api/
                        $image = Image::make($src)
                            // resize if required
                            ->resize(600, 600)
                            ->encode($mimetype, 100)  // encode file to the specified mimetype
                            ->save(public_path($filepath));
                        $new_src = asset($filepath);
                        $img->removeAttribute('src');
                        $img->setAttribute('src', $new_src);
                        $img->setAttribute('class', 'img-responsive');
                    }
                }
                $data['deskripsi'] = $dom->saveHTML();
            }

            Produk::create($data);

            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil tersimpan',
                'title' => 'Berhasil'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                // 'message' => 'Data gagal tersimpan',
                'message' => $e->getMessage(),
                'title' => 'Gagal'
            ]);
        }
    }

    public function edit($id)
    {
        $data = Produk::find($id);
        $kategori = Kategori::pluck('nama', 'id_kategori')->prepend('Pilih Kategori', '');
        $view = [
            'data' => view('admin.produk.edit', compact('data', 'kategori'))->render()
        ];

        return response()->json($view);
    }

    public function detail($id)
    {
        $data = Produk::find($id);
        return response()->json($data);
    }

    public function update(ProdukRequest $request)
    {
        try {
            $produk = Produk::find($request->id);
            $data = [
                'nama_produk' => $request->nama,
                'id_kategori' => $request->id_kategori,
                'harga' => preg_replace('/[^0-9]/', '', $request->harga),
                'stok' => $request->stok,
                // 'deskripsi' => $request->deskripsi,
            ];

            if($request->hasFile('foto')) {
                unlink($produk->foto);
                $filenamewithextension = $request->file('foto')->getClientOriginalName();

                //get file extension
                $extension = $request->file('foto')->getClientOriginalExtension();

                //filename to store
                $filenametostore = $request->nama . '-' . time() . '.' . $extension;
                $save_path = 'assets/uploads/media/produk';

                if (!file_exists($save_path)) {
                    mkdir($save_path, 666, true);
                }

                $img = Image::make($request->file('foto')->getRealPath());
                $img->resize(410, 410);
                $img->save($save_path . '/' . $filenametostore);
                $data['foto'] = $save_path . '/' . $filenametostore;
            }

            if($request->has('deskripsi')) {
                $contentPath = public_path('assets/uploads/deskripsi/');
                if (!file_exists($contentPath)) {
                    mkdir($contentPath, 666, true);
                }
                $dom = new \DOMDocument();
                libxml_use_internal_errors(true);
                $dom->loadHTML($request->deskripsi, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NOIMPLIED);
                libxml_clear_errors();
                $images = $dom->getElementsByTagName('img');
                foreach($images as $img) {
                    $src = $img->getAttribute('src');
                    if(preg_match('/data:image/', $src)) {
                        //get the mimetype
                        preg_match('/data:image\/(?<mime>.*?)\;/', $src, $groups);
                        $mimetype = $groups['mime'];
        
                        //Generating a random filename
                        $filename = uniqid();
                        $filepath = "/assets/uploads/deskripsi/$filename.$mimetype";
        
                        // @see http://image.intervention.io/api/
                        $image = Image::make($src)
                            // resize if required
                            ->resize(600, 600)
                            ->encode($mimetype, 100)  // encode file to the specified mimetype
                            ->save(public_path($filepath));
                        $new_src = asset($filepath);
                        $img->removeAttribute('src');
                        $img->setAttribute('src', $new_src);
                        $img->setAttribute('class', 'img-responsive');
                    }
                }
                $data['deskripsi'] = $dom->saveHTML();
            }

            $produk->update($data);

            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil diperbarui',
                'title' => 'Berhasil'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'title' => 'Gagal'
            ]);
        }
    }


    public function delete(Request $request)
    {
        try {
            $produk = Produk::find($request->id);
            unlink($produk->foto);
            $produk->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil dihapus',
                'title' => 'Berhasil'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'title' => 'Gagal'
            ]);
        }
    }
}
