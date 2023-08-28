<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kembalikan Barang') }}
        </h2>
    </x-slot>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border border-gray-200">
                    <form method="POST" action="{{ route('barangkembali.store') }}" enctype="multipart/form-data">
                        @csrf
                        <!-- Nama Barang -->
                        <div>
                            <x-input-label for="nama_barang_id" :value="__('Nama Barang')" />
                            <select id="nama_barang_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                                type="text" name="nama_barang_id" required autofocus>
                                <option value="" disabled selected>Pilih Nama Barang</option>
                                @foreach($barang as $barang)
                                    <option value="{{ $barang->id }}">{{ $barang->nama_barang }}</option>
                                @endforeach
                            </select>
                            @if ($errors->get('nama_barang_id'))
                                <x-input-error :messages="$errors->get('nama_barang_id')" class="mt-2" />
                            @endif
                        </div>
                        <!-- Status -->
                        <div class="mt-4">
                            <x-input-label for="status" :value="__('Status')" />
                            <select id="status" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                                type="text" name="status" required autofocus>
                                <option value="" disabled selected>Pilih Status</option>
                                <option value="Baik">Baik</option>
                                <option value="Rusak">Rusak</option>
                            </select>
                            @if ($errors->get('status'))
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            @endif
                        </div>
                        <!-- kode atau (jumlah dan nama barang) -->
                        <div class="mt-4">
                            <!-- pilih -->
                            <div>
                                <label for="option">Pilih salah satu:</label>
                                <select name="option" id="option" onchange="toggleInput(this)" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                                    <option value="" disabled selected>Pilih salah satu</option>
                                    <option value="jumlah">Jumlah</option>
                                    <option value="kode">Kode</option>
                                </select>
                            </div>
                            <!-- jumlah -->
                            <div class="mt-4" id="jumlahInput" style="display: none;">
                                <label for="jumlahkembali">Jumlah Kembali:</label>
                                <input type="number" name="jumlahkembali" id="jumlahkembali" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                            </div>
                            <!-- kode -->
                            <div class="mt-4" id="kodeInput" style="display: none;">
                                <x-input-label for="kodebarang" :value="__('Kode Barang')" />
                                <textarea id="kodebarang" name="kodebarang" rows="4" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full"></textarea>  
                                <span>Bagi kode barang dengan koma (,)</span> 
                                <span class="text-red-500">Pastikan sama dengan nama barang</span>
                            </div>
                        </div>
                        <!-- Keterangan -->
                        <div class="mt-4">
                            <x-input-label for="keterangan" :value="__('Keterangan')" />
                            <textarea id="keterangan" name="keterangan" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                                rows="4">{{ old('keterangan') }}</textarea>
                            @if ($errors->get('keterangan'))
                                <x-input-error :messages="$errors->get('keterangan')" class="mt-2" />
                            @endif
                        </div>
                        <!-- submit -->
                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-4">
                                {{ __('Kembalikan Barang') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function toggleInput(selectElement) {
            var selectedOption = selectElement.value;
            var kodeInput = document.getElementById('kodeInput');
            var jumlahInput = document.getElementById('jumlahInput');
            var nama_barang_id = document.getElementById('nama_barang_id');

            if (selectedOption === 'jumlah') {
                kodeInput.style.display = 'none';
                jumlahInput.style.display = 'block';
                document.getElementById('code').required = false;
                document.getElementById('jumlahkembali').required = true;
            } else if (selectedOption === 'kode') {
                kodeInput.style.display = 'block';
                jumlahInput.style.display = 'none';
                document.getElementById('code').required = true;
                document.getElementById('jumlahkembali').required = false;
            }
        }
    </script>
</x-app-layout>


