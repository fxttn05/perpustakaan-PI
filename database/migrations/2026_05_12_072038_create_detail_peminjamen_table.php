<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('detail_peminjamen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peminjaman_id')->constrained('peminjamans')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('buku_id')->constrained('bukus')->cascadeOnUpdate()->cascadeOnDelete();
            $table->date('tanggal_pinjam');
            $table->integer('periode')->default(1);
            $table->integer('durasi')->default(7);
            $table->integer('jumlah_perpanjangan')->default(0);
            $table->date('tanggal_jatuh_tempo');
            $table->enum('status',['Dipinjam', 'Dikembalikan', 'Terlambat'])->default('Dipinjam');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_peminjamen');
    }
};
