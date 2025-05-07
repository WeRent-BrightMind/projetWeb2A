<?php
// filepath: c:\xampp1\htdocs\andolsi2\views\back\complaint.php
require_once '../../controllers/ComplaintController.php';

session_start();


$controller = new ComplaintController();

// Handle form actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_complaint'])) {
        $id = $_POST['id'] ?? null;
        if ($id && $controller->delete($id)) {
            $_SESSION['message'] = "Complaint deleted successfully!";
        } else {
            $_SESSION['error'] = "Failed to delete complaint.";
        }
        header("Location: complaint.php");
        exit();
    }

    if (isset($_POST['submit_response'])) {
        $complaintId = $_POST['complaint_id'] ?? null;
        $response = $_POST['response'] ?? null;
        
        if ($complaintId && $response && $controller->respond($complaintId, $response)) {
            $_SESSION['message'] = "Response submitted successfully!";
            // Update complaint status to "in progress"
            $controller->updateStatus($complaintId, 'en_cours');
        } else {
            $_SESSION['error'] = "Failed to submit response.";
        }
        header("Location: complaint.php");
        exit();
    }

    if (isset($_POST['update_status'])) {
        $complaintId = $_POST['complaint_id'] ?? null;
        $status = $_POST['status'] ?? null;
        
        if ($complaintId && $status && $controller->updateStatus($complaintId, $status)) {
            $_SESSION['message'] = "Status updated successfully!";
        } else {
            $_SESSION['error'] = "Failed to update status.";
        }
        header("Location: complaint.php");
        exit();
    }
}

// Fetch all complaints
$complaints = $controller->getAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Complaint Management</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
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
                <span class="material-icons-sharp">close</span>
            </div>
        </div>

        <div class="sidebar">
            <a href="#">
                <span class="material-icons-sharp">dashboard</span>
                <h3>Dashboard</h3>
            </a>
            <a href="#">
                <span class="material-icons-sharp">person_outline</span>
                <h3>Users</h3>
            </a>
            <a href="blog.php">
                <span class="material-icons-sharp">receipt_long</span>
                <h3>Blog</h3>
            </a>
            <a href="index.php">
                <span class="material-icons-sharp">insights</span>
                <h3>Analytics</h3>
            </a>
            <a href="complaint.php" class="active">
                <span class="material-icons-sharp">mail_outline</span>
                <h3>Complaint</h3>
                <span class="message-count">27</span>
            </a>
            <a href="event.php">
                <span class="material-icons-sharp">inventory</span>
                <h3>Event</h3>
            </a>
            <a href="annoucement.php">
                <span class="material-icons-sharp">report_gmailerrorred</span>
                <h3>Announcement</h3>
            </a>
            <a href="#">
                <span class="material-icons-sharp">add</span>
                <h3>New Login</h3>
            </a>
            <a href="#" id="logout-btn">
                <span class="material-icons-sharp">logout</span>
                <h3>Logout</h3>
            </a>
        </div>
    </aside>
    <!-- End of Sidebar Section -->

    <!-- Main Content -->
    <main>
        <h1>Complaint Management</h1>

        <!-- Alerts -->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-success"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
        <?php endif; ?>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <!-- Filters -->
        <div class="card mb-4">
            <div class="card-body">
                <form class="row g-3">
                    <div class="col-md-6">
                        <input type="text" class="form-control" placeholder="Search complaints...">
                    </div>
                    <div class="col-md-3">
                        <select class="form-select">
                            <option value="">All Types</option>
                            <option value="annonce">Annonce</option>
                            <option value="utilisateur">Utilisateur</option>
                            <option value="paiement">Paiement</option>
                            <option value="autre">Autre</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select">
                            <option value="">All Statuses</option>
                            <option value="nouveau">Nouveau</option>
                            <option value="en_cours">En cours</option>
                            <option value="resolu">Résolu</option>
                            <option value="rejete">Rejeté</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>

        <!-- Complaints Table -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User Email</th>
                                <th>Subject</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Responses</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($complaints)): ?>
                                <tr>
                                    <td colspan="8" class="text-center">No complaints found</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($complaints as $complaint): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($complaint['id_reclamation']) ?></td>
                                        <td><?= htmlspecialchars($complaint['email']) ?></td>
                                        <td><?= htmlspecialchars($complaint['sujet']) ?></td>
                                        <td><?= ucfirst(htmlspecialchars($complaint['type'])) ?></td>
                                        <td>
                                            <span class="badge badge-<?= str_replace('_', '-', $complaint['statut']) ?>">
                                                <?= ucfirst(str_replace('_', ' ', $complaint['statut'])) ?>
                                            </span>
                                        </td>
                                        <td><?= date('d/m/Y H:i', strtotime($complaint['date_creation'])) ?></td>
                                        <td>
                                            <?php if (!empty($responses = $controller->getResponsesForComplaint($complaint['id_reclamation']))): ?>
                                                <?php foreach ($responses as $response): ?>
                                                    <div class="response-item">
                                                        <p><?= htmlspecialchars($response['reponse']) ?></p>
                                                        <small class="text-muted"><?= date('d/m/Y H:i', strtotime($response['date_reponse'])) ?></small>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <span class="text-muted">No responses</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" 
                                                        data-bs-target="#responseModal" 
                                                        data-id="<?= $complaint['id_reclamation'] ?>">
                                                    Respond
                                                </button>
                                                <form method="POST" action="complaint.php" class="d-inline">
                                                    <input type="hidden" name="id" value="<?= $complaint['id_reclamation'] ?>">
                                                    <button type="submit" name="delete_complaint" class="btn btn-danger btn-sm" 
                                                            onclick="return confirm('Are you sure you want to delete this complaint?')">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Response Modal -->
<div class="modal fade" id="responseModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Respond to Complaint</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="complaint.php">
                <input type="hidden" name="complaint_id" id="modalComplaintId">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="responseText" class="form-label">Your Response</label>
                        <textarea class="form-control" id="responseText" name="response" rows="5" placeholder="Write your response here..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="submit_response" class="btn btn-primary">Send Response</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Initialize response modal with complaint ID
    var responseModal = document.getElementById('responseModal');
    responseModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget; // Button that triggered the modal
        var complaintId = button.getAttribute('data-id'); // Extract complaint ID from data-id attribute
        var modalInput = responseModal.querySelector('#modalComplaintId'); // Find the hidden input in the modal
        modalInput.value = complaintId; // Set the complaint ID in the hidden input
    });

    // Ensure the modal is interactive and no overlapping elements block input
    document.addEventListener('DOMContentLoaded', function () {
        var modalElement = new bootstrap.Modal(document.getElementById('responseModal'));
    });

    // Fix potential z-index issues with overlapping elements
    document.querySelectorAll('.modal').forEach(function (modal) {
        modal.addEventListener('shown.bs.modal', function () {
            document.body.style.overflow = 'hidden'; // Prevent background scrolling
        });
        modal.addEventListener('hidden.bs.modal', function () {
            document.body.style.overflow = ''; // Restore scrolling
        });
    });
</script>
</body>
</html>