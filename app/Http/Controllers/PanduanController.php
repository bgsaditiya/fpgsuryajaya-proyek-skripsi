<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PanduanController extends Controller
{
    //
    public function index()
    {
        return view('menu.panduan.index', [
            'title' => 'Panduan Penggunaan Aplikasi',
            'active' => 'panduan',
        ]);
    }

    public function view()
    {
        return response()->file(public_path('pdf/akademik.pdf'),['content-type' => 'aplication/pdf']);
    }
}