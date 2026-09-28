<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Superadmin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        /* Complete CSS from previous response */
        body {
            padding-top: 56px; /* Adjust this value to match your navbar height */
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
        }
        
        #mainContent {
            flex: 1; /* Makes the main content take up all available space */
            transition: margin-left 0.3s ease;
        }
        
        .sidebar {
            background-color: #0D47A1; /* Bright blue */
            color: #ffffff;
            min-height: 100vh;
            transition: transform 0.3s ease, width 0.3s ease;
            width: 220px;
            overflow-x: hidden;
            position: fixed;
            top: 0;
            left: 0;
            transform: translateX(0);
        }
        
        .sidebar.hidden {
            transform: translateX(-100%);
        }
        
        .sidebar .nav-item {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .sidebar a {
            display: block;
            padding: 15px;
            text-decoration: none;
            color: white;
        }
        
        .sidebar a:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }
        
        .sidebar-toggle {
            color: white; /* Text color */
            background-color: transparent; /* Match sidebar background */
            border: none; /* Remove border */
            padding: 10px; /* Add some padding */
        }

        .sidebar-toggle:hover {
            background-color: rgba(255, 255, 255, 0.2); /* Similar hover effect to sidebar links */
        }
        
        .content {
            margin-left: 260px; /* Offset for the sidebar */
            padding: 20px;
        }
        
        .footer {
            font-size: 1rem; /* Small text */
            padding: 5px 0; /* Thin padding */
            background-color: #343a40; /* Dark background */
            color: #ffffff; /* White text */
        }
        
        .nav-link {
            font-weight: 500;
            cursor: pointer;
        }
        
        .main-content {
            margin-left: 18rem; /* Adjust to match sidebar width */
            min-height: 100vh;
            padding: 2rem;
            transition: margin-left 0.3s ease;
        }
        
        .card-title {
            font-size: 1.2rem;
            font-weight: bold;
        }
        
        .fs-2 {
            font-size: 2.5rem;
            font-weight: bold;
        }
        
        #searchButton {
            background-color: #6c757d; /* Grey background */
            border-color: #6c757d; /* Grey border */
            color: white;
            transition: background-color 0.3s, border-color 0.3s;
            width: 50px; /* Adjust the width as needed */
        }
        
        #searchButton:hover {
            background-color: #0056b3; /* Darker grey for hover effect */
            border-color: #0056b3; /* Darker grey for hover effect */
        }
        
        .navbar {
            background-color: #0D47A1 !important;
            color: #ffffff;
        }
        
        .highlight {
            background-color: #ffeb3b; /* Yellow background for highlight */
            transition: background-color 0.3s ease;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                width: 60px; /* Reduced width for mobile */
                overflow: hidden; /* Prevents overflow */
            }
            
            .sidebar.hidden {
                transform: translateX(-100%);
            }
            
            .main-content {
                margin-left: 0; /* Center main content on small screens */
            }
        }
        
        .main-content.centered {
            margin-left: auto;
            margin-right: auto;
        }
</style>
</head>
<body class="bg-light">
    <!-- Navigation Bar -->   
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top custom-navbar-blue">
    <div class="container-fluid">
        <a class="navbar-brand me-2" href="#">SuperAdmin</a>
        <button class="btn sidebar-toggle" data-bs-toggle="collapse" data-bs-target="#sidebar" aria-expanded="false" aria-controls="sidebar">
            <i class="bi bi-list"></i>
        </button>

        <!-- Centered Search Bar -->
        <div class="mx-auto" style="width: 50%;">
            <div class="input-group">
                <input type="text" class="form-control" id="searchInput" placeholder="Search...">
                <button class="btn btn-primary px-2" id="searchButton" type="button">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </div>

        <!-- Right-aligned Content -->
        <div class="d-flex align-items-center ms-auto">
            <!-- Notifications -->
            <div class="dropdown me-3">
                <button class="btn btn-secondary position-relative" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-bell"></i>
                    <span id="notifCount" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger d-none">
                        0
                        <span class="visually-hidden">unread notifications</span>
                    </span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" id="notifList">
                    <li><span class="dropdown-item text-muted">Loading...</span></li>
                </ul>
            </div>


            <!-- Profile Dropdown -->
            <div class="dropdown">
                  <i class="bi bi-person-circle" style="font-size: 30px; color: #6c757d; cursor: pointer;" data-bs-toggle="dropdown" aria-expanded="false"></i>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                    <!-- View Profile -->
                    <li>
                        <a href="#" class="dropdown-item" onclick="loadViewProfile()">
                            <i class="bi bi-person"></i> View Profile
                        </a>
                    </li>
                    <!-- Sign Out -->
                    <li>
                        <a href="<?php echo base_url('/login'); ?>" class="dropdown-item text-danger">
                            <i class="bi bi-box-arrow-right"></i> Sign Out
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>


   <nav class="col-auto col-md-3 col-lg-2 sidebar collapse show px-0 text-white" id="sidebar" style="position: fixed; top: 56px; left: 0; height: calc(100vh - 56px); overflow-y: auto;">
            <ul class="nav flex-column text-white" id="sidebarMenu">
                <li class="nav-item">
                    <a class="nav-link text-white" onclick="loadDashboard()">
                        <i class="bi bi-house-door me-2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" onclick="loadManageUsers()">
                        <i class="bi bi-people me-2"></i> Users
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" onclick="loadManageCases()">
                        <i class="bi bi-folder me-2"></i> Cases
                    </a>
                </li>
                    <li class="nav-item">
                    <a class="nav-link text-white" href="#" onclick="loadSuperadminReports();">
                        <i class="bi bi-bar-chart-fill"></i> Reports
                    </a>
                </li>
                 <li class="nav-item">
                    <a class="nav-link text-white" onclick="loadAccessLogs()">
                        <i class="bi bi-clock-history me-2"></i> Access Logs 
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" onclick="loadSystemSettings()">
                        <i class="bi bi-gear me-2"></i> Settings
                    </a>
                </li>
               
            </ul>
        </nav>

          <!-- Main Content -->
<main class="col-md-9 col-lg-10 ms-auto px-4 py-4 main-content" id="mainContent">
    <!-- Theme Wrapper starts here -->
    <div id="themeWrapper" class="rounded-3 p-2">
        <div class="row g-4 mt-4" id="dashboardContent">
            <div class="col-md-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">Total Users</h5>
                        <p class="card-text fs-2 text-primary"><?= esc($totalUsers); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">Admins</h5>
                        <p class="card-text fs-2 text-success"><?= esc($totalAdmins); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">Officers</h5>
                        <p class="card-text fs-2 text-warning"><?= esc($totalOfficers); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Theme Wrapper ends here -->
