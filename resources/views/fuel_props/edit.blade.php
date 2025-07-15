<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Fuel') }} {{ $fuelProp->fuel_type }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-yellow-400 overflow-hidden shadow-sm sm:rounded-lg p-4">
                <h1 class=" font-bold ">PERHATIAN !</h1>
                <span>Mengubah data ini dapat mempengaruhi laporan emisi. Sesuaikan dengan standar KLHK.</span><br>
                <span>Bila belum ada, bisa menyesuaikan dengan IPCC.</span>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-2">
                <div class="p-6 bg-white border-b border-gray-200">

                    <h1 class=" font-bold ">Edit {{ $fuelProp->fuel_type }}</h1>
                    <form action="{{ route('fuel_props.update', $fuelProp->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')
                        <div>
                            <x-input-label for="fuel_type" :value="__('Tipe Bahan Bakar')" />
                            <x-text-input id="fuel_type" name="fuel_type" type="text" class="mt-1 block w-full"
                                autofocus autocomplete="fuel_type" placeholder="mis. Solar, Bensin"
                                value="{{ $fuelProp->fuel_type }}" />
                            <x-input-error class="mt-2" :messages="$errors->get('fuel_type')" />
                        </div>
                        <div>
                            <x-input-label for="unit" :value="__('Satuan')" />
                            <x-text-input id="unit" name="unit" type="text" class="mt-1 block w-full" autofocus
                                autocomplete="unit" placeholder="Pilih satuan" value="{{ $fuelProp->unit }}" />
                            <x-input-error class="mt-2" :messages="$errors->get('unit')" />
                        </div>

                        <div>
                            <x-input-label for="densitas" :value="__('Densitas')" />
                            <x-text-input id="densitas" name="densitas" type="text" class="mt-1 block w-full"
                                autocomplete="densitas" placeholder="Tulis Densitas" />
                            <x-input-error class="mt-2" :messages="$errors->get('densitas')" />
                        </div>
                        <div>
                            <x-input-label for="ncv" :value="__('NCV')" />
                            <x-text-input id="ncv" name="ncv" type="text" class="mt-1 block w-full" autocomplete="ncv"
                                placeholder="Tulis Faktor Konversi" />
                            <x-input-error class="mt-2" :messages="$errors->get('ncv')" />
                        </div>
                        <x-primary-button id="hitung-konversi">Hitung Faktor Konversi</x-primary-button>
                        <div>
                            <x-input-label for="conversion_factor" :value="__('Faktor Konversi')" />
                            <x-text-input id="conversion_factor" name="conversion_factor" type="text" class="mt-1 block w-full"
                                autofocus autocomplete="conversion_factor" placeholder="mis. Solar, Bensin"
                                value="{{ $fuelProp->conversion_factor }}" />
                            <x-input-error class="mt-2" :messages="$errors->get('conversion_factor')" />
                        </div>
                        <div>
                            <x-input-label for="co2_factor" :value="__('Faktor CO2')" />
                            <x-text-input id="co2_factor" name="co2_factor" type="text" class="mt-1 block w-full"
                                autocomplete="co2_factor" placeholder="Tuliskan koma menjadi titik. Mis. 4.8"
                                value="{{ $fuelProp->co2_factor }}" />
                            <x-input-error class="mt-2" :messages="$errors->get('co2_factor')" />
                        </div>
                        <div>
                            <x-input-label for="ch4_factor" :value="__('Faktor CH4')" />
                            <x-text-input id="ch4_factor" name="ch4_factor" type="text" class="mt-1 block w-full"
                                autocomplete="ch4_factor" placeholder="Tuliskan koma menjadi titik. Mis. 4.8"
                                value="{{ $fuelProp->ch4_factor }}" />
                            <x-input-error class="mt-2" :messages="$errors->get('ch4_factor')" />
                        </div>
                        <div>
                            <x-input-label for="n2o_factor" :value="__('Faktor N2O')" />
                            <x-text-input id="n2o_factor" name="n2o_factor" type="text" class="mt-1 block w-full"
                                autocomplete="n2o_factor" placeholder="Tuliskan koma menjadi titik. Mis. 4.8"
                                value="{{ $fuelProp->n2o_factor }}" />
                            <x-input-error class="mt-2" :messages="$errors->get('n2o_factor')" />
                        </div>

                        <x-primary-button class="mt-4">+ Update</x-primary-button>
            </form>
        </div>
    </div>
    </div>
    </div>
</x-app-layout>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var btn = document.getElementById('hitung-konversi');
        if (btn) {
            btn.addEventListener('click', function() {
                var densitasInput = document.getElementById('densitas');
                var ncvInput = document.getElementById('ncv');
                var convInput = document.getElementById('conversion_factor');
                if (densitasInput && ncvInput && convInput) {
                    var densitas = parseFloat(densitasInput.value.replace(',', '.'));
                    var ncv = parseFloat(ncvInput.value.replace(',', '.'));
                    if (!isNaN(densitas) && !isNaN(ncv)) {
                        // Menghitung faktor konversi
                        // Faktor Konversi = Densitas * NCV / 1000000
                        // 10000000 digunakan untuk mengkonversi dari kg ke ton
                        var hasil = densitas * ncv / 1000000;
                        convInput.value = hasil;
                    } else {
                        alert('Masukkan nilai Densitas dan NCV yang valid!');
                    }
                }
            });
        }
    });
</script>