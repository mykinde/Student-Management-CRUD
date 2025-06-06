<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Assign New Grade') }}
        </h2>
    </x-slot>

    <form method="POST" action="{{ route('grades.store') }}" class="mt-6 space-y-6">
        @csrf

        <div>
            <x-input-label for="student_id" :value="__('Student')" />
            <select id="student_id" name="student_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                <option value="">Select a Student</option>
                @foreach ($students as $student)
                    <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                        {{ $student->first_name }} {{ $student->last_name }} ({{ $student->email }})
                    </option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('student_id')" />
        </div>

        <div>
            <x-input-label for="course_id" :value="__('Course')" />
            <select id="course_id" name="course_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                <option value="">Select a Course</option>
                @foreach ($courses as $course)
                    <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                        {{ $course->name }} ({{ $course->code }})
                    </option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('course_id')" />
        </div>

        <div>
            <x-input-label for="grade" :value="__('Grade')" />
            <x-text-input id="grade" name="grade" type="text" class="mt-1 block w-full" :value="old('grade')" required autocomplete="grade" />
            <x-input-error class="mt-2" :messages="$errors->get('grade')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save Grade') }}</x-primary-button>
        </div>
    </form>
</x-app-layout>