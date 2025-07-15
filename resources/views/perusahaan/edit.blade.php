@section('title', config('app.name', 'EMisi') . ' - Edit Data Perusahaan')
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Perusahaan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Edit Perusahaan') }}
                </h2>
                <div class="max-w-full">
                    <form method="post" action="{{ route('companies.update', $perusahaan->id) }}" class="mt-6 space-y-6">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-2 justify-between gap-4">
                            <div class="flex flex-col gap-4">
                                <div>
                                    <x-input-label for="nama" :value="__('Nama Perusahaan')" />
                                    <x-text-input id="nama" name="nama" type="text" class="mt-1 block w-full" value="{{ $perusahaan->nama }}"  autofocus autocomplete="nama" />
                                    <x-input-error class="mt-2" :messages="$errors->get('nama')" />
                                </div>
                        
                                <div>
                                    <x-input-label for="alamat" :value="__('Alamat')" />
                                    <x-text-input id="alamat" name="alamat" type="text" class="mt-1 block w-full" value="{{ $perusahaan->alamat }}"  autofocus autocomplete="alamat" />
                                    <x-input-error class="mt-2" :messages="$errors->get('alamat')" />
                                </div>
                                    
                                <div>
                                    <x-input-label for="provinsi" :value="__('Provinsi')" />
                                    <x-text-input id="provinsi" name="provinsi" type="text" class="mt-1 block w-full" value="{{ $perusahaan->provinsi }}"  autofocus autocomplete="provinsi" />
                                    <x-input-error class="mt-2" :messages="$errors->get('provinsi')" />
                                </div>
                                <div>
                                    <x-input-label for="kab_kota" :value="__('Kabupaten/Kota')" />
                                    <x-text-input id="kab_kota" name="kab_kota" type="text" class="mt-1 block w-full" value="{{ $perusahaan->kab_kota }}"  autofocus autocomplete="kab_kota" />
                                    <x-input-error class="mt-2" :messages="$errors->get('kab_kota')" />
                                </div>
                            </div>
                            <div class="flex flex-col gap-4">
                                <div>
                                    <x-input-label for="kecamatan" :value="__('Kecamatan')" />
                                    <x-text-input id="kecamatan" name="kecamatan" type="text" class="mt-1 block w-full" value="{{ $perusahaan->kecamatan }}"  autofocus autocomplete="kecamatan" />
                                    <x-input-error class="mt-2" :messages="$errors->get('kecamatan')" />
                                </div>
                                <div>
                                    <x-input-label for="kelurahan" :value="__('Kelurahan')" />
                                    <x-text-input id="kelurahan" name="kelurahan" type="text" class="mt-1 block w-full" value="{{ $perusahaan->kelurahan }}"  autofocus autocomplete="kelurahan" />
                                    <x-input-error class="mt-2" :messages="$errors->get('kelurahan')" />
                                </div>
                                <div>
                                    <x-input-label for="no_telp" :value="__('Nomor Telepon')" />
                                    <x-text-input id="no_telp" name="no_telp" type="text" class="mt-1 block w-full" value="{{ $perusahaan->no_telp }}"  autofocus autocomplete="no_telp" />
                                    <x-input-error class="mt-2" :messages="$errors->get('no_telp')" />
                                </div>
                                <div>
                                    <x-input-label for="kode_pos" :value="__('Kode Pos')" />
                                    <x-text-input id="kode_pos" name="kode_pos" type="text" class="mt-1 block w-full" value="{{ $perusahaan->kode_pos }}"  autofocus autocomplete="kode_pos" />
                                    <x-input-error class="mt-2" :messages="$errors->get('kode_pos')" />
                                </div>
                            </div>
                        </div>
                        
                        
                        <div>
                            <x-input-label for="penanggung_jawab" :value="__('Penanggung Jawab')" />
                            <x-text-input id="penanggung_jawab" name="penanggung_jawab" type="text" class="mt-1 block w-full" value="{{ $perusahaan->penanggung_jawab }}"  autofocus autocomplete="penanggung_jawab" />
                            <x-input-error class="mt-2" :messages="$errors->get('penanggung_jawab')" />
                        </div>
                        <div>
                            <x-input-label for="no_hp" :value="__('Nomor HP')" />
                            <x-text-input id="no_hp" name="no_hp" type="text" class="mt-1 block w-full" value="{{ $perusahaan->no_hp }}"  autofocus autocomplete="no_hp" />
                            <x-input-error class="mt-2" :messages="$errors->get('no_hp')" />
                        </div>
                        <div>
                            <x-input-label for="jabatan" :value="__('Jabatan')" />
                            <x-text-input id="jabatan" name="jabatan" type="text" class="mt-1 block w-full" value="{{ $perusahaan->jabatan }}"  autofocus autocomplete="jabatan" />
                            <x-input-error class="mt-2" :messages="$errors->get('jabatan')" />
                        </div>
                        <div>
                            <x-input-label for="email" :value="__('Email PJ')" />
                            <x-text-input id="email" name="email" type="text" class="mt-1 block w-full" value="{{ $perusahaan->email }}"  autofocus autocomplete="email" />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>
                        {{-- <div>
                            <x-input-label for="jabatan" :value="__('Jabatan')" />
                            <x-text-input id="jabatan" name="jabatan" type="text" class="mt-1 block w-full" value={{ $perusahaan->jabatan }}  autocomplete="jabatan" />
                            <x-input-error class="mt-2" :messages="$errors->get('jabatan')" />
                        </div>
                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" name="email" type="text" class="mt-1 block w-full" value={{ $perusahaan->email }}  autocomplete="email" />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div> --}}
                
                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Save') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>