{{-- @section('title', config('app.name', 'EMisi') . ' - Sensor') --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pengelolaan Kategori Sumber') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto py-2 sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-2">
                <div class="overflow-x-auto">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex justify-between">
                            <span>Data Kategori Sumber</span>
                            <a href="/kategori-sumber/add">
                                <x-primary-button>+ Tambah Kategori</x-button-primary>
                            </a>
                        </div>
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nama Kategori</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Kode</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Deskripsi</th>
                                    <!-- <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Latitude</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Longitude</th> -->
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($kategoriSumbers as $ks)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $ks->nama }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $ks->kode}}</td>
                                    @if($ks->deskripsi == null)
                                    <td class="px-6 py-4 whitespace-nowrap">-</td>
                                    @else
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $ks->deskripsi}}</td>
                                    @endif
                                    <td class="px-6 py-4 whitespace-nowrap">
                    
                                        
                                        <a href="{{ route('kategori_sumber.edit', $ks->id) }}"
                                            ><x-primary-button>Edit</x-primary-button></a>
                                        
                                        <form action="{{ route('kategori_sumber.destroy', $ks->id) }}" method="POST"
                                            style="display:inline;"
                                            onsubmit="return confirm('Are you sure you want to delete this sensor?');">
                                            @csrf
                                            @method('DELETE')
                                            <x-danger-button>Delete</x-danger-button>
                                        </form>
                                        
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>


</x-app-layout>

