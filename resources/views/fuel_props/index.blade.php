<x-app-layout>
    <x-slot name="header">
        <span class="font-light text-slate-400 text-sm">Home / Bahan Bakar</span>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Jenis Bahan Bakar') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto py-2 sm:px-6 lg:px-8">
            {{-- <div class="grid grid-cols-3 overflow-hidden gap-x-4 shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 flex flex-col">
                    Total Sumber Emisi
                    <span class="font-semibold text-2xl">{{count($sumberEmisis)}}</span>
                </div>
                <div class="p-6 bg-white border-b border-gray-200 flex flex-col">
                    Kendaraan
                    <span class="font-semibold text-2xl">{{ $sumberEmisis->where('tipe_sumber', 'kendaraan')->count()
                        }}</span>
                </div>
                <div class="p-6 bg-white border-b border-gray-200 flex flex-col">
                    Alat Berat
                    <span class="font-semibold text-2xl">{{ $sumberEmisis->where('tipe_sumber', 'alat_berat')->count()
                        }}</span>
                </div>
            </div> --}}
            <div class="bg-white mt-4 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between">
                        <label for="table-search" class="sr-only">Search</label>
                        <div class="relative">
                            <input type="text" id="table-search-users"
                                class="block pt-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 "
                                placeholder="Search for data">
                        </div>
                        <div class="mt-6 flex justify-end gap-x-4">
                            <a href="/fuel-props/add">
                                <x-primary-button>
                                    {{ __('+ Tambah') }}
                                </x-primary-button>
                            </a>
                            <a href="{{ route('emisis.export') }}">
                                <x-primary-button>
                                    {{ __('> Export') }}
                                </x-primary-button>
                            </a>
                        </div>
                    </div>
                    <table class="table-auto w-full mt-4">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">Tipe Bahan Bakar</th>
                                <th class="px-4 py-2">Faktor Konversi</th>
                                <th class="px-4 py-2">Faktor CO2</th>
                                <th class="px-4 py-2">Faktor CH4</th>
                                <th class="px-4 py-2">Faktor N2O</th>
                                <th class="px-4 py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach ($fuelProps as $fp)
                            <tr class="hover:bg-gray-100">
                                <td class=" px-4 py-2">{{ $fp->fuel_type }}</td>
                                <td class=" px-4 py-2">{{ $fp->conversion_factor }}</td>
                                <td class=" px-4 py-2">{{ $fp->co2_factor }}</td>
                                <td class=" px-4 py-2">{{ $fp->ch4_factor }}</td>
                                <td class=" px-4 py-2">{{ $fp->n2o_factor }}</td>
                                <td class=" px-4 py-2">
                                    <a href="{{ route('fuel_props.edit', $fp->id) }}">
                                        <x-primary-button>Edit</x-primary-button>
                                    </a>
                                    <x-danger-button
                                        onclick="window.dispatchEvent(new CustomEvent('open-modal', { detail: 'confirm-fuel-props-deletion-{{ $fp->id }}' }))">
                                        Hapus
                                    </x-danger-button>
                                    <x-modal id="modalDel{{ $fp->id }}" name="confirm-fuel-props-deletion-{{ $fp->id }}">
                                        <form method="post" action="{{ route('emisis.destroy', $fp->id) }}" class="p-6">
                                            @csrf
                                            @method('delete')
                                            <h2 class="text-sm text-gray-600">
                                                {{ __('Yakin menghapus data ini?') }}
                                            </h2>
                                            <p class="mt-1 text-lg font-medium text-black">
                                                {{ __($fp->fuel_type) }}
                                            </p>
                                            <div class="mt-6 flex justify-end">
                                                <x-secondary-button x-on:click="$dispatch('close')">
                                                    {{ __('Batal') }}
                                                </x-secondary-button>
                                                <x-danger-button class="ms-3">
                                                    {{ __('Hapus Data') }}
                                                </x-danger-button>
                                            </div>
                                        </form>
                                    </x-modal>

                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $fuelProps->links() }}
                    </div>
                </div>

            </div>
        </div>
    </div>
    </div>


</x-app-layout>