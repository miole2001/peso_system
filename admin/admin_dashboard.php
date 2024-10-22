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
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../css/dashboard.css">
    <title>PESO System | Admin Dashboard Page</title>
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="admin_dashboard.php" class="logo">
            <i class='bx bx-code-alt'></i>
            <div class="logo-name"><span>PESO</span>System</div>
        </a>
        <ul class="side-menu">
            <li class="active"><a href="admin_dashboard.php"><i class='bx bxs-dashboard'></i>Dashboard</a></li>
            <li><a href="pending_applicants.php"><i class='bx bx-analyse'></i>Pending Applicants</a></li>
            <li><a href="approved_applicants.php"><i class='bx bx-group'></i>Approved Applicants</a></li>
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
                        <li><a href="#">Dashboard</a></li>
                        /
                        <li><a href="#" class="active">Analytics</a></li>
                    </ul>
                </div>
            </div>

            <!-- Insights -->
            <ul class="insights">
                <li>
                    <i class='bx bx-calendar-check'></i>
                    <span class="info">
                        <?php
                        $query = "SELECT * FROM peso_accounts WHERE userType = 'peso_user' ";
                        $run_query = mysqli_query($connForAccounts, $query);
                        $row = mysqli_num_rows($run_query);

                        echo '<h3>' . $row . '</h3>'
                        ?>
                        <p>Registered Accounts</p>
                    </span>
                </li>
                <li><i class='bx bx-show-alt'></i>
                    <span class="info">
                        <?php
                        $query = "SELECT * FROM applicants WHERE status = 'pending' ";
                        $run_query = mysqli_query($connForPosts, $query);
                        $row = mysqli_num_rows($run_query);

                        echo '<h3>' . $row . '</h3>'
                        ?>
                        <p>Pending Applicants</p>
                    </span>
                </li>
                <li><i class='bx bx-line-chart'></i>
                    <span class="info">
                        <?php
                        $query = "SELECT * FROM applicants WHERE status = 'approved' ";
                        $run_query = mysqli_query($connForPosts, $query);
                        $row = mysqli_num_rows($run_query);

                        echo '<h3>' . $row . '</h3>'
                        ?>
                        <p>Approved Applicants</p>
                    </span>
                </li>
                <!-- <li><i class='bx bx-dollar-circle'></i>
                    <span class="info">
                        <h3>$6,742</h3>
                        <p>Total Sales</p>
                    </span>
                </li> -->
            </ul>
            <!-- End of Insights -->

        </main>

    </div>
    
    <script>
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
