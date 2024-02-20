<x-app-layout>
    <x-modal name="create-album" :show="$errors->albumCreation->isNotEmpty()" focusable>
        <form method="post" action="{{ route('album.create') }}" class="p-6">
            @csrf
            @method('post')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Créer un nouvel album') }}
            </h2>

            <div class="mt-6">
                <x-input-label for="title" value="{{ __('Titre') }}" class="sr-only" />

                <x-text-input
                    id="title"
                    name="title"
                    type="text"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Titre') }}"
                />

                <x-input-error :messages="$errors->albumCreation->get('title')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button class="ms-3">
                    {{ __('Create Album') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Mes Albums') }}
        </h2>
        <x-primary-button 
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'create-album')"
        >
            {{ __('Créer') }}
        </x-primary-button>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if (count($albums) > 0)
                        @foreach ($albums as $album)
                            <a href="{{ route('album.read', $album->id) }}">
                                <p>{{ $album->title }}</p>
                                <p>{{ count($album->photos) }}</p>
                            </a>
                        @endforeach
                    @else 
                        <div class="text-center">
                            {{ __('Vous n\'avez aucun album pour le moment.') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100 grid gap-4 grid-cols-3 grid-rows-3"">
                @if (count($photos) > 0)
                        @foreach ($photos as $photo)
                            <a href="{{ asset('uploads/' . $photo->name) }}" target="_blank" class="overflow-hidden block bg-cover">
                                <div>
                                    <img src="{{ asset('uploads/' . $photo->name) }}" alt="{{ $photo->name }}" class="bg-cover" />
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
