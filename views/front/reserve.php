<?php
require_once __DIR__ . '/../../controllers/EventController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $eventController = new EventController();
    $reservationData = [
        'id_evenement' => $_POST['event_id'],
        'id_locataire' => 1, // Replace with actual user ID from session
    ];
    $eventController->reserveEvent($reservationData);
    header("Location: event-management.php");
    exit;
}
?>
