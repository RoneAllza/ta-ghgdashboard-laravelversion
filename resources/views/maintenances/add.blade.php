@php
$user = Auth::user();
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Data Maintenance') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Buat Laporan') }}
                </h2>
                <div class="max-w-xl">
                    <form method="post" action="{{ route('teknisi_maintenances.store') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                        @csrf

                        <div>
                            <x-input-label for="nama_alat" :value="__('Nama Alat')" />
                            <x-text-input id="nama_alat" name="nama_alat" type="text"
                                class="mt-1 block w-full" required autofocus autocomplete="nama_alat" placeholder="Nama alat emisi (mis. Sensor ABC)"/>
                            <x-input-error class="mt-2" :messages="$errors->get('nama_alat')" />
                        </div>

                        <div>
                            <x-input-label for="jenis_alat" :value="__('Jenis Alat')" />
                            <x-select-input id="jenis_alat" name="jenis_alat" type="text" class="mt-1 block w-full" required autofocus autocomplete="status">
                                <option selected disabled>Pilih Tipe Sumber...</option>
                                <option value="sensor" >Sensor</option>
                                <option value="aktuator" disabled>Aktuator</option>
                            </x-select-input>
                            <x-input-error class="mt-2" :messages="$errors->get('jenis_alat')" />
                        </div>

                        <div>
                            <x-input-label for="sensor" :value="__('Alat')" />
                            <x-select-input id="sensor_id" name="sensor_id" type="text" class="mt-1 block w-full" required autofocus autocomplete="status">
                                <option selected disabled>Pilih Alat...</option>
                                @foreach ($sensors as $s)
                                    <option value="{{$s->id}}">{{$s->sensor_id}}</option>
                                @endforeach
                            </x-select-input>
                            <x-input-error class="mt-2" :messages="$errors->get('sensor_id')" />
                        </div>
                        <div>
                            <x-input-label for="jenis_maintenance" :value="__('jenis_maintenance')" />
                            <x-select-input id="jenis_maintenance" name="jenis_maintenance" type="text" class="mt-1 block w-full" required autofocus autocomplete="status">
                                <option selected disabled>Pilih Jenis maintenances...</option>
                                <option value="perbaikan" >Perbaikan</option>
                                <option value="penggantian" >Penggantian</option>
                            </x-select-input>
                            <x-input-error class="mt-2" :messages="$errors->get('jenis_maintenance')" />
                        </div>

                        <div>
                            <x-input-label for="waktu_mulai" :value="__('Waktu Mulai')" />
                            <x-text-input id="waktu_mulai" name="waktu_mulai" type="text"
                                class="mt-1 block w-full" required autofocus autocomplete="waktu_mulai" placeholder="Durasi hari aktif"/>
                            <x-input-error class="mt-2" :messages="$errors->get('waktu_mulai')" />
                        </div>
                        <div>
                            <x-input-label for="waktu_selesai" :value="__('Waktu Selesai')" />
                            <x-text-input id="waktu_selesai" name="waktu_selesai" type="text"
                                class="mt-1 block w-full" required autofocus autocomplete="waktu_selesai" placeholder="Durasi hari aktif"/>
                            <x-input-error class="mt-2" :messages="$errors->get('waktu_selesai')" />
                        </div>

                        <div>
                            <x-input-label for="keterangan" :value="__('Keterangan')" />
                            <x-text-input id="keterangan" name="keterangan" type="text"
                                class="mt-1 block w-full" autofocus autocomplete="keterangan" placeholder="Output bahan bakar per-jam"/>
                            <x-input-error class="mt-2" :messages="$errors->get('keterangan')" />
                        </div>
                        <div>
                            <x-input-label for="keterangan" :value="__('Keterangan')" />
                            <x-text-input id="keterangan" name="keterangan" type="text"
                                class="mt-1 block w-full" autofocus autocomplete="keterangan" placeholder="Output bahan bakar per-jam"/>
                            <x-input-error class="mt-2" :messages="$errors->get('keterangan')" />
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