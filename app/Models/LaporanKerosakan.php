<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanKerosakan extends Model
{
    use HasFactory;

    protected $table = 'laporan_kerosakan';
    protected $primaryKey = 'id_laporan';
    public $timestamps = true;

    protected $fillable = [
        'id_permohonan',
        'no_pendaftaran',
        'tarikh_laporan',
        'jenis_kerosakan',
        'ulasan',
    ];

    public function kenderaan()
    {
        return $this->belongsTo(
            \App\Models\Kenderaan::class,
            'no_pendaftaran'
        );
    }
}
