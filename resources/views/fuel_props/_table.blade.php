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
                    <form method="post" action="{{ route('emisi.destroy', $fp->id) }}" class="p-6">
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
    {{ $fuelProperties->links() }}
</div>
