@section('title', config('app.name', 'EMisi') . ' - Tambah Sensor')

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pendataan Sensor') }}
        </h2>
    </x-slot>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inisialisasi map
            var map = L.map('map').setView([-6.9175, 107.6191], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap'
            }).addTo(map);

            var marker;
            map.on('click', function(e) {
                var lat = e.latlng.lat.toFixed(6);
                var lng = e.latlng.lng.toFixed(6);

                if (marker) {
                    marker.setLatLng(e.latlng);
                } else {
                    marker = L.marker(e.latlng).addTo(map);
                }

                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lng;
            });

            // Set default parameter dan unit saat load
            const fieldMapping = {
                field1: { parameter: "Kecepatan Angin", unit: "m/s" },
                field2: { parameter: "Arah Angin", unit: "°" },
                field3: { parameter: "Suhu", unit: "°C" },
                field4: { parameter: "Kelembaban", unit: "%" },
                field5: { parameter: "PM2.5", unit: "µg/m3" },
                field6: { parameter: "PM10", unit: "µg/m3" },
                field7: { parameter: "CO2", unit: "ppm" },
                field8: { parameter: "CH4", unit: "%LEL" },
            };

            const fieldSelect = document.getElementById('field');
            const paramInput = document.getElementById('parameter_name');
            const unitInput = document.getElementById('unit');

            function updateParamUnit(value) {
                const mapping = fieldMapping[value];
                if (mapping) {
                    paramInput.value = mapping.parameter;
                    unitInput.value = mapping.unit;
                }
            }

            // Inisialisasi saat load
            if (fieldSelect.value) {
                updateParamUnit(fieldSelect.value);
            }

            // Saat field berubah
            fieldSelect.addEventListener('change', function () {
                updateParamUnit(this.value);
            });

            // Validasi sebelum submit
            document.querySelector('form').addEventListener('submit', function(e) {
                if (!paramInput.value || !unitInput.value) {
                    alert('Silakan pilih Field agar Parameter dan Unit terisi otomatis!');
                    e.preventDefault();
                }
            });
        });
    </script>

    <div class="py-12">
        <div class="max-w-7xl mx-auto py-2 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="font-bold">Tambah Sensor</h1>

                    @if ($errors->any())
                        <div class="mb-4 text-red-600">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('sensors.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="sensor_name" :value="__('Sensor Name')" />
                            <x-text-input id="sensor_name" name="sensor_name" type="text" class="mt-1 block w-full"
                                required autofocus autocomplete="sensor_name" placeholder="mis. Sensor A"
                                value="{{ old('sensor_name') }}" />
                            <x-input-error class="mt-2" :messages="$errors->get('sensor_name')" />
                        </div>

                        <div>
                            <x-input-label for="field" :value="__('Field')" />
                            <x-select-input id="field" name="field" class="mt-1 block w-full" required>
                                <option disabled {{ old('field') ? '' : 'selected' }}>Pilih Field sesuai fitur deteksi sensors...</option>
                                <option value="field1" {{ old('field') == 'field1' ? 'selected' : '' }}>Field 1 - Kecepatan Angin (m/s)</option>
                                <option value="field2" {{ old('field') == 'field2' ? 'selected' : '' }}>Field 2 - Arah Angin (°)</option>
                                <option value="field3" {{ old('field') == 'field3' ? 'selected' : '' }}>Field 3 - Suhu (°C)</option>
                                <option value="field4" {{ old('field') == 'field4' ? 'selected' : '' }}>Field 4 - Kelembaban (%)</option>
                                <option value="field5" {{ old('field') == 'field5' ? 'selected' : '' }}>Field 5 - PM2.5 (µg/m3)</option>
                                <option value="field6" {{ old('field') == 'field6' ? 'selected' : '' }}>Field 6 - PM10 (µg/m3)</option>
                                <option value="field7" {{ old('field') == 'field7' ? 'selected' : '' }}>Field 7 - CO2 (ppm)</option>
                                <option value="field8" {{ old('field') == 'field8' ? 'selected' : '' }}>Field 8 - CH4 (%LEL)</option>
                            </x-select-input>
                            <x-input-error class="mt-2" :messages="$errors->get('field')" />
                        </div>

                        <input type="hidden" id="parameter_name" name="parameter_name" value="{{ old('parameter_name') }}">
                        <input type="hidden" id="unit" name="unit" value="{{ old('unit') }}">

                        <div id="map" style="height: 300px;" class="mb-4"></div>

                        <div>
                            <x-input-label for="latitude" :value="__('Latitude')" />
                            <x-text-input id="latitude" name="latitude" type="text" class="mt-1 block w-full"
                                required value="{{ old('latitude') }}" />
                            <x-input-error class="mt-2" :messages="$errors->get('latitude')" />
                        </div>

                        <div>
                            <x-input-label for="longitude" :value="__('Longitude')" />
                            <x-text-input id="longitude" name="longitude" type="text" class="mt-1 block w-full"
                                required value="{{ old('longitude') }}" />
                            <x-input-error class="mt-2" :messages="$errors->get('longitude')" />
                        </div>

                        <x-primary-button>Tambah Sensor</x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
