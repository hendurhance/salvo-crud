<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white leading-tight">
                {{ __('Show') }}
            </h2>
            <a href="{{ route('posts.index') }}" class="text-sm text-white dark:text-gray-600">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-white dark:text-gray-900">
                    <div class="mb-6">
                        <h2 class="text-lg font-medium text-white dark:text-gray-900">
                            {{ 'Title' }}
                        </h2>
                
                        <p class="mt-1 text-sm text-gray-300 dark:text-gray-600">
                            {{ $post->title }}
                        </p>
                    </div>
                    <div class="mb-6">
                        <h2 class="text-lg font-medium text-white dark:text-gray-900">
                            {{ 'Content' }}
                        </h2>
                
                        <p class="mt-1 text-sm text-gray-300 dark:text-gray-600">
                            {{ $post->content }}
                        </p>
                    </div>
                    <div class="mb-6">
                        <h2 class="text-lg font-medium text-white dark:text-gray-900">
                            {{ 'Created At' }}
                        </h2>
                
                        <p class="mt-1 text-sm text-gray-300 dark:text-gray-600">
                            {{ $post->created_at }}
                        </p>
                    </div>
                    <div class="mb-6">
                        <h2 class="text-lg font-medium text-white dark:text-gray-900">
                            {{ 'Updated At' }}
                        </h2>
                
                        <p class="mt-1 text-sm text-gray-300 dark:text-gray-600">
                            {{ $post->updated_at }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>