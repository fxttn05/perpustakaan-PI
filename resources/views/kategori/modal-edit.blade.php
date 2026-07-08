<div id="editModal" class="hidden fixed inset-0 bg-black/50 z-50 items-center justify-center">
    <div class="bg-white rounded-xl w-full max-w-4xl">
        <!-- Header -->
        <div class="flex justify-between items-center border-b p-5">
            <h2 class="text-xl font-semibold">Form Edit Kategori</h2>
            <button onclick="closeEditModal()" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">Batal</button>
        </div>

        <!-- Body -->
        <form id="formEdit" method="POST">
            @csrf @method('PUT')
            <div class="grid grid-cols-2 gap-5 p-6">
                <div>
                    <label class="block mb-2">Nama kategori</label>
                    <input id="edit_nama" name="nama_kategori" class="w-full border rounded-lg p-2 bg-slate-100">
                </div>

                <div class="block mb-2">
                    <label>Deskripsi</label>
                    <textarea id="edit_deskripsi" name="deskripsi" class="w-full border rounded-lg p-2" rows="5"></textarea>
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