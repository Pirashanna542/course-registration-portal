<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Registration Portal</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Course Portal</a>
            <div>
                @auth
                    <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-light btn-sm">Admin Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">Admin Login</a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <h1 class="mb-4 text-center">Available Courses</h1>

        <!-- Live Search Input -->
        <div class="mb-4">
            <input type="text" id="searchInput" class="form-control" placeholder="Search courses by title...">
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <!-- Course List -->
        <div class="row" id="courseList">
            @foreach($courses as $course)
                <div class="col-md-4 mb-4 course-card">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title course-title">{{ $course->title }}</h5>
                            <p class="card-text">{{ $course->description }}</p>
                            <p class="text-muted fw-bold">Price: ${{ $course->price }}</p>
                            
                            <!-- Registration Modal Trigger Button -->
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#registerModal{{ $course->id }}">Register Now</button>
                        </div>
                    </div>
                </div>

                <!-- Registration Modal -->
                <div class="modal fade" id="registerModal{{ $course->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <form action="{{ route('register.course', $course->id) }}" method="POST" class="modal-content">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title">Register for {{ $course->title }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email Address</label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Phone Number</label>
                                    <input type="text" name="phone" class="form-control" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">Submit Registration</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- JavaScript Feature: Live Search -->
    <script>
        document.getElementById('searchInput').addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();
            let cards = document.querySelectorAll('.course-card');

            cards.forEach(card => {
                let title = card.querySelector('.course-title').innerText.toLowerCase();
                if (title.includes(filter)) {
                    card.style.display = "";
                } else {
                    card.style.display = "none";
                }
            });
        });
    </script>
</body>
</html>