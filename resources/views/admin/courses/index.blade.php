<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Courses - Course Portal</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f8fafc; }
        .sidebar {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            min-height: 100vh;
            color: white;
        }
        .sidebar a {
            color: #94a3b8;
            text-decoration: none;
            padding: 12px 20px;
            display: block;
            border-radius: 8px;
            margin-bottom: 5px;
            transition: all 0.3s;
        }
        .sidebar a:hover, .sidebar a.active {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar p-4 d-none d-md-flex flex-column justify-content-between">
                <div>
                    <h4 class="fw-bold mb-4 text-white"><i class="fa-solid fa-graduation-cap me-2 text-primary"></i>Portal Admin</h4>
                    <hr class="border-secondary mb-4">
                    <nav class="nav flex-column">
                        <a href="{{ route('admin.dashboard') }}" class="mb-2"><i class="fa-solid fa-house me-2"></i> Dashboard</a>
                        <a href="{{ route('admin.courses.index') }}" class="active mb-2"><i class="fa-solid fa-book me-2"></i> Courses</a>
                        <a href="{{ url('/') }}" target="_blank" class="mb-2"><i class="fa-solid fa-globe me-2"></i> Visit Website</a>
                    </nav>
                </div>
                <div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger w-100 btn-sm py-2">
                            <i class="fa-solid fa-right-from-bracket me-2"></i> Logout
                        </button>
                    </form>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="col-md-9 col-lg-10 p-4">
                <!-- Top Header Bar -->
                <div class="d-flex justify-content-between align-items-center bg-white p-3 rounded-3 shadow-sm mb-4">
                    <h5 class="fw-bold mb-0 text-secondary">Manage Courses</h5>
                    <a href="{{ route('admin.courses.create') }}" class="btn btn-primary btn-sm fw-bold px-3">
                        <i class="fa-solid fa-plus me-1"></i> Add New Course
                    </a>
                </div>

                <!-- Success Alert Message -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show small" role="alert">
                        <i class="fa-solid fa-circle-check me-1"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Courses Table Card -->
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="py-3">ID</th>
                                        <th class="py-3">Title</th>
                                        <th class="py-3">Price</th>
                                        <th class="py-3">Created At</th>
                                        <th class="py-3 text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($courses as $course)
                                        <tr>
                                            <td class="fw-semibold">#{{ $course->id }}</td>
                                            <td>{{ $course->title }}</td>
                                            <td class="text-success fw-bold">${{ number_format($course->price, 2) }}</td>
                                            <td class="text-muted small">{{ $course->created_at->format('M d, Y') }}</td>
                                            <td class="text-end">
                                                <a href="{{ route('admin.courses.edit', $course->id) }}" class="btn btn-sm btn-outline-primary me-1">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </a>
                                                <form action="{{ route('admin.courses.destroy', $course->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this course?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4 text-muted">
                                                <i class="fa-solid fa-folder-open fa-2x mb-2 d-block text-secondary opacity-50"></i>
                                                No courses found. Click on "Add New Course" to create one!
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>