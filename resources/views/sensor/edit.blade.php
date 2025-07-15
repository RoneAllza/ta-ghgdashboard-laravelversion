<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Sensor') }}
        </h2>
    </x-slot>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Koordinat dari data existing
            var lat = {{ $sensor->latitude ?? -6.9175 }};
            var lng = {{ $sensor->longitude ?? 107.6191 }};
            // Inisialisasi map
            var map = L.map('map').setView([lat, lng], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap'
            }).addTo(map);

            var marker = L.marker([lat, lng]).addTo(map);

            // Saat map diklik, update marker dan input
            map.on('click', function(e) {
                var newLat = e.latlng.lat.toFixed(6);
                var newLng = e.latlng.lng.toFixed(6);
                marker.setLatLng(e.latlng);
                document.getElementById('latitude').value = newLat;
                document.getElementById('longitude').value = newLng;
            });
        });
    </script>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="font-bold">Edit Sensor</h1>
                    <form action="{{ route('sensors.update', $sensor->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')
                        <div>
                            <x-input-label for="sensor_name" :value="__('Sensor Name')" />
                            <x-text-input id="sensor_name" name="sensor_name" type="text" class="mt-1 block w-full"
                                autofocus autocomplete="sensor_name" placeholder="mis. Sensor A"
                                value="{{ $sensor->sensor_name }}" />
                            <x-input-error class="mt-2" :messages="$errors->get('sensor_name')" />
                        </div>
                        <div>
                            <x-input-label for="field" :value="__('Field')" />
                            <x-select-input id="field" name="field" type="text" class="mt-1 block w-full"
                                autofocus autocomplete="status">
                                @foreach($sensorOptions as $value => $label)
                                <option value="{{ $value }}" {{ $sensor->field == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                                @endforeach
                            </x-select-input>
                            <x-input-error class="mt-2" :messages="$errors->get('field')" />
                        </div>
                        <div id="map" style="height: 300px;" class="mb-4"></div>
                        <div>
                            <x-input-label for="latitude" :value="__('Latitude')" />
                            <x-text-input id="latitude" name="latitude" type="text" class="mt-1 block w-full"
                                autofocus autocomplete="latitude" placeholder="mis. Sensor A"
                                value="{{ $sensor->latitude }}" />
                            <x-input-error class="mt-2" :messages="$errors->get('latitude')" />
                        </div>
                        <div>
                            <x-input-label for="longitude" :value="__('Longitude')" />
                            <x-text-input id="longitude" name="longitude" type="text" class="mt-1 block w-full"
                                autofocus autocomplete="longitude" placeholder="mis. Sensor A"
                                value="{{ $sensor->longitude }}" />
                            <x-input-error class="mt-2" :messages="$errors->get('longitude')" />
                        </div>
                        <x-primary-button class="mt-4">+ Update</x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>