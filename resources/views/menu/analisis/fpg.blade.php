@extends('layout.main')
@section('content')
    <div class="page-header mb-4">
        <h1>{{ $title }}</h1>
    </div>

    <div class="row">

        @if ($tampilan == 'lengkap')
            <div class="col-4" id="rightside">
                <nav id="navbar-example3" class="h-100 flex-column align-items-stretch pe-4 border-end">
                    <nav class="nav nav-pills flex-column">
                        <a class="nav-link" href="#konfigurasi">Konfigurasi</a>
                        <a class="nav-link" href="#dataset">Dataset</a>
                        <a class="nav-link" href="#frequent-itemset">Frequent Itemset</a>
                        <a class="nav-link" href="#fp-list">FP-List</a>
                        <a class="nav-link" href="#fpt">FP-Tree</a>
                        <a class="nav-link" href="#cpb">Conditional Pattern Base</a>
                        <a class="nav-link" href="#cfp">Conditional FP-Tree</a>
                        <a class="nav-link" href="#fpattern">Frequent Pattern</a>
                        <a class="nav-link" href="#asosiasi">Aturan Asosiasi</a>
                        <a class="nav-link" href="#rekomendasi">Rekomendasi</a>
                        <a class="nav-link" href="#waktu-memory">Waktu dan Memori</a>
                    </nav>
                </nav>
            </div>

            <div class="col-8" id="tabel-konten">
            @else
                <div>
        @endif

        <div data-bs-spy="scroll" data-bs-target="#navbar-example3" data-bs-smooth-scroll="true" class="scrollspy-example-2"
            tabindex="50">

            <div class="card mb-4" id="konfigurasi">
                <div class="card-header">
                    Konfigurasi
                </div>
                <div class="card-body">
                    <form>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Jumlah Data</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" value="{{ $total_data }} Data" disabled
                                    readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Jumlah Maksimal Aturan</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" value="{{ $max_rule }} Aturan" disabled
                                    readonly>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-2 col-form-label">Rentang Tanggal</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" value="{{ $start_date }} - {{ $end_date }}"
                                    disabled readonly>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            @if ($tampilan == 'lengkap')
                <h4 id="dataset"></h4>
                @if (sizeof($data) <= 10)
                    <div class="card mb-4" id="dataset">
                        <div class="card-header">
                            Dataset
                        </div>
                        <div class="card-body">
                            <div class="table-responsive-sm">
                                <table class="table table-bordered table-hover table-striped datatable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>ID</th>
                                            <th>Tanggal</th>
                                            <th>Item</th>
                                        </tr>
                                    </thead>
                                    @php($no = 1)
                                    @foreach ($data as $idtransaksi => $val)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $idtransaksi }}</td>
                                            <td>{{ $tanggal[$idtransaksi] }}</td>
                                            <td>{{ implode(', ', array_column($val, 'item')) }}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="card mb-4" id="dataset">
                        <div class="card-header">
                            Dataset
                        </div>
                        <div class="card-body">
                            <div class="table-responsive-sm">
                                <table class="table table-bordered table-hover table-striped datatable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>ID</th>
                                            <th>Tanggal</th>
                                            <th>Item</th>
                                        </tr>
                                    </thead>
                                    @php($no_head = 1)
                                    @foreach ($data_head as $idtransaksi => $val)
                                        <tr>
                                            <td>{{ $no_head++ }}</td>
                                            <td>{{ $idtransaksi }}</td>
                                            <td>{{ $tanggal[$idtransaksi] }}</td>
                                            <td>{{ implode(', ', array_column($val, 'item')) }}</td>
                                        </tr>
                                    @endforeach

                                    <tr>
                                        <td>...</td>
                                        <td>...</td>
                                        <td>...</td>
                                        <td>...</td>
                                    </tr>

                                    @php($no_tail = $total_data - 4)
                                    @foreach ($data_tail as $idtransaksi => $val)
                                        <tr>
                                            <td>{{ $no_tail++ }}</td>
                                            <td>{{ $idtransaksi }}</td>
                                            <td>{{ $tanggal[$idtransaksi] }}</td>
                                            <td>{{ implode(', ', array_column($val, 'item')) }}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="card mb-4" id="frequent-itemset">
                    <div class="card-header">
                        Frequent Itemset
                    </div>
                    <div class="card-body">
                        <div class="table-responsive-sm">
                            <table class="table table-bordered table-hover table-striped datatable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Itemset</th>
                                        <th>Qty</th>
                                        <th>Support</th>
                                    </tr>
                                </thead>
                                @php($no = 1)
                                @foreach ($frequent_itemset as $item => $val)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $item }}</td>
                                        <td>{{ $val }}</td>
                                        <td>{{ round($support[$item], 2) }}%</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>

                @if (sizeof($fp_list) <= 10)
                    <div class="card mb-4" id="fp-list">
                        <div class="card-header">
                            FP-List
                        </div>
                        <div class="card-body">
                            <div class="table-responsive-sm">
                                <table class="table table-bordered table-hover table-striped datatable">
                                    <thead>
                                        <tr>
                                            <th>Data</th>
                                            <th>Itemset</th>
                                        </tr>
                                    </thead>
                                    @php($no = 1)
                                    @foreach ($fp_list as $item => $val)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ implode(', ', $val) }}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="card mb-4" id="fp-list">
                        <div class="card-header">
                            FP-List
                        </div>
                        <div class="card-body">
                            <div class="table-responsive-sm">
                                <table class="table table-bordered table-hover table-striped datatable">
                                    <thead>
                                        <tr>
                                            <th>Data</th>
                                            <th>Itemset</th>
                                        </tr>
                                    </thead>
                                    @php($no_head = 1)
                                    @foreach ($fp_list_head as $item => $val)
                                        <tr>
                                            <td>{{ $no_head++ }}</td>
                                            <td>{{ implode(', ', $val) }}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td>...</td>
                                        <td>...</td>
                                    </tr>
                                    @php($no_tail = count($fp_list) - 4)
                                    @foreach ($fp_list_tail as $item => $val)
                                        <tr>
                                            <td>{{ $no_tail++ }}</td>
                                            <td>{{ implode(', ', $val) }}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="card mb-4" id="fpt">
                    <div class="card-header">
                        FP-Tree
                    </div>
                    <div class="card-body">
                        {{ App\Http\Controllers\AnalisisController::display() }}
                    </div>
                </div>

                <div class="card mb-4" id="cpb">
                    <div class="card-header">
                        Conditional Patern Base
                    </div>
                    <div class="card-body">
                        <div class="table-responsive-sm">
                            <table class="table table-bordered table-hover table-striped datatable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Item</th>
                                        <th>Conditional Patern Base</th>
                                    </tr>
                                </thead>
                                @php($no = 1)
                                @foreach ($it as $key => $val)
                                    @if (isset($conditional_pb[$key]))
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $key }}</td>
                                            <td>
                                                @php($arr = [])
                                                @foreach ($conditional_pb[$key] as $key => $val)
                                                    {<code>{{ $arr[] = ' ' . implode(',', $val['items']) . ":$val[count] " }}</code>}
                                                @endforeach
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card mb-4" id="cfp">
                    <div class="card-header">
                        Conditional FP-Tree
                    </div>
                    <div class="card-body">
                        <div class="table-responsive-sm">
                            <table class="table table-bordered table-hover table-striped datatable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Item</th>
                                        <th>Conditional FP-Tree</th>
                                    </tr>
                                </thead>
                                @php($no = 1)
                                @foreach ($it as $key => $val)
                                    @if (isset($conditional_fpt[$key]))
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $key }}</td>
                                            <td>
                                                @php($arr = [])
                                                @foreach ($conditional_fpt[$key] as $key => $val)
                                                    {<code>{{ $arr[] = ' ' . implode(',', $val['items']) . ":$val[count] " }}</code>}
                                                @endforeach
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card mb-4" id="fpattern">
                    <div class="card-header">
                        Frequent Pattern
                    </div>
                    <div class="card-body">
                        <div class="table-responsive-sm">
                            <table class="table table-bordered table-hover table-striped datatable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Item</th>
                                        <th>Frequent Pattern</th>
                                    </tr>
                                </thead>
                                @php($no = 1)
                                @foreach ($fpg as $key => $val)
                                    @foreach ($val as $k => $v)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $key }}</td>
                                            <td>{{ implode(', ', $v['items']) }} ({{ $v['count'] }})</td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            @endif

            <div class="card mb-4" id="asosiasi">
                <div class="card-header">
                    Aturan Asosiasi
                </div>
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <table class="table table-bordered table-hover table-striped datatable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Rule</th>
                                    <th>Support</th>
                                    <th>Confidence</th>
                                    <th>Lift Ratio</th>
                                </tr>
                            </thead>
                            @php($no = 1)
                            @foreach ($association as $key => $val)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>
                                        Jika
                                        <code>{{ implode(',', $val['left']) }}</code>
                                        maka
                                        <code>{{ implode(',', $val['right']) }}</code>
                                    </td>
                                    <td>{{ $val['a'] }}/{{ $val['total'] }} =
                                        {{ round($val['sup'] * 100, 2) }}%
                                    </td>
                                    <td>{{ $val['a'] }}/{{ $val['b'] }} =
                                        {{ round($val['conf'] * 100, 2) }}%
                                    </td>
                                    <td>{{ round($val['lr'], 2) }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>

            <div class="card mb-4" id="rekomendasi">
                <div class="card-header">
                    Rekomendasi
                </div>
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <table class="table table-bordered table-hover table-striped datatable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Strong Rule</th>
                                    <th colspan="2">Representasi Pengetahuan</th>
                                    <th>Lift Ratio</th>
                                </tr>
                            </thead>
                            @php($no = 1)
                            @foreach ($association as $key => $val)
                                @if ($val['lr'] >= 1)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>
                                            Jika
                                            <code>{{ implode(', ', $val['left']) }}</code>
                                            maka
                                            <code>{{ implode(', ', $val['right']) }}</code>
                                        </td>
                                        <td>
                                            Item
                                            <code>{{ join(' dan ', array_filter(array_merge([join(', ', array_slice($val['merge'], 0, -1))], array_slice($val['merge'], -1)), 'strlen')) }}</code>
                                            harus ditempatkan pada rak yang berdekatan.
                                        </td>
                                        <td>
                                            Item
                                            <code>{{ join(' dan ', array_filter(array_merge([join(', ', array_slice($val['merge'], 0, -1))], array_slice($val['merge'], -1)), 'strlen')) }}</code>
                                            cocok untuk dijadikan paket pembelian.
                                        </td>
                                        <td>
                                            {{ round($val['lr'], 2) }}
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>

            <div class="card mb-4" id="waktu-memory">
                <div class="card-body">
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">Waktu Eksekusi</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="{{ round($waktu_eksekusi, 2) }} Detik"
                                disabled readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">Penggunaan Memori</label>
                        <div class="col-sm-10">
                            @php($memory = memory_get_usage() / 1024 / 1024)
                            <input type="text" class="form-control" value="{{ round($memory, 2) }} MB" disabled
                                readonly>
                        </div>
                    </div>
                    <a class="btn btn-primary" href="/analisis" id="tombol">
                        Kembali</a>
                </div>
            </div>

        </div>
    </div>
    </div>
@endsection
