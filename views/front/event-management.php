<?php
require_once __DIR__ . '/../../controllers/EventController.php'; // Corrected path

$eventController = new EventController();
$events = $eventController->getEvents();
$categories = $eventController->getCategories();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_event_id'])) {
        $eventController->deleteEvent($_POST['delete_event_id']);
        header("Location: event-management.php");
        exit;
    }

    $eventData = [
        'id_utilisateur' => 1, // Admin ID
        'nom' => $_POST['nom'],
        'description' => $_POST['description'],
        'date_debut' => $_POST['date_debut'],
        'date_fin' => $_POST['date_fin'],
        'lieu' => $_POST['lieu'],
        'type' => $_POST['type'],
        'statut' => 'actif',
        'id_categorie' => $_POST['id_categorie']
    ];
    $eventController->postEvent($eventData);
    header("Location: event-management.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Event Management</title>
    <link rel="stylesheet" href="css/event-style.css">
    <!-- Reuse existing styles -->
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
        <h2 class="event-title">Manage Events</h2>
        <p class="event-description">Schedule and update community events or promotions.</p>
        
        <!-- Display Events -->
        <?php foreach ($events as $event): ?>
            <div class="event-card">
                <h4><?= htmlspecialchars($event['nom']) ?> (<?= htmlspecialchars($event['category_name']) ?>)</h4>
                <p><?= htmlspecialchars($event['description']) ?></p>
                <p><strong>Date:</strong> <?= $event['date_debut'] ?> to <?= $event['date_fin'] ?></p>
                <p><strong>Location:</strong> <?= htmlspecialchars($event['lieu']) ?></p>
                <button class="btn btn-primary reserve-btn" data-event-id="<?= $event['id_evenement'] ?>" data-event-name="<?= htmlspecialchars($event['nom']) ?>">Reserve</button>
                <form method="POST" action="event-management.php" class="d-inline">
                    <input type="hidden" name="delete_event_id" value="<?= $event['id_evenement'] ?>">
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        <?php endforeach; ?>

        <!-- Reservation Modal -->
        <div id="reservationModal" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form id="reservationForm" method="POST" action="reserve.php">
                        <div class="modal-header">
                            <h5 class="modal-title">Reserve Event</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="event_id" id="event_id">
                            <div class="form-group">
                                <label for="user_name">Your Name</label>
                                <input type="text" name="user_name" id="user_name" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Reserve</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const reserveButtons = document.querySelectorAll('.reserve-btn');
                const modal = document.getElementById('reservationModal');
                const eventIdInput = document.getElementById('event_id');

                reserveButtons.forEach(button => {
                    button.addEventListener('click', function () {
                        const eventId = this.getAttribute('data-event-id');
                        eventIdInput.value = eventId;
                        $(modal).modal('show');
                    });
                });
            });
        </script>

        <!-- Admin Post Event Form -->
        <form method="POST" class="mt-5">
            <h3>Post a New Event</h3>
            <div class="form-group">
                <label for="nom">Event Name</label>
                <input type="text" name="nom" id="nom" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label for="date_debut">Start Date</label>
                <input type="datetime-local" name="date_debut" id="date_debut" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="date_fin">End Date</label>
                <input type="datetime-local" name="date_fin" id="date_fin" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="lieu">Location</label>
                <input type="text" name="lieu" id="lieu" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="type">Type</label>
                <select name="type" id="type" class="form-control" required>
                    <option value="materiel">Material</option>
                    <option value="lieu">Location</option>
                    <option value="service">Service</option>
                </select>
            </div>
            <div class="form-group">
                <label for="id_categorie">Category</label>
                <select name="id_categorie" id="id_categorie" class="form-control" required>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['id_categorie'] ?>"><?= htmlspecialchars($category['nom']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Post Event</button>
        </form>
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
    </script>
</body>
</html>
