<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaklumatPermohonan extends Model
{
    protected $table = 'maklumat_permohonan';
    protected $primaryKey = 'id_permohonan';

    protected $fillable = [
        'id_user',
        'no_pendaftaran',
        'tarikh_mohon',
        'tarikh_pelepasan',
        'lokasi',
        'bil_penumpang',
        'kod_projek',
        'hak_milik',
        'lampiran',
        'status_pengesahan',
        'speedometer_sebelum',
        'speedometer_selepas',
        'ulasan',
    ];

    protected $casts = [
        'lampiran' => 'array',
        'tarikh_pelepasan' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_pekerja');
    }

    public function kenderaan()
    {
        return $this->belongsTo(Kenderaan::class, 'no_pendaftaran', 'no_pendaftaran');
    }
}
