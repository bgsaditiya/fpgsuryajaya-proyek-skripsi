<?php

namespace App\Imports;

use App\Models\Data;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Illuminate\Support\Facades\DB;

class DataImport implements ToModel, WithHeadingRow, WithChunkReading, WithBatchInserts 
{

    public function __construct()
    {
        // Data::truncate();
        DB::table('tbdata')->truncate();
    }
    
    public function model(array $row)
    {
        return new Data([
            'id_transaksi' => $row['id_transaksi'],
            'item' => $row['item'],
            'tanggal' => Carbon::parse($row['tanggal'])->toDateString(),
        ]);
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}