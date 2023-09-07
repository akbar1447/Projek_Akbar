<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">  
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <!-- Button -->
                    <div class="flex justify-between mb-4 mr-4 ml-4">
                        <h2 class="font-semibold text-xl text-gray-800">
                            {{ __('History Pengembalian Barang') }}
                        </h2>
                        <div>
                            <a id="showFilterButton"
                                class="fa-solid fa-filter inline-flex items-center px-4 py-2 bg-white border border-blue-500 font-semibold rounded-md text-xs 
                                    hover:bg-blue-500 activate:bg-blue-700 text-blue-500 uppercase tracking-widest hover:text-white ">&nbsp; Filter
                            </a>
                            @if(\Auth::user()->role !== 'atasan')
                                <a href="{{ route('barangkembali.print', Request::query()) }}" 
                                    target="_blank"
                                    class="fa-solid fa-print inline-flex items-center px-4 py-2 bg-blue-400 border 
                                        border-transparent rounded-md font-semibold text-xs text-white uppercase 
                                        tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none 
                                        focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25">&nbsp;Cetak
                                </a>
                                <x-nav-button :href="route('barangkembali.kembali')"
                                    class="inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase 
                                        tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none 
                                        focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition 
                                        ease-in-out duration-150" 
                                    label="Kembalikankan Barang" icon="fa-solid fa-circle-plus" id="barangkembali"/>
                            @endif
                        </div>
                    </div>

                    <!-- filter -->
                    <form id="myFilter" style="display: none;" action="{{ route('barangkembali.index') }}" method="GET" class="items-center mb-8">  
                        <div class="grid grid-cols-3 gap-4 m-4">
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
                                    <option value="Baik">Baik</option>
                                    <option value="Rusak">Rusak</option>
                                </select>
                                @if ($errors->get('status'))
                                    <x-input-error :messages="$errors->get('status')" class="mt-2" />
                                @endif
                            </div>

                            <div class="flex justify-end mr-2">
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
                            <x-table-column>Tanggal</x-table-column>
                            <x-table-column>Barang</x-table-column>
                            <x-table-column>Jumlah</x-table-column>
                            <x-table-column>Status</x-table-column> 
                            <x-table-column>Keterangan</x-table-column>
                            <x-table-column>Kode Kembali</x-table-column>
                            @if(\Auth::user()->role !== 'atasan')
                            <x-table-column>Aksi</x-table-column>
                            @endif
                        </x-slot>
                        @foreach ($barangkembali as $item)
                            <tr>
                                <x-table-column>{{ $loop->iteration }}</x-table-column>
                                <x-table-column>{{ $item->created_at->format('Y-m-d') }}</x-table-column>
                                <x-table-column>{{ $item->barang->nama_barang }}</x-table-column>
                                <x-table-column>{{ $item->jumlahkembali}}</x-table-column>
                                <x-table-column>{{ $item->status }}</x-table-column> 
                                <x-table-column>{{ $item->keterangan }}</x-table-column>
                                <x-table-column>
                                    <div class="flex justify-between">
                                        <a
                                            class="fa-solid fa-eye max-h-12 items-center p-4 mr-2 bg-orange-400 border 
                                                border-transparent rounded-md hover:bg-gray-700 active:bg-gray-900 
                                                focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 
                                                disabled:opacity-25 transition ease-in-out duration-150 text-white"
                                            onclick="toggleVisibility('kodeBarangKembali-{{ $item->id }}')">
                                        </a>
                                        <div id="kodeBarangKembali-{{ $item->id }}" class="overflow-y-auto max-h-5 mt-3">
                                            {!! str_replace(',', '<br>', $item->kode_barang_kembali) !!}
                                        </div>
                                    </div>
                                </x-table-column>
                                @if(\Auth::user()->role !== 'atasan')
                                <x-table-column>
                                    <div class="flex justify-start">
                                        <a href="{{ route('barangkembali.printid', $item->id) }}" 
                                            target="_blank"
                                            class="fas fa-print inline-flex items-center p-4 mr-2 bg-blue-400 border 
                                                    border-transparent rounded-md hover:bg-gray-700 active:bg-gray-900 
                                                    focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 
                                                    disabled:opacity-25 transition ease-in-out duration-150 text-white">
                                        </a>
                                        <button type="button" 
                                            class="fas fa-trash inline-flex items-center p-4 bg-red-400 border 
                                                border-transparent rounded-md hover:bg-gray-700 active:bg-gray-900 
                                                focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 
                                                disabled:opacity-25 transition ease-in-out duration-150 text-white"
                                            onclick="toggleModal('hapus_barangkembali{{$item->id}}')">
                                        </button>
                                    </div>

                                    <x-modals id="hapus_barangkembali{{$item->id}}" title="Konfirmasi Hapus Histori Barang Kembali" form="true">
                                        <form action="{{route('barangkembali.destroy',$item->id)}}" method="POST" class="inline-flex">
                                        @csrf
                                        @method('DELETE')
                                        Apakah anda yakin akan menghapus {{$item->nama_barang}}?
                                    </x-modals>
                                    <form action="{{route('barangkembali.destroy',$item->id)}}" method="POST" class="inline-flex">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </x-table-column>
                                @endif
                            </tr>
                        @endforeach
                    </x-table>

                    <!-- halaman pagination -->
                    <div class="mt-4">
                        {{ $barangkembali->links() }}
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

        function toggleVisibility(elementId) {
            var element = document.getElementById(elementId);
            if (element.style.maxHeight === '' || element.style.maxHeight === '28px') {
                element.style.maxHeight = 'none';
                element.style.overflow = 'visible';
            } else {
                element.style.maxHeight = '28px';
                element.style.overflow = 'auto';
            }
        }

        function toggleModal(modalID){
            document.getElementById(modalID).classList.toggle("hidden");
            document.getElementById(modalID + "-backdrop").classList.toggle("hidden");
            document.getElementById(modalID).classList.toggle("flex");
            document.getElementById(modalID + "-backdrop").classList.toggle("flex");
        }
    </script>
</x-app-layout>
