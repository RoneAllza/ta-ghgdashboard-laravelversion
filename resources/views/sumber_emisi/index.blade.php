@section('title', config('app.name', 'EMisi') . ' - Sumber Emisi')

<x-app-layout>
    <x-slot name="header">
        <span class="font-light text-slate-400 text-sm">Home / Sumber Emisi</span>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Sumber Emisi') }}
        </h2>
        <span class="text-sm text-slate-500">Data sarana perusahaan yang mengeluarkan emisi</span>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto py-2 sm:px-6 lg:px-8">
            <div class="grid grid-cols-3 overflow-hidden gap-x-4 shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 flex flex-col">
                    Total Sumber Emisi
                    <span class="font-semibold text-2xl">{{count($sumberEmisis)}}</span>
                </div>
                <div class="p-6 bg-white border-b border-gray-200 flex flex-col">
                    Kendaraan
                    <span class="font-semibold text-2xl">{{ $sumberEmisis->where('tipe_sumber', 'Kendaraan')->count()
                        }}</span>
                </div>
                <div class="p-6 bg-white border-b border-gray-200 flex flex-col">
                    Alat Berat
                    <span class="font-semibold text-2xl">{{ $sumberEmisis->where('tipe_sumber', 'Alat Berat')->count()
                        }}</span>
                </div>
            </div>
            <div class="bg-white mt-4 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between">
                        <label for="table-search" class="sr-only">Search</label>
                        <div class="relative">
                            <form method="GET" action="" class="flex">
                                <input type="text" name="search_emisi" id="table-search-emisi"
                                    class="block pt-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 "
                                    placeholder="Cari Data" value="{{ request('search_emisi') }}">
                                <button type="submit" class="ml-2 px-4 py-2 bg-blue-600 text-white rounded">Cari</button>
                            </form>
                        </div>
                        <div class="mt-6 flex justify-end gap-x-4">
                            <a href="/emisi/tambah">
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
                                <th class="px-4 py-2">#</th>
                                <th class="px-4 py-2">Sumber</th>
                                <th class="px-4 py-2">Kapasitas Output</th>
                                <th class="px-4 py-2">Tipe Sumber</th>
                                <th class="px-4 py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach ($sumberEmisis as $se)
                            <tr>
                                <td class="flex px-4 py-2 justify-center align-center items-center">
                                    <img src="{{asset('uploads/sumber_emisi/'.$se->dokumentasi)}}"
                                        alt="{{$se->dokumentasi}}" class="w-20">
                                </td>
                                <td class=" px-4 py-2">{{ $se->sumber }}</td>
                                <td class=" px-4 py-2">{{ $se->kapasitas_output }} {{$se->unit}}</td>
                                @if ($se->tipe_sumber == 'Kendaraan')
                                <td class="px-4 py-2"><span
                                        class="py-2 px-4 bg-fuchsia-700 text-white rounded-full">Kendaraan</span></td>
                                @elseif ($se->tipe_sumber == 'Alat Berat')
                                <td class="px-4 py-2"><span class="py-2 px-4 bg-blue-700 text-white rounded-full">Alat
                                        Berat</span></td>
                                @elseif ($se->tipe_sumber == 'Boiler')
                                <td class="px-4 py-2"><span
                                        class="py-2 px-4 bg-cyan-700 text-white rounded-full">Boiler</span></td>
                                @else
                                <td class="px-4 py-2"><span
                                    class="py-2 px-4 bg-cyan-700 text-white rounded-full">Lainnya</span></td>
                                @endif
                                <td class=" px-4 py-2">
                                    <a href="/emisi/{{$se->id}}">
                                        <x-primary-button>Lihat</x-primary-button>
                                    </a>
                                    <a href="{{ route('emisis.edit', $se->id) }}">
                                        <x-secondary-button>Edit</x-secondary-button>
                                    </a>
                                    <x-danger-button type="button"
                                        onclick="window.dispatchEvent(new CustomEvent('open-modal', { detail: 'confirm-sumber-emisi-deletion-{{ $se->id }}' }))">
                                        Hapus
                                    </x-danger-button>
                                    <x-modal id="modalDel{{ $se->id }}" name="confirm-sumber-emisi-deletion-{{ $se->id }}">
                                        <form method="post" action="{{ route('emisis.destroy', $se->id) }}" class="p-6">
                                            @csrf
                                            @method('delete')
                                            <h2 class="text-sm text-gray-600">
                                                {{ __('Yakin menghapus data ini?') }}
                                            </h2>
                                            <p class="mt-1 text-lg font-medium text-black">
                                                {{ __('Emisi ' . $se->sumber) }}
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
                        {{ $sumberEmisis->appends(request()->except('emisi_page'))->links() }}
                    </div>
                </div>

            </div>
            <div class="bg-white mt-4 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between">
                        <div class="flex flex-col">
                            <h1 class=" font-bold">Daftar Bahan Bakar</h1>
                            <span class="text-sm text-gray-500">Data bahan bakar yang digunakan pada sumber emisi</span>
                        </div>
                        <div class="relative">
                            <form method="GET" action="" class="flex">
                                <input type="text" name="search_fuel" id="table-search-fuel"
                                    class="block pt-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 "
                                    placeholder="Cari Data" value="{{ request('search_fuel') }}">
                                <button type="submit" class="ml-2 px-4 py-2 bg-blue-600 text-white rounded">Cari</button>
                            </form>
                        </div>
                        <div class="mt-6 flex justify-end gap-x-4">
                            <a href="/fuel-props">
                                <x-primary-button>
                                    {{ __('Lihat Semua') }}
                                </x-primary-button>
                            </a>
                            <a href="/fuel-props/add">
                                <x-primary-button>
                                    {{ __('+ Tambah') }}
                                </x-primary-button>
                            </a>
                        </div>
                    </div>
                    <div id="fuel-props-table">
                        @section('fuel_table')
                        <table class="table-auto w-full mt-4">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2">Tipe Bahan Bakar</th>
                                    <th class="px-4 py-2">Faktor Konversi</th>
                                    <th class="px-4 py-2">Action</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @foreach ($fuelProperties as $fp)
                                <tr class="hover:bg-gray-100">
                                    <td class=" px-4 py-2">{{ $fp->fuel_type }}</td>
                                    <td class=" px-4 py-2">{{ $fp->conversion_factor }}</td>
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
                            {{ $fuelProperties->appends(request()->except('fuel_page'))->links() }}
                        </div>
                        @show
                    </div>
                </div>
            </div>
            <div class="bg-white mt-4 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between">
                        <div class="flex flex-col">
                            <h1 class=" font-bold">Daftar Kategori Sumber</h1>
                            <span class="text-sm text-gray-500">Data bahan bakar yang digunakan pada sumber emisi</span>
                        </div>
                        <div class="relative">
                            <form method="GET" action="" class="flex">
                                <input type="text" name="search_kategori" id="table-search-kategori"
                                    class="block pt-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 "
                                    placeholder="Cari Data" value="{{ request('search_kategori') }}">
                                <button type="submit" class="ml-2 px-4 py-2 bg-blue-600 text-white rounded">Cari</button>
                            </form>
                        </div>
                        <div class="mt-6 flex justify-end gap-x-4">
                            <a href="/kategori-sumber">
                                <x-primary-button>
                                    {{ __('Lihat Semua') }}
                                </x-primary-button>
                            </a>
                            <a href="/kategori-sumber/add">
                                <x-primary-button>
                                    {{ __('+ Tambah') }}
                                </x-primary-button>
                            </a>
                        </div>
                    </div>
                    <div id="kategori-sumber-table">
                        @section('kategori_table')
                        <table class="table-auto w-full mt-4">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2">Nama</th>
                                    <th class="px-4 py-2">Kode</th>
                                    <th class="px-4 py-2">Action</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @foreach ($kategoriSumbers as $ks)
                                <tr class="hover:bg-gray-100">
                                    <td class=" px-4 py-2">{{ $ks->nama }}</td>
                                    <td class=" px-4 py-2">{{ $ks->kode }}</td>
                                    <td class=" px-4 py-2">
                                        <a href="{{ route('kategori_sumber.edit', $ks->id) }}">
                                            <x-primary-button>Edit</x-primary-button>
                                        </a>
                                        <x-danger-button
                                            onclick="window.dispatchEvent(new CustomEvent('open-modal', { detail: 'confirm-kategori-sumber-deletion-{{ $ks->id }}' }))">
                                            Hapus
                                        </x-danger-button>
                                        <x-modal id="modalDel{{ $ks->id }}" name="confirm-kategori-sumber-deletion-{{ $ks->id }}">
                                            <form method="post" action="{{ route('emisis.destroy', $ks->id) }}" class="p-6">
                                                @csrf
                                                @method('delete')
                                                <h2 class="text-sm text-gray-600">
                                                    {{ __('Yakin menghapus data ini?') }}
                                                </h2>
                                                <p class="mt-1 text-lg font-medium text-black">
                                                    {{ __($ks->nama) }}
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
                            {{ $kategoriSumbers->appends(request()->except('kategori_page'))->links() }}
                        </div>
                        @show
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>


</x-app-layout>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.addEventListener('click', function (e) {
            if (e.target.closest('#fuel-props-table .pagination a')) {
                e.preventDefault();
                const url = new URL(e.target.closest('a').href);
                url.searchParams.set('fuel_only', '1');
                fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                    .then(res => res.json())
                    .then data => {
                        document.getElementById('fuel-props-table').innerHTML = data.html;
                    });
            }
        });
    });
</script>
@endpush