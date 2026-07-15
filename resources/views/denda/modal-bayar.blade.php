<div id="modalBayar" class="hidden fixed inset-0 bg-black/50 z-50 items-center justify-center">
    <div class="bg-white rounded-xl w-full max-w-xl">

        <div class="flex justify-between items-center border-b p-5">
            <h2 class="text-xl font-semibold">Pembayaran Denda</h2>
            <button type="button" onclick="closeBayarModal()" class="bg-red-500 text-white px-4 py-2 rounded-lg">
                Batal
            </button>
        </div>

        <form id="formBayar" method="POST">
            @csrf
            @method('PUT')

            <div class="p-6">
                <label class="block mb-2">Keterangan</label>
                <textarea name="keterangan" rows="4" class="w-full border rounded-lg p-2"></textarea>
            </div>

            <div class="border-t p-5 text-right">
                <button type="button" onclick="confirmSave('formBayar')" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg">
                    Simpan
                </button>
            </div>

        </form>

    </div>
</div>