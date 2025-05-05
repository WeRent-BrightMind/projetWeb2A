<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Blog Management</title>
</head>

<body>
    <div class="container">
        <!-- Sidebar Section -->
        <aside>
            <div class="toggle">
                <div class="logo">
                    <img src="images/">
                    <h2>WE<span class="danger">RENT</span></h2>
                </div>
                <div class="close" id="close-btn">
                    <span class="material-icons-sharp">
                        close
                    </span>
                </div>
            </div>

            <div class="sidebar">
                <a href="index.php">
                    <span class="material-icons-sharp">
                        dashboard
                    </span>
                    <h3>Dashboard</h3>
                </a>
                <a href="#">
                    <span class="material-icons-sharp">
                        person_outline
                    </span>
                    <h3>Users</h3>
                </a>
                <a href="blog.php" class="active">
                    <span class="material-icons-sharp">
                        receipt_long
                    </span>
                    <h3>Blog</h3>
                </a>
                <a href="#">
                    <span class="material-icons-sharp">
                        insights
                    </span>
                    <h3>Analytics</h3>
                </a>
                <a href="complaint.php">
                    <span class="material-icons-sharp">
                        mail_outline
                    </span>
                    <h3>Complaint</h3>
                    <span class="message-count">27</span>
                </a>
                <a href="event.php">
                    <span class="material-icons-sharp">
                        inventory
                    </span>
                    <h3>Event</h3>
                </a>
                <a href="annoucement.php">
                    <span class="material-icons-sharp">
                        report_gmailerrorred
                    </span>
                    <h3>Announcement</h3>
                </a>
                <a href="#">
                    <span class="material-icons-sharp">
                        add
                    </span>
                    <h3>New Login</h3>
                </a>
                <a href="#" id="logout-btn">
                    <span class="material-icons-sharp">
                        logout
                    </span>
                    <h3>Logout</h3>
                </a>
            </div>
        </aside>
        <!-- End of Sidebar Section -->

        <!-- Main Content -->
        <main>
            <h1>Blog Management</h1>
            <div class="posts-container">
                <?php
                require_once '../../models/Blog.php';
                $blog = new Blog();
                $posts = $blog->getPosts();

                if (empty($posts)) {
                    echo '<p>No posts have been published yet.</p>';
                } else {
                    foreach ($posts as $post) {
                        echo '<div class="announcement-card">';
                        echo '<h4>' . htmlspecialchars($post['title']) . '</h4>';
                        echo '<p>' . htmlspecialchars(substr($post['message'], 0, 100)) . '...</p>';
                        if (!empty($post['image'])) {
                            echo '<img src="../../uploads/' . htmlspecialchars($post['image']) . '" alt="Post Image">';
                        }
                        echo '<button class="btn-danger" data-post-id="' . $post['id'] . '">Delete Post</button>';
                        echo '</div>';
                    }
                }
                ?>
            </div>
        </main>
        <!-- End of Main Content -->
    </div>

    <script>
        // Delete post functionality
        document.querySelectorAll('.btn-danger').forEach(button => {
            button.addEventListener('click', function () {
                const postId = this.getAttribute('data-post-id');
                if (confirm('Are you sure you want to delete this post?')) {
                    fetch('../../controllers/BlogController.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: `action=delete&postId=${postId}`
                    })
                    .then(response => response.text())
                    .then(data => {
                        console.log('Response from server:', data); // Debugging
                        if (data.trim() === 'success') {
                            this.closest('.announcement-card').remove();
                            alert('Post deleted successfully.');
                        } else {
                            alert('Failed to delete post. Please try again.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while deleting the post.');
                    });
                }
            });
        });
    </script>
    <script>
        // Logout functionality
        document.getElementById('logout-btn').addEventListener('click', function(e) {
            e.preventDefault();
            alert('You have been logged out.');
            window.location.href = '../front/user-management.html'; // Redirect to front login page
        });
    </script>
</body>

</html>
