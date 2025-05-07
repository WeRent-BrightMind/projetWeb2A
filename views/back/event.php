<?php
require_once __DIR__ . '/../../controllers/EventController.php';

$eventController = new EventController();
$events = $eventController->getEvents();
$reservations = $eventController->getReservationsGroupedByEvent();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_event_id'])) {
        $eventController->deleteEvent($_POST['delete_event_id']);
        header("Location: event.php");
        exit;
    }

    if (isset($_POST['edit_event_id'])) {
        $eventData = [
            'id_evenement' => $_POST['edit_event_id'],
            'nom' => $_POST['nom'],
            'description' => $_POST['description'],
            'date_debut' => $_POST['date_debut'],
            'date_fin' => $_POST['date_fin'],
            'lieu' => $_POST['lieu'],
            'type' => $_POST['type'],
            'id_categorie' => $_POST['id_categorie']
        ];
        $eventController->updateEvent($eventData);
        header("Location: event.php");
        exit;
    }

    if (isset($_POST['delete_reservation_id'])) {
        $eventController->deleteReservation($_POST['delete_reservation_id']);
        header("Location: event.php");
        exit;
    }

    if (isset($_POST['edit_reservation_id'])) {
        $reservationData = [
            'id_reservation' => $_POST['edit_reservation_id'],
            'user_name' => $_POST['user_name']
        ];
        $eventController->updateReservation($reservationData);
        header("Location: event.php");
        exit;
    }

    $eventData = [
        'id_utilisateur' => 1,
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
    <style>
        .event-card {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
            background-color: #f9f9f9;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .event-card h4 {
            margin: 0 0 10px;
            color: #333;
        }
        .event-card p {
            margin: 5px 0;
            color: #555;
        }
        .event-card button {
            margin-top: 10px;
        }
        form.mt-5, .modal-content {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        form.mt-5 h3, .modal-content h3 {
            margin-bottom: 20px;
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }
        .form-group input, .form-group textarea, .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }
        .btn {
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }
        .btn-primary {
            background-color: #3498db;
            color: white;
            border: none;
        }
        .btn-primary:hover {
            background-color: #2980b9;
        }
        .btn-secondary {
            background-color: #95a5a6;
            color: white;
            border: none;
        }
        .btn-secondary:hover {
            background-color: #7f8c8d;
        }
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            width: 90%;
            max-width: 500px;
        }
        .reservation-list {
            margin-top: 10px;
            padding-left: 20px;
        }
        .reservation-item {
            margin-bottom: 10px;
            padding: 8px;
            background-color: #f0f0f0;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
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

        <main>
            <h1>Event Management</h1>

            <h2>Existing Events</h2>
            <?php foreach ($events as $event): ?>
                <div class="event-card">
                    <h4><?= htmlspecialchars($event['nom']) ?> (<?= htmlspecialchars($event['category_name']) ?>)</h4>
                    <p><?= htmlspecialchars($event['description']) ?></p>
                    <p><strong>Date:</strong> <?= $event['date_debut'] ?> to <?= $event['date_fin'] ?></p>
                    <p><strong>Location:</strong> <?= htmlspecialchars($event['lieu']) ?></p>
                    <form method="POST" action="event.php" class="d-inline">
                        <input type="hidden" name="delete_event_id" value="<?= $event['id_evenement'] ?>">
                        <button type="submit" class="btn btn-danger" style="background-color: #e74c3c; color: white; border: none; padding: 10px 15px; border-radius: 5px; cursor: pointer;">Delete</button>
                    </form>
                    <button class="btn btn-warning" style="background-color: #f39c12; color: white; border: none; padding: 10px 15px; border-radius: 5px; cursor: pointer;" onclick="openEditForm(<?= htmlspecialchars(json_encode($event)) ?>)">Edit</button>

                    <!-- Display Reservations for this Event -->
                    <h5>Reservations:</h5>
                    <div class="reservation-list">
                        <?php if (isset($reservations[$event['id_evenement']]) && count($reservations[$event['id_evenement']]) > 0): ?>
                            <?php foreach ($reservations[$event['id_evenement']] as $reservation): ?>
                                <div class="reservation-item">
                                    <strong>User Name:</strong> <?= htmlspecialchars($reservation['user_name']) ?><br>
                                    <strong>Date Reserved:</strong> <?= $reservation['date_reservation'] ?>
                                    <form method="POST" action="event.php" class="d-inline">
                                        <input type="hidden" name="delete_reservation_id" value="<?= $reservation['id_reservation'] ?>">
                                        <button type="submit" class="btn btn-danger" style="background-color: #e74c3c; color: white; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer; margin-top: 5px;">Delete</button>
                                    </form>
                                    <button class="btn btn-warning" style="background-color: #f39c12; color: white; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer; margin-top: 5px;" onclick="openEditReservationForm(<?= htmlspecialchars(json_encode($reservation)) ?>)">Edit</button>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No reservations for this event.</p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>

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
                        <?php foreach ($eventController->getCategories() as $category): ?>
                            <option value="<?= htmlspecialchars($category['id_categorie']) ?>">
                                <?= htmlspecialchars($category['nom']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Post Event</button>
            </form>

            <div id="editEventModal" class="modal">
                <form method="POST" class="modal-content">
                    <h3>Edit Event</h3>
                    <input type="hidden" name="edit_event_id" id="edit_event_id">
                    <div class="form-group">
                        <label for="edit_nom">Event Name</label>
                        <input type="text" name="nom" id="edit_nom" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_description">Description</label>
                        <textarea name="description" id="edit_description" class="form-control" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="edit_date_debut">Start Date</label>
                        <input type="datetime-local" name="date_debut" id="edit_date_debut" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_date_fin">End Date</label>
                        <input type="datetime-local" name="date_fin" id="edit_date_fin" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_lieu">Location</label>
                        <input type="text" name="lieu" id="edit_lieu" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_type">Type</label>
                        <select name="type" id="edit_type" class="form-control" required>
                            <option value="materiel">Material</option>
                            <option value="lieu">Location</option>
                            <option value="service">Service</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_id_categorie">Category</label>
                        <select name="id_categorie" id="edit_id_categorie" class="form-control" required>
                            <?php foreach ($eventController->getCategories() as $category): ?>
                                <option value="<?= htmlspecialchars($category['id_categorie']) ?>">
                                    <?= htmlspecialchars($category['nom']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <button type="button" class="btn btn-secondary" onclick="closeEditForm()">Cancel</button>
                </form>
            </div>

            <div id="editReservationModal" class="modal">
                <form method="POST" class="modal-content">
                    <h3>Edit Reservation</h3>
                    <input type="hidden" name="edit_reservation_id" id="edit_reservation_id">
                    <div class="form-group">
                        <label for="edit_user_name">User Name</label>
                        <input type="text" name="user_name" id="edit_user_name" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <button type="button" class="btn btn-secondary" onclick="closeEditReservationForm()">Cancel</button>
                </form>
            </div>
        </main>
    </div>

    <script>
        function openEditForm(event) {
            document.getElementById('edit_event_id').value = event.id_evenement;
            document.getElementById('edit_nom').value = event.nom;
            document.getElementById('edit_description').value = event.description;
            document.getElementById('edit_date_debut').value = event.date_debut.replace(' ', 'T');
            document.getElementById('edit_date_fin').value = event.date_fin.replace(' ', 'T');
            document.getElementById('edit_lieu').value = event.lieu;
            document.getElementById('edit_type').value = event.type;
            document.getElementById('edit_id_categorie').value = event.id_categorie;
            document.getElementById('editEventModal').style.display = 'block';
        }

        function closeEditForm() {
            document.getElementById('editEventModal').style.display = 'none';
        }

        function openEditReservationForm(reservation) {
            document.getElementById('edit_reservation_id').value = reservation.id_reservation;
            document.getElementById('edit_user_name').value = reservation.user_name;
            document.getElementById('editReservationModal').style.display = 'block';
        }

        function closeEditReservationForm() {
            document.getElementById('editReservationModal').style.display = 'none';
        }
    </script>
</body>
</html>