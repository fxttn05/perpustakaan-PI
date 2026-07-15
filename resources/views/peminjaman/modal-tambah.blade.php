<div id="tambahModal" class="hidden fixed inset-0 bg-black/50 z-50 items-center justify-center overflow-y-auto">
    <div class="bg-white rounded-xl w-full max-w-6xl my-10">

        <div class="flex justify-between items-center border-b p-5">
            <h2 class="text-xl font-semibold">Form Tambah Peminjaman</h2>
            <button type="button" onclick="closeTambahModal()" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">Batal</button>
        </div>

        <form id="formTambah" action="{{ route('peminjaman.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-2 gap-5 p-6">

                <div class="relative">
                    <label class="block mb-2">Nama Peminjam *</label>

                    <input type="hidden" name="anggota_id" id="anggota_id">

                    <input type="text" id="anggota_search" autocomplete="off" placeholder="Cari kode / nama / kelas..." class="w-full border rounded-lg p-2">

                    <div id="anggota_result" class="hidden absolute left-0 right-0 bg-white border rounded-lg shadow-lg mt-1 max-h-60 overflow-y-auto z-50">
                    </div>

                </div>

                <div>
                    <label class="block mb-2">Tanggal Pinjam *</label>
                    <input type="date" name="tanggal_pinjam" value="{{ date('Y-m-d') }}" class="w-full border rounded-lg p-2">
                </div>

            </div>
            <hr>
            <div class="p-6">

                <div class="flex justify-between items-center mb-5">

                    <h3 class="font-semibold text-lg">
                        Daftar Buku
                    </h3>

                    <button type="button" id="btnTambahBuku"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">

                        + Tambah Buku

                    </button>

                </div>

                <div id="bookContainer">

                    <div class="grid grid-cols-12 gap-3 mb-3 book-row">

                        <div class="col-span-8 relative">

                            <input type="hidden" name="buku_id[]" class="buku-id">

                            <input type="text" class="buku-search w-full border rounded-lg p-2" placeholder="Cari kode / judul buku">

                            <div class="hidden buku-result absolute left-0 right-0 bg-white border rounded-lg shadow-lg mt-1 max-h-60 overflow-y-auto z-40">
                            </div>

                        </div>

                        <div class="col-span-3">

                            <input type="number" name="periode[]" min="1" value="1" class="w-full border rounded-lg p-2">

                        </div>

                        <div class="col-span-1">

                            <button type="button" class="hapusBaris bg-red-500 text-white rounded-lg w-full h-full">

                                ✕

                            </button>

                        </div>

                    </div>

                </div>

                <p class="text-sm text-slate-500 mt-2">
                    Maksimal 6 buku dalam satu transaksi.
                </p>

            </div>
            <hr>
            <div class="p-6">
                <label class="block mb-2">Keterangan</label>
                <textarea name="keterangan" class="w-full border rounded-lg p-2" rows="3"></textarea>
            </div>

            <div class="border-t p-5 text-right">

                <button type="button" onclick="confirmSave('formTambah')" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg">

                    Simpan

                </button>

            </div>
            
            

        </form>

    </div>
</div>
