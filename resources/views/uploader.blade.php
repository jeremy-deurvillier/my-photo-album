<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Upload files') }}
        </h2>
    </x-slot>

    <div x-data="{files: []}" @hydrate="() => {$data.files = Array.from(document.querySelector('#photos').files);$store.upload.sendFiles({{ $album->id }}, $data.files)}">
        <div class="pt-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <form method="post" enctype="multipart/form-data" class="flex flex-col flex-nowrap justify-center md:flex-row" @submit.prevent="$dispatch('hydrate')">
                            @csrf
                            <div class="flex-1 md:flex-0 justify-center overflow-hidden">
                                <input 
                                    type="file" 
                                    id="photos" 
                                    name="photos[]" 
                                    class="mt-1 block inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150" 
                                    placeholder="{{ __('Sélectionner mes photos') }}" 
                                    accept="image/jpeg, image/png, image/gif, image/bmp, image/webp, image/svg+xml, image/x-icon"
                                    multiple 
                                    webkitdirectory directory
                                />
                            </div>
                            <div class="flex justify-end justify-around mt-6">
                                <a
                                    href="{{ route('album.read', $album->id) }}"
                                    class="inline-flex text-center items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150 ms-3"
                                >
                                    {{ __('Back to album') }}
                                </a>
                                <x-primary-button class="ms-3">
                                    {{ __('Add Photos') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="py-2">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <ul class="block columns-1 md:columns-2 2xl:columns-3">
                            <template x-for="(file, index) in files" :key="file.name">
                                <li>
                                    <div>
                                        <span x-text="index+1"></span>
                                        <span x-text="file.name"></span>
                                    </div>
                                </li>
                            </template>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
