<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pelajaran extends Model
{
    use HasFactory;

    protected $fillable = ['nama_pelajaran'];

    public function guru(): HasMany
    {
        return $this->hasMany(Guru::class);
    }

    public function jadwalPelajaran(): HasMany
    {
        return $this->hasMany(JadwalPelajaran::class);
    }
}
