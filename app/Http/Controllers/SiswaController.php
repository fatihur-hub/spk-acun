<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSiswaRequest;
use App\Http\Requests\UpdateSiswaRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Kriteria;
use App\Models\Kriteriadetail;
use App\Models\Siswa;
use App\Models\SiswaDetail;
use App\Models\SubSiswaDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Flash;
use Response;

class SiswaController extends AppBaseController
{
    public function index(Request $request)
    {
        $siswas = Siswa::orderBy('created_at', 'DESC')->get();
        return view('siswas.index', compact('siswas'));
    }

    public function create()
    {
        $nis = Siswa::orderBy('created_at', 'DESC')->first()->nis ?? date('Y') . '1';
        if (date('Y') != substr($nis, 0, 4)) {
            $nis = date('Y') . '1';
        } else {
            $nis = date('Y') . ((int) substr($nis, 4) + 1);
        }

        $kriterias = Kriteria::all();
        return view('siswas.create', compact('kriterias', 'nis'));
    }

    public function store(CreateSiswaRequest $request)
    {
        $input = $request->all();
        $input['tanggal_lahir'] = Carbon::createFromFormat('d/m/Y', $input['tanggal_lahir'])->format('Y-m-d');

        if (is_null($request->nisn)) {
            $yearNisn = substr($input['tanggal_lahir'], 2, 2);
            $input['nisn'] = $yearNisn . $yearNisn . rand(1000, 9999) . rand(1000, 9999);
        }

        DB::transaction(function () use ($input) {
            $siswa = Siswa::create($input);
            $this->saveSiswaDetails($siswa, $input);
        });

        Flash::success('Siswa saved successfully.');
        return redirect(route('siswas.index'));
    }

    public function show($id)
    {
        $siswa = Siswa::find($id);

        if (empty($siswa)) {
            Flash::error('Siswa not found');
            return redirect(route('siswas.index'));
        }

        return view('siswas.show', compact('siswa'));
    }

    public function edit($id)
    {
        $siswa = Siswa::find($id);

        if (empty($siswa)) {
            Flash::error('Siswa not found');
            return redirect(route('siswas.index'));
        }

        $kriterias = Kriteria::all();
        return view('siswas.edit', compact('siswa', 'kriterias'));
    }

    public function update($id, UpdateSiswaRequest $request)
    {
        $siswa = Siswa::find($id);

        if (empty($siswa)) {
            Flash::error('Siswa not found');
            return redirect(route('siswas.index'));
        }

        $input = $request->all();
        $input['tanggal_lahir'] = Carbon::createFromFormat('d/m/Y', $input['tanggal_lahir'])->format('Y-m-d');

        DB::transaction(function () use ($siswa, $input) {
            $siswa->update($input);
            $siswa->siswaDetail()->delete();
            $this->saveSiswaDetails($siswa, $input);
        });

        Flash::success('Siswa updated successfully.');
        return redirect(route('siswas.index'));
    }

    public function destroy($id)
    {
        $siswa = Siswa::find($id);

        if (empty($siswa)) {
            Flash::error('Siswa not found');
            return redirect(route('siswas.index'));
        }

        $siswa->delete();
        Flash::success('Siswa deleted successfully.');
        return redirect(route('siswas.index'));
    }

    private function saveSiswaDetails(Siswa $siswa, array $input)
    {
        $kriteriaSingle = [];
        $kriteriaMultiple = [];

        foreach ($input as $key => $value) {
            if (preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-5][0-9a-f]{3}-[089ab][0-9a-f]{3}-[0-9a-f]{12}$/', $key)) {
                $kriteriaSingle[$key] = $value;
            } elseif (preg_match('/^[A-Za-z]+_[0-9a-f]{8}-[0-9a-f]{4}-[0-5][0-9a-f]{3}-[089ab][0-9a-f]{3}-[0-9a-f]{12}$/', $key)) {
                $kriteriaMultiple[$key] = $value;
            }
        }

        foreach ($kriteriaSingle as $key => $value) {
            $kriteria = Kriteriadetail::find($value);
            SiswaDetail::create([
                'siswa_id' => $siswa->id,
                'kriteria_id' => $key,
                'kriteria_detail_id' => $value,
                'bobot' => $kriteria->bobot,
                'keterangan' => $kriteria->nama,
            ]);
        }

        foreach ($kriteriaMultiple as $key => $value) {
            if (preg_match('/^bobot+_[0-9a-f]{8}-[0-9a-f]{4}-[0-5][0-9a-f]{3}-[089ab][0-9a-f]{3}-[0-9a-f]{12}$/', $key)) {
                $kriteriaId = str_replace('bobot_', '', $key);
                $siswaDetail = SiswaDetail::create([
                    'siswa_id' => $siswa->id,
                    'kriteria_id' => $kriteriaId
                ]);

                $bobot = 0;
                $countSubSiswaDetail = count($kriteriaMultiple[$key]);
                foreach ($kriteriaMultiple['bobot_' . $kriteriaId] as $keyIndex => $valueIndex) {
                    $kriteria = Kriteriadetail::find($valueIndex);
                    SubSiswaDetail::create([
                        'siswa_detail_id' => $siswaDetail->id,
                        'kriteria_id' => $kriteriaId,
                        'kriteria_detail_id' => $valueIndex,
                        'bobot' => $kriteria->bobot ?? 0,
                        'keterangan' => $kriteriaMultiple['keterangan_' . $kriteriaId][$keyIndex],
                        'nilai' => $kriteriaMultiple['nilai_' . $kriteriaId][$keyIndex] ?? null,
                    ]);
                    $bobot += $kriteria->bobot ?? 0;
                }
                $siswaDetail->bobot = $bobot / $countSubSiswaDetail;
                $siswaDetail->save();
            }
        }
    }
}
