@extends('layout')

@section('content')

<div class="min-h-screen">
    <div class="bg-slate-100 py-6 px-10">

        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-800">Peminjaman</h1>
            <p class="text-slate-500">Kelola data peminjaman buku perpustakaan.</p>
        </div>

        <livewire:peminjamantable />
        @include('peminjaman.modal-tambah')

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

        function confirmSave(formId){
            Swal.fire({
            title:'Simpan data?',
            icon:'question',
            showCancelButton:true,
            confirmButtonText:'Simpan',
            cancelButtonText:'Batal'
            }).then(result=>{
                if(result.isConfirmed){
                    document.getElementById(formId).submit();
                }
            });
        }
        function confirmKembaliSemua(url){
            Swal.fire({
                title:'Kembalikan semua buku?',
                text:'Semua buku pada transaksi ini akan dikembalikan.',
                icon:'question',
                showCancelButton:true,
                confirmButtonText:'Ya',
                cancelButtonText:'Batal'
            }).then(result=>{
                if(result.isConfirmed){
                    let form=document.createElement('form');
                    form.method='POST';
                    form.action=url;
                    form.innerHTML='@csrf @method("PUT")';
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        function confirmPerpanjang(url){
            Swal.fire({
                title:'Perpanjang periode?',
                text:'Periode akan bertambah 1 minggu.',
                icon:'question',
                showCancelButton:true,
                confirmButtonText:'Perpanjang',
                cancelButtonText:'Batal'
                }).then(result=>{
                    if(result.isConfirmed){
                    let form=document.createElement('form');
                    form.method='POST';
                    form.action=url;
                    form.innerHTML='@csrf @method("PUT")';
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        function confirmKembali(url){       
            Swal.fire({
                title:'Kembalikan buku?',
                icon:'question',
                showCancelButton:true,
                confirmButtonText:'Ya',
                cancelButtonText:'Batal'
                }).then(result=>{
                    if(result.isConfirmed){
                    let form=document.createElement('form');
                    form.method='POST';
                    form.action=url;
                    form.innerHTML='@csrf @method("PUT")';
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
        document.addEventListener('DOMContentLoaded', function(){
            const anggota = @json($anggota);
            const buku = @json($buku);
            const bookContainer=document.getElementById('bookContainer');
            const btnTambah=document.getElementById('btnTambahBuku');
    
            function initAnggotaAutocomplete(){
                const input=document.getElementById('anggota_search');
                const hidden=document.getElementById('anggota_id');
                const result=document.getElementById('anggota_result');
                input.addEventListener('input',function(){
                
                    const keyword=this.value.toLowerCase();
                
                    result.innerHTML='';
                
                    if(keyword.length==0){
                        result.classList.add('hidden');
                        return;
                    }
                
                    const data=anggota.filter(item=>
                
                        item.kode_anggota.toLowerCase().includes(keyword) ||
                
                        item.nama_lengkap.toLowerCase().includes(keyword) ||
                
                        (item.kelas??'').toLowerCase().includes(keyword)
                
                    );
                
                    if(data.length==0){
                    
                        result.classList.add('hidden');
                        hidden.value='';
                        return;
                    
                    }
                
                    data.forEach(item=>{
                    
                        const div=document.createElement('div');
                    
                        div.className='px-3 py-2 hover:bg-blue-50 cursor-pointer border-b';
                    
                        div.innerHTML=`
                            <div class="font-medium">${item.nama_lengkap} - ${item.kode_anggota}</div>
                            <div class="text-xs text-slate-500">${item.jabatan} - ${item.kelas ?? ' '}</div>
                        `;
                    
                        div.onclick=function(){
                        
                            input.value=`${item.kode_anggota} - ${item.nama_lengkap} - ${item.jabatan} - ${item.kelas ?? ' '}`;
                        
                            hidden.value=item.id;
                        
                            result.classList.add('hidden');
                        
                        };
                    
                        result.appendChild(div);
                    
                    });
                
                    result.classList.remove('hidden');
                
                });
            
                document.addEventListener('click',function(e){
                
                    if(!result.contains(e.target) && e.target!=input){
                    
                        result.classList.add('hidden');
                    
                    }
                
                });
            
            }
    
            function initBookAutocomplete(row){
            
                const input=row.querySelector('.buku-search');
                const hidden=row.querySelector('.buku-id');
                const result=row.querySelector('.buku-result');
            
                input.addEventListener('input',function(){
                
                    const keyword=this.value.toLowerCase();
                
                    result.innerHTML='';
                
                    if(keyword.length==0){
                    
                        result.classList.add('hidden');
                        hidden.value='';
                        return;
                    
                    }
                
                    const selected=[
                
                        ...document.querySelectorAll('.buku-id')
                
                    ].map(i=>i.value);
                
                    const data=buku.filter(item=>{
                    
                        if(selected.includes(String(item.id))) return false;
                    
                        return item.kode_buku.toLowerCase().includes(keyword)
                    
                        ||
                    
                        item.judul_buku.toLowerCase().includes(keyword);
                    
                    });
                
                    if(data.length==0){
                    
                        result.classList.add('hidden');
                        hidden.value='';
                        return;
                    
                    }
                
                    data.forEach(item=>{
                    
                        const div=document.createElement('div');
                    
                        div.className='px-3 py-2 hover:bg-blue-50 cursor-pointer border-b';
                    
                        div.innerHTML=`
                            <div class="font-medium">${item.judul_buku}</div>
                            <div class="text-sm text-slate-700">${item.kode_buku} - Tersedia ${item.jumlah_tersedia} buku</div>
                        `;
                    
                        div.onclick=function(){
                        
                            input.value=`${item.kode_buku} - ${item.judul_buku}`;
                        
                            hidden.value=item.id;
                        
                            result.classList.add('hidden');
                        
                        };
                    
                        result.appendChild(div);
                    
                    });
                
                    result.classList.remove('hidden');
                
                });
            
                document.addEventListener('click',function(e){
                
                    if(!result.contains(e.target) && e.target!=input){
                    
                        result.classList.add('hidden');
                    
                    }
                
                });
            
            }
    
            initAnggotaAutocomplete();
    
            document.querySelectorAll('.book-row').forEach(row=>{
            
                initBookAutocomplete(row);
            
            });
    
            btnTambah.addEventListener('click',function(){
            
                if(document.querySelectorAll('.book-row').length>=6){
                
                    Swal.fire({
                        icon:'warning',
                        title:'Maksimal 6 buku.'
                    });
                
                    return;
                
                }
            
                const row=document.querySelector('.book-row').cloneNode(true);
            
                row.querySelector('.buku-search').value='';
                row.querySelector('.buku-id').value='';
                row.querySelector('[name="periode[]"]').value=1;
            
                row.querySelector('.buku-result').innerHTML='';
            
                row.querySelector('.buku-result').classList.add('hidden');
            
                bookContainer.appendChild(row);
            
                initBookAutocomplete(row);
            
            });
    
            document.addEventListener('click',function(e){
            
                if(e.target.classList.contains('hapusBaris')){
                
                    if(document.querySelectorAll('.book-row').length==1){
                    
                        Swal.fire({
                            icon:'warning',
                            title:'Minimal harus ada 1 buku.'
                        });
                    
                        return;
                    
                    }
                
                    e.target.closest('.book-row').remove();
                
                }
            
            });
        });

    </script>
</div>



@endsection