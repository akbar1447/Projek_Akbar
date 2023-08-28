<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">  
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <!-- button -->
                    <div class="flex justify-between mb-4 mr-4 ml-4">
                        <h2 class="font-semibold text-xl text-gray-800">
                            {{ __('User') }}
                        </h2>
                        <x-nav-button :href="route('user.create')"
                            class="inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase 
                                tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none 
                                focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition 
                                ease-in-out duration-150" 
                            label="Tambah User" icon="fa-solid fa-user-plus" id="tambah_user"/>
                    </div>

                    @if (session('sukses'))
                        <div class="bg-green-500 text-white p-4 rounded-lg shadow-md mb-4 text-center">
                            <p class="text-xl font-bold">{{ session('sukses') }}</p>
                        </div>
                    @endif
                    @if (session('errors'))
                        <div class="bg-red-500 text-white p-4 rounded-lg shadow-md mb-4 text-center">
                            <p class="text-xl font-bold">Oops, ada beberapa masalah:</p>
                            <ul class="mt-2 list-disc list-inside">
                                @foreach (session('errors')->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <!-- table -->
                    <x-table id="tabel_barang">
                        <x-slot name="header">
                            <x-table-column>No</x-table-column>
                            <x-table-column>Nama</x-table-column>   
                            <x-table-column>Jabatan</x-table-column>
                            <x-table-column>Nomor HP</x-table-column>
                            <x-table-column>Email</x-table-column>
                            <x-table-column>Role</x-table-column>
                            <x-table-column>Aksi</x-table-column>
                        </x-slot>
                        @foreach ($user as $item)
                            <tr>
                                <x-table-column>{{ $loop->iteration }}</x-table-column>
                                <x-table-column>{{ $item->name }}</x-table-column>
                                <x-table-column>{{ $item->jabatan }}</x-table-column>
                                <x-table-column>{{ $item->hp }}</x-table-column> 
                                <x-table-column>{{ $item->email }}</x-table-column>
                                <x-table-column>{{ $item->role }}</x-table-column>
                                <x-table-column>
                                    <x-nav-button :href="route('user.edit',$item->id)"
                                        class="inline-flex items-center p-3 bg-blue-400 border border-transparent 
                                            rounded-md hover:bg-gray-700 active:bg-gray-900 focus:outline-none
                                            focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 
                                            transition ease-in-out duration-150 text-white"
                                        label="" icon="fas fa-pencil" id="edit_user"/>
                                    <x-nav-button type="button" 
                                        class=" inline-flex items-center p-3 bg-red-400 border 
                                            border-transparent rounded-md hover:bg-gray-700 active:bg-gray-900 
                                            focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 
                                            disabled:opacity-25 transition ease-in-out duration-150 text-white"
                                        onclick="toggleModal('hapus_user{{$item->id}}')"
                                        label="" icon="fa-solid fa-user-minus" id="delete_user"/>
                                    <x-modals id="hapus_user{{$item->id}}" title="Konfirmasi Hapus User" form="true">
                                        <form action="{{route('user.destroy',$item->id)}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <p>Apakah anda yakin akan menghapus {{$item->name}}?</p>
                                    </x-modals>
                                    <form action="{{route('user.destroy',$item->id)}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </x-table-column>
                            </tr>
                        @endforeach
                    </x-table>
                    
                    <!-- halaman pagination -->
                    <div class="mt-4">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function toggleModal(modalID){
            document.getElementById(modalID).classList.toggle("hidden");
            document.getElementById(modalID + "-backdrop").classList.toggle("hidden");
            document.getElementById(modalID).classList.toggle("flex");
            document.getElementById(modalID + "-backdrop").classList.toggle("flex");
        }
    </script>
</x-app-layout>