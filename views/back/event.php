<?php
require_once __DIR__ . '/../../controllers/EventController.php';

$eventController = new EventController();
$events = $eventController->getEvents();
$reservations = []; // Placeholder for reservations (fetch logic can be added if needed)

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_event_id'])) {
        $eventController->deleteEvent($_POST['delete_event_id']);
        header("Location: event.php");
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
    header("Location: event.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Event</title>
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
                <a href="#">
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
                <a href="index.php">
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
                <a href="event.php" class="active">
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
        <!-- End of Sidebar Section -->

        <!-- Main Content -->
        <main>
            <h1>Event Management</h1>

            <!-- Display Events -->
            <h2>Existing Events</h2>
            <?php foreach ($events as $event): ?>
                <div class="event-card">
                    <h4><?= htmlspecialchars($event['nom']) ?> (<?= htmlspecialchars($event['category_name']) ?>)</h4>
                    <p><?= htmlspecialchars($event['description']) ?></p>
                    <p><strong>Date:</strong> <?= $event['date_debut'] ?> to <?= $event['date_fin'] ?></p>
                    <p><strong>Location:</strong> <?= htmlspecialchars($event['lieu']) ?></p>
                    <form method="POST" action="event.php" class="d-inline">
                        <input type="hidden" name="delete_event_id" value="<?= $event['id_evenement'] ?>">
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            <?php endforeach; ?>

            <!-- Display Reservations -->
            <h2>Reservations</h2>
            <?php foreach ($reservations as $reservation): ?>
                <div class="reservation-card">
                    <p><strong>Event:</strong> <?= htmlspecialchars($reservation['event_name']) ?></p>
                    <p><strong>User:</strong> <?= htmlspecialchars($reservation['user_name']) ?></p>
                    <p><strong>Date Reserved:</strong> <?= $reservation['date_reservation'] ?></p>
                </div>
            <?php endforeach; ?>

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