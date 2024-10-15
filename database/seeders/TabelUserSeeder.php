<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TabelUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Hash::make('admin123');
        $a = Hash::make('a1234567');
        $b = Hash::make('b1234567');
        $c = Hash::make('c1234567');
        $d = Hash::make('d1234567');
        $e = Hash::make('e1234567');
        $f = Hash::make('f1234567');
        $g = Hash::make('g1234567');
        $h = Hash::make('h1234567');
        $i = Hash::make('i1234567');
        $guru1 = Hash::make('guru1123');
        $guru2 = Hash::make('guru2123');
        $guru3 = Hash::make('guru3123');
        $guru4 = Hash::make('guru4123');
        $guru5 = Hash::make('guru5123');
        $guru6 = Hash::make('guru6123');
        $guru7 = Hash::make('guru7123');
        $guru8 = Hash::make('guru8123');
        $guru9 = Hash::make('guru9123');
        $guru10 = Hash::make('guru10123');
        $damar = Hash::make('damar123');

        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => $admin,
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'a',
            'email' => 'a@gmail.com',
            'password' => $a,
        ]);

        User::create([
            'name' => 'b',
            'email' => 'b@gmail.com',
            'password' => $b,
        ]);

        User::create([
            'name' => 'c',
            'email' => 'c@gmail.com',
            'password' => $c,
        ]);

        User::create([
            'name' => 'd',
            'email' => 'd@gmail.com',
            'password' => $d,
        ]);

        User::create([
            'name' => 'e',
            'email' => 'e@gmail.com',
            'password' => $e,
        ]);

        User::create([
            'name' => 'f',
            'email' => 'f@gmail.com',
            'password' => $f,
        ]);

        User::create([
            'name' => 'g',
            'email' => 'g@gmail.com',
            'password' => $g,
        ]);

        User::create([
            'name' => 'h',
            'email' => 'h@gmail.com',
            'password' => $h,
        ]);

        User::create([
            'name' => 'i',
            'email' => 'i@gmail.com',
            'password' => $i,
        ]);

        User::create([
            'name' => 'Pak Aji',
            'email' => 'aji@gmail.com',
            'password' => $guru1,
            'role' => 'guru',
        ]);

        User::create([
            'name' => 'Pak Fahmi',
            'email' => 'fahmi@gmail.com',
            'password' => $guru2,
            'role' => 'guru',
        ]);

        User::create([
            'name' => 'Pak Anjas',
            'email' => 'anjas@gmail.com',
            'password' => $guru3,
            'role' => 'guru',
        ]);

        User::create([
            'name' => 'Pak Agus',
            'email' => 'agus@gmail.com',
            'password' => $guru4,
            'role' => 'guru',
        ]);

        User::create([
            'name' => 'Pak Dwi',
            'email' => 'dwi@gmail.com',
            'password' => $guru5,
            'role' => 'guru',
        ]);

        User::create([
            'name' => 'Pak Fuad',
            'email' => 'fuad@gmail.com',
            'password' => $guru6,
            'role' => 'guru',
        ]);

        User::create([
            'name' => 'Bu Lisfana',
            'email' => 'lisfana@gmail.com',
            'password' => $guru7,
            'role' => 'guru',
        ]);

        User::create([
            'name' => 'Bu Ristina',
            'email' => 'ristina@gmail.com',
            'password' => $guru8,
            'role' => 'guru',
        ]);

        User::create([
            'name' => 'Bu Widi',
            'email' => 'widi@gmail.com',
            'password' => $guru9,
            'role' => 'guru',
        ]);

        User::create([
            'name' => 'Sensei Reike',
            'email' => 'reike@gmail.com',
            'password' => $guru10,
            'role' => 'guru',
        ]);

        User::create([
            'name' => 'damar',
            'email' => 'damarfikrihaikal2@gmail.com',
            'password' => $damar,
        ]);
    }
}
