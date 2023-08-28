<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div class="mb-4 mr-4 ml-4">
                        <div class="flex justify-between">
                            <h2 class="font-semibold text-xl text-gray-800">
                                {{ __('Total Barang') }}
                            </h2>
                            @if(\Auth::user()->role !== 'atasan')
                                <div class="relative inline-block text-left">
                                    <a id="showFilterButton"
                                            class="inline-flex items-center px-4 py-2 bg-white border border-blue-500 font-semibold rounded-md text-xs 
                                                hover:bg-blue-500 activate:bg-blue-700 text-blue-500 uppercase tracking-widest hover:text-white ">
                                                <i class="fa-solid fa-filter text-white-400"></i>
                                                &nbsp; Filter
                                    </a>
                                    <a href="{{ route('barang.print', Request::query()) }}" 
                                            target="_blank"
                                            class="inline-flex items-center px-4 py-2 bg-blue-400
                                                rounded-md font-semibold text-xs text-white uppercase 
                                                tracking-widest hover:bg-gray-700 active:bg-gray-900">
                                                <i class="fa-solid fa-print text-white-400"></i>
                                                &nbsp; Cetak
                                    </a>
                                    <div class="relative inline-block text-left">
                                        <button id="showDropdownButton"
                                            class="dropdown-button text-white inline-flex items-center px-4 py-2 bg-slate-500
                                                    rounded-md font-semibold text-xs text-white uppercase 
                                                    tracking-widest hover:bg-gray-700 active:bg-gray-900">
                                            <i class="fa-solid fa-pen-to-square text-white-400"></i>
                                            &nbsp; Edit
                                        </button>
                                        <div class="dropdown-menu origin-top-right absolute right-0 mt-2 max-w-xs rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none hidden" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                                            <div class="py-1" role="none">
                                                @if(\Auth::user()->role == 'admin')
                                                    <a href="{{ route('barang.create') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 whitespace-nowrap" role="menuitem">
                                                        <i class="fa-solid fa-circle-plus text-green-500"></i>
                                                        &nbsp; Tambah Jenis Barang</a>
                                                    <a href="{{ route('barangmasuk.tambah') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 whitespace-nowrap" role="menuitem">
                                                        <i class="fa-solid fa-circle-plus text-green-500"></i>
                                                        &nbsp; Tambah Barang</a>
                                                @endif
                                                <a href="{{ route('barangkeluar.kurang') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 whitespace-nowrap" role="menuitem">
                                                    <i class="fa-solid fa-square-minus text-green-500"></i>
                                                    &nbsp; Keluarkan Barang</a>
                                                <a href="{{ route('barangkembali.kembali') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 whitespace-nowrap" role="menuitem">
                                                    <i class="fa-solid fa-recycle text-green-500"></i>
                                                    &nbsp; Kembalikan Barang</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- filter -->
                    <form id="myFilter" style="display: none;" action="{{ route('barang.index') }}" method="GET" class="items-center">
                        <div class="grid grid-cols-3 gap-4 mx-4 mb-8">
                            <div>
                                <label for="tahun" class="mr-2">Tahun:</label>
                                <input type="number" name="tahun" id="tahun" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full" value="">
                            </div>

                            <div>
                                <label for="bulan" class="mr-2">Bulan:</label>
                                <input type="number" name="bulan" id="bulan" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full" value="">
                            </div>

                            <div>
                                <label for="tanggal" class="mr-2">Tanggal:</label>
                                <input type="number" name="tanggal" id="tanggal" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full" value="">
                            </div>

                            <div>
                                <label for="nama_barang" class="mr-2">Nama Barang:</label>
                                <select name="nama_barang" id="nama_barang" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full">
                                    <option value="">Pilih Barang</option>
                                    @foreach($barang as $barang1)
                                        <option>{{ $barang1->nama_barang }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div>
                                <label for="type" class="mr-2">Tipe:</label>
                                <select name="type" id="type" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full">
                                    <option value="">Pilih Tipe</option>
                                    @foreach($barang as $barang2)
                                        <option>{{ $barang2->type }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="flex justify-end mr-4">
                                <button href="route('barang')" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold px-8 mt-8 mr-2 rounded">
                                    <i class="fa-solid fa-filter-circle-xmark">&nbsp;</i>
                                    Reset
                                </button>
                                <button type="submit" class="bg-white border border-blue-500 hover:bg-blue-500 text-blue-500 hover:text-white font-bold px-8 mt-8 rounded">
                                    <i class="fa-solid fa-filter">&nbsp;</i>
                                    Filter
                                </button>
                            </div>
                        </div>
                    </form>

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
                            <x-table-column>Tanggal Masuk</x-table-column>
                            <x-table-column>Barang</x-table-column>
                            <x-table-column>Tipe</x-table-column>
                            <x-table-column>Tahun</x-table-column>
                            <x-table-column>Jumlah</x-table-column>
                            <x-table-column>Code</x-table-column>
                            <x-table-column>Gambar</x-table-column>
                            @if(\Auth::user()->role !== 'atasan')
                            <x-table-column>Aksi</x-table-column>
                            @endif
                        </x-slot>
                        @foreach ($barang as $item)
                            <tr>
                                <x-table-column>{{$loop->iteration}}</x-table-column>
                                <x-table-column>{{$item->created_at->format('Y-m-d')}}</x-table-column>
                                <x-table-column>{{$item->nama_barang}}</x-table-column>
                                <x-table-column>{{$item->type}}</x-table-column>
                                <x-table-column>{{$item->tahun}}</x-table-column>
                                <x-table-column>
                                    @if($item->jumlah <= 0)
                                        Tidak Tersedia
                                    @else 
                                        {{$item->jumlah}}
                                    @endif
                                </x-table-column>
                                <x-table-column>{{$item->code}}</x-table-column>
                                <x-table-column>
                                    <img src="{{ asset('gambar_barang/' . $item->gambar) }}" alt="Gambar Barang" width="100">
                                </x-table-column>
                                @if(\Auth::user()->role !== 'atasan')
                                <x-table-column>
                                    <x-nav-button :href="route('barang.edit',$item->id)"
                                        class="inline-flex items-center p-3 bg-blue-400 border border-transparent 
                                                rounded-md hover:bg-gray-700 active:bg-gray-900 focus:outline-none
                                                focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 
                                                transition ease-in-out duration-150 text-white"
                                        label="" icon="fas fa-pencil" id="edit_barang"/>    
                                    <button type="button" 
                                        class="fas fa-trash inline-flex items-center p-4 bg-red-400 border 
                                            border-transparent rounded-md hover:bg-gray-700 active:bg-gray-900 
                                            focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 
                                            disabled:opacity-25 transition ease-in-out duration-150 text-white"
                                        onclick="toggleModal('hapus_barang{{$item->id}}')">
                                    </button>

                                    <x-modals id="hapus_barang{{$item->id}}" title="Konfirmasi Hapus Barang" form="true">
                                        <form action="{{route('barang.destroy',$item->id)}}" method="POST" class="inline-flex">
                                        @csrf
                                        @method('DELETE')
                                        <p>Apakah anda yakin akan menghapus {{$item->nama_barang}}?</p>
                                    </x-modals>
                                </x-table-column>
                                @endif
                            </tr>
                        @endforeach
                    </x-table>

                    <!-- halaman pagination -->
                    <div class="mt-4">
                        {{ $barang->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script>
        var formVisible = false;
        var form = document.getElementById("myFilter");
        var showFilterButton = document.getElementById("showFilterButton");

        showFilterButton.addEventListener("click", function() {
            if (formVisible) {
                form.style.display = "none";
                formVisible = false;
            } else {
                form.style.display = "block";
                formVisible = true;
            }
        });

        var dropdownVisible = false;
        var dropdownMenu = document.querySelector('.dropdown-menu');
        var showDropdownButton = document.querySelector('.dropdown-button');
        showDropdownButton.addEventListener("click", function() {
            if (dropdownVisible) {
                dropdownMenu.style.display = "none";
                dropdownVisible = false;
            } else {
                dropdownMenu.style.display = "block";
                dropdownVisible = true;
            }
        });

        function toggleModal(modalID){
            document.getElementById(modalID).classList.toggle("hidden");
            document.getElementById(modalID + "-backdrop").classList.toggle("hidden");
            document.getElementById(modalID).classList.toggle("flex");
            document.getElementById(modalID + "-backdrop").classList.toggle("flex");
        }
    </script>
</x-app-layout>