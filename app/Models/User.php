<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = ['image', 'name', 'email', 'password', 'fcm_token', 'role'];

    public function kelas(): HasOne
    {
        return $this->hasOne(Kelas::class, 'wali_kelas_id');
    }

    public function guru(): HasOne
    {
        return $this->hasOne(Guru::class, 'user_id');
    }

    public function siswa(): HasOne
    {
        return $this->hasOne(Siswa::class, 'user_id');
    }
}
