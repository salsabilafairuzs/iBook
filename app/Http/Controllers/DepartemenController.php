<?php

namespace App\Http\Controllers;

use Validator;
use DataTables;
use App\Models\Departemen;
use Illuminate\Http\Request;

class DepartemenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Departemen::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('edit', function ($data) {
                    return '<button type="button" onclick="editForm(' . $data->id . ')" class="btn btn-sm btn-primary btn-flat text-center ti ti-edit"></button>'.
                    ' | <button type="button" onclick="hapus(' . $data->id . ')" class="btn btn-sm btn-danger btn-flat text-center ti ti-trash"></button>';
                })
                ->rawColumns(['edit'])
                ->make(true);
        }
        return view('departemen.departemen');
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
            'departemen' => ['required'],
        ],[
            'departemen.required'=> 'Departemen Wajib diisi !!!',
        ]);

        if ($cek->fails()) {
            return response()->json(['sukses' => false, 'error' => $cek->errors()]);
        }else{
            $departemen=new Departemen();
            $departemen->departemen=$request['departemen'];
            $departemen->save();

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
        $departemen = Departemen::where('id',$id)->first();
        return response()->json([
            'data'=>$departemen
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $cek = Validator::make($request->all(), [
            'departemen' => ['required'],
        ],[
            'departemen.required'=> 'Departemen Wajib diisi !!!',
        ]);

        if ($cek->fails()) {
            return response()->json(['sukses' => false, 'error' => $cek->errors()]);
        }else{
            $departemen=Departemen::where('id', $id)->first();
            $departemen->departemen=$request['departemen'];
            $departemen->update();

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
        $departemen = Departemen::where('id',$id)->delete();
        return response()->json([
            'sukses'=> true,
            'message'=> 'Berhasil Hapus Data !'
        ]);
    }
}
