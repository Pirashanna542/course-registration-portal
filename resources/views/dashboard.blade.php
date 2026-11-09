<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Course Portal</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8fafc;
        }
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
        .card-stat {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s;
        }
        .card-stat:hover {
            transform: translateY(-3px);
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
                        <a href="{{ route('admin.dashboard') }}" class="active mb-2"><i class="fa-solid fa-house me-2"></i> Dashboard</a>
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
                    <h5 class="fw-bold mb-0 text-secondary">Dashboard Overview</h5>
                    <div>
                        <span class="fw-semibold text-dark me-2"><i class="fa-solid fa-user-shield me-1 text-primary"></i> {{ Auth::user()->name ?? 'Admin' }}</span>
                    </div>
                </div>

                <!-- Statistics Cards Row -->
                <div class="row g-4 mb-4">
                    <div class="col-md-4">
                        <a href="{{ route('admin.courses.index') }}" class="text-decoration-none">
                            <div class="card card-stat bg-white p-4 border-start border-primary border-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-muted small mb-1">Total Courses</p>
                                        <h3 class="fw-bold mb-0 text-dark">Manage</h3>
                                    </div>
                                    <div class="bg-primary bg-opacity-10 p-3 rounded-circle text-primary">
                                        <i class="fa-solid fa-book fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-stat bg-white p-4 border-start border-success border-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-muted small mb-1">System Status</p>
                                    <h3 class="fw-bold text-success mb-0">Active</h3>
                                </div>
                                <div class="bg-success bg-opacity-10 p-3 rounded-circle text-success">
                                    <i class="fa-solid fa-server fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-stat bg-white p-4 border-start border-warning border-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-muted small mb-1">Quick Action</p>
                                    <a href="{{ url('/') }}" class="btn btn-sm btn-dark mt-1">View Portal</a>
                                </div>
                                <div class="bg-warning bg-opacity-10 p-3 rounded-circle text-warning">
                                    <i class="fa-solid fa-bolt fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Welcome Section -->
                <div class="card border-0 shadow-sm p-5 text-center bg-white rounded-3">
                    <div class="mb-3">
                        <i class="fa-solid fa-circle-check text-success fa-3x"></i>
                    </div>
                    <h3 class="fw-bold text-dark">Welcome back, {{ Auth::user()->name ?? 'Admin' }}!</h3>
                    <p class="text-muted">You are successfully logged into the Course Portal admin control panel.</p>
                    <div class="mt-3">
                        <a href="{{ url('/') }}" class="btn btn-primary px-4 fw-bold">Explore Website</a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>