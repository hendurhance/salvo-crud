<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ 'Posts' }}
            </h2>
            @can('create', App\Models\Post::class)
                <a href="{{ route('posts.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md">ADD</a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="border-collapse table-auto w-full text-sm">
                        <thead>
                            <tr>
                                <th class="border-b font-medium p-4 pl-8 pt-0 pb-3 text-white text-slate-400 text-left">Title</th>
                                <th class="border-b font-medium p-4 pl-8 pt-0 pb-3 text-white text-slate-400 text-left">Created At</th>
                                <th class="border-b font-medium p-4 pl-8 pt-0 pb-3 text-white text-slate-400 text-left">Updated At</th>
                                <th class="border-b font-medium p-4 pl-8 pt-0 pb-3 text-white text-slate-400 text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800">
                            {{-- populate our post data --}}
                            @foreach ($posts as $post)
                                <tr>
                                    <td class="border-b border-slate-100 text-white dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">{{ $post->title }}</td>
                                    <td class="border-b border-slate-100 text-white dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">{{ $post->created_at }}</td>
                                    <td class="border-b border-slate-100 text-white dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">{{ $post->updated_at }}</td>
                                    <td class="border-b border-slate-100 text-white dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">
                                        @can('view', $post)
                                        <a href="{{ route('posts.show', $post->id) }}" class="border border-blue-500 hover:bg-blue-500 hover:text-white px-4 py-2 rounded-md"><i class="fas fa-eye"></i></a>
                                        @endcan
                                        @can('update', $post)
                                        <a href="{{ route('posts.edit', $post->id) }}" class="border border-yellow-500 hover:bg-yellow-500 hover:text-white px-4 py-2 rounded-md"><i class="fas fa-edit"></i></a>
                                        @endcan
                                        @can('delete', $post)
                                            <form method="post" action="{{ route('posts.destroy', $post->id) }}" class="inline">
                                                @csrf
                                                @method('delete')
                                                <button class="border border-red-500 hover:bg-red-500 hover:text-white px-4 py-2 rounded-md"><i class="fas fa-trash"></i></button>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>