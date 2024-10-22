<?php
// Display errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
include("../database/connection.php");


if (isset($_POST['submit'])) {


    // Collect data
    $picture = $_POST['picture'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $number = $_POST['number'];
    $resume = $_POST['resume'];
    $status = $_POST['status'];

    // Prepare the SQL statement
    $sql = "INSERT INTO `applicants`(`profile`, `name`, `email`, `contact_number`, `resume`, `status`) 
        VALUES ('$picture', '$name', '$email', '$number', '$resume', '$status')";


    // Execute the query
    if ($connForPosts->query($sql) === TRUE) {
        header('Location: user_dashboard.php');
    } else {
        echo "Error: " . $sql . "<br>" . $connForPosts->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../css/user_dashboard.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>PESO System | Job Lists Page</title>
</head>
<style>
    .sidebar a {
        text-decoration: none;
    }
    .sidebar a:hover {
        text-decoration: none;
    }
    body {
        background-color: #eee;
    }
</style>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <a href="user_dashboard.php" class="logo">
            <i class='bx bx-code-alt'></i>
            <div class="logo-name"><span>PESO</span>System</div>
        </a>
        <ul class="side-menu">
            <li class="active"><a href="user_dashboard.php"><i class='bx bxs-dashboard'></i>Job Lists</a></li>
            <li><a href="profile.php"><i class='bx bx-cog'></i>My Account</a></li>
            <li><a href="job_applied.php"><i class='bx bx-analyse'></i>Job Applied</a></li>
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
        <nav>
            <i class='bx bx-menu'></i>
            <a href="#" class="profile">
                <img src="images/logo.png">
            </a>
        </nav>
        <main>
            <div class="header">
                <div class="left">
                    <h1>Dashboard</h1>
                    <ul class="breadcrumb">
                        <li><a href="#">PESO</a></li> /
                        <li><a href="#" class="active">Job Lists</a></li>
                    </ul>
                </div>
            </div>

            <!-- Insights -->
            <ul class="insights">
                <?php
                $select_jobs = mysqli_query($connForPosts, "SELECT * FROM peso_jobs");

                if (mysqli_num_rows($select_jobs) > 0) {
                    while ($fetch_jobs = mysqli_fetch_assoc($select_jobs)) {
                ?>
                        <li>
                            <div>
                                <img src="../image/<?php echo $fetch_jobs['image']; ?>" alt="">
                            </div>
                            <span class="info">
                                <h3><?php echo $fetch_jobs['title']; ?></h3>
                                <p><?php echo $fetch_jobs['description']; ?></p>
                                <button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#jobModal<?php echo $fetch_jobs['id']; ?>">
                                    Apply
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="jobModal<?php echo $fetch_jobs['id']; ?>" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"><?php echo $fetch_jobs['title']; ?></h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p><?php echo $fetch_jobs['description']; ?></p>
                                                <form action="user_dashboard.php" method="POST">
                                                    <div class="form-group">
                                                        <label for="picture">Upload 2x2 Picture</label>
                                                        <input type="file" class="form-control" id="picture" name="picture" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="name">Name</label>
                                                        <input type="text" class="form-control" id="name" name="name" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="email">Email</label>
                                                        <input type="email" class="form-control" id="email" name="email" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="number">Contact Number</label>
                                                        <input type="number" class="form-control" id="number" name="number" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="resume">Upload Resume</label>
                                                        <input type="file" class="form-control" id="resume" name="resume" required>
                                                    </div>

                                                    <div class="form-group">
                                                    <input type="hidden" id="status" name="status" value="pending">
                                                    </div>

                                                    <button type="submit" name="submit" class="btn btn-primary btn-block">Submit</button>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </span>
                        </li>
                <?php
                    }
                }
                ?>
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
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
