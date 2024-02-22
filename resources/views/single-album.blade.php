<x-app-layout>
    <x-modal name="add-photos" :show="$errors->photoAdd->isNotEmpty()" focusable>
        <form method="post" action="{{ route('photo.add', $album->id) }}" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('post')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Ajouter des photos') }}
            </h2>

            <div class="mt-6">
                <x-input-label for="photos" value="{{ __('Photos') }}" class="sr-only" />

                <input 
                    type="file" 
                    id="photos" 
                    name="photos[]" 
                    class="mt-1 block w-3/4" 
                    placeholder="{{ __('Sélectionner mes photos') }}" 
                    accept="image/jpeg, image/png, image/gif, image/bmp, image/webp, image/svg+xml, image/x-icon"
                    multiple 
                />

                <x-input-error :messages="$errors->photoAdd->get('photos')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button class="ms-3">
                    {{ __('Add Photos') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __($album->title) . ' (' . count($photos) . ')' }}
        </h2>
        <x-primary-button 
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'add-photos')"
        >
            {{ __('Ajouter') }}
        </x-primary-button>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 grid gap-4 grid-cols-3 grid-rows-3"">
                @if (count($photos) > 0)
                        @foreach ($photos as $photo)
                            @php
                                $explodeFileName = explode('.', $photo->original_name);
                                $extension = '.' . $explodeFileName[count($explodeFileName) - 1];
                            @endphp
                            <a href="{{ route('file.show', ['photo' => $photo->id]) }}" target="_blank" class="overflow-hidden block bg-cover">
                                <div>
                                    <img src="{{ asset('uploads/' . $photo->hash . $extension) }}" alt="{{ $photo->original_name }}" class="bg-cover" />
                                    <!-- <p>{{ $photo->name }}</p> -->
                                </div>
                            </a>
                        @endforeach
                    @else 
                        <div class="text-center">
                            {{ __('Vous n\'avez aucune photo dans cet album.') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
