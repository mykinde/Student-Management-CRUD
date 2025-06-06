<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Grade Details') }}
        </h2>
    </x-slot>

    <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100">
                Grade for {{ $grade->student->first_name }} {{ $grade->student->last_name }} in {{ $grade->course->name }}
            </h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-400">
                Grade details.
            </p>
        </div>
        <div class="border-t border-gray-200 dark:border-gray-700">
            <dl>
                <div class="bg-gray-50 dark:bg-gray-700 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">
                        Student Name
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">
                        {{ $grade->student->first_name }} {{ $grade->student->last_name }}
                    </dd>
                </div>
                <div class="bg-white dark:bg-gray-800 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">
                        Course Name
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">
                        {{ $grade->course->name }} ({{ $grade->course->code }})
                    </dd>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">
                        Grade
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">
                        {{ $grade->grade }}
                    </dd>
                </div>
            </dl>
        </div>
    </div>
</x-app-layout>