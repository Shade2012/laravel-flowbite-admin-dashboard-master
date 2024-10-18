<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

    class JadwalPelajaran extends Model
    {
        use HasFactory;

        protected $fillable = ['kelas_id', 'hari', 'jam_mulai', 'jam_selesai', 'pelajaran_id', 'guru_id', 'ruang_id'];

        public function kelas(): BelongsTo
        {
            return $this->belongsTo(Kelas::class);
        }

    public function pelajaran(): BelongsTo
    {
        return $this->belongsTo(Pelajaran::class);
    }

    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class);
    }

    public function ruang(): BelongsTo
    {
        return $this->belongsTo(Ruang::class);
    }
}
