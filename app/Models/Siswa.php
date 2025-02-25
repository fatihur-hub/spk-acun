<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Siswa
 * @package App\Models
 * @version April 18, 2023, 2:36 pm UTC
 *
 * @property string $nis
 * @property string $nama
 * @property string $alamat
 * @property string $jenis_kelamin
 * @property string $tanggal_lahir
 * @property string $ibu
 * @property string $ayah
 *
 */
class Siswa extends Model
{
    use SoftDeletes;

    use HasFactory;

    use \App\Traits\TraitUuid;
    public $table = 'siswas';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'nis',
        'nisn',
        'nama',
        'alamat',
        'tahun_masuk',
        'jenis_kelamin',
        'tanggal_lahir',
        'ibu',
        'ayah',

    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'nis' => 'string',
        'nisn' => 'string',
        'nama' => 'string',
        'alamat' => 'string',
        'tahun_masuk',
        'jenis_kelamin' => 'string',
        'tanggal_lahir' => 'date',
        'ibu' => 'string',
        'ayah' => 'string',

    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'nis' => 'required',
        'nama' => 'required',
        'alamat' => 'required',
        'tahun_masuk',
        'jenis_kelamin' => 'required',
        'tanggal_lahir' => 'required',
        'ibu' => 'required',
        'ayah' => 'required',

    ];

    /**
     * Get all of the siswaDetail for the Siswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function siswaDetail()
    {
        return $this->hasMany(SiswaDetail::class, 'siswa_id', 'id');
    }

    public function getNilaiFuzzy()
    {
        $nilaiFuzzy = [];
        $kriterias = Kriteria::all();
        foreach ($kriterias as $kriteria) {
            $siswa = SiswaDetail::where('siswa_id', $this->id)->where('kriteria_id', $kriteria->id)->first();

            $nilaiFuzzy[$kriteria->id] = $siswa->bobot ?? 0;
        }
        return $nilaiFuzzy;
    }
}
