<?php
require_once __DIR__ . '/../../controllers/AnnouncementController.php'; // Use absolute path

$controller = new AnnouncementController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_id']) && !empty($_POST['delete_id'])) { // Ensure delete_id is set and not empty
        $deleteResult = $controller->deleteAnnouncement($_POST['delete_id']);
        if ($deleteResult) {
            header("Location: announcement-management.php");
            exit;
        } else {
            echo "<p class='text-danger'>Failed to delete the announcement. Please try again.</p>";
        }
    } elseif (isset($_POST['edit_id'])) {
        $controller->updateAnnouncement($_POST['edit_id'], $_POST);
        header("Location: announcement-management.php");
        exit;
    } else {
        $controller->createAnnouncement($_POST, $_FILES);
        header("Location: announcement-management.php");
        exit;
    }
}

$announcements = $controller->getAnnouncements();
$categories = $controller->getCategories(); // Fetch categories from the database
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Announcement Management</title>
    <link rel="stylesheet" href="css/announcement-style.css">
    <!-- Reuse existing styles and header from index.html -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/templatemo-style.css">
</head>
<body>
    <div class="tm-main-content" id="top">
        <div class="tm-top-bar-bg"></div>    
        <div class="tm-top-bar" id="tm-top-bar">
            <!-- Same header as index.html -->
            <div class="container">
                <div class="row">
                    <nav class="navbar navbar-expand-lg narbar-light">
                        <a class="navbar-brand mr-auto" href="index.html">
                            <img src="img/logo.png" alt="Site logo">
                            WeRent
                        </a>
                        <button type="button" id="nav-toggle" class="navbar-toggler collapsed" data-toggle="collapse" data-target="#mainNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div id="mainNav" class="collapse navbar-collapse tm-bg-white">
                            <ul class="navbar-nav ml-auto">
                                <li class="nav-item">
                                    <a class="nav-link" href="index.php">Home</a>
                                </li>
                                <li class="nav-item">
                                        <a class="nav-link" href="user-management.php">User Management</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="complaint-management.php">Complaint Management</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="blog-management.php">Blog Management</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="announcement-management.php">Announcement Management</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="event-management.php">Event Management</a>
                                    </li>
                               
                            </ul>
                        </div>                            
                    </nav>
                </div>
            </div>
        </div>

    <div class="container mt-5">
        <h2 class="announcement-title">Manage Announcements</h2>
        <p class="announcement-description">Create, edit, and delete platform announcements.</p>

        <!-- Form to create a new announcement -->
        <form id="create-announcement-form" class="mb-4" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="announcement-name">Name</label>
                <input type="text" id="announcement-name" name="name" class="form-control" placeholder="Enter your name" required>
            </div>
            <div class="form-group">
                <label for="announcement-address">Address</label>
                <input type="text" id="announcement-address" name="address" class="form-control" placeholder="Enter address" required>
            </div>
            <div class="form-group">
                <label for="announcement-description">Description</label>
                <textarea id="announcement-description" name="description" class="form-control" rows="4" placeholder="Enter description" required></textarea>
            </div>
            <div class="form-group">
                <label for="announcement-phone">Cell Phone</label>
                <input type="tel" id="announcement-phone" name="phone" class="form-control" placeholder="Enter cell phone number" required>
            </div>
            <div class="form-group">
                <label for="announcement-category">Category</label>
                <select id="announcement-category" name="category_id" class="form-control" required>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= htmlspecialchars($category['id_categorie']) ?>">
                            <?= htmlspecialchars($category['nom']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Create Announcement</button>
        </form>

        <!-- Display announcements from the database -->
        <?php foreach ($announcements as $announcement): ?>
            <div class="announcement-card">
                <h4><?= htmlspecialchars($announcement['name']) ?></h4>
                <p><?= htmlspecialchars($announcement['description']) ?></p>
                <p><strong>Address:</strong> <?= htmlspecialchars($announcement['address']) ?></p>
                <p><strong>Phone:</strong> <?= htmlspecialchars($announcement['phone']) ?></p>
                <?php if (!empty($announcement['image'])): ?>
                    <img src="<?= htmlspecialchars($announcement['image']) ?>" alt="Announcement Image" class="img-fluid">
                <?php endif; ?>
                <form method="POST" style="display: inline;">
                    <input type="hidden" name="delete_id" value="<?= htmlspecialchars($announcement['id_annonce']) ?>"> <!-- Ensure id_annonce exists -->
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
                <button class="btn btn-warning edit-btn" 
                        data-id="<?= htmlspecialchars($announcement['id_annonce']) ?>" 
                        data-name="<?= htmlspecialchars($announcement['name']) ?>" 
                        data-address="<?= htmlspecialchars($announcement['address']) ?>" 
                        data-description="<?= htmlspecialchars($announcement['description']) ?>" 
                        data-phone="<?= htmlspecialchars($announcement['phone']) ?>" 
                        data-category="<?= htmlspecialchars($announcement['id_categorie']) ?>">
                    Edit
                </button>
            </div>
        <?php endforeach; ?>

        <!-- Edit Modal -->
        <div id="editModal" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form method="POST">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Announcement</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="edit_id" id="edit-id">
                            <div class="form-group">
                                <label for="edit-name">Name</label>
                                <input type="text" id="edit-name" name="name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="edit-address">Address</label>
                                <input type="text" id="edit-address" name="address" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="edit-description">Description</label>
                                <textarea id="edit-description" name="description" class="form-control" rows="4" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="edit-phone">Phone</label>
                                <input type="tel" id="edit-phone" name="phone" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="edit-category">Category</label>
                                <select id="edit-category" name="category_id" class="form-control" required>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?= htmlspecialchars($category['id_categorie']) ?>">
                                            <?= htmlspecialchars($category['nom']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save changes</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Same footer as index.html -->
    <div class="tm-container-outer tm-position-relative" id="tm-section-4">
        <footer class="tm-container-outer">
            <p class="mb-0">Copyright © <span class="tm-current-year">2025</span> WeRent</p>
        </footer>
    </div>
    <!-- Same scripts as index.html -->
    <script src="js/jquery-1.11.3.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
        $(function(){
            // Change top navbar on scroll
            $(window).on("scroll", function() {
                if($(window).scrollTop() > 100) {
                    $(".tm-top-bar").addClass("active");
                } else {                    
                    $(".tm-top-bar").removeClass("active");
                }
            });

            // Close navbar after clicked
            $('.nav-link').click(function(){
                $('#mainNav').removeClass('show');
            });

            $('.tm-current-year').text(new Date().getFullYear());
        });

        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function () {
                document.getElementById('edit-id').value = this.dataset.id;
                document.getElementById('edit-name').value = this.dataset.name;
                document.getElementById('edit-address').value = this.dataset.address;
                document.getElementById('edit-description').value = this.dataset.description;
                document.getElementById('edit-phone').value = this.dataset.phone;
                document.getElementById('edit-category').value = this.dataset.category;
                $('#editModal').modal('show');
            });
        });
    </script>
</body>
</html>
