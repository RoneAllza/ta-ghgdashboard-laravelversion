@section('title', config('app.name', 'EMisi') . ' - Laporan ' . $report->report_name)
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan') }}
        </h2>
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="flex gap-x-4 items-center mb-4">

                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Laporan {{ $report->period_date }}
                    </h2>
                    @if ($report->period_type == 'harian')
                        <span class="py-2 px-4 mt-2 bg-fuchsia-700 text-white rounded-full">Harian</span>
                    @elseif ($report->period_type == 'bulanan')
                        <span class="py-2 px-4 mt-2 bg-blue-700 text-white rounded-full">Bulanan</span>
                    @elseif ($report->period_type == 'tahunan') 
                        <span class="py-2 px-4 mt-2 bg-cyan-700 text-white rounded-full">Tahunan</span>
                    @endif
                </div>
                <span class="font-semibold text-slate-600"></span>
                <div class="max-w-xl">
                    <div class="flex flex-col gap-y-2">
                        <div class="grid grid-cols-2 justify-between">
                            <div>
                                <x-input-label for="total_ch4" :value="__('Total CH4')" />
                                <span id="total_ch4" class=" block font-semibold">{{$report->total_ch4}}</span>
                            </div>
                        
                            <div class="mt-2">
                                <x-input-label for="total_co2" :value="__('Total CO2')" />
                                <span id="total_co2" class=" block font-semibold">{{$report->total_co2}}</span>
                            </div>
                            <div class="mt-2">
                                <x-input-label for="total_n2o" :value="__('Total N2O')" />
                                <span id="total_n2o" class=" block font-semibold">{{$report->total_n2o}}</span>
                            </div>
                            <div class="mt-2">
                                <x-input-label for="avg_co2" :value="__('Rata-rata CO2')" />
                                <span id="avg_co2" class=" block font-semibold">{{$report->avg_co2}}</span>
                            </div>
                            <div class="mt-2">
                                <x-input-label for="avg_ch4" :value="__('Rata-rata CH4')" />
                                <span id="avg_ch4" class=" block font-semibold">{{$report->avg_ch4}}</span>
                            </div>
                            <div class="mt-2">
                                <x-input-label for="avg_n2o" :value="__('Rata-rata N2O')" />
                                <span id="avg_n2o" class=" block font-semibold">{{$report->avg_n2o}}</span>
                            </div>

                        </div>

                        <div class="mt-2">
                            <x-input-label for="komentar" :value="__('Komentar')" />
                            <x-text-input id="komentar" name="komentar" type="text" class="mt-1 block w-full"
                                value="{{ $report->komentar }}" required autocomplete="komentar" />
                            <x-input-error class="mt-2" :messages="$errors->get('komentar')" />
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-x-4 mt-4">
                    <form method="GET" action="{{ route('reports.export') }}">
                        <input type="hidden" name="period_type" value="{{ $report->period_type }}">
                        @if($report->period_type === 'harian')
                            <input type="hidden" name="tanggal" value="{{ $report->period_date }}">
                        @elseif($report->period_type === 'bulanan')
                            <input type="hidden" name="bulan" value="{{ \Illuminate\Support\Str::substr($report->period_date, 0, 7) }}">
                        @elseif($report->period_type === 'tahunan')
                            <input type="hidden" name="tahun" value="{{ \Illuminate\Support\Str::substr($report->period_date, 0, 4) }}">
                        @endif
                        <x-primary-button>Ekspor</x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>