</main>


    <!-- Edit Profile Modal -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editProfileForm" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="profileUserId" name="userId">

                    <!-- Basic Personal Information -->
                    <h6>Basic Personal Information</h6>
                    <div class="mb-3">
                        <label for="profileName" class="form-label">Full Name</label>
                        <input type="text" id="profileName" name="name" class="form-control" placeholder="Enter your full name" required>
                    </div>
                    <div class="mb-3">
                        <label for="profilePicture" class="form-label">Profile Picture</label>
                        <input type="file" id="profilePicture" name="profilePicture" class="form-control" accept="image/*">
                    </div>
                    <img id="profilePreview" class="img-thumbnail mt-3" alt="Profile Picture Preview" style="display: none; max-height: 150px;">
                    <div class="mb-3">
                        <label for="profileDOB" class="form-label">Date of Birth</label>
                        <input type="date" id="profileDOB" name="date_of_birth" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="profileGender" class="form-label">Gender</label>
                        <select id="profileGender" name="gender" class="form-select">
                            <option value="">Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <!-- Contact Information -->
                    <h6>Contact Information</h6>
                    <div class="mb-3">
                        <label for="profileEmail" class="form-label">Email Address</label>
                        <input type="email" id="profileEmail" name="email" class="form-control" placeholder="Enter your email" required>
                    </div>
                    <div class="mb-3">
                        <label for="profilePhone" class="form-label">Phone Number</label>
                        <input type="tel" id="profilePhone" name="phone_number" class="form-control" placeholder="Enter your phone number" required>
                    </div>
                    <div class="mb-3">
                        <label for="profileAddress" class="form-label">Address</label>
                        <textarea id="profileAddress" name="address" class="form-control" rows="2" placeholder="Enter your address"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="profileEmergencyContact" class="form-label">Emergency Contact</label>
                        <input type="tel" id="profileEmergencyContact" name="emergency_contact" class="form-control" placeholder="Enter emergency contact number" required>
                    </div>

                    <!-- region -->
                    <h6>User Region</h6>                    
                    <div class="mb-3">
                        <label for="profileRegion" class="form-label">Region</label>
                        <input type="text" id="profileRegion" name="region" class="form-control" placeholder="Enter your region" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

    <!-- Add User Modal -->
