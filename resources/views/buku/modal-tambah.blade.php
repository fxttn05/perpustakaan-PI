<div id="tambahModal" class="hidden fixed inset-0 bg-black/50 z-50 items-center justify-center">
    <div class="bg-white rounded-xl w-full max-w-5xl">

        <!-- Header -->
        <div class="flex justify-between items-center border-b p-5">
            <h2 class="text-xl font-semibold">Form Tambah Buku</h2>
            <button onclick="closeTambahModal()" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">Batal</button>
        </div>

        <!-- Body -->
        <form id="formTambah" action="{{ route('buku.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-2 gap-5 p-6">
                <div>
                    <label class="block mb-2">Judul Buku *</label>
                    <input type="text" name="judul_buku" class="w-full border rounded-lg p-2" required>
                </div>

                <div>
                    <label class="block mb-2">Penulis *</label>
                    <input type="text" name="penulis" class="w-full border rounded-lg p-2" required>
                </div>

                <div>
                    <label class="block mb-2">Penerbit *</label>
                    <input list="publisher-list" name="penerbit" class="w-full border rounded-lg p-2" required>
                    <datalist id="publisher-list">
                        <option value="SMK Taruna Bhakti Depok">
                    </datalist>
                </div>

                <div>
                    <label class="block mb-2">ISBN</label>
                    <input type="text" name="isbn" class="w-full border rounded-lg p-2">
                </div>

                <div>
                    <label class="block mb-2">Kategori *</label>
                    <select name="kategori_id" class="w-full border rounded-lg p-2" required>
                        @foreach($kategori as $item)
                            <option value="{{ $item->id }}">
                                {{ $item->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block mb-2">Tahun Terbit *</label>
                    <input type="number" min="1900" max="{{ date('Y') }}" name="tahun_terbit" class="w-full border rounded-lg p-2" required>
                </div>

                <div>
                    <label class="block mb-2">Jumlah Total *</label>
                    <input type="number" min="1" name="jumlah_total" class="w-full border rounded-lg p-2" required>
                </div>

                <div>
                    <label class="block mb-2">Jumlah Tersedia *</label>
                    <input type="number" min="0" name="jumlah_tersedia" class="w-full border rounded-lg p-2" required>
                </div>
            </div>

            <!-- Footer -->
            <div class="border-t p-5 text-right">
                <button type="button" onclick="confirmSave('formTambah')" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>