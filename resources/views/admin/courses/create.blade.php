<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manage Courses</h2>
    </x-slot>

    <div class="py-8 max-w-5xl mx-auto sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @endif

        <a href="{{ route('admin.courses.create') }}"
           class="inline-block mb-4 px-4 py-2 bg-indigo-600 text-white rounded">+ Add Course</a>

        <div class="bg-white shadow rounded">
            <table class="w-full text-left">
                <thead class="border-b">
                    <tr>
                        <th class="p-3">Title</th>
                        <th class="p-3">Duration</th>
                        <th class="p-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($courses as $course)
                        <tr class="border-b">
                            <td class="p-3">{{ $course->title }}</td>
                            <td class="p-3">{{ $course->duration }}</td>
                            <td class="p-3 flex gap-3">
                                <a href="{{ route('admin.courses.edit', $course) }}" class="text-indigo-600">Edit</a>
                                <form method="POST" action="{{ route('admin.courses.destroy', $course) }}"
                                      onsubmit="return confirm('Delete this course?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="p-3">No courses yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>