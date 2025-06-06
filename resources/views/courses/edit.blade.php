<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Course') }}
        </h2>
    </x-slot>

    <form method="POST" action="{{ route('courses.update', $course) }}" class="mt-6 space-y-6">
        @csrf
        @method('PUT')

        <div>
            <x-input-label for="name" :value="__('Course Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $course->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="code" :value="__('Course Code')" />
            <x-text-input id="code" name="code" type="text" class="mt-1 block w-full" :value="old('code', $course->code)" required autocomplete="code" />
            <x-input-error class="mt-2" :messages="$errors->get('code')" />
        </div>

        <div>
            <x-input-label for="description" :value="__('Description (Optional)')" />
            <textarea id="description" name="description" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('description', $course->description) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('description')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Update Course') }}</x-primary-button>
        </div>
    </form>
</x-app-layout>