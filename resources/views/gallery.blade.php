<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- CSS -->
        @vite(['resources/css/gallery.css', 'resources/js/gallery.js'])
    </head>
    <body>
        <h1 hidden>Collective Gallery</h1>

        <p class="tooltip" x-data x-show="$store.tooltip.isVisible" x-text="$store.tooltip.text" x-transition></p>

        <nav id="navigation">
            <ul>
                <li data-navigation="group">
                    <a href="#" class="link" x-data @mouseenter="$store.tooltip.visible($event)" @mouseleave="$store.tooltip.hide()" data-tooltip="Forward">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <title>Forward</title>
                            <path d="M20.016 11.016v1.969h-12.188l5.578 5.625-1.406 1.406-8.016-8.016 8.016-8.016 1.406 1.406-5.578 5.625h12.188z"></path>
                        </svg>
                    </a>
                </li>
                <li data-navigation="group">
                    <a href="#" class="link" x-data @mouseenter="$store.tooltip.visible($event)" @mouseleave="$store.tooltip.hide()" data-tooltip="Next">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <title>Next</title>
                            <path d="M12 3.984l8.016 8.016-8.016 8.016-1.406-1.406 5.578-5.625h-12.188v-1.969h12.188l-5.578-5.625z"></path>
                        </svg>
                    </a>
                </li>

                <li data-navigation="photo">
                    <a href="#" class="link" x-data @mouseenter="$store.tooltip.visible($event)" @mouseleave="$store.tooltip.hide()" data-tooltip="Forward">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <title>Back</title>
                            <path d="M20.016 11.016v1.969h-12.188l5.578 5.625-1.406 1.406-8.016-8.016 8.016-8.016 1.406 1.406-5.578 5.625h12.188z"></path>
                        </svg>
                    </a>
                </li>
                <li data-navigation="photo">
                    <a href="#" class="link" x-data @mouseenter="$store.tooltip.visible($event)" @mouseleave="$store.tooltip.hide()" data-tooltip="Next">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <title>Next</title>
                            <path d="M12 3.984l8.016 8.016-8.016 8.016-1.406-1.406 5.578-5.625h-12.188v-1.969h12.188l-5.578-5.625z"></path>
                        </svg>
                    </a>
                </li>

                <li>
                    <a href="#" class="link" x-data @mouseenter="$store.tooltip.visible($event)" @mouseleave="$store.tooltip.hide()" data-tooltip="Play">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <title>Play</title>
                            <path d="M9.984 16.5l6-4.5-6-4.5v9zM12 2.016q4.125 0 7.055 2.93t2.93 7.055-2.93 7.055-7.055 2.93-7.055-2.93-2.93-7.055 2.93-7.055 7.055-2.93z"></path>
                        </svg>
                    </a>
                </li>

                <li>
                    <a href="{{ route('albums') }}" class="link" x-data @mouseenter="$store.tooltip.visible($event)" @mouseleave="$store.tooltip.hide()" data-tooltip="Close">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <title>Close</title>
                            <path d="M18.984 6.422l-5.578 5.578 5.578 5.578-1.406 1.406-5.578-5.578-5.578 5.578-1.406-1.406 5.578-5.578-5.578-5.578 1.406-1.406 5.578 5.578 5.578-5.578z"></path>
                        </svg>
                    </a>
                </li>
            </ul>
        </nav>

        <div id="gallery">
            <img src="{{ asset('storage/90198.jpg') }}" alt="Default Image" id="currentImage" />
        </div>
        <div id="list" x-data="$store.gallery.list" x-init="$store.gallery.createThumbnails()"></div>
    </body>
</html>
