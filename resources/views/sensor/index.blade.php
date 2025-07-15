{{-- @section('title', config('app.name', 'EMisi') . ' - Sensor') --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Sensor') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto py-2 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <span>Lokasi Sensor</span>
                    <div id="map" class="w-full h-[250px]"></div>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            var map = L.map('map').setView([-6.9175, 107.6191], 20);
                            
                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                maxZoom: 19,
                                attribution: '© OpenStreetMap'
                            }).addTo(map);

                            const provider = new GeoSearch.OpenStreetMapProvider();

                            const searchControl = new GeoSearch.GeoSearchControl({
                                provider: provider,
                                style: 'bar',
                                autoComplete: true,
                                autoCompleteDelay: 250,
                                showMarker: false,
                            });

                            // Add the GeoSearch control to the map
                            map.addControl(searchControl);

                            // // Listen for the search event
                            // document.getElementById('search-form').addEventListener('submit', function(e) {
                            //     e.preventDefault();
                            //     const query = document.getElementById('search-input').value;
                            //     provider.search({ query: query }).then(function(result) {
                            //         if (result && result.length > 0) {
                            //             const { x, y } = result[0].bounds[0];
                            //             map.setView([y, x], 10);
                            //         }
                            //     });
                            // });
                            @foreach ($sensors as $sensor)
                            // ntar nambahin jumlah sensornya
                                L.marker([{{ $sensor->latitude }}, {{ $sensor->longitude }}]).addTo(map)
                                .bindPopup(`
                                    Name : {{ $sensor->sensor_name }}<br>
                                    Lat: {{ $sensor->latitude }}<br>
                                    Long: {{ $sensor->longitude }}<br>
                                    <a href="/sensor/{{$sensor->id}}">View Data</a>
                                `);

                                @endforeach
                            });
                    </script>

                </div>
            </div>
            @if(auth()->check() && auth()->user()->role == 'unit_lingkungan')
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-2">
                <div class="overflow-x-auto">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex justify-between">
                            <span>Data Sensor</span>
                            <a href="/sensor/create">
                                <x-primary-button>+ Tambah Sensor</x-button-primary>
                            </a>
                        </div>
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Sensor Name</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Field</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Unit</th>
                                    <!-- <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Latitude</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Longitude</th> -->
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($sensors as $sensor)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $sensor->sensor_name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $sensor->field}}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $sensor->unit}}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="http://maps.google.com/maps?q={{ $sensor->latitude }}%2C{{ $sensor->longitude }}&z=17&hl=en"
                                            ><x-primary-button>View on Map</x-primary-button></a>
                                        
                                        <a href="{{ route('sensors.edit', $sensor->id) }}"
                                            ><x-primary-button>Edit</x-primary-button></a>
                                        
                                        <form action="{{ route('sensors.destroy', $sensor->id) }}" method="POST"
                                            style="display:inline;"
                                            onsubmit="return confirm('Are you sure you want to delete this sensor?');">
                                            @csrf
                                            @method('DELETE')
                                            <x-danger-button>Delete</x-danger-button>
                                        </form>
                                        
                                        <a href="#">
                                            <x-secondary-button onclick="window.dispatchEvent(new CustomEvent('open-modal', { detail: 'add-maintenance-{{ $sensor->id }}' }))">
                                                Maintenance
                                            </x-secondary-button>
                                        </a>
                                        <x-modal id="modalDel{{ $sensor->id }}" name="add-maintenance-{{ $sensor->id }}">
                                            <form method="POST" action="{{ route('teknisi_maintenances.store') }}" class="p-6">
                                                @csrf
                                                <input type="hidden" name="sensor_id" value="{{ $sensor->id }}">
                                                <div>
                                                    <label class="block font-medium">Nama Alat</label>
                                                    <x-text-input name="nama_alat" value="{{ $sensor->sensor_name }}" readonly class="w-full" />
                                                </div>
                                                <div class="mt-4">
                                                    <label class="block font-medium">Jenis Maintenance</label>
                                                    <select name="jenis_maintenance" class="w-full border-gray-300 rounded">
                                                        <option value="perbaikan">Perbaikan</option>
                                                        <option value="penggantian">Penggantian</option>
                                                    </select>
                                                </div>
                                                <div class="mt-4">
                                                    <label class="block font-medium">Jenis Alat</label>
                                                    <select name="jenis_alat" class="w-full border-gray-300 rounded">
                                                        <option value="sensor">Sensor</option>
                                                        <option value="aktuator">Aktuator</option>
                                                    </select>
                                                </div>
                                                
                                                <div class="mt-6 flex justify-end">
                                                    <x-primary-button type="submit">Simpan</x-primary-button>
                                                </div>
                                            </form>
                                        </x-modal>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @elseif(auth()->check() && auth()->user()->role == 'teknisi')
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-2">
                <div class="overflow-x-auto">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex justify-between">
                            <span>Data Sensor</span>
                            <a href="/teknisi/sensor/create">
                                <x-primary-button>+ Tambah Sensor</x-button-primary>
                            </a>
                        </div>
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Sensor Name</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Field</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Unit</th>
                                    <!-- <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Latitude</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Longitude</th> -->
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($sensors as $sensor)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $sensor->sensor_name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $sensor->field}}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $sensor->unit}}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="http://maps.google.com/maps?q={{ $sensor->latitude }}%2C{{ $sensor->longitude }}&z=17&hl=en"
                                            ><x-primary-button>View on Map</x-primary-button></a>
                                        
                                        <a href="{{ route('sensors.edit', $sensor->id) }}"
                                            ><x-primary-button>Edit</x-primary-button></a>
                                        
                                        <form action="{{ route('sensors.destroy', $sensor->id) }}" method="POST"
                                            style="display:inline;"
                                            onsubmit="return confirm('Are you sure you want to delete this sensor?');">
                                            @csrf
                                            @method('DELETE')
                                            <x-danger-button>Delete</x-danger-button>
                                        </form>
                                        
                                        <a href="#">
                                            <x-secondary-button onclick="window.dispatchEvent(new CustomEvent('open-modal', { detail: 'add-maintenance-{{ $sensor->id }}' }))">
                                                Maintenance
                                            </x-secondary-button>
                                        </a>
                                        <x-modal id="modalDel{{ $sensor->id }}" name="add-maintenance-{{ $sensor->id }}">
                                            <form method="POST" action="{{ route('teknisi_maintenances.store') }}" class="p-6">
                                                @csrf
                                                <input type="hidden" name="sensor_id" value="{{ $sensor->id }}">
                                                <div>
                                                    <label class="block font-medium">Nama Alat</label>
                                                    <x-text-input name="nama_alat" value="{{ $sensor->sensor_name }}" readonly class="w-full" />
                                                </div>
                                                <div class="mt-4">
                                                    <label class="block font-medium">Jenis Maintenance</label>
                                                    <select name="jenis_maintenance" class="w-full border-gray-300 rounded">
                                                        <option value="perbaikan">Perbaikan</option>
                                                        <option value="penggantian">Penggantian</option>
                                                    </select>
                                                </div>
                                                <div class="mt-4">
                                                    <label class="block font-medium">Jenis Alat</label>
                                                    <select name="jenis_alat" class="w-full border-gray-300 rounded">
                                                        <option value="sensor">Sensor</option>
                                                        <option value="aktuator">Aktuator</option>
                                                    </select>
                                                </div>
                                                
                                                <div class="mt-6 flex justify-end">
                                                    <x-primary-button type="submit">Simpan</x-primary-button>
                                                </div>
                                            </form>
                                        </x-modal>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
    </div>


</x-app-layout>

{{-- Leaflet map fix: hide map when modal open --}}
<script>
    window.addEventListener('open-modal', function(e) {
        document.getElementById('map').style.zIndex = 0;
    });
    window.addEventListener('close-modal', function(e) {
        document.getElementById('map').style.zIndex = '';
    });
</script>