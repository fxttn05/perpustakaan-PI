@extends('layout')

@section('content')

<div class="min-h-screen">

    <div class="bg-slate-100 py-6 px-10">

        <div class="mb-8">

            <h1 class="text-3xl font-bold text-slate-800">

                Kategori Buku

            </h1>

            <p class="text-slate-500">

                Kelola kategori buku perpustakaan

            </p>

        </div>

        <livewire:kategoritable />

    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('searchInput').addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll('#kategoriTable tbody tr');
        
            rows.forEach(row => {
                let text = row.innerText.toLowerCase();
                row.style.display = text.includes(filter) ? '' : 'none';
            });
        });

        function openTambahModal(){
            document.getElementById('tambahModal').classList.remove('hidden');
            document.getElementById('tambahModal').classList.add('flex');
        }
        
        function closeTambahModal(){
            document.getElementById('tambahModal').classList.add('hidden');
        }

        function openEditModal(button)
        {
            document
                .getElementById('edit_nama')
                .value =
                button.dataset.nama;
        
            document
                .getElementById('edit_deskripsi')
                .value =
                button.dataset.deskripsi;
        
            document
                .getElementById('formEdit')
                .action =
                `/kategori/update/${button.dataset.id}`;
        
            document
                .getElementById('editModal')
                .classList.remove('hidden');
        
            document
                .getElementById('editModal')
                .classList.add('flex');
        }

        function closeEditModal(){
            document.getElementById('editModal').classList.remove('flex');
        
            document.getElementById('editModal').classList.add('hidden');
        }

        function confirmSave(formId)
        {
            Swal.fire({
                title: 'Apakah sudah benar?',
                text: 'Cek kembali jika masih ragu',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, sudah',
                cancelButtonText: 'Cek lagi'
            }).then((result) => {
                if(result.isConfirmed){
                    document.getElementById(formId).submit();
                }
            
            });
        }

        function deleteData(id){
            Swal.fire({
                title: 'Hapus data?',
                text: 'Data yang dihapus tidak dapat dikembalikan',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if(result.isConfirmed){
                    document.getElementById(`delete-${id}`).submit();
                }
            });
        }
    </script>

</div>

@include('kategori.modal-tambah')
@include('kategori.modal-edit')

@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Berhasil',
    text: '{{ session("success") }}'
});
</script>
@endif

@endsection