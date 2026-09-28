<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
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
    margin-left: 260px; /* Adjust to match sidebar width */
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
        width: 100%; /* Allow full width for centered alignment */
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
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
        <!-- Brand and Sidebar Toggle -->
        <a class="navbar-brand me-2" href="#">Admin</a>
        <button class="btn btn-secondary sidebar-toggle" type="button" aria-expanded="false" aria-controls="sidebar">
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
                    <button class="btn btn-secondary position-relative" id="adminNotifBtn" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-bell"></i>
                        <span id="adminNotifCount" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger d-none">
                            0
                            <span class="visually-hidden">unread notifications</span>
                        </span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" id="adminNotifList">
                        <li><span class="dropdown-item text-muted">Loading...</span></li>
                    </ul>
                </div>
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

<!-- Sidebar -->
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
            <a class="nav-link text-white" href="<?php echo base_url('view-reports'); ?>">
                <i class="bi bi-file-earmark-bar-graph me-2"></i> Reports
            </a>
        </li>
    </ul>
</nav>

<!-- Main Content -->
<main class="col-md-9 col-lg-10 ms-auto px-4 py-4 main-content" id="mainContent">                     
    <div class="row g-4 mt-4" id="dashboardContent">
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title">Total Users</h5>
                    <p class="card-text fs-2 text-primary"><?php echo $total_users; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title">Admins</h5>
                    <p class="card-text fs-2 text-success"><?php echo $total_admins; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title">Officers</h5>
                    <p class="card-text fs-2 text-warning"><?php echo $total_officers; ?></p>
                </div>
            </div>
        </div>
    </div>
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

        sidebarLinks.forEach(link => {
            link.addEventListener('click', (event) => {
                event.preventDefault();
                const section = event.target.getAttribute('onclick');
                if (section) {
                    eval(section);
                }
                mainContent.classList.remove('centered');
            });
        });

        toggleButton.addEventListener('click', () => {
            const isHidden = sidebar.classList.toggle('hidden');
            if (isHidden) {
                mainContent.classList.add('centered');
            } else {
                mainContent.classList.remove('centered');
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


        
    // Add Case Form Submission
    document.getElementById('addCaseForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        fetch('<?= base_url('store_case'); ?>', {
            method: 'POST',
            body: formData,
        })
            .then((response) => response.json())
            .then((data) => {
                const messageDiv = document.getElementById('addCaseMessage');
                if (data.success) {
                    messageDiv.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
                    this.reset();
                } else {
                    messageDiv.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
                }
            })
            .catch((error) => console.error('Error:', error));
    });
     function loadDashboard() {
    const mainContent = document.getElementById('mainContent');
    mainContent.innerHTML = `
        <div class="container mt-4">
            <!-- Statistics Cards -->
            <div class="row g-3">
                <div class="col-lg-3 col-md-6">
                    <div class="card shadow-sm border-0" style="background-color: #007bff;">
                        <div class="card-body text-center py-3 text-white">
                            <h6 class="card-title mb-1">Total Users</h6>
                            <h4 class="fw-bold mb-1"><?php echo $total_users; ?></h4>
                            <i class="bi bi-people-fill" style="font-size: 1.5rem;"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card shadow-sm border-0" style="background-color: #28a745;">
                        <div class="card-body text-center py-3 text-white">
                            <h6 class="card-title mb-1">Admins</h6>
                            <h4 class="fw-bold mb-1"><?php echo $total_admins; ?></h4>
                            <i class="bi bi-person-badge-fill" style="font-size: 1.5rem;"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card shadow-sm border-0" style="background-color: #ffc107;">
                        <div class="card-body text-center py-3 text-dark">
                            <h6 class="card-title mb-1">Officers</h6>
                            <h4 class="fw-bold mb-1"><?php echo $total_officers; ?></h4>
                            <i class="bi bi-shield-fill" style="font-size: 1.5rem;"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card shadow-sm border-0" style="background-color: #17a2b8;">
                        <div class="card-body text-center py-3 text-white">
                            <h6 class="card-title mb-1">Total Cases</h6>
                            <h4 class="fw-bold mb-1"><?php echo $total_cases; ?></h4>
                            <i class="bi bi-file-earmark-text-fill" style="font-size: 1.5rem;"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Open and Closed Cases -->
            <div class="row g-3 mt-3">
                <div class="col-lg-6">
                    <div class="card shadow-sm border-0" style="background-color: #6c757d;">
                        <div class="card-body text-center py-3 text-white">
                            <h6 class="card-title mb-1">Open Cases</h6>
                            <h4 class="fw-bold mb-1"><?php echo $open_cases; ?></h4>
                            <i class="bi bi-folder-symlink" style="font-size: 1.5rem;"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card shadow-sm border-0" style="background-color: #dc3545;">
                        <div class="card-body text-center py-3 text-white">
                            <h6 class="card-title mb-1">Closed Cases</h6>
                            <h4 class="fw-bold mb-1"><?php echo $closed_cases; ?></h4>
                            <i class="bi bi-folder-check" style="font-size: 1.5rem;"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Cases Section -->
            <div class="mt-4">
                
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0">Recent Cases Overview</h6>
                    </div>
                    <div class="card-body p-3">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-secondary fw-bold">Title</th>
                                        <th class="text-secondary fw-bold">Description</th>
                                        <th class="text-secondary fw-bold">Status</th>
                                        <th class="text-secondary fw-bold">Date Created</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($recent_cases)): ?>
                                        <?php foreach ($recent_cases as $case): ?>
                                            <tr>
                                                <td class="fw-bold text-dark"><?= $case['title']; ?></td>
                                                <td class="text-muted"><?= $case['description']; ?></td>
                                                <td>
                                                    <span class="badge <?= $case['status'] === 'open' ? 'bg-success' : 'bg-secondary'; ?>">
                                                        <?= ucfirst($case['status']); ?>
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
            </div>
        </div>
    `;

    // Load Charts
    setTimeout(() => {
        const ctxCases = document.getElementById('casesStatusChart').getContext('2d');
        new Chart(ctxCases, {
            type: 'bar',
            data: {
                labels: ['Open', 'Closed'],
                datasets: [{
                    label: 'Cases',
                    data: [<?php echo $open_cases; ?>, <?php echo $closed_cases; ?>],
                    backgroundColor: ['#007bff', '#dc3545']
                }]
            },
            options: { responsive: true }
        });

        const ctxUsers = document.getElementById('usersRoleChart').getContext('2d');
        new Chart(ctxUsers, {
            type: 'bar',
            data: {
                labels: ['Admins', 'Officers'],
                datasets: [{
                    label: 'Users',
                    data: [<?php echo $total_admins; ?>, <?php echo $total_officers; ?>],
                    backgroundColor: ['#28a745', '#ffc107']
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    }, 500);
}

document.addEventListener('DOMContentLoaded', () => {
    loadDashboard();
});  


   function loadManageUsers() {
    const mainContent = document.getElementById('mainContent');
    mainContent.innerHTML = `<div class="text-center"><span class="spinner-border" role="status"></span> Loading...</div>`;

    fetch('http://localhost/admin/fetch_user', {
        credentials: 'include', // Include session cookies
        headers: {
            'Authorization': `Bearer ${localStorage.getItem('authToken')}` // Add token if applicable
        }
    })
        .then(response => {
            if (!response.ok) {
                if (response.status === 401) {
                    throw new Error('Unauthorized. Please log in.');
                }
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(result => {
            if (result.status !== 200 || !Array.isArray(result.data)) {
                throw new Error(result.message || 'Invalid data format.');
            }

            const users = result.data; // Extract user data
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
                            </td>
                        </tr>
                    `;
                });
            } else {
                tableRows = `
                    <tr>
                        <td colspan="6" class="text-center text-muted">No users found in your region.</td>
                    </tr>
                `;
            }

            mainContent.innerHTML = `
             <h3 class="text-center mb-3 border border-primary rounded py-2">Users</h3> <!-- Centered heading with border -->
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
                </table>
            `;
        })
        .catch(error => {
            console.error('Error fetching users:', error);
            mainContent.innerHTML = `<div class="alert alert-danger">${error.message}</div>`;
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


 function loadManageCases() {
    const mainContent = document.getElementById('mainContent');
    mainContent.innerHTML = `<div class="text-center"><span class="spinner-border" role="status"></span> Loading...</div>`;

    // Fetch cases filtered by the user's region from the backend
    fetch('http://localhost/fetch_cases_by_region') // Ensure this endpoint filters cases by region
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(result => {
            console.log("Fetched cases:", result); // Debugging log

            // Check if the response is valid and contains data
            if (result.status !== 200 || !Array.isArray(result.data)) {
                throw new Error(result.message || 'Invalid data format.');
            }

            const cases = result.data; // Extract the filtered cases
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
                                <button class="btn btn-sm btn-info" onclick="viewCase(${caseItem.id})">
                                    <i class="bi bi-eye-fill"></i> <!-- View Icon -->
                                </button>
                                <button class="btn btn-sm btn-warning" onclick="editCase(${caseItem.id})">
                                    <i class="bi bi-pencil-fill"></i> <!-- Edit Icon -->
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="deleteCase(${caseItem.id})">
                                    <i class="bi bi-trash-fill"></i> <!-- Delete Icon -->
                                </button>
                            </td>
                        </tr>
                    `;
                });
            } else {
                tableRows = `
                    <tr>
                        <td colspan="6" class="text-center text-muted">No cases found in your region.</td>
                    </tr>
                `;
            }

            mainContent.innerHTML = `               
                 <h3 class="text-center mb-3 border border-primary rounded py-2">Manage Cases</h3> <!-- Centered heading with border -->
                  <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addCaseModal">Add Case</button>
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th>CaseId</th>
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
            mainContent.innerHTML = `<div class="alert alert-danger">Failed to load cases. Please try again.</div>`;
            console.error('Error fetching cases:', error);
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
    e.preventDefault();

    const formData = new FormData(this);

    fetch('http://localhost/user/update_profile', {
        method: 'POST',
        body: formData,
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === 200) {
                alert(data.message);

                const updatedUser = data.updatedUser;

                // Update profile information on the page dynamically
                document.getElementById('profileNameDisplay').textContent = updatedUser.name;
                document.getElementById('profileEmailDisplay').textContent = updatedUser.email;

                if (updatedUser.profilePicture) {
                    document.getElementById('profilePictureDisplay').src = `http://localhost/uploads/${updatedUser.profilePicture}`;
                }

                // Hide the modal
                const editProfileModal = bootstrap.Modal.getInstance(document.getElementById('editProfileModal'));
                editProfileModal.hide();
            } else {
                alert(data.message || 'Failed to update profile.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to update profile. Please try again.');
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
function loadAdminNotifications(callback = null) {
    fetch(`${baseURL}/admin/notifications`) // <-- use baseURL here
        .then(res => {
            if (!res.ok) {
                throw new Error(`HTTP error! status: ${res.status}`);
            }
            return res.json();
        })
        .then(data => {
            console.log("Admin notifications:", data);

            const notifList = document.getElementById('adminNotifList');
            const notifCount = document.getElementById('adminNotifCount');

            notifList.innerHTML = '';
            const unreadCount = data.length;

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
                            <span class="fw-bold" style="flex:1; cursor:pointer;" onclick="markAdminAsRead(${n.id}, '${n.link}')">${n.title}</span>
                            <button class="btn btn-sm btn-outline-danger ms-2" title="Delete" onclick="deleteAdminNotification(${n.id}); return false;">
                                🗑️
                            </button>
                        </div>
                    `;
                    notifList.appendChild(item);
                });

                notifList.innerHTML += `<li><hr class="dropdown-divider"></li>`;
            }

            if (callback && typeof callback === 'function') {
                callback();
            }
        })
        .catch(error => {
            console.error('Admin Notification loading error:', error);
            const notifList = document.getElementById('adminNotifList');
            notifList.innerHTML = `<li><span class="dropdown-item text-danger">Failed to load notifications</span></li>`;
        });
}

function markAdminAsRead(id, link) {
    fetch(`${baseURL}/notifications/markAsRead/${id}`)
        .then(res => res.json())
        .then(data => {
            if (data.status === 'read') {
                loadAdminNotifications(() => {
                    window.location.href = link;
                });
            }
        })
        .catch(error => {
            console.error('Error marking admin notification as read:', error);
        });
}

function deleteAdminNotification(id) {
    if (!confirm('Are you sure you want to delete this notification?')) return;

    fetch(`${baseURL}/notifications/delete/${id}`)
        .then(res => res.json())
        .then(data => {
            if (data.status === 'deleted') {
                loadAdminNotifications();
            } else {
                alert('Failed to delete the notification.');
            }
        })
        .catch(err => {
            console.error('Admin Delete error:', err);
        });
}

// Make sure baseURL is set
const baseURL = "<?= base_url() ?>";

// Load notifications on page load and refresh every 15s
document.addEventListener('DOMContentLoaded', () => {
    loadAdminNotifications();
    setInterval(loadAdminNotifications, 15000); // every 15s
});

    </script>
</body>
</html>
