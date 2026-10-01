<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('suppliers')->insert([
            [
                'name' => 'PT. Indofood Sukses Makmur Tbk',
                'phone' => '02157958822',
                'address' => 'Jakarta, Indonesia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'PT. Unilever Indonesia Tbk',
                'phone' => '02180827000',
                'address' => 'Tangerang, Banten, Indonesia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'PT. Mayora Indah Tbk',
                'phone' => '02180637777',
                'address' => 'Jakarta, Indonesia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