<div class="modal fade" id="registerUserModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Register User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="registerUserForm">
                    <!-- Full Name -->
                    <div class="mb-3">
                        <label for="name">Full Name</label>
                        <input type="text" id="name" name="name" class="form-control" required>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>

                    <!-- County -->
                    <div class="mb-3">
                        <label for="county" class="form-label">County</label>
                        <select id="county" name="county" class="form-control" required>
                            <option value="">-- Select County --</option>
                            <?php foreach ($counties as $county): ?>
                                <option value="<?= esc($county['name']) ?>"><?= esc($county['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Region -->
                    <div class="mb-3">
                    <label for="region" class="form-label">Region</label>
                    <select id="region" name="region" class="form-control" required>
                        <option value="">-- Select Region --</option>
                        <?php foreach ($regions as $region): ?>
                            <option value="<?= esc($region['name']) ?>"><?= esc($region['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>


                    <!-- Role -->
                    <div class="mb-3">
                        <label for="role">User Role</label>
                        <select id="role" name="role" class="form-select" required>
                            <option value="superadmin">Super Admin</option>
                            <option value="admin">Admin</option>
                            <option value="officer">Officer</option>
                        </select>
                    </div>

                    <!-- Status -->
                    <div class="mb-3">
                        <label for="status">Status</label>
                        <select id="status" name="status" class="form-select" required>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Register</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- view User Details Modal -->
<div class="modal fade" id="viewUserModal" tabindex="-1" aria-labelledby="viewUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewUserModalLabel">View User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <input type="hidden" id="userId">
                    <div class="mb-3">
                        <label for="userName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="userName" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="userEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="userEmail" readonly>
                    </div>
                     <div class="mb-3">
                        <label for="userCounty" class="form-label">County</label>
                        <input type="county" class="form-control" id="userCounty" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="userRegion" class="form-label">Region</label>
                        <input type="region" class="form-control" id="userRegion" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="userRole" class="form-label">Role</label>
                        <input type="text" class="form-control" id="userRole" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="userStatus" class="form-label">Status</label>
                        <input type="text" class="form-control" id="userStatus" readonly>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editUserForm">
                    <input type="hidden" id="editUserId" name="id">
                    <div class="mb-3">
                        <label for="editUserName" class="form-label">Name</label>
                        <input type="text" id="editUserName" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="editUserEmail" class="form-label">Email</label>
                        <input type="email" id="editUserEmail" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="editUserCounty" class="form-label">County</label>
                        <select id="editUserCounty" name="county" class="form-control" required>
                            <option value="">-- Select County --</option>
                            <?php foreach ($counties as $county): ?>
                                <option value="<?= esc($county['name']) ?>"><?= esc($county['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editUserRegion" class="form-label">Region</label>
                        <select id="editUserRegion" name="region" class="form-control" required>
                            <option value="">-- Select Region --</option>
                            <?php foreach ($regions as $region): ?>
                                <option value="<?= esc($region['name']) ?>"><?= esc($region['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editUserRole" class="form-label">Role</label>
                        <select id="editUserRole" name="role" class="form-control" required>
                            <option value="superadmin">Superadmin</option>
                            <option value="admin">Admin</option>
                            <option value="officer">Officer</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editUserStatus" class="form-label">Status</label>
                        <select id="editUserStatus" name="status" class="form-control" required>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Add Case Modal -->
<div class="modal fade" id="addCaseModal" tabindex="-1" aria-labelledby="addCaseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCaseModalLabel">Add Case</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Success/Error Message -->
                <div id="addCaseMessage"></div>

                <form id="addCaseForm">
                    <div class="mb-3">
                        <label for="id" class="form-label">Case ID</label>
                        <input type="text" id="id" name="id" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="title" class="form-label">Case Title</label>
                        <input type="text" id="title" name="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="complainant" class="form-label">Complainant Name</label>
                        <input type="text" id="complainant" name="complainant" class="form-control" required>
                    </div>
                    <div class="mb-3">
                         <label for="id_no" class="form-label">ID No:</label>
                        <input type="text" id="id_no" name="id_no" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea id="description" name="description" class="form-control" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="county" class="form-label">County</label>
                        <select id="county" name="county" class="form-control" required>
                            <option value="">-- Select County --</option>
                            <?php foreach ($counties as $county): ?>
                                <option value="<?= esc($county['name']) ?>"><?= esc($county['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="region" class="form-label">Region <span class="text-danger">*</span></label>
                        <select id="region" name="region" class="form-select" required>
                            <option value="" disabled selected>-- Select Region --</option>
                            <?php if (!empty($regions) && is_array($regions)): ?>
                                <?php foreach ($regions as $region): ?>
                                    <option value="<?= esc($region['name']) ?>">
                                        <?= esc($region['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option value="">No regions available</option>
                            <?php endif; ?>
                        </select>
                    </div>


                    <div class="mb-3">
                        <label for="uploads" class="form-label">Upload Document</label>
                        <input type="file" id="uploads" name="uploads" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="officer_id" class="form-label">Assign to Officer</label>
                        <select id="officer_id" name="officer_id" class="form-select" required>
                            <option value="" disabled selected>Select an officer</option>
                            <?php if (!empty($officers)): ?>
                                <?php foreach ($officers as $officer): ?>
                                    <option value="<?= esc($officer['id']); ?>"><?= esc($officer['name']); ?></option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option value="" disabled>No officers available</option>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Case Status</label>
                        <select id="status" name="status" class="form-select" required>
                            <option value="open" selected>Open</option>
                            <option value="closed">Closed</option>
                        </select>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Add Case</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--  Modal for editing Case -->
<div class="modal fade" id="editCaseModal" tabindex="-1" aria-labelledby="editCaseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCaseModalLabel">Edit Case</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editCaseForm">
                    <input type="hidden" id="editCaseId" name="id">
                    <div class="mb-3">
                        <label for="editCaseTitle" class="form-label">Case Title</label>
                        <input type="text" id="editCaseTitle" name="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="editCaseDescription" class="form-label">Description</label>
                        <textarea id="editCaseDescription" name="description" class="form-control" rows="4" required></textarea>
                    </div>                   
                    <div class="mb-3">
                        <label for="editCaseCounty" class="form-label">County</label>
                        <select id="editCaseCounty" name="county" class="form-control" required>
                            <option value="">-- Select County --</option>
                            <?php foreach ($counties as $county): ?>
                                <option value="<?= esc($county['name']) ?>"><?= esc($county['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editCaseRegion" class="form-label">Region</label>
                        <select id="editCaseRegion" name="region" class="form-control" required>
                            <option value="">-- Select Region --</option>
                            <?php foreach ($regions as $region): ?>
                                <option value="<?= esc($region['name']) ?>"><?= esc($region['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editCaseIdNo" class="form-label">ID No:</label>
                        <input type="text" id="editCaseIdNo" name="id_no" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="editCaseComplainant" class="form-label">Complainant</label>
                        <input type="text" id="editCaseComplainant" name="complainant" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="editCaseOfficer" class="form-label">Assigned Officer</label>
                        <select id="editCaseOfficer" name="officer_id" class="form-select" required>
                            <option value="" disabled>Select an officer</option>
                            <?php foreach ($officers as $officer): ?>
                                <option value="<?= esc($officer['id']); ?>"><?= esc($officer['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editCaseStatus" class="form-label">Status</label>
                        <select id="editCaseStatus" name="status" class="form-select" required>
                            <option value="open">Open</option>
                            <option value="closed">Closed</option>
                        </select>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Update Case</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Viewing Case -->
<div class="modal fade" id="viewCaseModal" tabindex="-1" aria-labelledby="viewCaseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewCaseModalLabel">Case Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="caseId" class="form-label">Case ID</label>
                        <input type="text" id="caseId" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="caseTitle" class="form-label">Case Title</label>
                        <input type="text" id="caseTitle" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="caseDescription" class="form-label">Description</label>
                        <textarea id="caseDescription" class="form-control" rows="4" readonly></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="caseCounty" class="form-label">County</label>
                        <input type="text" id="caseCounty" class="form-control" readonly>
                    </div> 
                    <div class="mb-3">
                        <label for="caseRegion" class="form-label">Region</label>
                        <input type="text" id="caseRegion" class="form-control" disabled>
                    </div>                  
                    <div class="mb-3">
                        <label for="caseId_no" class="form-label">ID No:</label>
                        <input type="text" id="caseId_no" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="caseComplainant" class="form-label">Complainant</label>
                        <input type="text" id="caseComplainant" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="caseUploads" class="form-label">Uploaded Document</label>
                        <input type="text" id="caseUploads" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="caseOfficer" class="form-label">Assigned Officer</label>
                        <input type="text" id="caseOfficer" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="caseStatus" class="form-label">Status</label>
                        <input type="text" id="caseStatus" class="form-control" readonly>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
  <!-- Static Footer -->
  <footer class="footer bg-dark text-white text-center">
        <div class="container py-2">
            <small>&copy; 2025 Case Management System | Version 1.0.0 | Superadmin Dashboard</small>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
      document.addEventListener('DOMContentLoaded', () => {
        const sidebarLinks = document.querySelectorAll('.sidebar a');
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        const toggleButton = document.querySelector('.sidebar-toggle');

        // Function to load content based on the link clicked
        sidebarLinks.forEach(link => {
            link.addEventListener('click', (event) => {
                event.preventDefault(); // Prevent default link action

                // Optionally load content dynamically
                const section = event.target.getAttribute('onclick');
                if (section) {
                    eval(section); // Call the corresponding function to load the content
                }

                // Ensure the sidebar stays visible and content is centered
                mainContent.classList.remove('centered'); // Remove centering
            });
        });

        toggleButton.addEventListener('click', () => {
            const isHidden = sidebar.classList.toggle('hidden'); // Toggle sidebar visibility
            mainContent.classList.toggle('centered', isHidden); // Center main content if sidebar is hidden
        });
    });
    document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('searchInput');

    // Listen for the "Enter" key press
    searchInput.addEventListener('keypress', (event) => {
        if (event.key === 'Enter') {
            performSearch();
        }
    });
});
  function performSearch() {
    const query = document.getElementById('searchInput').value.trim();
    const resultsContainer = document.getElementById('mainContent');

    // Show a loading spinner
    resultsContainer.innerHTML = `<div class="text-center"><span class="spinner-border" role="status"></span> Searching...</div>`;

    fetch(`http://localhost/dashboardsearch?query=${encodeURIComponent(query)}`)
        .then((response) => response.json())
        .then((data) => {
            if (data.status === 200) {
                const results = data.results;
                let resultsHtml = `<h3>Search Results</h3>`;

                if (results.length > 0) {
                    resultsHtml += `
                        <table class="table table-hover table-bordered" id="resultsTable">
                            <thead class="table-primary">
                                <tr>
                                    <th>Type</th>
                                    <th>Title/Name</th>
                                    <th>Description/Details</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${results
                                    .map((result, index) => `
                                        <tr id="row-${index}">
                                            <td>${result.type}</td>
                                            <td>${result.title || result.name}</td>
                                            <td>${result.description || result.details}</td>
                                            <td>
                                                <button class="btn btn-sm btn-info" onclick="navigateToSection('${result.type}', '${result.id}', 'row-${index}')">
                                                    View Details
                                                </button>
                                            </td>
                                        </tr>
                                    `)
                                    .join('')}
                            </tbody>
                        </table>
                    `;
                } else {
                    resultsHtml += `<p class="text-muted">No results found.</p>`;
                }

                resultsContainer.innerHTML = resultsHtml;
            } else {
                resultsContainer.innerHTML = `<div class="alert alert-warning">${data.message}</div>`;
            }
        })
        .catch((error) => {
            resultsContainer.innerHTML = `<div class="alert alert-danger">Failed to search. Please try again later.</div>`;
            console.error('Search error:', error);
        });
}

function navigateToSection(type, id, rowId) {
    // Highlight the clicked row
    highlightRow(rowId);

    // Navigate based on the type
    switch (type.toLowerCase()) {
        case 'case':
            loadManageCases(id); // Navigate to a specific case
            break;
        case 'user':
            loadManageUsers(id); // Navigate to a specific user
            break;
        case 'task':
            loadManageTasks(id); // Navigate to a specific task
            break;
        case 'notification':
            loadManageNotifications(id); // Navigate to a specific notification
            break;
        default:
            alert('Invalid section type or no matching section found.');
            console.warn(`Unhandled type: ${type}`);
    }
}

function highlightRow(rowId) {
    // Remove highlight from all rows
    const rows = document.querySelectorAll('#resultsTable tbody tr');
    rows.forEach((row) => row.classList.remove('highlight'));

    // Add highlight to the specific row
    const selectedRow = document.getElementById(rowId);
    if (selectedRow) {
        selectedRow.classList.add('highlight');
    } else {
        console.error(`Row with ID ${rowId} not found.`);
    }
}

// Placeholder functions for additional section types
function loadManageTasks(id) {
    console.log(`Loading task with ID: ${id}`);
}

function loadManageNotifications(id) {
    console.log(`Loading notification with ID: ${id}`);
}


// Attach search button click event
document.getElementById('searchButton').addEventListener('click', performSearch);


         // Add User Form Submission
 document.getElementById('registerUserForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch('http://localhost/users/register', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message || 'User registered successfully!');
            console.log('User registered successfully');

            // Reset form
            document.getElementById('registerUserForm').reset();

            // Close modal (if using Bootstrap modal)
            const modal = bootstrap.Modal.getInstance(document.getElementById('registerUserModal'));
            modal.hide();

            // Reload user list dynamically
            loadManageUsers();
        } else {
            console.error('Registration Error:', data.errors || data.message);
            alert(data.errors ? Object.values(data.errors).join('\n') : data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An unexpected error occurred.');
    });
});

    // Add Case Form Submission
   document.getElementById('addCaseForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    const messageDiv = document.getElementById('addCaseMessage');

    fetch('<?= base_url('store_case'); ?>', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest', // Important for CodeIgniter 4 AJAX detection
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            messageDiv.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
            this.reset();

            // Close Bootstrap modal if it exists
            const modalEl = document.getElementById('addCaseModal');
            if (modalEl) {
                const modal = bootstrap.Modal.getInstance(modalEl);
                if (modal) modal.hide();
            }

            // Reload the case list dynamically
            if (typeof loadManageCases === 'function') {
                loadManageCases(); // <-- your dynamic reloader
            }
        } else {
            messageDiv.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        messageDiv.innerHTML = `<div class="alert alert-danger">An unexpected error occurred.</div>`;
    });
});

       function loadDashboard() {
    const mainContent = document.getElementById('mainContent');
    mainContent.innerHTML = `
        <div class="container mt-4">         

            <!-- Statistics Cards -->
<div class="row g-3">
    <div class="col-md-3 col-sm-6">
        <div class="card shadow-sm border-0" style="background: linear-gradient(135deg, #007bff, #0056b3); color: white;">
            <div class="card-body p-3 d-flex flex-column align-items-center justify-content-center">
                <i class="bi bi-people-fill mb-2" style="font-size: 2rem;"></i>
                <h6 class="text-light mb-1 small">Total Users</h6>
                <h4 class="fw-bold mb-0"><?= esc($totalUsers); ?></h4>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card shadow-sm border-0" style="background: linear-gradient(135deg, #28a745, #1e7e34); color: white;">
            <div class="card-body p-3 d-flex flex-column align-items-center justify-content-center">
                <i class="bi bi-person-badge-fill mb-2" style="font-size: 2rem;"></i>
                <h6 class="text-light mb-1 small">Admins</h6>
                <h4 class="fw-bold mb-0"><?= esc($totalAdmins); ?></h4>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card shadow-sm border-0" style="background: linear-gradient(135deg, #ffc107, #e0a800); color: black;">
            <div class="card-body p-3 d-flex flex-column align-items-center justify-content-center">
                <i class="bi bi-shield-fill mb-2" style="font-size: 2rem;"></i>
                <h6 class="text-dark mb-1 small">Officers</h6>
                <h4 class="fw-bold mb-0"><?= esc($totalOfficers); ?></h4>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card shadow-sm border-0" style="background: linear-gradient(135deg, #17a2b8, #117a8b); color: white;">
            <div class="card-body p-3 d-flex flex-column align-items-center justify-content-center">
                <i class="bi bi-file-earmark-text-fill mb-2" style="font-size: 2rem;"></i>
                <h6 class="text-light mb-1 small">Total Cases</h6>
                <h4 class="fw-bold mb-0"><?= esc($totalCases); ?></h4>
            </div>
        </div>
    </div>
</div>

<!-- Open and Closed Cases -->
<div class="row g-3 mt-3">
    <div class="col-md-6">
        <div class="card shadow-sm border-0" style="background: linear-gradient(135deg, #e3f2fd, #bbdefb); color: #007bff;">
            <div class="card-body p-3 d-flex flex-column align-items-center justify-content-center">
                <i class="bi bi-folder-symlink mb-2" style="font-size: 2rem;"></i>
                <h6 class="text-muted mb-1 small">Open Cases</h6>
                <h4 class="fw-bold mb-0"><?= esc($openCases); ?></h4>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow-sm border-0" style="background: linear-gradient(135deg, #f8d7da, #f5c6cb); color: #dc3545;">
            <div class="card-body p-3 d-flex flex-column align-items-center justify-content-center">
                <i class="bi bi-folder-check mb-2" style="font-size: 2rem;"></i>
                <h6 class="text-muted mb-1 small">Closed Cases</h6>
                <h4 class="fw-bold mb-0"><?= esc($closedCases); ?></h4>
            </div>
        </div>
    </div>
</div>

<!-- Cases by Region Table -->
<h4 class="mt-4">📍 Cases by Region</h4>
<div class="table-responsive">
    <table class="table table-bordered table-striped mt-3">
        <thead class="table-light">
            <tr>
                <th>Region</th>
                <th>Total Cases</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($casesPerRegion)): ?>
                <?php foreach ($casesPerRegion as $row): ?>
                    <tr>
                        <td><?= esc($row['region']) ?></td>
                        <td><?= esc($row['total']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="2" class="text-center">No data found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Recent Cases -->
<div class="mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h6 class="mb-0">Recent Cases Overview</h6>
        </div>
        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle">
                <thead style="background-color: #007bff; color: white;">
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Date Created</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($recentCases)): ?>
                        <?php foreach ($recentCases as $case): ?>
                            <tr>
                                <td class="fw-bold text-dark"><?= esc($case['title']); ?></td>
                                <td class="text-muted"><?= esc($case['description']); ?></td>
                                <td>
                                    <span class="badge <?= $case['status'] === 'open' ? 'bg-success' : 'bg-secondary'; ?>">
                                        <?= ucfirst(esc($case['status'])); ?>
                                    </span>
                                </td>
                                <td class="text-muted"><?= date('d M Y', strtotime($case['created_at'])); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted">No recent cases available.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

    `;
}

document.addEventListener('DOMContentLoaded', () => {
    loadDashboard();
});

function loadSystemSettings() {
    const mainContent = document.getElementById('mainContent');
    mainContent.innerHTML = `
        <div class="text-center my-5">
            <div class="spinner-border text-primary" role="status"></div>
            <div>Loading Settings...</div>
        </div>
    `;

    fetch('http://localhost/settings/fetchSettings')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const settings = data.data;

                let settingsHTML = `
                    <div class="card shadow-sm">
                        <div class="card-header d-flex justify-content-between align-items-center bg-light">
                            <h5 class="mb-0">⚙️ System Settings</h5>
                            <button type="button" class="btn btn-outline-danger btn-sm" id="resetDefaultsBtn">
                                <i class="bi bi-arrow-clockwise"></i> Reset to Defaults
                            </button>
                        </div>
                        <div class="card-body">
                            <form id="systemSettingsForm">
                                <div class="row g-4">
                `;

                settings.forEach(setting => {
                    let inputField = '';
                    let preview = '';

                    if (setting.type === 'boolean') {
                        inputField = `
                            <select class="form-select" id="${setting.key_name}" name="${setting.key_name}">
                                <option value="1" ${setting.value == '1' ? 'selected' : ''}>Yes</option>
                                <option value="0" ${setting.value == '0' ? 'selected' : ''}>No</option>
                            </select>
                        `;
                    } else if (setting.type === 'select') {
                        const options = setting.options ? setting.options.split(',') : [];
                        inputField = `
                            <select class="form-select" id="${setting.key_name}" name="${setting.key_name}">
                                ${options.map(opt => `
                                    <option value="${opt}" ${setting.value === opt ? 'selected' : ''}>${opt}</option>
                                `).join('')}
                            </select>
                        `;
                    } else {
                        inputField = `
                            <input type="${setting.type}" class="form-control" id="${setting.key_name}" 
                                   name="${setting.key_name}" value="${setting.value || ''}" required>
                        `;

                        if (setting.key_name === 'site_name') {
                            preview = `
                                <div class="form-text text-info">
                                    Live Preview: <strong id="preview_site_name">${setting.value}</strong>
                                </div>
                            `;
                        }
                    }

                    settingsHTML += `
                        <div class="col-md-6">
                            <label for="${setting.key_name}" class="form-label">
                                ${setting.key_name.replaceAll('_', ' ').toUpperCase()}
                            </label>
                            ${inputField}
                            ${preview}
                            <div class="form-text">${setting.description || ''}</div>
                        </div>
                    `;
                });

                settingsHTML += `
                                </div>
                                <div class="mt-4 text-end">
                                    <button type="submit" class="btn btn-primary" id="saveSettingsBtn">
                                        <i class="bi bi-save"></i> Save Settings
                                    </button>
                                </div>
                            </form>
                            <div id="formMessage" class="mt-3"></div>
                        </div>
                    </div>
                `;

                mainContent.innerHTML = settingsHTML;

                // Live Preview for site_name
                const siteNameInput = document.getElementById('site_name');
                if (siteNameInput) {
                    siteNameInput.addEventListener('input', () => {
                        document.getElementById('preview_site_name').textContent = siteNameInput.value;
                    });
                }

                // Reset to Defaults Button
                const resetBtn = document.getElementById('resetDefaultsBtn');
                resetBtn.addEventListener('click', () => {
                    if (confirm('Are you sure you want to reset all settings to default values?')) {
                        fetch('http://localhost/settings/resetDefaults', {
                            method: 'POST',
                        })
                        .then(res => res.json())
                        .then(data => {
                            alert(data.message || '✅ Settings reset to defaults.');
                            if (data.success) loadSystemSettings();
                        })
                        .catch(error => {
                            console.error('Reset error:', error);
                            alert('⚠️ Error resetting settings.');
                        });
                    }
                });
                                // Apply Theme Based on Saved Setting
                const themeSelect = document.getElementById('theme_mode');
                if (themeSelect) {
                    applyTheme(themeSelect.value); // Apply immediately

                    // Listen for changes and update theme live
                    themeSelect.addEventListener('change', function () {
                        applyTheme(this.value);
                    });
                }


                // Submit Form
                document.getElementById('systemSettingsForm').addEventListener('submit', function (e) {
                    e.preventDefault();

                    const formData = new FormData(this);
                    const saveBtn = document.getElementById('saveSettingsBtn');
                    const msgDiv = document.getElementById('formMessage');

                    saveBtn.disabled = true;
                    saveBtn.innerHTML = `<span class="spinner-border spinner-border-sm me-2"></span>Saving...`;

                    fetch('http://localhost/settings/updateSettings', {
                        method: 'POST',
                        body: formData,
                    })
                    .then(response => response.json())
                    .then(data => {
                        saveBtn.disabled = false;
                        saveBtn.innerHTML = `<i class="bi bi-save"></i> Save Settings`;

                        msgDiv.innerHTML = `
                            <div class="alert alert-${data.success ? 'success' : 'danger'}" role="alert">
                                ${data.message}
                            </div>
                        `;
                    })
                    .catch(error => {
                        console.error('Update error:', error);
                        saveBtn.disabled = false;
                        saveBtn.innerHTML = `<i class="bi bi-save"></i> Save Settings`;

                        msgDiv.innerHTML = `
                            <div class="alert alert-warning" role="alert">
                                ⚠️ An error occurred while updating settings.
                            </div>
                        `;
                    });
                });

            } else {
                mainContent.innerHTML = `
                    <div class="alert alert-danger text-center mt-5">
                        ❌ Failed to load settings. Please try again later.
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            mainContent.innerHTML = `
                <div class="alert alert-warning text-center mt-5">
                    ⚠️ Error fetching settings. Please check your server or API.
                </div>
            `;
        });
}


function loadAccessLogs() {
    const mainContent = document.getElementById('mainContent');
    mainContent.innerHTML = `
        <div class="d-flex justify-content-center align-items-center mt-5">
            <div class="spinner-border text-primary" role="status"></div>
            <p class="ms-3 text-primary">Loading Access Logs...</p>
        </div>
    `;

    fetch('http://localhost/accessLogs/fetchLogs') // Update with your base URL
        .then(response => response.json())
        .then(data => {
            if (data.success && data.data.length > 0) {
                // Generate table rows dynamically
                let tableRows = '';
                data.data.forEach((log, index) => {
                    tableRows += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${log.name}</td>
                            <td>${log.email}</td>
                            <td>${new Date(log.login_time).toLocaleString()}</td>
                            <td>${log.logout_time ? new Date(log.logout_time).toLocaleString() : '<span class="text-muted">N/A</span>'}</td>
                            <td>${log.ip_address}</td>
                            <td>${log.device}</td>
                            <td>${log.location || '<span class="text-muted">Unknown</span>'}</td>
                        </tr>
                    `;
                });


                // Insert the styled table into the main content
                mainContent.innerHTML = `
                    <div class="container mt-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                <h4 class="mb-0">Access Logs</h4>
                                <button class="btn btn-light btn-sm" onclick="window.open('http://localhost/accessLogs/exportLogs')">
    <i class="bi bi-download"></i> Export Logs
</button>

                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover align-middle">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Login Time</th>
                                                <th>Logout Time</th>
                                                <th>IP Address</th>
                                                <th>Device</th>
                                                <th>Location</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            ${tableRows}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            } else {
                // If no logs are found
                mainContent.innerHTML = `
                    <div class="container mt-4">
                        <div class="alert alert-info text-center">
                            <h5>No Access Logs Found</h5>
                            <p>No login activities have been recorded yet.</p>
                        </div>
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('Error fetching logs:', error);
            mainContent.innerHTML = `
                <div class="container mt-4">
                    <div class="alert alert-danger text-center">
                        <h5 class="text-danger">Error Loading Logs</h5>
                        <p>There was an error while fetching the access logs. Please try again later.</p>
                    </div>
                </div>
            `;
        });
}

function loadManageUsers() {
    const mainContent = document.getElementById('mainContent');
    mainContent.innerHTML = `
        <div class="text-center my-4">
            <span class="spinner-border" role="status"></span> Loading...
        </div>`;

    fetch('http://localhost/fetch_users')
        .then(response => response.json())
        .then(users => {
            let tableRows = '';

            if (users.length > 0) {
                users.forEach(user => {
                    tableRows += `
                        <tr>
                            <td>${user.id}</td>
                            <td>${user.name}</td>
                            <td>${user.email}</td>
                            <td>${user.role.charAt(0).toUpperCase() + user.role.slice(1)}</td>
                            <td>${user.status.charAt(0).toUpperCase() + user.status.slice(1)}</td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-info" onclick="viewUser(${user.id})">
                                    <i class="bi bi-eye-fill"></i>
                                </button>
                                <button class="btn btn-sm btn-warning" onclick="editUser(${user.id})">
                                    <i class="bi bi-pencil-fill"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="deleteUser(${user.id})">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                });
            } else {
                tableRows = `
                    <tr>
                        <td colspan="6" class="text-center text-muted">No users found.</td>
                    </tr>`;
            }

            mainContent.innerHTML = `
                <h3 class="text-center mb-3 border border-primary rounded py-2">Manage Users</h3>
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#registerUserModal">
                    Register User
                </button>
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${tableRows}
                    </tbody>
                </table>`;
        })
        .catch(error => {
            console.error('Error fetching users:', error);
            mainContent.innerHTML = `<div class="alert alert-danger">Failed to load users. Please try again.</div>`;
        });
}



// Action handlers
function viewUser(userId) {
    fetch(`http://localhost/get_user/${userId}`)
        .then(response => response.json())
        .then(data => {
            console.log('Response Data:', data); // Debugging log

            if (data.status === 200) {
                const userData = data.data;

                // Map data to form fields (use correct keys)
                document.getElementById('userId').value = userData.id || '';
                document.getElementById('userName').value = userData.name || '';
                document.getElementById('userEmail').value = userData.email || '';
                document.getElementById('userCounty').value = userData.county || '';
                document.getElementById('userRegion').value = userData.region || '';
                document.getElementById('userRole').value = userData.role || '';
                document.getElementById('userStatus').value = userData.status || '';

                // Show the modal
                const viewUserModal = new bootstrap.Modal(document.getElementById('viewUserModal'));
                viewUserModal.show();
            } else {
                alert(data.message || 'Failed to fetch user details.');
            }
        })
        .catch(error => {
            console.error('Error fetching user details:', error);
            alert('An error occurred while fetching user details.');
        });
}

function editUser(userId) {
    fetch(`http://localhost/user/edit_user/${userId}`)
        .then(response => response.json())
        .then(data => {
            if (data.status === 200) {
                const userData = data.data;

                // Populate the modal fields
                document.getElementById('editUserId').value = userData.id || '';
                document.getElementById('editUserName').value = userData.name || '';
                document.getElementById('editUserEmail').value = userData.email || '';
                document.getElementById('editUserCounty').value = userData.county || '';
                document.getElementById('editUserRegion').value = userData.region || '';
                document.getElementById('editUserRole').value = userData.role || '';
                document.getElementById('editUserStatus').value = userData.status || '';

                // Show the modal
                const editUserModal = new bootstrap.Modal(document.getElementById('editUserModal'));
                editUserModal.show();
            } else {
                alert(data.message || 'Failed to fetch user details.');
            }
        })
        .catch(error => {
            console.error('Error fetching user details:', error);
            alert('An error occurred while fetching user details.');
        });
}

// Handle form submission for updating the user
document.getElementById('editUserForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch('http://localhost/user/update_user', {
        method: 'POST',
        body: formData,
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === 200) {
                alert(data.message);
                location.reload(); // Reload page to reflect updates
            } else {
                alert(data.message || 'Failed to update user.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to update user. Please try again.');
        });
});

function deleteUser(userId) {
    if (!confirm('Are you sure you want to delete this user?')) {
        return;
    }

    fetch(`${window.location.origin}/user/delete_user/${userId}`, {
        method: 'DELETE',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 200) {
            alert(data.message);
            loadManageUsers();  // ✅ Refresh user list dynamically
        } else {
            alert(data.message || 'Failed to delete the user.');
        }
    })
    .catch(error => {
        console.error('Error deleting user:', error);
        alert('An error occurred while deleting the user.');
    });
}



 function loadManageCases() {
    const mainContent = document.getElementById('mainContent');
    mainContent.innerHTML = `
        <div class="text-center my-4">
            <span class="spinner-border" role="status"></span> Loading cases...
        </div>`;

    const fetchUrl = `${window.location.origin}/fetch_cases`;

    fetch(fetchUrl)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(cases => {
            let tableRows = '';

            if (cases.length > 0) {
                cases.forEach(caseItem => {
                    tableRows += `
                        <tr>
                            <td>${caseItem.id}</td>
                            <td>${caseItem.title}</td>
                            <td>${caseItem.description}</td>
                            <td>${caseItem.officer_id}</td>
                            <td>
                                <span class="badge ${caseItem.status === 'open' ? 'bg-success' : 'bg-secondary'}">
                                    ${caseItem.status.charAt(0).toUpperCase() + caseItem.status.slice(1)}
                                </span>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-info me-1" onclick="viewCase(${caseItem.id})">
                                    <i class="bi bi-eye-fill"></i>
                                </button>
                                <button class="btn btn-sm btn-warning me-1" onclick="editCase(${caseItem.id})">
                                    <i class="bi bi-pencil-fill"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="deleteCase(${caseItem.id})">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                });
            } else {
                tableRows = `
                    <tr>
                        <td colspan="6" class="text-center text-muted">No cases found.</td>
                    </tr>
                `;
            }

            mainContent.innerHTML = `                
                <h3 class="text-center mb-3 border border-primary rounded py-2">Manage Cases</h3>
                <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addCaseModal">Add Case</button>
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th>Case ID</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Officer ID</th>
                            <th>Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${tableRows}
                    </tbody>
                </table>
            `;
        })
        .catch(error => {
            console.error('Error fetching cases:', error);
            mainContent.innerHTML = `<div class="alert alert-danger">Failed to load cases. Please try again later.</div>`;
        });
}

// Action handlers
function viewCase(caseId) {
    fetch(`http://localhost/case_details/${caseId}`)
        .then(response => response.json())
        .then(data => {
            if (data.status === 200) {
                const caseData = data.data;

                // Map data to form fields
                document.getElementById('caseId').value = caseData.id || '';
                document.getElementById('caseTitle').value = caseData.title || '';
                document.getElementById('caseDescription').value = caseData.description || '';
                document.getElementById('caseCounty').value = caseData.county || '';
                document.getElementById('caseRegion').value = caseData.region || '';
                document.getElementById('caseId_no').value = caseData.id_no || '';
                document.getElementById('caseComplainant').value = caseData.complainant || '';
                document.getElementById('caseUploads').value = caseData.uploads || '';
                document.getElementById('caseOfficer').value = caseData.officer_id || '';
                document.getElementById('caseStatus').value = caseData.status || '';

                // Show the modal
                const viewCaseModal = new bootstrap.Modal(document.getElementById('viewCaseModal'));
                viewCaseModal.show();
            } else {
                alert(data.message || 'Failed to fetch case details.');
            }
        })
        .catch(error => {
            console.error('Error fetching case details:', error);
            alert('An error occurred while fetching case details.');
        });
}


function editCase(caseId) {
    fetch(`http://localhost/case_details/${caseId}`)
        .then(response => response.json())
        .then(data => {
            if (data.status === 200) {
                const caseData = data.data;

                // Populate the modal fields
                document.getElementById('editCaseId').value = caseData.id || '';
                document.getElementById('editCaseTitle').value = caseData.title || '';
                document.getElementById('editCaseDescription').value = caseData.description || '';
                document.getElementById('editCaseCounty').value = caseData.county || '';
                document.getElementById('editCaseRegion').value = caseData.region || '';
                document.getElementById('editCaseIdNo').value = caseData.id_no || '';
                document.getElementById('editCaseComplainant').value = caseData.complainant || '';
                document.getElementById('editCaseOfficer').value = caseData.officer_id || '';
                document.getElementById('editCaseStatus').value = caseData.status || '';

                // Show the modal
                const editCaseModal = new bootstrap.Modal(document.getElementById('editCaseModal'));
                editCaseModal.show();
            } else {
                alert(data.message || 'Failed to fetch case details.');
            }
        })
        .catch(error => {
            console.error('Error fetching case details:', error);
            alert('An error occurred while fetching case details.');
        });
}

// Handle form submission for updating the case
document.getElementById('editCaseForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch('http://localhost/case/update_case', {
        method: 'POST',
        body: formData,
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === 200) {
                // Close the modal
                const modalElement = document.getElementById('editCaseModal');
                const modalInstance = bootstrap.Modal.getInstance(modalElement);
                modalInstance.hide();

                // Refresh cases dynamically
                loadManageCases();

                // Optional: Show success message
                const messageDiv = document.getElementById('addCaseMessage');
                if (messageDiv) {
                    messageDiv.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
                    setTimeout(() => {
                        messageDiv.innerHTML = '';
                    }, 3000);
                }
            } else {
                alert(data.message || 'Failed to update case.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to update case. Please try again.');
        });
});


function deleteCase(caseId) {
    if (!confirm('Are you sure you want to delete this case?')) {
        return;
    }

    fetch(`${window.location.origin}/delete_case/${caseId}`, {
        method: 'DELETE',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 200) {
            alert(data.message);
            loadManageCases();  // ✅ Refresh case list dynamically
        } else {
            alert(data.message || 'Failed to delete the case.');
        }
    })
    .catch(error => {
        console.error('Error deleting case:', error);
        alert('An error occurred while deleting the case.');
    });
}



function editProfile(userId) {
    fetch(`http://localhost/user/get_profile/${userId}`)
        .then(response => response.json())
        .then(data => {
            if (data.status === 200) {
                const userData = data.data;

                // Populate the form fields
                document.getElementById('profileUserId').value = userData.id;
                document.getElementById('profileName').value = userData.name;
                document.getElementById('profileEmail').value = userData.email;

                if (userData.profilePicture) {
                    const profilePreview = document.getElementById('profilePreview');
                    profilePreview.src = `http://localhost/uploads/${userData.profilePicture}`;
                    profilePreview.style.display = 'block';
                }

                // Show the modal
                const editProfileModal = new bootstrap.Modal(document.getElementById('editProfileModal'));
                editProfileModal.show();
            } else {
                alert(data.message || 'Failed to fetch profile details.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to fetch profile details. Please try again.');
        });
}

// Handle form submission for updating the profile
document.getElementById('editProfileForm').addEventListener('submit', function (e) {
    e.preventDefault(); // Prevent default form submission

    const form = e.target;
    const formData = new FormData(form);

    fetch('http://localhost/user/update_profile', { // Replace with your actual endpoint
        method: 'POST',
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 200) {
            alert(data.message);
            location.reload(); // Reload the page to reflect changes
        } else {
            alert(data.message || 'Failed to update profile.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while updating the profile. Please try again.');
    });
});

function loadViewProfile() {
    const mainContent = document.getElementById('mainContent');
    mainContent.innerHTML = `<div class="text-center"><span class="spinner-border" role="status"></span> Loading...</div>`;

    fetch('http://localhost/user/profile') // Replace with your backend endpoint
        .then(response => response.json())
        .then(data => {
            if (data.status === 200) {
                const user = data.data;

                // Populate profile details
                mainContent.innerHTML = `
                    <div class="container mt-4">
                        <h2 class="text-center">User Profile</h2>
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <div class="card shadow">
                                    <div class="card-body">
                                        <div class="mb-3 text-center">
                                            <img src="http://localhost/uploads/${user.profilePicture}" alt="Profile Picture" class="img-thumbnail w-25">
                                        </div>
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <th>Name</th>
                                                    <td>${user.name}</td>
                                                </tr>
                                                <tr>
                                                    <th>Email</th>
                                                    <td>${user.email}</td>
                                                </tr>
                                                <tr>
                                                    <th>Role</th>
                                                    <td>${user.role.charAt(0).toUpperCase() + user.role.slice(1)}</td>
                                                </tr>
                                                <tr>
                                                    <th>Status</th>
                                                    <td>${user.status.charAt(0).toUpperCase() + user.status.slice(1)}</td>
                                                </tr>
                                                <tr>
                                                    <th>Region</th>
                                                    <td>${user.region}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="text-center mt-3">
                                            
                                        <button 
                                        class="btn btn-primary" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editProfileModal" 
                                        style="background-color: #007BFF; border: none; padding: 10px 15px; width: auto;">
                                        Edit Profile
                                    </button>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            } else {
                mainContent.innerHTML = `<div class="alert alert-danger text-center">${data.message || 'Failed to load profile.'}</div>`;
            }
        })
        .catch(error => {
            console.error('Error loading profile:', error);
            mainContent.innerHTML = `<div class="alert alert-danger text-center">An error occurred while loading the profile. Please try again later.</div>`;
        });
}
function loadSuperadminNotifications(callback = null) {
    fetch('/superadmin/notifications') // should return only unread for superadmin
        .then(res => res.json())
        .then(data => {
            const notifList = document.getElementById('notifList');
            const notifCount = document.getElementById('notifCount');

            notifList.innerHTML = '';
            const unreadCount = data.length;

            // Update badge text and visibility
            notifCount.textContent = unreadCount;
            notifCount.classList.toggle('d-none', unreadCount === 0);

            if (unreadCount === 0) {
                notifList.innerHTML = `
                    <li><span class="dropdown-item text-muted">No new notifications</span></li>
                `;
            } else {
                data.forEach(n => {
                    const item = document.createElement('li');
                    item.innerHTML = `
                        <div class="dropdown-item d-flex justify-content-between align-items-center">
                            <span class="fw-bold" style="flex:1; cursor:pointer;" onclick="markSuperadminAsRead(${n.id}, '${n.link}')">${n.title}</span>
                            <button class="btn btn-sm btn-outline-danger ms-2" title="Delete" onclick="deleteSuperadminNotification(${n.id}); return false;">
                                🗑️
                            </button>
                        </div>
                    `;
                    notifList.appendChild(item);
                });

                notifList.innerHTML += `
                    <li><hr class="dropdown-divider"></li>
                `;
            }

            if (callback && typeof callback === 'function') {
                callback();
            }
        })
        .catch(error => {
            console.error('Superadmin Notification loading error:', error);
        });
}

function markSuperadminAsRead(id, link) {
    fetch(`/notifications/markAsRead/${id}`)
        .then(res => res.json())
        .then(data => {
            if (data.status === 'read') {
                // Reload then redirect
                loadSuperadminNotifications(() => {
                    window.location.href = link;
                });
            }
        })
        .catch(error => {
            console.error('Error marking superadmin notification as read:', error);
        });
}

function deleteSuperadminNotification(id) {
    if (!confirm('Are you sure you want to delete this notification?')) return;

    fetch(`/notifications/delete/${id}`)
        .then(res => res.json())
        .then(data => {
            if (data.status === 'deleted') {
                loadSuperadminNotifications(); // refresh the list and badge
            } else {
                alert('Failed to delete the notification.');
            }
        })
        .catch(err => {
            console.error('Superadmin Delete error:', err);
        });
}

document.addEventListener('DOMContentLoaded', () => {
    loadSuperadminNotifications();
    setInterval(loadSuperadminNotifications, 15000); // auto-refresh
});
function loadSuperadminReports() {
    const mainContent = document.getElementById('mainContent');

    mainContent.innerHTML = `
        <div class="text-center my-5">
            <span class="spinner-border" role="status"></span> Loading Reports...
        </div>`;

    fetch('/superadmin/reports')
        .then(response => response.json())
        .then(data => {
            const { totalCases, resolvedCases, openCases, casesPerRegion, allCases } = data;

            let regionRows = '';
            if (casesPerRegion.length > 0) {
                regionRows = casesPerRegion.map(row => `
                    <tr>
                        <td>${row.region}</td>
                        <td>${row.total}</td>
                    </tr>
                `).join('');
            } else {
                regionRows = `<tr><td colspan="2" class="text-center">No data found.</td></tr>`;
            }

            let caseRows = '';
            if (allCases.length > 0) {
                caseRows = allCases.map(caseItem => {
                    let badge = '';
                    const status = caseItem.status.toLowerCase();
                    if (status === 'resolved' || status === 'closed') {
                        badge = `<span class="badge bg-success">${status.charAt(0).toUpperCase() + status.slice(1)}</span>`;
                    } else if (status === 'open') {
                        badge = `<span class="badge bg-warning text-dark">Open</span>`;
                    } else {
                        badge = `<span class="badge bg-secondary">${status.charAt(0).toUpperCase() + status.slice(1)}</span>`;
                    }

                    return `
                        <tr>
                            <td>${caseItem.id}</td>
                            <td>${caseItem.title}</td>
                            <td>${caseItem.region}</td>
                            <td>${badge}</td>
                            <td>${caseItem.officer_id ?? 'Unassigned'}</td>
                            <td>${new Date(caseItem.created_at).toISOString().split('T')[0]}</td>
                            <td>
                                <a href="/reports/download-case-pdf/${caseItem.id}" class="btn btn-sm btn-outline-danger">
    <i class="bi bi-file-pdf"></i> PDF
</a>
                                </a>
                            </td>
                        </tr>
                    `;
                }).join('');
            } else {
                caseRows = `<tr><td colspan="7" class="text-center">No case records found.</td></tr>`;
            }

            mainContent.innerHTML = `
                <div class="container mt-4 pt-2">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2>📊 Reports</h2>
                    </div>

                    <!-- Summary Cards -->
                    <div class="row g-4 mb-5">
                        <div class="col-md-4">
                            <div class="card bg-primary text-white shadow">
                                <div class="card-body">
                                    <h5>Total Cases</h5>
                                    <p class="fs-3">${totalCases}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-success text-white shadow">
                                <div class="card-body">
                                    <h5>Resolved Cases</h5>
                                    <p class="fs-3">${resolvedCases}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-warning text-dark shadow">
                                <div class="card-body">
                                    <h5>Open Cases</h5>
                                    <p class="fs-3">${openCases}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cases by Region Table -->
                    <h4 class="mt-4">📍 Cases by Region</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped mt-3">
                            <thead class="table-light">
                                <tr>
                                    <th>Region</th>
                                    <th>Total Cases</th>
                                </tr>
                            </thead>
                            <tbody>${regionRows}</tbody>
                        </table>
                    </div>

                    <!-- All Case Details Table -->
                    <h4 class="mt-5">🗂️ All Case Details</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-sm align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Region</th>
                                    <th>Status</th>
                                    <th>Officer ID</th>
                                    <th>Created At</th>
                                    <th>Export</th>
                                </tr>
                            </thead>
                            <tbody>${caseRows}</tbody>
                        </table>
                    </div>
                </div>
            `;
        })
        .catch(error => {
            console.error('Failed to load reports:', error);
            mainContent.innerHTML = `<div class="alert alert-danger mt-5">Failed to load reports. Please try again later.</div>`;
        });
}


  function maybeCollapseSidebar() {
        if (window.innerWidth < 992) { // Collapse on medium and small screens
            const sidebarElement = document.getElementById('sidebar');
            const sidebarInstance = bootstrap.Collapse.getOrCreateInstance(sidebarElement);
            sidebarInstance.hide();
        }
    }
    document.getElementById('resetDefaultsBtn').addEventListener('click', () => {
    if (confirm('Are you sure you want to reset all settings to default values?')) {
        fetch('http://localhost/settings/resetDefaults', {
            method: 'POST',
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert('✅ Defaults restored.');
                loadSystemSettings(); // reload UI
            } else {
                alert('❌ Failed to reset settings.');
            }
        })
        .catch(error => {
            alert('⚠️ Error resetting settings.');
            console.error(error);
        });
    }
});


function applyTheme(mode) {
    const wrapper = document.getElementById('themeWrapper');
    if (!wrapper) return;

    wrapper.classList.remove('theme-dark', 'theme-light');

    if (mode === 'dark') {
        wrapper.classList.add('theme-dark');
    } else if (mode === 'light') {
        wrapper.classList.add('theme-light');
    } else if (mode === 'auto') {
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        wrapper.classList.add(prefersDark ? 'theme-dark' : 'theme-light');
    }
}
 



    </script>
</body>
</html>
