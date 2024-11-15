<?php

namespace App\Models;

use App\Models\Jabatan;
use App\Models\Departemen;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pegawai extends Model
{
    public function jabatan()  {
        return $this->belongsTo(Jabatan::class);
    }
    public function departemen()  {
        return $this->belongsTo(Departemen::class);
    }
}
