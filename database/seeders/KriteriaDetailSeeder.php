<?php

namespace Database\Seeders;

use App\Models\Kriteria;
use App\Models\Kriteriadetail;
use Illuminate\Database\Seeder;

class KriteriaDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kriteria = Kriteria::where('kode', 'kartu')->first();
        Kriteriadetail::create(
            [
                'kriteria_id' => $kriteria->id,
                'nama' => 'Ada',
                'bobot' => 100,
            ]
        );
        Kriteriadetail::create(
            [
                'kriteria_id' => $kriteria->id,
                'nama' => 'Tidak Ada',
                'bobot' => 40,
            ]
        );
        $kriteria = Kriteria::where('kode', 'penghasilan')->first();
        Kriteriadetail::create(
            [
                'kriteria_id' => $kriteria->id,
                'nama' => 'X < Rp. 500.000,-',
                'bobot' => 100,
            ]
        );
        Kriteriadetail::create(
            [
                'kriteria_id' => $kriteria->id,
                'nama' => 'Rp. 500.000,- < X < Rp. 750.000,-',
                'bobot' => 80,
            ]
        );
        Kriteriadetail::create(
            [
                'kriteria_id' => $kriteria->id,
                'nama' => 'Rp. 750.000,- < X < Rp. 1.000.000,-',
                'bobot' => 60,
            ]
        );
        Kriteriadetail::create(
            [
                'kriteria_id' => $kriteria->id,
                'nama' => 'Rp. 1.000.000,- < X < Rp. 2.000.000,-',
                'bobot' => 40,
            ]
        );
        Kriteriadetail::create(
            [
                'kriteria_id' => $kriteria->id,
                'nama' => 'X > Rp. 2.000.000,-',
                'bobot' => 20,
            ]
        );
        $kriteria = Kriteria::where('kode', 'pekerjaan')->first();
        Kriteriadetail::create(
            [
                'kriteria_id' => $kriteria->id,
                'nama' => 'Tidak Punya',
                'bobot' => 100,
            ]
        );
        Kriteriadetail::create(
            [
                'kriteria_id' => $kriteria->id,
                'nama' => 'Pribadi',
                'bobot' => 50,
            ]
        );
        $kriteria = Kriteria::where('kode', 'tanggungan')->first();
        Kriteriadetail::create(
            [
                'kriteria_id' => $kriteria->id,
                'nama' => 'Nasional',
                'bobot' => 100,
            ]
        );
        Kriteriadetail::create(
            [
                'kriteria_id' => $kriteria->id,
                'nama' => 'Provinsi',
                'bobot' => 75,
            ]
        );
        Kriteriadetail::create(
            [
                'kriteria_id' => $kriteria->id,
                'nama' => 'Kabupaten',
                'bobot' => 50,
            ]
        );
        Kriteriadetail::create(
            [
                'kriteria_id' => $kriteria->id,
                'nama' => 'Sekolah',
                'bobot' => 25,
            ]
        );
        $kriteria = Kriteria::where('kode', 'status')->first();
        Kriteriadetail::create(
            [
                'kriteria_id' => $kriteria->id,
                'nama' => '90 < X < 100',
                'bobot' => 100,
            ]
        );
        Kriteriadetail::create(
            [
                'kriteria_id' => $kriteria->id,
                'nama' => '80 < X < 90',
                'bobot' => 80,
            ]
        );
        Kriteriadetail::create(
            [
                'kriteria_id' => $kriteria->id,
                'nama' => '70 < X < 80',
                'bobot' => 60,
            ]
        );
        Kriteriadetail::create(
            [
                'kriteria_id' => $kriteria->id,
                'nama' => '60 < X < 70',
                'bobot' => 40,
            ]
        );
        Kriteriadetail::create(
            [
                'kriteria_id' => $kriteria->id,
                'nama' => 'X < 60',
                'bobot' => 20,
            ]
        );

    }
}
