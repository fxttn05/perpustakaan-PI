<div
    id="editModal"
    class="hidden fixed inset-0 bg-black/50 z-50 items-center justify-center">

    <div
        class="bg-white rounded-xl w-full max-w-4xl">

        <!-- Header -->

        <div
            class="flex justify-between items-center border-b p-5">

            <h2
                class="text-xl font-semibold">

                Form Edit Anggota

            </h2>

            <button
                onclick="closeEditModal()"
                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">

                Batal

            </button>

        </div>

        <form
            id="formEdit"
            method="POST">

            @csrf
            @method('PUT')

            <!-- Body -->

            <div
                class="grid grid-cols-2 gap-5 p-6">

                <div>
                    <label class="block mb-2">
                        Kode Anggota
                    </label>

                    <input
                        id="edit_kode"
                        readonly
                        class="w-full border rounded-lg p-2 bg-slate-100">
                </div>

                <div>
                    <label class="block mb-2">
                        Nama Lengkap
                    </label>

                    <input
                        type="text"
                        id="edit_nama"
                        name="nama_lengkap"
                        class="w-full border rounded-lg p-2">
                </div>

                <div>
                    <label class="block mb-2">
                        Jabatan
                    </label>

                    <select
                        id="edit_jabatan"
                        name="jabatan"
                        class="w-full border rounded-lg p-2">

                        <option value="Siswa">
                            Siswa
                        </option>

                        <option value="Guru">
                            Guru
                        </option>

                    </select>

                </div>

                <div>
                    <label class="block mb-2">
                        Kelas
                    </label>

                    <input
                        type="text"
                        id="edit_kelas"
                        name="kelas"
                        class="w-full border rounded-lg p-2">
                </div>

                <div>
                    <label class="block mb-2">
                        Email
                    </label>

                    <input
                        type="email"
                        id="edit_email"
                        name="email"
                        class="w-full border rounded-lg p-2">
                </div>

                <div>
                    <label class="block mb-2">
                        No Telepon
                    </label>

                    <input
                        type="text"
                        id="edit_telp"
                        name="no_telp"
                        class="w-full border rounded-lg p-2">
                </div>

            </div>

            <!-- Footer -->

            <div
                class="border-t p-5 text-right">

                <button
                    type="button"
                    onclick="confirmSave('formEdit')"
                    class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg">

                    Simpan

                </button>

            </div>

        </form>

    </div>

</div>