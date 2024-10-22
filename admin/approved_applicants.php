<?php 
// Display errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
include("../database/connection.php");

// Handle delete action
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $stmt = $connForPosts->prepare("DELETE FROM applicants WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    $result = $stmt->execute();

    if ($result) {
        header("Location: approved_applicants.php?message=delete_success");
        exit();
    } else {
        header("Location: approved_applicants.php?message=delete_error");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.5/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../css/user_dashboard.css">
    <title>PESO System | My Logs Page</title>
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="admin_dashboard.php" class="logo">
            <i class='bx bx-code-alt'></i>
            <div class="logo-name"><span>PESO</span>System</div>
        </a>
        <ul class="side-menu">
            <li><a href="admin_dashboard.php"><i class='bx bxs-dashboard'></i>Dashboard</a></li>
            <li><a href="pending_applicants.php"><i class='bx bx-analyse'></i>Pending Applicants</a></li>
            <li class="active"><a href="approved_applicants.php"><i class='bx bx-group'></i>Approved Applicants</a></li>
            <li><a href="job_list.php"><i class='bx bx-message-square-dots'></i>Job Lists</a></li>
            <li><a href="user_logs.php"><i class='bx bx-group'></i>Applicant Logs</a></li>
            <li><a href="admin_logs.php"><i class='bx bx-group'></i>My Logs</a></li>
        </ul>
        <ul class="side-menu">
            <li>
                <a href="#" class="logout" id="logoutLink">
                    <i class='bx bx-log-out-circle'></i>
                    Logout
                </a>
            </li>
        </ul>
    </div>
    <!-- End of Sidebar -->

    <!-- Main Content -->
    <div class="content">
        <!-- Navbar -->
        <nav>
            <i class='bx bx-menu'></i>
            <a href="#" class="profile">
                <img src="images/logo.png">
            </a>
        </nav>

        <!-- End of Navbar -->

        <main>
            <div class="header">
                <div class="left">
                    <h1>Dashboard</h1>
                    <ul class="breadcrumb">
                        <li><a href="#">PESO</a></li>
                        <li>/</li>
                        <li><a href="#" class="active">Approved Applicants</a></li>
                    </ul>
                </div>
            </div>

            <div>
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">APPROVED APPLICANTS DATA</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="dataTable" class="table table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Profile</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Contact #</th>
                                        <th>Resume</th>
                                        <th>Status</th>
                                        <th>Date Hired</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $sql = "SELECT * FROM applicants WHERE status = 'approved' ORDER BY id DESC";
                                    $result = $connForPosts->query($sql);

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr>
                                                    <td>{$row['id']}</td>
                                                    <td><img src='../image/profile/{$row['profile']}' alt='Profile Picture' style='width: 80px; height: 80px;'></td>
                                                    <td>{$row['name']}</td>
                                                    <td>{$row['email']}</td>
                                                    <td>{$row['contact_number']}</td>
                                                    <td><a href='../image/{$row['resume']}' target='_blank'>View Resume</a></td>
                                                    <td>{$row['status']}</td>
                                                    <td>{$row['date_applied']}</td>
                                                    <td>
                                                        <button class='btn btn-danger' onclick='confirmDelete({$row['id']})'>Delete</button>
                                                    </td>
                                                </tr>";
                                        }
                                    }

                                    $connForPosts->close();
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Profile</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Contact #</th>
                                        <th>Resume</th>
                                        <th>Status</th>
                                        <th>Date Hired</th>
                                        <th>Actions</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

        </main>

    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.5/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.5/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
    $('#dataTable').DataTable();

    // Check for success or error message in URL
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('message')) {
        const messageType = urlParams.get('message');
        if (messageType === 'delete_success') {
            Swal.fire('Deletion Successful!', 'Applicant deleted successfully!', 'success');
        } else if (messageType === 'delete_error') {
            Swal.fire('Deletion Unsuccessful', 'There was an error deleting the applicant.', 'error');
        }
    }
});

        function confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '?delete_id=' + id;
                }
            });
        }
        // SweetAlert2 confirmation for logout
        $('#logoutLink').click(function(e) {
            e.preventDefault(); // Prevent default link behavior
            Swal.fire({
                title: 'Are you sure?',
                text: "You will be logged out!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, logout!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '../logout.php'; // Redirect to logout page
                }
            });
        });
    </script>
    <script src="../js/dashboard.js"></script>
</body>

</html>
