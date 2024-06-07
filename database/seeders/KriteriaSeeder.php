<?php

namespace Database\Seeders;

use App\Models\Kriteria;
use Illuminate\Database\Seeder;

class KriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Kriteria::create([
            'nama' => 'Penghasilan Orang Tua',
            'bobot' => '25',
            'kode' => 'penghasilan',
            'jenis' => 'cost',
            'tipe' => 'single'
        ]);
        Kriteria::create([
            'nama' => 'Pekerjaan Orang Tua',
            'bobot' => '20',
            'kode' => 'pekerjaan',
            'jenis' => 'cost',
            'tipe' => 'single'
        ]);
        Kriteria::create([
            'nama' => 'Tanggungan Orang Tua',
            'bobot' => '20',
            'kode' => 'tanggungan',
            'jenis' => 'benefit',
            'tipe' => 'single'
        ]);
        Kriteria::create([
            'nama' => 'Status Siswa',
            'bobot' => '15',
            'kode' => 'status',
            'jenis' => 'benefit',
            'tipe' => 'single'
        ]);
        Kriteria::create([
            'nama' => 'Kepemilikan Kartu',
            'bobot' => '20',
            'kode' => 'kartu',
            'jenis' => 'benefit',
            'tipe' => 'single'
        ]);

    }
}
