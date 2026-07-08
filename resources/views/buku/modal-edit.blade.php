<div id="editModal" class="hidden fixed inset-0 bg-black/50 z-50 items-center justify-center">
    <div class="bg-white rounded-xl w-full max-w-5xl">

        <!-- Header -->
        <div class="flex justify-between items-center border-b p-5">
            <h2 class="text-xl font-semibold">Form Edit Buku</h2>
            <button onclick="closeEditModal()" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">Batal</button>
        </div>

        <!-- Body -->
        <form id="formEdit" method="POST">
            @csrf @method('PUT')
            <div class="grid grid-cols-2 gap-5 p-6">
                <div>
                    <label class="block mb-2">Kode Buku </label>
                    <input id="edit_kode" readonly class="w-full border rounded-lg p-2 bg-slate-100">
                </div>
                <div>
                    <label class="block mb-2">Judul Buku</label>
                    <input id="edit_judul" name="judul_buku" class="w-full border rounded-lg p-2">
                </div>
                <div>
                    <label class="block mb-2">Penulis</label>
                    <input id="edit_penulis" name="penulis" class="w-full border rounded-lg p-2">
                </div>
                <div>
                    <label class="block mb-2">Penerbit</label>
                    <input list="publisher-list" id="edit_penerbit" name="penerbit" class="w-full border rounded-lg p-2">
                </div>
                <div>
                    <label class="block mb-2">ISBN</label>
                    <input id="edit_isbn" name="isbn" class="w-full border rounded-lg p-2">
                </div>
                <div>
                    <label class="block mb-2">Tahun Terbit</label>
                    <input type="number" id="edit_tahun" name="tahun_terbit" class="w-full border rounded-lg p-2">
                </div>
                <div>
                    <label class="block mb-2">Kategori</label>
                    <select id="edit_kategori" name="kategori_id" class="w-full border rounded-lg p-2">
                        @foreach($kategori as $item)
                            <option value="{{ $item->id }}">
                                {{ $item->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block mb-2">Jumlah Total</label>
                    <input type="number" id="edit_total" name="jumlah_total" class="w-full border rounded-lg p-2">
                </div>
                <div>
                    <label class="block mb-2">Jumlah Tersedia</label>
                    <input type="number" id="edit_tersedia" name="jumlah_tersedia" class="w-full border rounded-lg p-2">
                </div>
            </div>

            <!-- Footer -->
            <div class="border-t p-5 text-right">
                <button type="button" onclick="confirmSave('formEdit')" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>