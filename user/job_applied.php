<?php 
    //to display errors
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    //database connection
    include("../database/connection.php");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.5/css/dataTables.bootstrap5.css">

    <link rel="stylesheet" href="../css/user_dashboard.css">
    <title>PESO System | Job Applied Page</title>
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="user_dashboard.php" class="logo">
            <i class='bx bx-code-alt'></i>
            <div class="logo-name"><span>PESO</span>System</div>
        </a>
        <ul class="side-menu">
            <li><a href="user_dashboard.php"><i class='bx bxs-dashboard'></i>Job Lists</a></li>
            <li><a href="profile.php"><i class='bx bx-cog'></i>My Account</a></li>
            <li class="active"><a href="job_applied.php"><i class='bx bx-analyse'></i>Job Applied</a></li>
            <li><a href="my_logs.php"><i class='bx bx-cog'></i>My Logs</a></li>
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
                        <li>
                            <a href="#">PESO</a>
                        </li>
                        /
                        <li>
                            <a href="#" class="active">Job Applied</a>
                        </li>
                    </ul>
                </div>
            </div>


            <div>
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">POSTS DATA</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="dataTable" class="table table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Post Image</th>
                                        <th>Date posted</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>as</td>
                                        <td>as</td>
                                        <td>as</td>
                                        <td>asas</td>
                                        <td>update/delete</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Post Image</th>
                                        <th>Date posted</th>
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

        });

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