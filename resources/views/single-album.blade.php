<x-app-layout>
    <!-- Add photos modal -->
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
                    webkitdirectory directory
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

    <!-- Update album title -->
    <x-modal name="update-album" :show="$errors->albumUpdating->isNotEmpty()" focusable>
        <form method="post" action="{{ route('album.update', $album->id) }}" class="p-6">
            @csrf
            @method('patch')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Changer le titre') }}
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

                <x-input-error :messages="$errors->albumUpdating->get('title')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button class="ms-3">
                    {{ __('Update Album') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>

    <!-- Delete album modal -->
    <x-modal name="confirm-album-deletion" :show="$errors->albumDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('album.delete', $album->id) }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Are you sure you want to delete album "' . $album->title . '" ?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Once your album is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your album.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->albumDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Delete Album') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __($album->title) . ' (' . count($photos) . ')' }}
        </h2>
        <div>
            <x-primary-button 
                x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'add-photos')"
            >
                {{ __('Ajouter') }}
            </x-primary-button>
            <x-secondary-button 
                x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'update-album')"
            >
                {{ __('Changer le titre') }}
            </x-secondary-button>
            <x-danger-button 
                x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'confirm-album-deletion')"
            >
                {{ __('Supprimer') }}
            </x-danger-button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="photo-collection">
                        @if (count($photos) > 0)
                            @foreach ($photos as $photo)
                                @php
                                    $explodeFileName = explode('.', $photo->original_name);
                                    $extension = '.' . $explodeFileName[count($explodeFileName) - 1];
                                    $bg = 'background: url("' . asset('uploads/' . $photo->hash . $extension) . '") no-repeat center center';
                                @endphp
                                <a href="{{ route('file.show', ['photo' => $photo->id]) }}" target="_blank" class="photo-link">
                                    <div style="{{ $bg }}"></div>
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
    </div>
</x-app-layout>
