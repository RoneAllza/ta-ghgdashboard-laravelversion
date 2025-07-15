@section('title', config('app.name', 'EMisi') . ' - Maintenance ' . $maintenance->nama_alat)
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Maintenance '.$maintenance->nama_alat) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(auth()->check() && auth()->user()->role == 'unit_lingkungan')
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="p-2 max-w-full flex justify-between">
                    <div class="flex flex-col gap-y-2">
                        <div>
                            <x-input-label for="nama_alat" :value="__('Nama Alat')" />
                            <span id="nama_alat" class="block font-semibold">{{$maintenance->nama_alat}}</span>
                        </div>
                        <div>
                            <x-input-label for="jenis_maintenance" :value="__('Jenis Maintenance')" />
                            @if ($maintenance->jenis_maintenance === 'perbaikan')
                            <span id="jenis_maintenance" class="block font-semibold">Perbaikan</span>
                            @elseif ($maintenance->jenis_maintenance === 'penggantian')
                            <span id="jenis_maintenance" class="block font-semibold">Penggantian</span>
                            @endif

                        </div>
                        <div>
                            <x-input-label for="jenis_alat" :value="__('Jenis Alat')" />
                            @if ($maintenance->jenis_alat === 'sensor')
                            <span id="jenis_alat" class=" block font-semibold">Sensor</span>
                            @elseif ($maintenance->jenis_alat === 'aktuator')
                            <span id="jenis_alat" class=" block font-semibold">Aktuator</span>
                            @endif
                        </div>
                        <div>
                            <x-input-label for="waktu_mulai" :value="__('Waktu Mulai')" />
                            @if ($maintenance->waktu_mulai === null)
                            <span class="text-gray-400">Belum dimulai</span>
                            @else
                            <span id="waktu_mulai" class=" block font-semibold">{{$maintenance->waktu_mulai}}</span>
                            @endif
                        </div>
                        <div>
                            <x-input-label for="waktu_selesai" :value="__('Waktu Selesai')" />
                            @if ($maintenance->waktu_selesai === null)
                            <span class="text-gray-400">Belum dimulai</span>
                            @else
                            <span id="waktu_mulai" class=" block font-semibold">{{$maintenance->waktu_selesai}}</span>
                            @endif
                        </div>
                        <div class="flex flex-col gap-y-2">
                            <x-input-label for="status" :value="__('Status')" />
                            @if($maintenance->status == 'waiting')
                            <td class="px-4 py-2 "><span
                                    class="w-fit py-2 px-4 bg-slate-600 text-white rounded-full">Menunggu</span></td>
                            @elseif($maintenance->status == 'in_progress')
                            <td class="px-4 py-2 "><span
                                    class="w-fit py-2 px-4 bg-yellow-600 text-white rounded-full">In Progress</span>
                            </td>
                            @elseif($maintenance->status == 'selesai')
                            <td class="px-4 py-2 "><span
                                    class="w-fit py-2 px-4 bg-green-600 text-white rounded-full">Selesai</span></td>
                            @endif
                        </div>
                    </div>
                    <div>
                        <div class="flex flex-col gap-y-2">
                            <div>
                                <x-input-label for="teknisi" :value="__('Teknisi')" />
                                @if ($maintenance->teknisi === null)
                                <span class="text-gray-400">Belum ada Teknisi</span>
                                @else
                                <span id="waktu_mulai" class=" block font-semibold">{{$maintenance->teknisi}}</span>
                                @endif
                            </div>
                            <div>
                                <x-input-label for="keterangan" :value="__('Keterangan')" />
                                @if ($maintenance->keterangan === null)
                                <span class="text-gray-400">Belum dimulai</span>
                                @else
                                <span id="waktu_mulai" class=" block font-semibold">{{$maintenance->keterangan}}</span>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
                @elseif(auth()->check() && auth()->user()->role == 'teknisi')
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="flex justify-end">

                        @if($maintenance->status == 'waiting')
                        <form method="POST" action="{{ route('maintenances.kerjakan', $maintenance->id) }}"
                            style="display:inline">
                            @csrf
                            <x-primary-button>Kerjakan</x-primary-button>
                        </form>
                        @elseif($maintenance->status == 'in_progress')
                        <x-primary-button
                            onclick="window.dispatchEvent(new CustomEvent('open-modal', { detail: 'isi-keterangan-{{ $maintenance->id }}' }))">
                            Selesai</x-primary-button>
                        <x-modal id="modalDel{{ $maintenance->id }}" name="isi-keterangan-{{ $maintenance->id }}">
                            <form method="POST" action="{{ route('maintenances.selesai', $maintenance->id) }}"
                                style="display:inline">
                                @csrf
                                <div class="p-6 flex flex-col items-center justify-center min-w-[300px]">
                                    <h2 class="text-base font-semibold mb-4 text-gray-700 text-center">
                                        {{ __('Apa yang dikerjakan pada maintenance ini?') }}
                                    </h2>
                                    <x-text-input id="keterangan" name="keterangan" type="text" class="w-full mb-4"
                                        placeholder="Isi keterangan pekerjaan..." />
                                    <div class="flex justify-end w-full">
                                        <x-primary-button class="ms-3">
                                            {{ __('OK') }}
                                        </x-primary-button>
                                    </div>
                                </div>
                            </form>
                        </x-modal>
                        @endif
                    </div>
                    <div class="p-2 max-w-full flex justify-between">
                        <div class="flex flex-col gap-y-2">
                            <div>
                                <x-input-label for="nama_alat" :value="__('Nama Alat')" />
                                <span id="nama_alat" class="block font-semibold">{{$maintenance->nama_alat}}</span>
                            </div>
                            <div>
                                <x-input-label for="jenis_maintenance" :value="__('Jenis Maintenance')" />
                                @if ($maintenance->jenis_maintenance === 'perbaikan')
                                <span id="jenis_maintenance" class="block font-semibold">Perbaikan</span>
                                @elseif ($maintenance->jenis_maintenance === 'penggantian')
                                <span id="jenis_maintenance" class="block font-semibold">Penggantian</span>
                                @endif

                            </div>
                            <div>
                                <x-input-label for="jenis_alat" :value="__('Jenis Alat')" />
                                @if ($maintenance->jenis_alat === 'sensor')
                                <span id="jenis_alat" class=" block font-semibold">Sensor</span>
                                @elseif ($maintenance->jenis_alat === 'aktuator')
                                <span id="jenis_alat" class=" block font-semibold">Aktuator</span>
                                @endif
                            </div>
                            <div>
                                <x-input-label for="waktu_mulai" :value="__('Waktu Mulai')" />
                                @if ($maintenance->waktu_mulai === null)
                                <span class="text-gray-400">Belum dimulai</span>
                                @else
                                <span id="waktu_mulai" class=" block font-semibold">{{$maintenance->waktu_mulai}}</span>
                                @endif
                            </div>
                            <div>
                                <x-input-label for="waktu_selesai" :value="__('Waktu Selesai')" />
                                @if ($maintenance->waktu_selesai === null)
                                <span class="text-gray-400">Belum dimulai</span>
                                @else
                                <span id="waktu_mulai"
                                    class=" block font-semibold">{{$maintenance->waktu_selesai}}</span>
                                @endif
                            </div>
                            <div class="flex flex-col gap-y-2">
                                <x-input-label for="status" :value="__('Status')" />
                                @if($maintenance->status == 'waiting')
                                <td class="px-4 py-2 "><span
                                        class="w-fit py-2 px-4 bg-slate-600 text-white rounded-full">Menunggu</span>
                                </td>
                                @elseif($maintenance->status == 'in_progress')
                                <td class="px-4 py-2 "><span
                                        class="w-fit py-2 px-4 bg-yellow-600 text-white rounded-full">In Progress</span>
                                </td>
                                @elseif($maintenance->status == 'selesai')
                                <td class="px-4 py-2 "><span
                                        class="w-fit py-2 px-4 bg-green-600 text-white rounded-full">Selesai</span></td>
                                @endif
                            </div>

                        </div>
                        <div>
                            <div class="flex flex-col gap-y-2">
                                <div>
                                    <x-input-label for="teknisi" :value="__('Teknisi')" />
                                    @if ($maintenance->teknisi === null)
                                    <span class="text-gray-400">Belum ada Teknisi</span>
                                    @else
                                    <span id="waktu_mulai" class=" block font-semibold">{{$maintenance->teknisi}}</span>
                                    @endif
                                </div>
                                <div>
                                    <x-input-label for="keterangan" :value="__('Keterangan')" />
                                    @if ($maintenance->keterangan === null)
                                    <span class="text-gray-400">Belum dimulai</span>
                                    @else
                                    <span id="waktu_mulai"
                                        class=" block font-semibold">{{$maintenance->keterangan}}</span>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
