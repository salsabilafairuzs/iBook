<?php

namespace App\Http\Controllers;
use Validator;
use DataTables;
use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
    if ($request->ajax()) {
        $data = Buku::with(['kategori'])->latest()->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('foto2', function ($data) {
                if ($data->foto) {
                    return '<img src="' . asset('storage/foto/' . $data->foto) . '" alt="Foto" style="width: 100px; height: auto;">';
                } else {
                    return '<span class="text-muted">Tidak ada foto</span>';
                }
            })
            ->addColumn('edit', function ($data) {
                return '<button type="button" onclick="editForm(' . $data->id . ')" class="btn btn-sm btn-primary btn-flat text-center ti ti-edit"></button>'.
                ' | <button type="button" onclick="hapus(' . $data->id . ')" class="btn btn-sm btn-danger btn-flat text-center ti ti-trash"></button>';
            })
            ->rawColumns(['edit','foto2'])
            ->make(true);
    }
    $data['kategori'] = Kategori::get();
    return view('buku.buku', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $cek = Validator::make($request->all(), [
            'kategori' => ['required'],
            'judul' => ['required'],
            'penerbit' => ['required'],
            'deskripsi' => ['required'],
            'foto' => ['required', 'mimes:jpeg,png,jpg', 'max:10000'],
        ],[
            'kategori.required'=> 'Kategori Buku Wajib diisi !!!',
            'judul.required'=> 'Judul Buku Wajib diisi !!!',
            'penerbit.required'=> 'Penerbit Wajib dipilih !!!',
            'deskripsi.required'=> 'Deskripsi Wajib dipilih !!!',
            'foto.required'=> 'Foto Wajib diisi !!!',
            'foto.image' => 'File harus berupa gambar !!!',
            'foto.mimes' => 'Format foto harus jpeg/png/jpg !!!',
            'foto.max' => 'Ukuran foto maksimal 10MB !!!'
        ]);

        if ($cek->fails()) {
            return response()->json(['sukses' => false, 'error' => $cek->errors()]);
        }else{
            $buku=new Buku();
            $buku->kategori_id = $request->kategori;
            $buku->judul = $request->judul; 
            $buku->penerbit = $request->penerbit;
            $buku->deskripsi = $request->deskripsi;
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $filename = time() . '.' . $file->getClientOriginalExtension();                
                $file->move(public_path('storage/foto'), $filename); 
                $buku->foto = $filename;
            } else {
                $buku->foto = null; 
            }

            $buku->save();
            return response()->json([
                'sukses'=> true,
                'message'=> 'Berhasil Tambah Data !'
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $buku = Buku::where('id',$id)->first();
        return response()->json([
            'data'=>$buku
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $cek = Validator::make($request->all(), [
            'kategori' => ['required'],
            'judul' => ['required'],
            'penerbit' => ['required'],
            'deskripsi' => ['required'],
            'foto' => ['mimes:jpeg,png,jpg', 'max:10000'],
        ],[
            'kategori.required'=> 'Kategori Buku Wajib diisi !!!',
            'judul.required'=> 'Judul Buku Wajib diisi !!!',
            'penerbit.required'=> 'Penerbit Wajib dipilih !!!',
            'deskripsi.required'=> 'Deskripsi Wajib dipilih !!!',
            'foto.image' => 'File harus berupa gambar !!!',
            'foto.mimes' => 'Format foto harus jpeg/png/jpg !!!',
            'foto.max' => 'Ukuran foto maksimal 10MB !!!'
        ]);

        if ($cek->fails()) {
            return response()->json(['sukses' => false, 'error' => $cek->errors()]);
        }else{
            $buku=Buku::where('id', $id)->first();
            $buku->kategori_id = $request->kategori;
            $buku->judul = $request->judul; 
            $buku->penerbit = $request->penerbit;
            $buku->deskripsi = $request->deskripsi;
        if ($request->hasFile('foto')) {
            $fotoPath = public_path('storage/foto/' . $buku->foto);
            if (file_exists($fotoPath) && $buku->foto !== Null) {
                unlink($fotoPath);
            }
            $file = $request->file('foto');
            $filename = time() . '.' . $file->getClientOriginalExtension();                
            $file->move(public_path('storage/foto'), $filename); 
            $buku->foto = $filename;
        } else {
            $buku->foto = $buku->foto;
        }

        $buku->update();
        return response()->json([
            'sukses'=> true,
            'message'=> 'Berhasil Update Data !'
        ]);
    }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $buku = Buku::find($id);

        if (!$buku) {
            return response()->json([
                'sukses' => false,
                'message' => 'Data buku tidak ditemukan!'
            ]);
        }
    
        if ($buku->foto) {
            $fotoPath = public_path('storage/foto/' . $buku->foto);
            if (file_exists($fotoPath)) {
                unlink($fotoPath); 
            }
        }
    
        $buku->delete();
    
        return response()->json([
            'sukses' => true,
            'message' => 'Berhasil Hapus Data!'
        ]);
        }
}
