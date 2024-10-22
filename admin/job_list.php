<?php
// Display errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
include("../database/connection.php");

// Handle delete action
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $stmt = $connForPosts->prepare("DELETE FROM peso_jobs WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    $result = $stmt->execute();

    if ($result) {
        header("Location: job_list.php?message=delete_success");
        exit();
    } else {
        header("Location: job_list.php?message=delete_error");
        exit();
    }
}

// Handle add post action
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['post_id'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $requirements = $_POST['requirements'];
    $image = $_POST['image'];

    // Insert into database
    $sql = "INSERT INTO peso_jobs (image, title, description, requirements) VALUES ('$image', '$title', '$description', '$requirements')";
    
    if ($connForPosts->query($sql) === TRUE) {
        header("Location: job_list.php?message=add_success");
        exit();
    } else {
        echo "Error: " . $connForPosts->error;
    }
}

// Handle update post action
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['post_id'])) {
    $post_id = $_POST['post_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $requirements = $_POST['requirements'];
    $image = $_POST['image'];

    // Update the database
    $sql = "UPDATE peso_jobs SET title=?, description=?, requirements=?, image=? WHERE id=?";
    $stmt = $connForPosts->prepare($sql);
    $stmt->bind_param("ssssi", $title, $description, $requirements, $image, $post_id);

    if ($stmt->execute()) {
        header("Location: job_list.php?message=update_success");
        exit();
    } else {
        echo "Error: " . $stmt->error;
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
            <li><a href="approved_applicants.php"><i class='bx bx-group'></i>Approved Applicants</a></li>
            <li class="active"><a href="job_list.php"><i class='bx bx-message-square-dots'></i>Job Lists</a></li>
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
                        /
                        <li><a href="#" class="active">Job Lists</a></li>
                    </ul>
                </div>
            </div>

            <div>
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">JOB LISTS DATA</h6>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPostModal">Add Post</button>
                    </div>

                    <!-- Add Post Modal -->
                    <div class="modal fade" id="addPostModal" tabindex="-1" aria-labelledby="addPostModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addPostModalLabel">Add New Post</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="addPostForm" method="post" action="">
                                        <div class="mb-3">
                                            <label for="postImage" class="form-label">Post Image</label>
                                            <input type="file" class="form-control" id="image" name="image">
                                        </div>
                                        <div class="mb-3">
                                            <label for="postTitle" class="form-label">Title</label>
                                            <input type="text" class="form-control" id="postTitle" name="title" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="postDescription" class="form-label">Description</label>
                                            <textarea class="form-control" id="postDescription" name="description" required></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="postRequirements" class="form-label">Requirements</label>
                                            <textarea class="form-control" id="postRequirements" name="requirements" required></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Add Post</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Update Post Modal -->
                    <div class="modal fade" id="updatePostModal" tabindex="-1" aria-labelledby="updatePostModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="updatePostModalLabel">Update Post</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="updatePostForm" method="post" action="">
                                        <input type="hidden" id="updatePostId" name="post_id">
                                        <div class="mb-3">
                                            <label for="updatePostImage" class="form-label">Post Image</label>
                                            <input type="file" class="form-control" id="updateImage" name="image">
                                        </div>
                                        <div class="mb-3">
                                            <label for="updatePostTitle" class="form-label">Title</label>
                                            <input type="text" class="form-control" id="updatePostTitle" name="title" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="updatePostDescription" class="form-label">Description</label>
                                            <textarea class="form-control" id="updatePostDescription" name="description" required></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="updatePostRequirements" class="form-label">Requirements</label>
                                            <textarea class="form-control" id="updatePostRequirements" name="requirements" required></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Update Post</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="dataTable" class="table table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Post Image</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Requirements</th>
                                        <th>Date Posted</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT * FROM peso_jobs ORDER BY id DESC";
                                    $result = $connForPosts->query($sql);

                                    if ($result->num_rows > 0) {
                                        $count = 1;
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr>
                                                    <td>{$count}</td>
                                                    <td><img src='../image/{$row['image']}' alt='image' style='width: 80px; height: 80px;'></td>
                                                    <td>{$row['title']}</td>
                                                    <td>{$row['description']}</td>
                                                    <td>{$row['requirements']}</td>
                                                    <td>{$row['date_posted']}</td>
                                                    <td>
                                                        <button class='btn btn-warning' onclick='openUpdateModal({$row['id']}, \"{$row['title']}\", \"{$row['description']}\", \"{$row['requirements']}\")'>Edit</button>
                                                        <button class='btn btn-danger' onclick='confirmDelete({$row['id']})'>Delete</button>
                                                    </td> 
                                                </tr>";
                                                $count++;
                                        }
                                    }

                                    $connForPosts->close();
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Post Image</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Requirements</th>
                                        <th>Date Posted</th>
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
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();

            // Check for success or error message in URL
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('message')) {
                const messageType = urlParams.get('message');
                if (messageType === 'delete_success') {
                    Swal.fire('Deletion Successful!', 'Post deleted successfully!', 'success');
                } else if (messageType === 'delete_error') {
                    Swal.fire('Deletion Unsuccessful', 'There was an error deleting the post.', 'error');
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

        function openUpdateModal(id, title, description, requirements) {
            $('#updatePostId').val(id);
            $('#updatePostTitle').val(title);
            $('#updatePostDescription').val(description);
            $('#updatePostRequirements').val(requirements);
            $('#updatePostModal').modal('show');
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
                    window.location.href = '../logout.php'; 
                }
            });
        });
    </script>
    <script src="../js/dashboard.js"></script>
</body>

</html>
