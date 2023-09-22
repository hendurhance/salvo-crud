<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Create Role') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Create a new role for a user.") }}
        </p>
    </header>

    <form method="POST" action="{{ route('roles.store') }}" class="mt-6 space-y-6">
        @csrf

        <div>
            <x-input-label for="role" :value="__('Name')" />
            <x-text-input id="role" name="role" type="text" class="mt-1 block w-full" :value="old('role')" required autofocus />
            <x-input-error class="mt-2" :messages="$errors->get('role')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'role-created')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
