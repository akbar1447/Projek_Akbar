<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Barang') }}
        </h2>
    </x-slot>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('barangmasuk.store') }}">
                        @csrf

                        <!-- Nama Barang -->
                        <div class="mt-4">
                            <x-input-label for="nama_barang_id" :value="__('Nama Barang')" />

                            <select id="nama_barang_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                                type="text" name="nama_barang_id" required autofocus>
                                <option value="" disabled selected>Pilih Barang</option>
                                @foreach($barang as $barang)
                                    <option value="{{ $barang->id }}">{{ $barang->nama_barang }}</option>
                                @endforeach
                            </select>
                            @if ($errors->get('nama_barang_id'))
                                <x-input-error :messages="$errors->get('nama_barang_id')" class="mt-2" />
                            @endif
                        </div>

                        <!-- Jumlah Masuk -->
                        <div class="mt-4">
                            <x-input-label for="jumlahmasuk" :value="__('Jumlah Masuk')" />
                            <x-text-input id="jumlahmasuk" class="block mt-1 w-full" type="number" name="jumlahmasuk" min="0" :value="old('jumlahmasuk')" required autofocus/>
                            @if ($errors->get('jumlahmasuk'))
                                <x-input-error :messages="$errors->get('jumlahmasuk')" class="mt-2" />
                            @endif
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-4">
                                {{ __('Tambah Barang') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>