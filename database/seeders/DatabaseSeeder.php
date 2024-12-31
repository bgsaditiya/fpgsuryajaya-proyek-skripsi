<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        DB::table('TbUser')->insert([
            'username' => 'admin',
            'password' => bcrypt('admin'),
            'nama' => 'Admin Pertama',
            'jenis' => 'admin',
        ]);

        DB::table('TbUser')->insert([
            'username' => 'pegawai',
            'password' => bcrypt('pegawai'),
            'nama' => 'Pegawai Pertama',
            'jenis' => 'pegawai',
        ]);

        DB::table('TbData')->insert(array(array(
            'id_transaksi' => 'T000001',
            'item' => 'Apel',
            'tanggal' => '2019-02-26',
        ),
        array(
            'id_transaksi' => 'T000001',
            'item' => 'Bir',
            'tanggal' => '2019-02-26',
        ),
        array(
            'id_transaksi' => 'T000001',
            'item' => 'Nasi',
            'tanggal' => '2019-02-26',
        ),
        array(
            'id_transaksi' => 'T000001',
            'item' => 'Ayam',
            'tanggal' => '2019-02-26',
        ),
        array(
            'id_transaksi' => 'T000002',
            'item' => 'Apel',
            'tanggal' => '2019-02-27',
        ),
        array(
            'id_transaksi' => 'T000002',
            'item' => 'Bir',
            'tanggal' => '2019-02-27',
        ),
        array(
            'id_transaksi' => 'T000002',
            'item' => 'Nasi',
            'tanggal' => '2019-02-27',
        ),
        array(
            'id_transaksi' => 'T000003',
            'item' => 'Apel',
            'tanggal' => '2019-03-02',
        ),
        array(
            'id_transaksi' => 'T000003',
            'item' => 'Bir',
            'tanggal' => '2019-03-02',
        ),
        array(
            'id_transaksi' => 'T000004',
            'item' => 'Apel',
            'tanggal' => '2019-03-03',
        ),
        array(
            'id_transaksi' => 'T000004',
            'item' => 'Bir',
            'tanggal' => '2019-03-03',
        ),
        array(
            'id_transaksi' => 'T000005',
            'item' => 'Bir',
            'tanggal' => '2019-03-04',
        ),
        array(
            'id_transaksi' => 'T000005',
            'item' => 'Nasi',
            'tanggal' => '2019-03-04',
        ),
        array(
            'id_transaksi' => 'T000005',
            'item' => 'Ayam',
            'tanggal' => '2019-03-04',
        ),
        array(
            'id_transaksi' => 'T000005',
            'item' => 'Susu',
            'tanggal' => '2019-03-04',
        ),
        array(
            'id_transaksi' => 'T000006',
            'item' => 'Bir',
            'tanggal' => '2019-03-05',
        ),
        array(
            'id_transaksi' => 'T000006',
            'item' => 'Nasi',
            'tanggal' => '2019-03-05',
        ),
        array(
            'id_transaksi' => 'T000006',
            'item' => 'Susu',
            'tanggal' => '2019-03-05',
        ),
        array(
            'id_transaksi' => 'T000007',
            'item' => 'Bir',
            'tanggal' => '2019-03-06',
        ),
        array(
            'id_transaksi' => 'T000007',
            'item' => 'Susu',
            'tanggal' => '2019-03-06',
        ),
        array(
            'id_transaksi' => 'T000008',
            'item' => 'Pir',
            'tanggal' => '2019-03-07',
        ),
        array(
            'id_transaksi' => 'T000008',
            'item' => 'Susu',
            'tanggal' => '2019-03-07',
        ))
    );
    }
}
