<?php

namespace App\Http\Controllers;

use App\Models\Data;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Imports\DataImport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;
use Illuminate\Support\Facades\Validator;

class DataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //  
        $data = Data::orderBy('id_transaksi', 'asc')->paginate(10);
        //dd($data);

        return view('menu.data.index', [
            'title' => 'Data Transaksi',
            'active' => 'data',
        ], compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('menu.data.tambah', [
            'title' => 'Tambah Data Transaksi',
            'active' => 'data',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'id_transaksi'     => 'required',
            'item'     => 'required',
            'tanggal'   => 'required|date',
        ]);

        if (count(explode(',', $request->item)) > 1) {
            foreach (explode(',', $request->item) as $item) {
                $data = trim($item);
                if ($data) {
                    Data::create([
                        'id_transaksi' => $request->id_transaksi,
                        'item' => $data,
                        'tanggal' => $request->tanggal,
                    ]);
                }
            }
        } else {
            Data::create([
                'id_transaksi' => $request->id_transaksi,
                'item'     => $request->item,
                'tanggal'   => $request->tanggal
            ]);
        }

        //redirect to index
        return redirect()->route('data')->with(['success' => 'Data Berhasil Ditambah!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Data $data, $id_data)
    {
        //
        $dataedit = $data->find($id_data);
        return view('menu.data.edit', [
            'title' => 'Edit Data Transaksi',
            'active' => 'data',
        ], with([
            'iddata' => $id_data,
            'idtransaksi' => $dataedit->id_transaksi,
            'item' => $dataedit->item,
            'tanggal' => $dataedit->tanggal,
        ]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_data): RedirectResponse
    {
        //
        //validate form
        $this->validate($request, [
            'id_transaksi' => 'required',
            'item' => 'required',
            'tanggal' => 'required',
        ]);

        $data = Data::findOrFail($id_data);

        $arr = explode(',', $request->item);
        // dd($arr);
        if (count($arr) > 1) {
            foreach ($arr as $item) {
                // dd($item);
                $trim = trim($item);
                if ($trim) {
                    if ($trim == reset($arr)) {
                        $data->update([
                            'id_transaksi' => $request->id_transaksi,
                            'item' => $trim,
                            'tanggal' => $request->tanggal,
                        ]);
                    } else {
                        Data::create([
                            'id_transaksi' => $request->id_transaksi,
                            'item' => $trim,
                            'tanggal' => $request->tanggal,
                        ]);
                    }
                }
            }
        } else {
            $data->update([
                'id_transaksi' => $request->id_transaksi,
                'item' => $request->item,
                'tanggal' => $request->tanggal,
            ]);
        }

        return to_route('data')->with(['success' => 'Data Berhasil Diubah!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_data): RedirectResponse
    {
        //
        $del = Data::findOrFail($id_data);

        //delete post
        $del->delete();

        //redirect to index
        return redirect()->route('data')->with(['success' => 'Data Berhasil Dihapus!']);
    }

    // Fungsi pencarian data
    public function search(Request $request)
    {
        $keyword = $request->search;

        $data = Data::where(function ($query) use ($keyword) {
            $query->Where('id_transaksi', 'like', "%$keyword%")
                ->orWhere('item', 'like', "%$keyword%")
                ->orWhere('tanggal', 'like', "%$keyword%");
        })->paginate(10);

        return view('menu.data.index', [
            'title' => 'Cari Data Transaksi',
            'active' => 'data',
        ], compact('data', 'keyword'));
    }

    // fungsi return view import
    public function view_import()
    {
        //
        return view('menu.data.import', [
            'title' => 'Import Data Transaksi',
            'active' => 'data',
        ]);
    }

    public function import(Request $request)
    {
        //
        $this->validate($request, [
            'file' => 'required|mimes:csv,txt',
        ],[
            'file.required' => 'Pilih file terlebih dahulu!',
            'file.mimes' => 'Format file salah, pilih file dengan format csv!',
        ]);
        
        $headings = (new HeadingRowImport)->toArray($request->file);
        $val = Validator::make($headings[0][0], [
            '0' => 'required|in:id_transaksi',
            '1' => 'required|in:item',
            '2' => 'required|in:tanggal',
        ]);

        if($val->fails()){
            return redirect()->back()->withErrors('File yang dipilih tidak valid atau kosong!');
        }
        
        Excel::import(new DataImport, request()->file('file'));

        //return back();
        return to_route('data')->with(['success' => 'Data Berhasil Diimport!']);
    }
}