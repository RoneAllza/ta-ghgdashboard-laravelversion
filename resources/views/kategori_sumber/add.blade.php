@section('title', config('app.name', 'EMisi') . ' - Tambah Sumber Emisi')
<x-app-layout>
    <x-slot name="header">
        <span class="font-light text-slate-400 text-sm">Home / Kategori Sumber / Tambah</span>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Kategori Sumber') }}
        </h2>
        <span class="text-sm text-slate-500">Tambah data kategori sumber</span>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Tambah Kategori Sumber') }}
                </h2>
                <div class="max-w-xl">
                    <form method="post" action="{{ route('kategori_sumber.store') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                        @csrf

                        <div>
                            <x-input-label for="nama" :value="__('Nama Kategori')" />
                            <x-text-input id="nama" name="nama" type="text"
                                class="mt-1 block w-full" required autofocus autocomplete="nama" placeholder="Tulis nama kategori"/>
                            <x-input-error class="mt-2" :messages="$errors->get('nama')" />
                        </div>
                        <div>
                            <x-input-label for="kode" :value="__('Jenis Emisi')" />
                            <x-select-input id="kode" name="kode" type="text" class="mt-1 block w-full" required autofocus autocomplete="status">
                                <option selected disabled>Pilih Kategori Jenis</option>
                                <option value="1A1">Stationary Combustion</option>
                                <option value="1A2">Mobile Combustion</option>
                                <option value="1B1">Fugitive Emissions from Solid Fuels</option>
                            </x-select-input>
                            <x-input-error class="mt-2" :messages="$errors->get('kode')" />
                        </div>

                        <div>
                            <x-input-label for="deskripsi" :value="__('Deskripsi')" />
                            <x-text-input id="deskripsi" name="deskripsi" type="text"
                                class="mt-1 block w-full" autofocus autocomplete="deskripsi" placeholder="Berikan deskripsi (opsional)"/>
                            <x-input-error class="mt-2" :messages="$errors->get('deskripsi')" />
                        </div>
                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Save') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>