@php
$user = Auth::user();
@endphp
@section('title', config('app.name', 'EMisi') . ' - Tambah Sumber Emisi')
<x-app-layout>
    <x-slot name="header">
        <span class="font-light text-slate-400 text-sm">Home / Sumber Emisi / Tambah</span>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Sumber Emisi') }}
        </h2>
        <span class="text-sm text-slate-500">Tambah data sarana perusahaan yang mengeluarkan emisi</span>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Tambah Sumber Emisi') }}
                </h2>
                <div class="max-w-xl">
                    @php
                        $routeStore = ($user && $user->role == 'teknisi') ? route('teknisi_emisis.store') : route('emisis.store');
                    @endphp
                    <form method="post" action="{{ $routeStore }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <x-input-label for="sumber" :value="__('Sumber')" />
                            <x-text-input id="sumber" name="sumber" type="text"
                                class="mt-1 block w-full" required autofocus autocomplete="sumber" placeholder="Sumber emisi (mis. Hino Dutro - B1234ABC)"/>
                            <x-input-error class="mt-2" :messages="$errors->get('sumber')" />
                        </div>
                        <div>
                            <x-input-label for="kategori_sumber_id" :value="__('Kategori Sumber')" />
                            <x-select-input id="kategori_sumber_id" name="kategori_sumber_id" class="mt-1 block w-full" required autofocus>
                                <option selected disabled>Pilih Kategori Sumber...</option>
                                @foreach ($kategoriSumbers as $ks)
                                    <option value="{{$ks->id}}">{{$ks->nama}}</option>
                                @endforeach
                            </x-select-input>
                            <x-input-error class="mt-2" :messages="$errors->get('kategori_sumber_id')" />
                        </div>
                        <div>
                            <x-input-label for="tipe_sumber" :value="__('Tipe Sumber')" />
                            <x-select-input id="tipe_sumber" name="tipe_sumber" class="mt-1 block w-full" required autofocus>
                                <option selected disabled>Pilih Tipe Sumber...</option>
                                @foreach ($kategoriSumbers as $ks)
                                    <option value="{{$ks->nama}}">{{$ks->nama}}</option>
                                @endforeach
                            </x-select-input>
                            <x-input-error class="mt-2" :messages="$errors->get('tipe_sumber')" />
                        </div>
                        <div>
                            <x-input-label for="fuel_properties_id" :value="__('Bahan Bakar')" />
                            <x-select-input id="fuel_properties_id" name="fuel_properties_id" class="mt-1 block w-full" required autofocus>
                                <option selected disabled>Pilih Bahan Bakar...</option>
                                @foreach ($fuelProperties as $fp)
                                    <option value="{{$fp->id}}">{{$fp->fuel_type}}</option>
                                @endforeach
                            </x-select-input>
                            <x-input-error class="mt-2" :messages="$errors->get('fuel_properties_id')" />
                        </div>
                        <div>
                            <x-input-label for="unit" :value="__('Unit')" />
                            <x-select-input id="unit" name="unit" class="mt-1 block w-full" required autofocus>
                                <option selected disabled>Pilih Unit Satuan...</option>
                                <option value="ton" >Ton</option>
                                <option value="liter" >Liter</option>
                            </x-select-input>
                            <x-input-error class="mt-2" :messages="$errors->get('unit')" />
                        </div>
                        <div>
                            <x-input-label for="durasi_pemakaian" :value="__('Durasi Pemakaian')" />
                            <x-text-input id="durasi_pemakaian" name="durasi_pemakaian" type="text"
                                class="mt-1 block w-full" required autofocus autocomplete="durasi_pemakaian" placeholder="Durasi hari aktif"/>
                            <x-input-error class="mt-2" :messages="$errors->get('durasi_pemakaian')" />
                        </div>
                        <div>
                            <x-input-label for="kapasitas_output" :value="__('Kapasitas Output')" />
                            <x-text-input id="kapasitas_output" name="kapasitas_output" type="text"
                                class="mt-1 block w-full" autofocus autocomplete="kapasitas_output" placeholder="Output bahan bakar per-jam"/>
                            <x-input-error class="mt-2" :messages="$errors->get('kapasitas_output')" />
                        </div>
                        <div>
                            <x-input-label for="frekuensi_hari" :value="__('Frekuensi Hari')" />
                            <div>
                                @for ($i = 1; $i <= 7; $i++)
                                    <label class="inline-flex items-center mr-4">
                                        <input type="radio" class="form-radio" name="frekuensi_hari" value="{{ $i }}">
                                        <span class="ml-2">{{ $i }}</span>
                                    </label>
                                @endfor
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('frekuensi_hari')" />
                        </div>
                        <div>
                            <x-input-label for="dokumentasi" :value="__('Dokumentasi')" />
                            <x-text-input id="dokumentasi" name="dokumentasi" type="file" class="mt-1 block w-full" autofocus autocomplete="dokumentasi" />
                            <x-input-error class="mt-2" :messages="$errors->get('dokumentasi')" />
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