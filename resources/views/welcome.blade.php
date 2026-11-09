<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Course Registration Portal</title>

    <!-- Bootstrap 5 CSS & Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <style>
        body { font-family: 'Figtree', sans-serif; background-color: #f8f9fa; }
        .hero-section { background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%); }
        .course-card { transition: transform 0.2s ease, box-shadow 0.2s ease; border-radius: 12px; }
        .course-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- Header Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark py-3 shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex items-center gap-2" href="{{ url('/') }}">
                <i class="bi bi-journal-bookmark-fill text-primary"></i> CoursePortal
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <div class="d-flex align-items-center gap-3">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn btn-outline-light btn-sm px-3 rounded-pill">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm px-3 rounded-pill">Admin Login</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-primary btn-sm px-3 rounded-pill">Register</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section Banner -->
    <div class="hero-section text-white py-5 mb-4 text-center">
        <div class="container py-4">
            <h1 class="display-5 fw-bold mb-3">Welcome to Course Registration Portal</h1>
            <p class="lead max-w-2xl mx-auto mb-4 opacity-90">Explore available courses, view details, and register for programs easily.</p>
            @guest
                <a href="{{ route('login') }}" class="btn btn-light btn-lg font-semibold text-primary px-4 shadow-sm rounded-pill">Admin Portal Login</a>
            @endguest
        </div>
    </div>

    <!-- Live Search Bar Section -->
    <div class="container mb-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <input type="text" id="courseSearch" class="form-control form-control-lg shadow-sm rounded-pill px-4" placeholder="🔍 Search courses by title...">
            </div>
        </div>
    </div>

    <!-- Main Container -->
    <main class="container flex-grow-1 mb-5">
        <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
            <h3 class="fw-bold text-dark m-0"><i class="bi bi-book text-primary me-2"></i>Available Courses</h3>
            <span class="badge bg-primary rounded-pill px-3 py-2">{{ count($courses ?? []) }} Courses Loaded</span>
        </div>

        <!-- Success/Error Flash Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Course Cards List -->
        <div class="row" id="courseList">
            @forelse($courses ?? [] as $course)
                <div class="col-md-4 mb-4 course-card-wrapper course-card">
                    <div class="card h-100 shadow-sm course-card-inner bg-white border-0">
                        <div class="card-body d-flex flex-column p-4">
                            <h5 class="card-title course-title fw-bold text-dark mb-2">{{ $course->title }}</h5>
                            <p class="card-text text-muted small flex-grow-1">{{ Str::limit($course->description, 120) }}</p>
                            
                            <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                                <span class="text-primary fw-bold fs-5">${{ number_format($course->price, 2) }}</span>
                                <button class="btn btn-outline-primary btn-sm px-3 rounded-pill" data-bs-toggle="modal" data-bs-target="#registerModal{{ $course->id }}">
                                    Register Now
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Registration Modal Popup per Course -->
                <div class="modal fade" id="registerModal{{ $course->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $course->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 shadow">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title fw-bold" id="modalLabel{{ $course->id }}">Register for {{ $course->title }}</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            
                            <form action="{{ route('courses.register', $course->id) }}" method="POST">
                                @csrf
                                <div class="modal-body p-4 text-start">
                                    <p class="text-muted small mb-3">{{ $course->description }}</p>
                                    
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold small">Full Name</label>
                                        <input type="text" name="name" class="form-control" required placeholder="Enter your full name">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold small">Email Address</label>
                                        <input type="email" name="email" class="form-control" required placeholder="Enter your email">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold small">Phone Number</label>
                                        <input type="text" name="phone" class="form-control" required placeholder="Enter phone number">
                                    </div>

                                    <div class="alert alert-info py-2 d-flex justify-content-between align-items-center mb-0">
                                        <span class="small">Course Fee:</span>
                                        <strong class="fs-6">${{ number_format($course->price, 2) }}</strong>
                                    </div>
                                </div>
                                <div class="modal-footer bg-light">
                                    <button type="button" class="btn btn-secondary btn-sm rounded-pill" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary btn-sm rounded-pill px-4">Confirm Registration</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="p-5 bg-white rounded-4 shadow-sm border">
                        <i class="bi bi-inbox text-muted display-4 d-block mb-3"></i>
                        <h4 class="fw-bold text-dark">No Courses Available Yet</h4>
                        <p class="text-muted">Courses added by the admin will automatically show up here.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-light py-4 text-center mt-auto border-top border-secondary">
        <div class="container">
            <p class="mb-0 small text-white-50">Course Registration Portal &copy; {{ date('Y') }} — Built with Laravel</p>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Live Search JavaScript -->
    <script>
        document.getElementById('courseSearch').addEventListener('keyup', function() {
            let query = this.value.toLowerCase();
            let cards = document.querySelectorAll('.course-card');

            cards.forEach(function(card) {
                let titleElement = card.querySelector('.course-title');
                if (titleElement) {
                    let title = titleElement.textContent.toLowerCase();
                    if (title.includes(query)) {
                        card.style.display = '';
                    } else {
                        card.style.display = 'none';
                    }
                }
            });
        });
    </script>
</body>
</html>