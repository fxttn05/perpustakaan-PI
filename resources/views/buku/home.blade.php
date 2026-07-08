@extends('layout')
@section('content')
<div class="min-h-screen">
    <div class="bg-slate-100 py-6 px-10">

        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-800">
                Buku
            </h1>
            <p class="text-slate-500 mt-1">
                Kelola seluruh koleksi buku perpustakaan
            </p>
        </div>

        <!-- Livewire Volt -->
        <livewire:bukutable />

    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function openTambahModal(){
            const modal = document.getElementById('tambahModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeTambahModal()
        {
            const modal = document.getElementById('tambahModal');
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }

        function openEditModal(button)
        {
            const modal = document.getElementById('editModal');
            document.getElementById('formEdit').action =`/buku/update/${button.dataset.id}`;
            document.getElementById('edit_kode').value = button.dataset.kode;
            document.getElementById('edit_judul').value = button.dataset.judul;
            document.getElementById('edit_penerbit').value = button.dataset.penerbit;
            document.getElementById('edit_penulis').value = button.dataset.penulis;
            document.getElementById('edit_isbn').value = button.dataset.isbn;
            document.getElementById('edit_tahun').value = button.dataset.tahun;
            document.getElementById('edit_total').value = button.dataset.total;
            document.getElementById('edit_tersedia').value = button.dataset.tersedia;
            document.getElementById('edit_kategori').value = button.dataset.kategori;
            document.getElementById('edit_keterangan').value = button.dataset.keterangan;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeEditModal()
        {
            const modal = document.getElementById('editModal');
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }

        function confirmSave(formId)
        {
            Swal.fire({
                title: 'Apakah data sudah benar?',
                text: 'Periksa kembali sebelum disimpan.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#16a34a',
                cancelButtonColor: '#ef4444',
                confirmButtonText: 'Ya, Simpan',
                cancelButtonText: 'Cek Lagi'
            }).then((result)=>{
                if(result.isConfirmed){
                    document.getElementById(formId).submit();
                }
            });
        }

        function deleteBook(id)
        {
            Swal.fire({
                title:'Hapus Buku?',
                text:'Data buku akan dihapus permanen.',
                icon:'warning',
                showCancelButton:true,
                confirmButtonText:'Ya, Hapus',
                cancelButtonText:'Batal',
                confirmButtonColor:'#dc2626'
            }).then((result)=>{
                if(result.isConfirmed){
                    document.getElementById('delete-'+id).submit();
                }
            });
        }
    </script>
</div>

@include('buku.modal-tambah')
@include('buku.modal-edit')

@if(session('success'))
<script>
Swal.fire({
    icon:'success',
    title:'Berhasil',
    text:'{{ session("success") }}',
    timer:1800,
    showConfirmButton:false
});
</script>
@endif

@if($errors->any())
<script>
Swal.fire({
    icon:'error',
    title:'Terjadi Kesalahan',
    html:`{!! implode('<br>',$errors->all()) !!}`
});
</script>
@endif

@endsection