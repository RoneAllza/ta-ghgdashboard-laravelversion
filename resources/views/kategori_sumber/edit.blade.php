<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Kategori') }} {{ $kategoriSumber->nama }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-2">
                <div class="p-6 bg-white border-b border-gray-200">

                    <h1 class=" font-bold ">Edit {{ $kategoriSumber->nama }}</h1>
                    <form action="{{ route('kategori_sumber.update', $kategoriSumber->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')
                        <div>
                            <x-input-label for="nama" :value="__('Nama')" />
                            <x-text-input id="nama" name="nama" type="text" class="mt-1 block w-full"
                                autofocus autocomplete="nama"
                                value="{{ $kategoriSumber->nama }}" />
                            <x-input-error class="mt-2" :messages="$errors->get('nama')" />
                        </div>
                        <div>
                            <x-input-label for="kode" :value="__('Kode')" />
                            <x-text-input id="kode" name="kode" type="text" class="mt-1 block w-full" autofocus
                                autocomplete="kode" placeholder="Pilih satuan" value="{{ $kategoriSumber->kode }}" />
                            <x-input-error class="mt-2" :messages="$errors->get('kode')" />
                        </div>

                        <div>
                            <x-input-label for="deskripsi" :value="__('Deskripsi')" />
                            <x-text-input id="deskripsi" name="deskripsi" type="text" class="mt-1 block w-full"
                                autocomplete="deskripsi" placeholder="Tulis deskripsi" />
                            <x-input-error class="mt-2" :messages="$errors->get('deskripsi')" />
                        </div>

                        <x-primary-button class="mt-4">+ Update</x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>