<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SiswaDetail extends Model
{
    use SoftDeletes;

    use HasFactory;

    use \App\Traits\TraitUuid;
    public $table = 'siswa_details';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'siswa_id',
        'kriteria_id',
        'kriteria_detail_id',
        'bobot',
        'keterangan',

    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'bobot' => 'float',
        'keterangan' => 'string'
    ];

    /**
     * Get the siswa that owns the SiswaDetail
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }
    /**
     * Get all of the subSiswaDetail for the SiswaDetail
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subSiswaDetail()
    {
        return $this->hasMany(SubSiswaDetail::class, 'siswa_detail_id', 'id');
    }

    /**
     * Get the kriteria that owns the SiswaDetail
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kriteria(): BelongsTo
    {
        return $this->belongsTo(Kriteria::class, 'kriteria_id');
    }
}
