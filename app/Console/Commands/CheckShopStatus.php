<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;
class CheckShopStatus extends Command
{
    protected $signature = 'pos:status {jam?}';
    
    protected $description = 'Mengecek status operasional Toko Kelontong POS';
    public function handle()
    {
        $jam = $this->argument('jam') ?? 10;
        $this->info("=== SISTEM MONITORING TOKO KELONTONG ===");
        if ($jam >= 8 && $jam <= 21) {
            $this->info("Status Toko pada jam $jam:00 WIB adalah: BUKA");
            $this->comment("Silakan kasir bersiap di meja transaksi.");
        } else {
            $this->error("Status Toko pada jam $jam:00 WIB adalah: TUTUP");
            $this->warn("Akses transaksi kasir dinonaktifkan sementara.");
        }
    }
}
