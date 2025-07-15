@section('title', config('app.name', 'EMisi') . ' - Edit Sumber Emisi ' . $sumberEmisi->sumber)
<x-app-layout> 
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Sumber Emisi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 gap-4">
                    <h1 class=" font-bold ">Edit Sumber Emisi</h1>
                    @php
                        $user = Auth::user();
                        $routeUpdate = ($user && $user->role == 'teknisi') ? route('teknisi_emisis.update', $sumberEmisi->id) : route('emisis.update', $sumberEmisi->id);
                    @endphp
                    <form action="{{ $routeUpdate }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')
                        <div>
                            <x-input-label for="sumber" :value="__('Nama Sumber')" />
                            <x-text-input id="sumber" name="sumber" type="text" class="mt-1 block w-full"
                                 autofocus autocomplete="sumber" placeholder="mis. Sensor A" value="{{ $sumberEmisi->sumber }}"/>
                            <x-input-error class="mt-2" :messages="$errors->get('sumber')" />
                        </div>
                        <div>
                            <x-input-label for="kategori_sumber_id" :value="__('Kategori Sumber')" />
                            <x-select-input id="kategori_sumber_id" name="kategori_sumber_id" class="mt-1 block w-full" required autofocus>
                                <option selected disabled>Pilih Kategori Sumber...</option>
                                @foreach ($kategoriSumbers as $ks)
                                    <option value="{{$ks->id}}" {{ $sumberEmisi->kategori_sumber_id == $ks->id ? 'selected' : '' }}>{{$ks->nama}}</option>
                                @endforeach
                            </x-select-input>
                            <x-input-error class="mt-2" :messages="$errors->get('kategori_sumber_id')" />
                        </div>
                        <div>
                            <x-input-label for="kapasitas_output" :value="__('Kapasitas Output')"/>
                            <x-text-input id="kapasitas_output" name="kapasitas_output" type="text" class="mt-1 block w-full"
                                 autofocus autocomplete="kapasitas_output" placeholder="mis. Sensor A" value="{{ $sumberEmisi->kapasitas_output }}"/>
                            <x-input-error class="mt-2" :messages="$errors->get('kapasitas_output')" />
                        </div>
                        <div>
                            <x-input-label for="frekuensi_hari" :value="__('Frekuensi Hari')" />
                            <div>
                                @for ($i = 1; $i <= 7; $i++)
                                    <label class="inline-flex items-center mr-4">
                                        <input type="radio" class="form-radio" name="frekuensi_hari" value="{{ $i }}" {{ $sumberEmisi->frekuensi_hari == $i ? 'checked' : '' }}>
                                        <span class="ml-2">{{ $i }}</span>
                                    </label>
                                @endfor
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('frekuensi_hari')" />
                        </div>
                        <div>
                            <x-input-label for="durasi_pemakaian" :value="__('Durasi Pemakaian')" />
                            <x-text-input id="durasi_pemakaian" name="durasi_pemakaian" type="text" class="mt-1 block w-full"
                                 autofocus autocomplete="durasi_pemakaian" placeholder="mis. Sensor A" value="{{ $sumberEmisi->durasi_pemakaian }}"/>
                            <x-input-error class="mt-2" :messages="$errors->get('durasi_pemakaian')" />
                        </div>
                        <div>
                            <x-input-label for="dokumentasi" :value="__('Dokumentasi')" />
                            @if ($sumberEmisi->dokumentasi)
                                <img src="{{ asset('uploads/sumber_emisi/' . $sumberEmisi->dokumentasi) }}" alt="Dokumentasi" class="w-50 mb-2">
                            @endif
                            <x-text-input id="dokumentasi" name="dokumentasi" type="file" class="mt-1 block w-full"
                                 autofocus autocomplete="dokumentasi" placeholder="mis. Sensor A" />
                            <x-input-error class="mt-2" :messages="$errors->get('dokumentasi')" />
                        </div>
                        <div>
                            <x-input-label for="fuel_properties_id" :value="__('Bahan Bakar')" />
                            <x-select-input id="fuel_properties_id" name="fuel_properties_id" class="mt-1 block w-full" required autofocus>
                                <option selected disabled>Pilih Bahan Bakar...</option>
                                @foreach ($fuelProperties as $fp)
                                    <option value="{{$fp->id}}" {{ $sumberEmisi->fuel_properties_id == $fp->id ? 'selected' : '' }}>{{$fp->fuel_type}}</option>
                                @endforeach
                            </x-select-input>
                            <x-input-error class="mt-2" :messages="$errors->get('fuel_properties_id')" />
                        </div>
                        <div>
                            <x-input-label for="unit" :value="__('Unit')" />
                            <x-select-input id="unit" name="unit" class="mt-1 block w-full" required autofocus>
                                <option selected disabled>Pilih Unit Satuan...</option>
                                <option value="ton" {{ $sumberEmisi->unit == 'ton' ? 'selected' : '' }}>Ton</option>
                                <option value="liter" {{ $sumberEmisi->unit == 'liter' ? 'selected' : '' }}>Liter</option>
                            </x-select-input>
                            <x-input-error class="mt-2" :messages="$errors->get('unit')" />
                        </div>
                        <x-primary-button class="mt-4">Update Sumber Emisi</x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>