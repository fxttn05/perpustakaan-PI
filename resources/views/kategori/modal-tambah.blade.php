<div id="tambahModal" class="hidden fixed inset-0 bg-black/50 z-50 items-center justify-center">
    <div class="bg-white rounded-xl w-full max-w-4xl">

        <!-- Header -->
        <div class="flex justify-between items-center border-b p-5">
            <h2 class="text-xl font-semibold">
                Form Tambah Kategori
            </h2>

            <button onclick="closeTambahModal()" class="bg-red-500 text-white px-4 py-2 rounded-lg">
                Batal
            </button>
        </div>

        <!-- Body -->
        <form id="formTambah" action="{{ route('kategori.store') }}" method="POST">
            @csrf
            <div class="gap-5 gap-y-5 p-6">
                <div class="mb-5">
                    <label>Nama Kategori</label>
                    <input type="text" name="nama_kategori" class="w-full border rounded-lg p-2">
                </div>

                <div>
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" class="w-full border rounded-lg p-2" rows="5"></textarea>
                </div>
            </div>

            <!-- Footer -->
            <div class="border-t p-5 text-right">
                <button type="button" onclick="confirmSave('formTambah')" class="bg-green-600 text-white px-5 py-2 rounded-lg">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>