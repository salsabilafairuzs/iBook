<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Validator;
use DataTables;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Kategori::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('edit', function ($data) {
                    return '<button type="button" onclick="editForm(' . $data->id . ')" class="btn btn-sm btn-primary btn-flat text-center ti ti-edit"></button>'.
                    ' | <button type="button" onclick="hapus(' . $data->id . ')" class="btn btn-sm btn-danger btn-flat text-center ti ti-trash"></button>';
                })
                ->rawColumns(['edit'])
                ->make(true);
        }
        return view('kategori.kategori');
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
            'kategori' => ['required', 'unique:kategoris'],
        ],[
            'kategori.required'=> 'Kategori Buku Wajib diisi !!!',
            'kategori.unique'=> 'Kategori Buku Sudah ada!!!',

        ]);

        if ($cek->fails()) {
            return response()->json(['sukses' => false, 'error' => $cek->errors()]);
        }else{
            $kategori=new Kategori();
            $kategori->kategori=$request['kategori'];
            $kategori->save();

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
        
        $kategori = Kategori::where('id',$id)->first();
        return response()->json([
            'data'=>$kategori
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $cek = Validator::make($request->all(), [
            'kategori' => ['required'],
        ],[
            'kategori.required'=> 'Kategori Buku Wajib diisi !!!',
        ]);

        if ($cek->fails()) {
            return response()->json(['sukses' => false, 'error' => $cek->errors()]);
        }else{
            $kategori=Kategori::where('id', $id)->first();
            $kategori->kategori=$request['kategori'];
            $kategori->update();

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
        $kategori = Kategori::where('id',$id)->delete();
        return response()->json([
            'sukses'=> true,
            'message'=> 'Berhasil Hapus Data !'
        ]);
    }
}
