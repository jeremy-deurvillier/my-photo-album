<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Mes Albums') }}
        </h2>
        <a href="{{ route('album.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
            Créer
        </a>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if (count($albums) > 0)
                        @foreach ($albums as $album)
                            <p>{{ $album->title }}</p>
                            <p>{{ count($album->photos) }}</p>
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
</x-app-layout>
