<div id="tambahModal" class="hidden fixed inset-0 bg-black/50 z-50 items-center justify-center">
    <div class="bg-white rounded-xl w-full max-w-4xl">

        <!-- Header -->
        <div class="flex justify-between items-center border-b p-5">
            <h2 class="text-xl font-semibold">
                Form Tambah Anggota
            </h2>

            <button onclick="closeTambahModal()" class="bg-red-500 text-white px-4 py-2 rounded-lg">
                Batal
            </button>
        </div>

        <!-- Body -->
        <form id="formTambah" action="{{ route('anggota.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-2 gap-5 p-6">
                <div>
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="w-full border rounded-lg p-2">
                </div>

                <div>
                    <label>Email</label>
                    <input type="email" name="email" class="w-full border rounded-lg p-2">
                </div>

                <div>
                    <label>Jabatan</label>
                    <select name="jabatan" class="w-full border rounded-lg p-2">
                        <option value="Siswa">Siswa</option>
                        <option value="Guru">Guru</option>
                    </select>
                </div>

                <div>
                    <label>Kelas</label>
                    <input type="text" name="kelas" class="w-full border rounded-lg p-2">
                </div>

                <div>
                    <label>No Telepon</label>
                    <input type="text" name="no_telp" class="w-full border rounded-lg p-2">
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