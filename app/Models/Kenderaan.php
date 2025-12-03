<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kenderaan extends Model
{
    use HasFactory;

    protected $table = 'kenderaan';
    protected $primaryKey = 'no_pendaftaran';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'no_pendaftaran',
        'gambar_kenderaan',
        'jenis_kenderaan',
        'jenama',
        'model',
        'warna',
        'kapasiti_penumpang',
        'tarikh_mula_roadtax',
        'tarikh_tamat_roadtax',
        'status_kenderaan',
    ];
}
