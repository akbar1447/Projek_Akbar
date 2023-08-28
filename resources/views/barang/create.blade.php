<x-app-layout>
   <x-slot name="header">
       <h2 class="font-semibold text-xl text-gray-800 leading-tight">
           {{ __('Tambah Jenis Barang') }}
       </h2>
   </x-slot>
   <div class="py-8">
        
       <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
           <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
               <div class="p-6 bg-white border-b border-gray-200">
                  
                    <form method="POST" action="{{ route('barang.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Nama barang -->
                        <div>
                            <x-input-label for="nama_barang" :value="__('Nama Barang')" />
                            <x-text-input id="nama_barang" class="block mt-1 w-full" type="text" name="nama_barang" :value="old('nama_barang')" required />
                            @if ($errors->get('nama_barang'))    
                                <x-input-error :messages="$errors->get('nama_barang')" class="mt-2" />
                            @endif
                        </div>

                        <!-- Tipe -->
                        <div class="mt-4">
                            <x-input-label for="type" :value="__('Tipe')" />
                            <x-text-input id="type" class="block mt-1 w-full" type="text" name="type" :value="old('type')" required />
                            @if ($errors->get('type'))    
                                <x-input-error :messages="$errors->get('type')" class="mt-2" />
                            @endif
                        </div>

                        <!-- tahun -->
                        <div class="mt-4">
                            <x-input-label for="tahun" :value="__('Tahun')" />
                            <x-text-input id="tahun" class="block mt-1 w-full" type="number" name="tahun" :value="old('tahun')" required />
                            @if ($errors->get('tahun'))    
                                <x-input-error :messages="$errors->get('tahun')" class="mt-2" />
                            @endif
                        </div>

                        <!-- jumlah -->
                        <div class="mt-4">
                            <x-text-input id="jumlah" class="block mt-1 w-full" type="hidden" name="jumlah" :value="old('jumlah', 0)" readonly />
                            @if ($errors->get('jumlah'))    
                                <x-input-error :messages="$errors->get('jumlah')" class="mt-2" />
                            @endif
                        </div>

                        <!-- code -->
                        <div class="mt-4">
                            <x-text-input id="code" class="block mt-1 w-full" type="hidden" name="code" :value="old('code')" readonly />
                            @if ($errors->get('code'))    
                                <x-input-error :messages="$errors->get('code')" class="mt-2" />
                            @endif
                        </div>

                        <!-- gambar -->
                        <div class="mt-4">
                            <x-input-label for="gambar" :value="__('Gambar')" />
                            <x-text-input id="gambar" class="block mt-1 w-full" type="file" name="gambar" :value="old('gambar')" required />
                            @if ($errors->get('gambar'))    
                                <x-input-error :messages="$errors->get('gambar')" class="mt-2" />
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