<?php

namespace App\Http\Controllers;

use Validator;
use DataTables;
use App\Models\Jabatan;
use App\Models\Pegawai;
use App\Models\Departemen;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Pegawai::with(['departemen','jabatan'])->latest()->get();
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
        $data['departemen'] = Departemen::get();
        $data['jabatan'] = Jabatan::get();
        return view('pegawai.pegawai', $data);
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
        // return $request;
        $cek = Validator::make($request->all(), [
            'nip' => ['required', 'unique:pegawais,nip', 'max:20'],
            'nama' => ['required', 'max:255'],
            'departemen' => ['required'],
            'jabatan' => ['required'],
            'jenis_kelamin' => ['required'],
            'tgl_lahir' => ['required'],
            'status' => ['required'],
            'email' => ['required', 'unique:pegawais,email', 'max:255','email'],
            'telepon' => ['required'],
            'foto' => ['required', 'mimes:jpeg,png,jpg', 'max:10000'],
        ],[
            'nip.required'=> 'NIP Wajib diisi !!!',
            'nip.unique' => 'NIP sudah digunakan !!!',
            'nip.max' => 'NIP maksimal 20 karakter !!!',
            'nama.required'=> 'Nama Wajib diisi !!!',
            'nama.max' => 'Nama maksimal 255 karakter !!!',
            'departemen.required'=> 'Departemen Wajib dipilih !!!',
            'jabatan.required'=> 'Jabatan Wajib dipilih !!!',
            'jenis_kelamin.required'=> 'Jenis Kelamin Wajib diisi !!!',
            'tgl_lahir.required'=> 'Tanggal Lahir Wajib diisi !!!',
            'status.required'=> 'Status Wajib dipilih!!!',
            'email.required'=> 'Email Wajib diisi !!!',
            'email.email' => 'Format Email tidak valid !!!',
            'email.unique' => 'Email sudah digunakan !!!',
            'email.max' => 'Email maksimal 255 karakter !!!',
            'telepon.required'=> 'Nomor Telepon Wajib diisi !!!',
            'foto.required'=> 'Foto Wajib diisi !!!',
            'foto.image' => 'File harus berupa gambar !!!',
            'foto.mimes' => 'Format foto harus jpeg/png/jpg !!!',
            'foto.max' => 'Ukuran foto maksimal 10MB !!!'
        ]);

        if ($cek->fails()) {
            return response()->json(['sukses' => false, 'error' => $cek->errors()]);
        }else{
            $pegawai=new Pegawai();
            $pegawai->nip = $request->nip;
            $pegawai->nama = $request->nama; 
            $pegawai->departemen_id = $request->departemen;
            $pegawai->jabatan_id = $request->jabatan;
            $pegawai->jenis_kelamin = $request->jenis_kelamin;
            $pegawai->tgl_lahir = $request->tgl_lahir;
            $pegawai->status = $request->status;
            $pegawai->email = $request->email;
            $pegawai->telepon = $request->telepon;
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $filename = time() . '.' . $file->getClientOriginalExtension();                
                $file->move(public_path('storage/foto'), $filename); 
                $pegawai->foto = $filename;
            } else {
                $pegawai->foto = null; 
            }

            $pegawai->save();
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
    public function update(Request $request, string $id)
    {
        $cek = Validator::make($request->all(), [
            'nip' => ['required', 'max:20'],
            'nama' => ['required', 'max:255'],
            'departemen' => ['required'],
            'jabatan' => ['required'],
            'jenis_kelamin' => ['required'],
            'tgl_lahir' => ['required'],
            'status' => ['required'],
            'email' => ['required', 'max:255', 'email'],
            'telepon' => ['required'],
            'foto' => ['sometimes', 'mimes:jpeg,png,jpg', 'max:10000'],
        ],[
            'nip.required'=> 'NIP Wajib diisi !!!',
            'nip.max' => 'NIP maksimal 20 karakter !!!',
            'nama.required'=> 'Nama Wajib diisi !!!',
            'nama.max' => 'Nama maksimal 255 karakter !!!',
            'departemen.required'=> 'Departemen Wajib dipilih !!!',
            'jabatan.required'=> 'Jabatan Wajib dipilih !!!',
            'jenis_kelamin.required'=> 'Jenis Kelamin Wajib diisi !!!',
            'tgl_lahir.required'=> 'Tanggal Lahir Wajib diisi !!!',
            'status.required'=> 'Status Wajib dipilih !!!',
            'email.required'=> 'Email Wajib diisi !!!',
            'email.email' => 'Format Email tidak valid !!!',
            'email.max' => 'Email maksimal 255 karakter !!!',
            'telepon.required'=> 'Nomor Telepon Wajib diisi !!!',
            'foto.image' => 'File harus berupa gambar !!!',
            'foto.mimes' => 'Format foto harus jpeg/png/jpg !!!',
            'foto.max' => 'Ukuran foto maksimal 10MB !!!'
        ]);

        if ($cek->fails()) {
            return response()->json(['sukses' => false, 'error' => $cek->errors()]);
        }else{
            $pegawai=Pegawai::where('id', $id)->first();
            $pegawai->nip = $request->nip;
            $pegawai->nama = $request->nama; 
            $pegawai->departemen_id = $request->departemen;
            $pegawai->jabatan_id = $request->jabatan;
            $pegawai->jenis_kelamin = $request->jenis_kelamin;
            $pegawai->tgl_lahir = $request->tgl_lahir;
            $pegawai->status = $request->status;
            $pegawai->email = $request->email;
            $pegawai->telepon = $request->telepon;
            
            if ($request->hasFile('foto')) {
                $fotoPath = public_path('storage/foto/' . $pegawai->foto);
                if (file_exists($fotoPath)) {
                    unlink($fotoPath);
                }
                $file = $request->file('foto');
                $filename = time() . '.' . $file->getClientOriginalExtension();                
                $file->move(public_path('storage/foto'), $filename); 
                $pegawai->foto = $filename;
            } else {
                $pegawai->foto = null;
            }

            $pegawai->save();
            return response()->json([
                'sukses'=> true,
                'message'=> 'Berhasil Update Data !'
            ]);
        }
    }

    public function edit(string $id)
    {
        $pegawai = Pegawai::where('id',$id)->first();
        return response()->json([
            'data'=>$pegawai
        ]);
    }

    

    public function destroy(string $id)
    {
    $pegawai = Pegawai::find($id);

    if (!$pegawai) {
        return response()->json([
            'sukses' => false,
            'message' => 'Data pegawai tidak ditemukan!'
        ]);
    }

    if ($pegawai->foto) {
        $fotoPath = public_path('storage/foto/' . $pegawai->foto);
        if (file_exists($fotoPath)) {
            unlink($fotoPath); 
        }
    }

    $pegawai->delete();

    return response()->json([
        'sukses' => true,
        'message' => 'Berhasil Hapus Data!'
    ]);
    }
}
