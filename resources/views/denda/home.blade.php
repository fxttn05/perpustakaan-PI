@extends('layout')

@section('content')

<div class="min-h-screen">
    <div class="bg-slate-100 py-6 px-10">

        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-800">Denda</h1>
            <p class="text-slate-500">Kelola pembayaran denda keterlambatan buku.</p>
        </div>

        <livewire:dendatable />

    </div>
    <script>
        function confirmBayar(url){
            document.getElementById('formBayar').action=url;
            document.getElementById('modalBayar').classList.remove('hidden');
            document.getElementById('modalBayar').classList.add('flex');
        }
        
        function closeBayarModal(){
            document.getElementById('modalBayar').classList.remove('flex');
            document.getElementById('modalBayar').classList.add('hidden');
        }
    </script>
</div>

@include('denda.modal-bayar')

@endsection