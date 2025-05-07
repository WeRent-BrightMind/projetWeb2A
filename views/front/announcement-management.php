<?php
session_start();
require_once __DIR__ . '/../../controllers/AnnouncementController.php';

$controller = new AnnouncementController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_id']) && !empty($_POST['delete_id'])) {
        $deleteResult = $controller->deleteAnnouncement($_POST['delete_id']);
        if ($deleteResult) {
            $_SESSION['announcement_success'] = 'Announcement deleted successfully.';
            header("Location: announcement-management.php");
            exit;
        } else {
            $_SESSION['announcement_error'] = 'Failed to delete the announcement. Please try again.';
        }
    } elseif (isset($_POST['edit_id'])) {
        $updateResult = $controller->updateAnnouncement($_POST['edit_id'], $_POST, $_FILES);
        if ($updateResult) {
            $_SESSION['announcement_success'] = 'Announcement updated successfully.';
            header("Location: announcement-management.php");
            exit;
        }
    } else {
        $createResult = $controller->createAnnouncement($_POST, $_FILES);
        if ($createResult) {
            $_SESSION['announcement_success'] = 'Announcement created successfully.';
            header("Location: announcement-management.php");
            exit;
        }
    }
}

$selected_category = isset($_GET['category']) ? $_GET['category'] : null;
$announcements = $controller->getAnnouncements($selected_category);
$categories = $controller->getCategories();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Announcement Management</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/templatemo-style.css">
    <style>
        .error-message {
            color: red;
            font-size: 0.8em;
        }
        .announcement-card {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .announcement-card img {
            max-width: 100%;
            max-height: 200px;
            margin-top: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px;
        }
        .btn-container {
            margin-top: 15px;
        }
        .btn-container form {
            display: inline-block;
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <div class="tm-main-content" id="top">
        <div class="tm-top-bar-bg"></div>    
        <div class="tm-top-bar" id="tm-top-bar">
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
            <h2 class="mb-4">Manage Announcements</h2>
            <p class="text-muted mb-4">Create, edit, and delete platform announcements.</p>

            <!-- Success/Error Messages -->
            <?php if (isset($_SESSION['announcement_success'])): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <?= $_SESSION['announcement_success']; unset($_SESSION['announcement_success']); ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['announcement_error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <?= $_SESSION['announcement_error']; unset($_SESSION['announcement_error']); ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <!-- Create Announcement Form -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Create New Announcement</h5>
                </div>
                <div class="card-body">
                    <form id="create-announcement-form" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="announcement-name">Name</label>
                            <input type="text" id="announcement-name" name="name" class="form-control" 
                                   value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '' ?>" 
                                   placeholder="Enter announcement name">
                            <?php if (isset($_SESSION['announcement_errors']['name'])): ?>
                                <div class="error-message"><?= $_SESSION['announcement_errors']['name']; unset($_SESSION['announcement_errors']['name']); ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="announcement-address">Address</label>
                            <input type="text" id="announcement-address" name="address" class="form-control" 
                                   value="<?= isset($_POST['address']) ? htmlspecialchars($_POST['address']) : '' ?>" 
                                   placeholder="Enter address">
                            <?php if (isset($_SESSION['announcement_errors']['address'])): ?>
                                <div class="error-message"><?= $_SESSION['announcement_errors']['address']; unset($_SESSION['announcement_errors']['address']); ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="announcement-description">Description</label>
                            <textarea id="announcement-description" name="description" class="form-control" rows="4" 
                                      placeholder="Enter description"><?= isset($_POST['description']) ? htmlspecialchars($_POST['description']) : '' ?></textarea>
                            <?php if (isset($_SESSION['announcement_errors']['description'])): ?>
                                <div class="error-message"><?= $_SESSION['announcement_errors']['description']; unset($_SESSION['announcement_errors']['description']); ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="announcement-phone">Phone Number</label>
                            <input type="tel" id="announcement-phone" name="phone" class="form-control" 
                                   value="<?= isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : '' ?>" 
                                   placeholder="Enter phone number">
                            <?php if (isset($_SESSION['announcement_errors']['phone'])): ?>
                                <div class="error-message"><?= $_SESSION['announcement_errors']['phone']; unset($_SESSION['announcement_errors']['phone']); ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="announcement-category">Category</label>
                            <select id="announcement-category" name="category_id" class="form-control">
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= htmlspecialchars($category['id_categorie']) ?>" 
                                        <?= (isset($_POST['category_id']) && $_POST['category_id'] == $category['id_categorie']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($category['nom']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?php if (isset($_SESSION['announcement_errors']['category_id'])): ?>
                                <div class="error-message"><?= $_SESSION['announcement_errors']['category_id']; unset($_SESSION['announcement_errors']['category_id']); ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="announcement-image">Image</label>
                            <input type="file" id="announcement-image" name="image" class="form-control-file">
                            <?php if (isset($_SESSION['announcement_errors']['image'])): ?>
                                <div class="error-message"><?= $_SESSION['announcement_errors']['image']; unset($_SESSION['announcement_errors']['image']); ?></div>
                            <?php endif; ?>
                        </div>
                        <button type="submit" class="btn btn-primary">Create Announcement</button>
                    </form>
                </div>
            </div>

            <!-- Filter Form -->
            <div class="filter-container card mb-4">
                <div class="card-body">
                    <form method="GET" class="form-inline">
                        <div class="form-group mr-3">
                            <label for="category-filter" class="mr-2">Filter by Category:</label>
                            <select id="category-filter" name="category" class="form-control" onchange="this.form.submit()">
                                <option value="">All Categories</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= htmlspecialchars($category['id_categorie']) ?>" 
                                        <?= ($selected_category == $category['id_categorie']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($category['nom']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <a href="announcement-management.php" class="btn btn-secondary">Reset Filter</a>
                    </form>
                </div>
            </div>

            <!-- Announcements List -->
            <h3 class="mb-3">Current Announcements</h3>
            
            <?php if (empty($announcements)): ?>
                <div class="alert alert-info">No announcements found.</div>
            <?php else: ?>
                <?php foreach ($announcements as $announcement): ?>
                    <div class="announcement-card">
                        <h4><?= htmlspecialchars($announcement['name']) ?></h4>
                        <p><?= htmlspecialchars($announcement['description']) ?></p>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Address:</strong> <?= htmlspecialchars($announcement['address']) ?></p>
                                <p><strong>Phone:</strong> <?= htmlspecialchars($announcement['phone']) ?></p>
                                <p><strong>Category:</strong> <?= htmlspecialchars($announcement['category_name'] ?? 'N/A') ?></p>
                            </div>
                            <?php if (!empty($announcement['image'])): ?>
                                <div class="col-md-6 text-right">
                                    <img src="<?= htmlspecialchars($announcement['image']) ?>" alt="Announcement Image" class="img-fluid">
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="btn-container">
                            <form method="POST" onsubmit="return confirm('Are you sure you want to delete this announcement?');">
                                <input type="hidden" name="delete_id" value="<?= htmlspecialchars($announcement['id_annonce']) ?>">
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
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <!-- Edit Modal -->
            <div id="editModal" class="modal fade" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <form method="POST" enctype="multipart/form-data">
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
                                <div class="form-group">
                                    <label for="edit-image">New Image (optional)</label>
                                    <input type="file" id="edit-image" name="image" class="form-control-file">
                                    <small class="form-text text-muted">Leave blank to keep current image</small>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="tm-container-outer tm-position-relative" id="tm-section-4">
            <footer class="tm-container-outer">
                <p class="mb-0">Copyright © <span class="tm-current-year">2025</span> WeRent</p>
            </footer>
        </div>
    </div>

    <!-- Scripts -->
    <script src="js/jquery-1.11.3.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
        $(function () {
            // Handle "Create Announcement" button click
            $('#create-announcement-btn').on('click', function () {
                const modal = $('#editModal');
                modal.find('.modal-title').text('Create Announcement');
                modal.find('form').attr('action', 'announcement-management.php');
                modal.find('form')[0].reset(); // Clear the form
                modal.find('#edit-id').val(''); // Clear the hidden ID field
                modal.modal('show');
            });

            // Handle "Edit Announcement" button click
            $('.edit-btn').on('click', function () {
                const modal = $('#editModal');
                modal.find('.modal-title').text('Edit Announcement');
                modal.find('form').attr('action', 'announcement-management.php');
                modal.find('#edit-id').val($(this).data('id'));
                modal.find('#edit-name').val($(this).data('name'));
                modal.find('#edit-address').val($(this).data('address'));
                modal.find('#edit-description').val($(this).data('description'));
                modal.find('#edit-phone').val($(this).data('phone'));
                modal.find('#edit-category').val($(this).data('category'));
                modal.modal('show');
            });

            // Close modal on cancel button click
            $('.modal .btn-secondary').on('click', function () {
                $('#editModal').modal('hide');
            });
        });
    </script>
</body>
</html>
<?php
// Clear any remaining error messages
if (isset($_SESSION['announcement_errors'])) {
    unset($_SESSION['announcement_errors']);
}
?>