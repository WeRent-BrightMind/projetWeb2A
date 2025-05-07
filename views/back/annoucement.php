<?php
require_once __DIR__ . '/../../controllers/AnnouncementController.php';

$controller = new AnnouncementController();

// Handle category creation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_category'])) {
    $categoryName = $_POST['category_name'];
    $categoryDesc = $_POST['category_description'];
    
    if (!empty($categoryName)) {
        $announcementModel = $controller->getAnnouncementModel(); // Ensure the model is retrieved correctly
        $stmt = $announcementModel->getDb()->prepare("
            INSERT INTO categories (nom, description) 
            VALUES (?, ?)
        ");
        $result = $stmt->execute([$categoryName, $categoryDesc]);
        
        if ($result) {
            $_SESSION['category_success'] = "Category created successfully!";
        } else {
            $_SESSION['category_error'] = "Failed to create category.";
        }
    } else {
        $_SESSION['category_error'] = "Category name is required.";
    }
    header("Location: annoucement.php");
    exit;
}

// Handle category deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_category_id'])) {
    $categoryId = $_POST['delete_category_id'];
    
    $announcementModel = $controller->getAnnouncementModel(); // Ensure the model is retrieved correctly

    // Check if the category is used in the `evenements` table
    $stmt = $announcementModel->getDb()->prepare("
        SELECT COUNT(*) FROM evenements WHERE id_categorie = ?
    ");
    $stmt->execute([$categoryId]);
    $eventCount = $stmt->fetchColumn();

    if ($eventCount > 0) {
        $_SESSION['category_error'] = "Cannot delete category - it's being used by events.";
    } else {
        // Check if the category is used in the `annonces` table
        $stmt = $announcementModel->getDb()->prepare("
            SELECT COUNT(*) FROM annonces WHERE id_categorie = ?
        ");
        $stmt->execute([$categoryId]);
        $announcementCount = $stmt->fetchColumn();

        if ($announcementCount > 0) {
            $_SESSION['category_error'] = "Cannot delete category - it's being used by announcements.";
        } else {
            $stmt = $announcementModel->getDb()->prepare("
                DELETE FROM categories WHERE id_categorie = ?
            ");
            $result = $stmt->execute([$categoryId]);
            
            if ($result) {
                $_SESSION['category_success'] = "Category deleted successfully!";
            } else {
                $_SESSION['category_error'] = "Failed to delete category.";
            }
        }
    }
    header("Location: annoucement.php");
    exit;
}

// Handle announcement operations
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_id']) && !empty($_POST['delete_id'])) {
        $controller->deleteAnnouncement($_POST['delete_id']);
    } elseif (isset($_GET['edit_id'])) {
        $controller->updateAnnouncement($_GET['edit_id'], $_POST, $_FILES);
    } else {
        $controller->createAnnouncement($_POST, $_FILES);
    }
    header("Location: annoucement.php");
    exit;
}

