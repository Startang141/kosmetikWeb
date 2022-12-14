<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Google\Cloud\Storage\StorageClient;
use Illuminate\Support\Facades\URL;

class ProdukController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $data['produk'] = Produk::with('kategori')->get();
        $data['kategori'] = Kategori::get();
        return view('admin/produk/list', $data);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $request->validate([
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        // $imageName = time() . '.' . $request->gambar->extension();
        // $request->gambar->move(public_path('produk'), $imageName);
        if ($request->file('gambar')) {
            $image_name = $request->file('gambar');
            // $image_name = $request->file('gambar')->store('images', 'public');
            $storage = new StorageClient([
                'keyFilePath' => public_path('key.json')
            ]);

            $bucketName = env('GOOGLE_CLOUD_BUCKET');
            $bucket = $storage->bucket($bucketName);

            //get filename with extension
            $filenamewithextension = pathinfo($request->file('gambar')->getClientOriginalName(), PATHINFO_FILENAME);
            // $filenamewithextension = $request->file('gambar')->getClientOriginalName();

            //get filename without extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

            //get file extension
            $extension = $request->file('gambar')->getClientOriginalExtension();

            //filename to store
            $filenametostore = $filename . '_' . uniqid() . '.' . $extension;

            Storage::put('public/uploads/' . $filenametostore, fopen($request->file('gambar'), 'r+'));

            $filepath = storage_path('app/public/uploads/' . $filenametostore);

            $object = $bucket->upload(
                fopen($filepath, 'r'),
                [
                    'predefinedAcl' => 'publicRead'
                ]
            );

            // delete file from local disk
            Storage::delete('public/uploads/' . $filenametostore);
        }
        Produk::create([
            'id_kategori' => $request->kategori,
            'nama_produk' => $request->nama_produk,
            'gambar' => $filenametostore,
            'stok' => $request->stok,
            'terjual' => 0,
        ]);
        return redirect()->route('produk.index');
    }


    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $imageName = time() . '.' . $request->gambar->extension();
        $request->gambar->move(public_path('produk'), $imageName);

        $data = Produk::findOrFail($id);
        $data->update([
            'id' => $request->kategori,
            'nama_produk' => $request->nama_produk,
            'gambar' => $imageName,
            'stok' => $request->stok,
        ]);
        return redirect()->route('produk.index');
    }

    public function destroy($id)
    {
        $data = Produk::findOrFail($id);
        $data->delete();
        return redirect()->route('produk.index');
    }
}