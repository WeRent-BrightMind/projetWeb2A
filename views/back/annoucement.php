<?php
require_once __DIR__ . '/../../controllers/AnnouncementController.php';

$controller = new AnnouncementController();
$announcements = $controller->getAnnouncements();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <title>Announcements</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <!-- Sidebar Section -->
        <aside>
            <div class="toggle">
                <div class="logo">
                    <img src="images/" alt="Logo">
                    <h2>WE<span class="danger">RENT</span></h2>
                </div>
                <div class="close" id="close-btn">
                    <span class="material-icons-sharp">close</span>
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
                <a href="blog.php">
                    <span class="material-icons-sharp">
                        receipt_long
                    </span>
                    <h3>Blog</h3>
                </a>
                <a href="#" class="active">
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
                    <h3>announcement</h3>
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
        <!-- Main Content -->
        <main>
            <h1>Announcements</h1>
            <button id="create-post-btn" class="btn btn-primary">Create Announcement</button>
            <div id="posts-container" class="posts-container">
                <?php foreach ($announcements as $announcement): ?>
                    <div class="announcement-card">
                        <h4><?= htmlspecialchars($announcement['name']) ?></h4>
                        <p><?= htmlspecialchars($announcement['description']) ?></p>
                        <p><strong>Address:</strong> <?= htmlspecialchars($announcement['address']) ?></p>
                        <p><strong>Phone:</strong> <?= htmlspecialchars($announcement['phone']) ?></p>
                        <?php if (!empty($announcement['image'])): ?>
                            <img src="<?= htmlspecialchars($announcement['image']) ?>" alt="Announcement Image" class="img-fluid">
                        <?php endif; ?>
                        <button class="btn btn-warning edit-btn" 
                                data-id="<?= htmlspecialchars($announcement['id_annonce']) ?>" 
                                data-name="<?= htmlspecialchars($announcement['name']) ?>" 
                                data-address="<?= htmlspecialchars($announcement['address']) ?>" 
                                data-description="<?= htmlspecialchars($announcement['description']) ?>" 
                                data-phone="<?= htmlspecialchars($announcement['phone']) ?>">
                            Edit
                        </button>
                        <form method="POST" action="../../controllers/AnnouncementController.php" style="display: inline;">
                            <input type="hidden" name="delete_id" value="<?= htmlspecialchars($announcement['id_annonce']) ?>">
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        </main>
    </div>

    <!-- Popup Form -->
    <div id="popup-form" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Create Announcement</h2>
            <form id="create-announcement-form" action="../../controllers/AnnouncementController.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="announcement-name">Name</label>
                    <input type="text" id="announcement-name" name="name" class="form-control" placeholder="Enter your name" required>
                </div>
                <div class="form-group">
                    <label for="announcement-address">Address</label>
                    <input type="text" id="announcement-address" name="address" class="form-control" placeholder="Enter address" required>
                </div>
                <div class="form-group">
                    <label for="announcement-image">Image (optional)</label>
                    <input type="file" id="announcement-image" name="image" class="form-control">
                </div>
                <div class="form-group">
                    <label for="announcement-description">Description</label>
                    <textarea id="announcement-description" name="description" class="form-control" rows="4" placeholder="Enter description" required></textarea>
                </div>
                <div class="form-group">
                    <label for="announcement-phone">Cell Phone</label>
                    <input type="tel" id="announcement-phone" name="phone" class="form-control" placeholder="Enter cell phone number" required>
                </div>
                <button type="submit" class="btn btn-primary">Create Announcement</button>
            </form>
        </div>
    </div>

    <script>
        // Handle popup form
        const popup = document.getElementById('popup-form');
        const createPostBtn = document.getElementById('create-post-btn');
        const closeBtn = document.querySelector('.close');

        createPostBtn.onclick = () => popup.style.display = 'flex';
        closeBtn.onclick = () => popup.style.display = 'none';
        window.onclick = (e) => { if (e.target === popup) popup.style.display = 'none'; };

        // Handle edit button click
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function () {
                document.getElementById('announcement-name').value = this.dataset.name;
                document.getElementById('announcement-address').value = this.dataset.address;
                document.getElementById('announcement-description').value = this.dataset.description;
                document.getElementById('announcement-phone').value = this.dataset.phone;
                document.getElementById('create-announcement-form').action = `../../controllers/AnnouncementController.php?edit_id=${this.dataset.id}`;
                popup.style.display = 'flex';
            });
        });

        // Handle post deletion
        document.getElementById('posts-container').addEventListener('click', function(e) {
            if (e.target.classList.contains('delete-post-btn')) {
                e.target.parentElement.remove();
            }
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