</x-app-layout>

{{-- @extends('layouts.app')
@section('content')
<div class="max-w-2xl mx-auto mt-8 bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Detail Maintenance</h2>
    <div class="mb-2"><b>Nama Alat:</b> {{ $maintenance->nama_alat }}</div>
    <div class="mb-2"><b>Jenis Maintenance:</b> {{ $maintenance->jenis_maintenance }}</div>
    <div class="mb-2"><b>Jenis Alat:</b> {{ $maintenance->jenis_alat }}</div>
    <div class="mb-2"><b>Keterangan:</b> {{ $maintenance->keterangan }}</div>
    <div class="mb-2"><b>Teknisi:</b> {{ $maintenance->teknisi }}</div>
    <div class="mb-2"><b>Status:</b> {{ ucfirst($maintenance->status) }}</div>
    <div class="mb-2"><b>Waktu Mulai:</b> {{ $maintenance->waktu_mulai ?? '-' }}</div>
    <div class="mb-2"><b>Waktu Selesai:</b> {{ $maintenance->waktu_selesai ?? '-' }}</div>
    @if(auth()->user()->role === 'teknisi')
    @if($maintenance->status === 'waiting')
    <form method="POST" action="{{ route('maintenances.kerjakan', $maintenance->id) }}">
        @csrf
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Kerjakan</button>
    </form>
    @elseif($maintenance->status === 'in_progress')
    <form method="POST" action="{{ route('maintenances.selesai', $maintenance->id) }}">
        @csrf
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Selesai</button>
    </form>
    @endif
    @endif
    <a href="{{ route('maintenance.index') }}" class="inline-block mt-4 text-blue-600">Kembali</a>
</div>
@endsection --}}