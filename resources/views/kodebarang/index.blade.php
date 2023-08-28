<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">  
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div class="flex justify-between mb-4 mr-4 ml-4">
                        <h2 class="font-semibold text-xl text-gray-800">
                            {{ __('Kode Barang') }}
                        </h2>
                        <div>
                            <a id="showFilterButton"
                                class="fa-solid fa-filter inline-flex items-center px-4 py-2 bg-white border border-blue-500 font-semibold rounded-md text-xs 
                                    hover:bg-blue-500 activate:bg-blue-700 text-blue-500 uppercase tracking-widest hover:text-white ">&nbsp; Filter
                            </a>
                            <a href="{{ route('kodebarang.print', Request::query()) }}" 
                                target="_blank"
                                class="fa-solid fa-print inline-flex items-center px-4 py-2 bg-blue-400 border 
                                    border-transparent rounded-md font-semibold text-xs text-white uppercase 
                                    tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none 
                                    focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25">&nbsp;Cetak
                            </a>
                        </div>
                    </div>

                    <!-- filter -->
                    <form id="myFilter" style="display: none;" action="{{ route('kodebarang.index') }}" method="GET" class="items-center mb-8">
                        <div class="grid grid-cols-4 gap-4 m-4">
                            <div>
                                <label for="nama_barang_id" class="mr-2">Nama Barang:</label>
                                <select name="nama_barang_id" id="nama_barang_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full">
                                    <option value="">Pilih Barang</option>
                                    @foreach($barang as $barang)
                                    <option value="{{ $barang->id }}">{{ $barang->nama_barang }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="status" class="mr-2">Status:</label>
                                <select id="status" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full" 
                                    type="text" name="status">
                                    <option value="" disabled selected>Pilih Status</option>
                                    <option value="Tersedia">Tersedia</option>
                                    <option value="Keluar">Keluar</option>
                                    <option value="Tidak Bisa Digunakan">Tidak Bisa Digunakan</option>
                                </select>
                                @if ($errors->get('status'))
                                    <x-input-error :messages="$errors->get('status')" class="mt-2" />
                                @endif
                            </div>
                            <div>
                                <label for="code" class="mr-2">Kode:</label>
                                <input type="number" name="code" id="code" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full" value="">
                            </div>

                            <div class="flex justify-end mr-2">
                                <button href="route('barang')" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold px-6 mt-6 mr-2 rounded-md">
                                    <i class="fa-solid fa-filter-circle-xmark">&nbsp;</i>
                                    Reset
                                </button>
                                <button type="submit" class="bg-white border border-blue-500 hover:bg-blue-500 text-blue-500 hover:text-white font-bold px-6 mt-6 rounded">
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
                    
                    <!-- halaman pagination -->
                    <div class="m-4">
                        {{ $kodebarang->links() }}
                    </div>
                    
                    <!-- table -->
                    <x-table id="tabel_barang">
                        <x-slot name="header">
                            <x-table-column>No</x-table-column>
                            <x-table-column>Nama Barang</x-table-column>   
                            <x-table-column>Status</x-table-column>
                            <x-table-column>Keterangan</x-table-column>
                            <x-table-column>Kode</x-table-column>
                        </x-slot>
                        @foreach ($kodebarang as $idbarang)
                            <tr>
                                <x-table-column>{{ $loop->iteration }}</x-table-column>
                                <x-table-column>{{ $idbarang->barang->nama_barang }}</x-table-column>
                                <x-table-column>{{ $idbarang->status }}</x-table-column>
                                <x-table-column>{{ $idbarang->keterangan }}</x-table-column>
                                <x-table-column>{{ $idbarang->code }}</x-table-column>
                            </tr>
                        @endforeach
                    </x-table>
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
    </script>
</x-app-layout>