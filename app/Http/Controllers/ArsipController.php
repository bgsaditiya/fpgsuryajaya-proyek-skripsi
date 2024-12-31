<?php

namespace App\Http\Controllers;

use App\Models\Arsip;
use App\Models\Konfigurasi;
use App\Models\Rule;
use App\Models\User;

class ArsipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $arsip = Arsip::paginate(10);
        //dd($arsip);

        return view('menu.arsip.index', [
            'title' => 'Arsip Analisis Asosiasi',
            'active' => 'arsip',
        ], compact('arsip'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Arsip $arsip, $id_arsip)
    {
        //
        $arsipshow = $arsip->find($id_arsip);
        $rule = Rule::find($arsipshow->id_rule)->toArray();
        $user = User::find($arsipshow->username);
        $konfigurasi = Konfigurasi::find($arsipshow->id_konf);

        $asosiasi = $this->convert($rule);

        // dd($asosiasi);

        return view('menu.arsip.show', [
            'title' => 'Lihat Arsip Analisis Asosiasi',
            'active' => 'arsip',
        ], compact('rule', 'user', 'konfigurasi', 'asosiasi'));
    }

    public function convert($getrule)
    {
        foreach ($getrule['item_ante'] as $l => $k) {
            $asosiasi[$l]['left'] = $k;
        }

        foreach ($getrule['item_cons'] as $l => $k) {
            $asosiasi[$l]['right'] = $k;
        }

        foreach ($getrule['nilai_supp'] as $l => $k) {
            $asosiasi[$l]['supp'] = $k;
        }

        foreach ($getrule['nilai_conf'] as $l => $k) {
            $asosiasi[$l]['conf'] = $k;
        }

        foreach ($getrule['nilai_lift'] as $l => $k) {
            $asosiasi[$l]['lift'] = $k;
        }

        foreach ($asosiasi as $val => $key) {
            $asosiasi[$val]['merge'] = array_merge($asosiasi[$val]['left'], $asosiasi[$val]['right']);
        }

        return $asosiasi;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Arsip $arsip)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Arsip $arsip)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_data)
    {
        //
        $delArsip = Arsip::findOrFail($id_data);
        $delRule = Rule::findOrFail($delArsip->id_rule);
        $delKonf = Konfigurasi::findOrFail($delArsip->id_konf);

        //delete post
        $delArsip->delete();
        $delRule->delete();
        $delKonf->delete();

        //redirect to index
        return redirect()->back()->with(['success' => 'Arsip Berhasil Dihapus!']);
    }
}