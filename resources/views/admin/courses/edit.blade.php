<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Course</h2>
    </x-slot>

    <div class="py-8 max-w-2xl mx-auto sm:px-6 lg:px-8">
        <form method="POST" action="{{ route('admin.courses.update', $course) }}" class="bg-white shadow rounded p-6 space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block mb-1">Title</label>
                <input type="text" name="title" value="{{ old('title', $course->title) }}" class="w-full border rounded p-2">
                @error('title') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block mb-1">Description</label>
                <textarea name="description" rows="4" class="w-full border rounded p-2">{{ old('description', $course->description) }}</textarea>
                @error('description') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block mb-1">Duration</label>
                <input type="text" name="duration" value="{{ old('duration', $course->duration) }}" class="w-full border rounded p-2">
                @error('duration') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="flex gap-3">
                <button class="px-4 py-2 bg-indigo-600 text-white rounded">Update</button>
                <a href="{{ route('admin.courses.index') }}" class="px-4 py-2 border rounded">Cancel</a>
            </div>
        </form>
    </div>
</x-app-layout>