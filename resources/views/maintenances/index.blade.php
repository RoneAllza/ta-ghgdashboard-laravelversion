<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Maintenance') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto py-2 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(auth()->check() && auth()->user()->role == 'teknisi')
                    <div class="flex justify-between">
                        <h1 class=" font-bold">Maintenance</h1>
                        <div class="gap-x-4">
                            <a href="/teknisi/maintenance/add">
                                <x-primary-button>Tambah</x-primary-button>
                            </a>
                        </div>

                    </div>
                    <table class="table-auto w-full mt-4">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">Waktu Mulai</th>
                                <th class="px-4 py-2">Nama Alat</th>
                                <th class="px-4 py-2">Jenis</th>
                                <th class="px-4 py-2">Status Maintenance</th>
                                <th class="px-4 py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach ($maintenance_sensor as $ms)
                                <tr>
                                    <td class=" px-4 py-2">{{ $ms->waktu_mulai }}</td>
                                    <td class=" px-4 py-2">{{ $ms->nama_alat }}</td>
                                    <td class=" px-4 py-2">{{ $ms->jenis_alat }}</td>
                                    @if($ms->status == 'waiting')
                                    <td class="px-4 py-2"><span class="py-2 px-4 bg-slate-600 text-white rounded-full">Menunggu</span></td>
                                    @elseif($ms->status == 'in_progress')
                                        <td class="px-4 py-2"><span class="py-2 px-4 bg-yellow-600 text-white rounded-full">In Progress</span></td>
                                    @elseif($ms->status == 'selesai')
                                        <td class="px-4 py-2"><span class="py-2 px-4 bg-green-600 text-white rounded-full">Selesai</span></td>
                                    @endif
                                    <td class=" px-4 py-2">
                                        @if($ms->status == 'waiting')
                                            <a href="{{ route('maintenances.show', $ms->id) }}">
                                                <x-primary-button>Detail</x-primary-button>
                                            </a>
                                            <form method="POST" action="{{ route('maintenances.kerjakan', $ms->id) }}" style="display:inline">
                                                @csrf
                                                <x-primary-button>Kerjakan</x-primary-button>
                                            </form>
                                        @elseif($ms->status == 'in_progress')
                                            <a href="{{ route('maintenances.show', $ms->id) }}">
                                                <x-primary-button>Detail</x-primary-button>
                                            </a>
                                            <x-primary-button onclick="window.dispatchEvent(new CustomEvent('open-modal', { detail: 'isi-keterangan-{{ $ms->id }}' }))">Selesai</x-primary-button>
                                            <x-modal id="modalDel{{ $ms->id }}" name="isi-keterangan-{{ $ms->id }}">
                                                <form method="POST" action="{{ route('maintenances.selesai', $ms->id) }}" style="display:inline">
                                                    @csrf
                                                    <div class="p-6 flex flex-col items-center justify-center min-w-[300px]">
                                                        <h2 class="text-base font-semibold mb-4 text-gray-700 text-center">
                                                            {{ __('Apa yang dikerjakan pada maintenance ini?') }}
                                                        </h2>
                                                        <x-text-input id="keterangan" name="keterangan" type="text" class="w-full mb-4" placeholder="Isi keterangan pekerjaan..." />
                                                        <div class="flex justify-end w-full">
                                                            <x-primary-button class="ms-3">
                                                                {{ __('OK') }}
                                                            </x-primary-button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </x-modal>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @elseif(auth()->check() && auth()->user()->role == 'unit_lingkungan')
                    <div class="flex justify-between">
                        <h1 class=" font-bold">Maintenance</h1>

                    </div>
                    <table class="table-auto w-full mt-4">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">Waktu Mulai</th>
                                <th class="px-4 py-2">Nama Alat</th>
                                <th class="px-4 py-2">Status Maintenance</th>
                                <th class="px-4 py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach ($maintenance_sensor as $ms)
                                <tr>
                                    <td class=" px-4 py-2">{{ $ms->waktu_mulai }}</td>
                                    <td class=" px-4 py-2">{{ $ms->nama_alat }}</td>
                                    @if($ms->status == 'waiting')
                                    <td class="px-4 py-2"><span class="py-2 px-4 bg-slate-600 text-white rounded-full">Menunggu</span></td>
                                    @elseif($ms->status == 'in_progress')
                                        <td class="px-4 py-2"><span class="py-2 px-4 bg-yellow-600 text-white rounded-full">In Progress</span></td>
                                    @elseif($ms->status == 'selesai')
                                        <td class="px-4 py-2"><span class="py-2 px-4 bg-green-600 text-white rounded-full">Selesai</span></td>
                                    @endif
                                    <td class=" px-4 py-2">
                                        <a href="/maintenance/{{ $ms->id }}">
                                            <x-primary-button>Detail</x-primary-button>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>