$announcements = $controller->getAnnouncements();
$categories = $controller->getCategories();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <title>Announcements</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .category-management {
            background: #f5f5f5;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
        }
        .category-form {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
            flex-wrap: wrap;
        }
        .category-form input, .category-form textarea {
            flex: 1;
            min-width: 200px;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .category-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        .category-item {
            background: #fff;
            padding: 8px 12px;
            border-radius: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .category-delete-btn {
            background: none;
            border: none;
            color: #ff4444;
            cursor: pointer;
            padding: 0;
            margin-left: 5px;
        }
        .alert {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
        }
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .section-title {
            margin-bottom: 15px;
            color: #333;
        }
        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
        }
        .btn-primary {
            background-color: #4285f4;
            color: white;
        }
        .btn-danger {
            background-color: #ff4444;
            color: white;
        }
        .btn-warning {
            background-color: #ffbb33;
            color: #333;
        }
        /* Add these new styles */
        .edit-category-form {
            display: none;
            background: #fff;
            padding: 15px;
            border-radius: 5px;
            margin-top: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .edit-category-form.active {
            display: block;
        }
        .category-edit-btn {
            background: none;
            border: none;
            color: #4285f4;
            cursor: pointer;
            padding: 0;
            margin-left: 5px;
        }
        .announcement-form-container {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }
        .announcement-form h2 {
            margin-bottom: 20px;
            color: #333;
        }
        .announcement-form .form-group {
            margin-bottom: 15px;
        }
        .announcement-form .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }
        .announcement-form .form-group input,
        .announcement-form .form-group textarea,
        .announcement-form .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }
        .announcement-form .form-group textarea {
            resize: vertical;
        }
        .announcement-form .form-group button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #4285f4;
            color: white;
            font-size: 14px;
            cursor: pointer;
        }
        .announcement-form .form-group button:hover {
            background-color: #357ae8;
        }
        .announcement-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .announcement-card h3 {
            margin: 0;
            font-size: 18px;
            color: #333;
        }
        .announcement-card p {
            margin: 5px 0;
            font-size: 14px;
            color: #555;
        }
        .announcement-card img {
            max-width: 100%;
            border-radius: 5px;
            margin-top: 10px;
        }
        .action-buttons {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }
        .action-buttons .btn {
            padding: 8px 12px;
            font-size: 14px;
            border-radius: 5px;
            text-decoration: none;
            text-align: center;
        }
        .btn-warning {
            background-color: #ffbb33;
            color: #333;
        }
        .btn-warning:hover {
            background-color: #e6a828;
        }
        .btn-danger {
            background-color: #ff4444;
            color: white;
        }
        .btn-danger:hover {
            background-color: #e63b3b;
        }
    </style>
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
            
                       <!-- Category Management Section -->
                       <div class="category-management">
                <h2 class="section-title">Category Management</h2>
                
                <?php if (isset($_SESSION['category_success'])): ?>
                    <div class="alert alert-success"><?= $_SESSION['category_success'] ?></div>
                    <?php unset($_SESSION['category_success']); ?>
                <?php endif; ?>
                
                <?php if (isset($_SESSION['category_error'])): ?>
                    <div class="alert alert-error"><?= $_SESSION['category_error'] ?></div>
                    <?php unset($_SESSION['category_error']); ?>
                <?php endif; ?>
                
                <form method="POST" class="category-form">
                    <input type="text" name="category_name" placeholder="Category Name" required>
                    <textarea name="category_description" placeholder="Description (optional)" rows="1"></textarea>
                    <button type="submit" name="create_category" class="btn btn-primary">Add Category</button>
                </form>
                
                <div class="category-list">
                    <?php foreach ($categories as $category): ?>
                        <div class="category-item">
                            <span class="category-name"><?= htmlspecialchars($category['nom']) ?></span>
                            <?php if (!empty($category['description'])): ?>
                                <span class="material-icons-sharp" title="<?= htmlspecialchars($category['description']) ?>" style="font-size:16px;">info</span>
                            <?php endif; ?>
                            <button class="category-edit-btn" data-id="<?= $category['id_categorie'] ?>">
                                <span class="material-icons-sharp" style="font-size:16px;">edit</span>
                            </button>
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="delete_category_id" value="<?= $category['id_categorie'] ?>">
                                <button type="submit" class="category-delete-btn" onclick="return confirm('Delete this category?')">
                                    <span class="material-icons-sharp" style="font-size:16px;">delete</span>
                                </button>
                            </form>
                            
                            <div class="edit-category-form" id="edit-form-<?= $category['id_categorie'] ?>">
                                <form method="POST" class="category-form">
                                    <input type="hidden" name="category_id" value="<?= $category['id_categorie'] ?>">
                                    <input type="text" name="category_name" value="<?= htmlspecialchars($category['nom']) ?>" required>
                                    <textarea name="category_description" rows="1"><?= htmlspecialchars($category['description'] ?? '') ?></textarea>
                                    <button type="submit" name="update_category" class="btn btn-primary">Update</button>
                                    <button type="button" class="btn btn-danger cancel-edit" data-id="<?= $category['id_categorie'] ?>">Cancel</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
             <!-- Announcement Management Section -->
             <h2 class="section-title">Announcement Management</h2>

            <!-- Display the form directly -->
            <div class="announcement-form-container">
                <div class="announcement-form">
                    <h2>Create Announcement</h2>
                    <form method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="name">Title</label>
                            <input type="text" id="name" name="name" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="category_id">Category</label>
                            <select id="category_id" name="category_id" class="form-control" required>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category['id_categorie'] ?>"><?= htmlspecialchars($category['nom']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" id="address" name="address" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea id="description" name="description" class="form-control" rows="4" required></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" id="phone" name="phone" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="image">Image (optional)</label>
                            <input type="file" id="image" name="image" class="form-control">
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </form>
                </div>
            </div>

            <div id="announcements-container">
                <?php foreach ($announcements as $announcement): ?>
                    <div class="announcement-card">
                        <h3><?= htmlspecialchars($announcement['name']) ?></h3>
                        <p><strong>Category:</strong> <?= htmlspecialchars($announcement['category_name']) ?></p>
                        <p><?= htmlspecialchars($announcement['description']) ?></p>
                        <p><strong>Address:</strong> <?= htmlspecialchars($announcement['address']) ?></p>
                        <p><strong>Phone:</strong> <?= htmlspecialchars($announcement['phone']) ?></p>
                        <?php if (!empty($announcement['image'])): ?>
                            <img src="<?= htmlspecialchars($announcement['image']) ?>" alt="Announcement Image">
                        <?php endif; ?>
                        
                        <div class="action-buttons">
                            <a href="annoucement.php?edit_id=<?= $announcement['id_annonce'] ?>" class="btn btn-warning">Edit</a>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="delete_id" value="<?= $announcement['id_annonce'] ?>">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </main>
    </div>

    <!-- Announcement Form Popup -->
    <div id="announcement-form-container" class="announcement-form-container" style="display:none;">
        <div class="announcement-form">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
                <h2><?= $editAnnouncement ? 'Edit' : 'Create' ?> Announcement</h2>
                <button id="close-form-btn" style="background:none; border:none; font-size:1.5rem; cursor:pointer;">&times;</button>
            </div>
            
            <form method="POST" enctype="multipart/form-data">
                <?php if ($editAnnouncement): ?>
                    <input type="hidden" name="announcement_id" value="<?= $editAnnouncement['id_annonce'] ?>">
                <?php endif; ?>
                
                <div class="form-group">
                    <label for="name">Title</label>
                    <input type="text" id="name" name="name" class="form-control" 
                           value="<?= $editAnnouncement ? htmlspecialchars($editAnnouncement['name']) : '' ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="category_id">Category</label>
                    <select id="category_id" name="category_id" class="form-control" required>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['id_categorie'] ?>" 
                                <?= ($editAnnouncement && $editAnnouncement['id_categorie'] == $category['id_categorie']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($category['nom']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" id="address" name="address" class="form-control" 
                           value="<?= $editAnnouncement ? htmlspecialchars($editAnnouncement['address']) : '' ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" class="form-control" rows="4" required><?= 
                        $editAnnouncement ? htmlspecialchars($editAnnouncement['description']) : '' ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone" class="form-control" 
                           value="<?= $editAnnouncement ? htmlspecialchars($editAnnouncement['phone']) : '' ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="image">Image (optional)</label>
                    <input type="file" id="image" name="image" class="form-control">
                    <?php if ($editAnnouncement && !empty($editAnnouncement['image'])): ?>
                        <p>Current image: <?= basename($editAnnouncement['image']) ?></p>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn btn-primary"><?= $editAnnouncement ? 'Update' : 'Create' ?></button>
                    <button type="button" id="cancel-form-btn" class="btn btn-danger">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Handle "Close" and "Cancel" buttons in the popup
        document.getElementById('close-form-btn').addEventListener('click', function () {
            document.getElementById('announcement-form-container').style.display = 'none';
        });

        document.getElementById('cancel-form-btn').addEventListener('click', function () {
            document.getElementById('announcement-form-container').style.display = 'none';
        });

        // Close the popup when clicking outside of it
        window.addEventListener('click', function (event) {
            const popup = document.getElementById('announcement-form-container');
            if (event.target === popup) {
                popup.style.display = 'none';
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
    <script>
        // Handle "Edit" button click
        document.querySelectorAll('.btn-warning').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const announcementId = this.getAttribute('href').split('=')[1];

                fetch(`annoucement.php?edit_id=${announcementId}`)
                    .then(response => response.json())
                    .then(data => {
                        const form = document.querySelector('.announcement-form form');
                        form.action = `annoucement.php?edit_id=${announcementId}`;
                        form.querySelector('#name').value = data.name;
                        form.querySelector('#address').value = data.address;
                        form.querySelector('#description').value = data.description;
                        form.querySelector('#phone').value = data.phone;
                        form.querySelector('#category_id').value = data.id_categorie;

                        // Change the button text to "Save"
                        const saveButton = form.querySelector('.btn-primary');
                        saveButton.textContent = 'Save';
                    })
                    .catch(error => console.error('Error fetching announcement:', error));
            });
        });
    </script>

    <?php
    // Handle AJAX request for fetching announcement data
    if (isset($_GET['edit_id']) && $_SERVER['REQUEST_METHOD'] === 'GET') {
        $announcementId = $_GET['edit_id'];
        $announcement = $controller->getAnnouncementById($announcementId);
        header('Content-Type: application/json');
        echo json_encode($announcement);
        exit;
    }

    // Handle announcement update
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['edit_id'])) {
        $editId = $_GET['edit_id'];
        $controller->updateAnnouncement($editId, $_POST, $_FILES);
        header("Location: annoucement.php");
        exit;
    }
    ?>
</body>
</html>