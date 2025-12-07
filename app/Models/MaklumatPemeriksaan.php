<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaklumatPemeriksaan extends Model
{
    protected $table = 'maklumat_pemeriksaan';
    protected $primaryKey = 'id_pemeriksaan';

    protected $fillable = [
        'no_pendaftaran',
        'kategori',
        'nama_komponen',
        'status',
        'ulasan',
    ];

    public function permohonan()
    {
        return $this->belongsTo(
            MaklumatPermohonan::class,
            'no_pendaftaran',
            'no_pendaftaran'
        );
    }
}
