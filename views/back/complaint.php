<?php
// filepath: c:\xampp1\htdocs\andolsi2\views\back\complaint.php
require_once '../../controllers/ComplaintController.php';

$controller = new ComplaintController();

// Fetch all complaints
$complaints = $controller->index();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'delete') {
    $id = $_POST['id'] ?? null;
    if ($id) {
        $controller = new ComplaintController();
        if ($controller->delete($id)) {
            echo '<div class="alert alert-success">Complaint deleted successfully!</div>';
        } else {
            echo '<div class="alert alert-danger">Failed to delete the complaint. Please try again.</div>';
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'respond') {
    $id = $_POST['id'] ?? null;
    $response = $_POST['response'] ?? null;

    if ($id && $response) {
        $controller = new ComplaintController();
        if ($controller->respond($id, $response)) {
            // Redirect to the same page to refresh the list
            header("Location: complaint.php");
            exit;
        } else {
            echo '<div class="alert alert-danger">Failed to send the response. Please try again.</div>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Complaint Management</title>
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
                <a href="index.php">
                    <span class="material-icons-sharp">dashboard</span>
                    <h3>Dashboard</h3>
                </a>
                <a href="user-management.php">
                    <span class="material-icons-sharp">person_outline</span>
                    <h3>Users</h3>
                </a>
                <a href="blog-management.php">
                    <span class="material-icons-sharp">receipt_long</span>
                    <h3>Blog</h3>
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
            <div class="new-users">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search complaints...">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">Search</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="filter-section float-right">
                            <select class="form-control">
                                <option>All Status</option>
                                <option>Open</option>
                                <option>In Progress</option>
                                <option>Resolved</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="container mt-5">
        <h1 class="text-center">Admin - Complaint Management</h1>
        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User ID</th>
                    <th>Description</th>
                    <th>Date Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($complaints as $complaint): ?>
                    <tr>
                        <td><?= htmlspecialchars($complaint['id_reclamation']) ?></td>
                        <td><?= htmlspecialchars($complaint['id_utilisateur']) ?></td>
                        <td><?= htmlspecialchars($complaint['description']) ?></td>
                        <td><?= htmlspecialchars($complaint['date_creation']) ?></td>
                        <td>
                            <form method="POST" action="complaint.php?action=delete" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $complaint['id_reclamation'] ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                            <button class="btn btn-primary btn-sm respond-btn" data-id="<?= $complaint['id_reclamation'] ?>">Respond</button>
                            <button class="btn btn-info btn-sm view-responses-btn" data-id="<?= $complaint['id_reclamation'] ?>">View Responses</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
            </div>
        </main>
        <!-- End of Main Content -->

        <!-- Right Section -->
        <div class="right-section">
            <!-- ...existing code from index.html right section... -->
        </div>
    </div>

    <!-- Popup Modal -->
    <div id="resolveModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Send Message to User</h2>
            <form id="resolveForm">
                <div class="form-group">
                    <label for="userEmail">User Email</label>
                    <input type="email" id="userEmail" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea id="message" class="form-control" rows="5" placeholder="Write your message here..." required></textarea>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Send</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Popup Modal for Responding -->
    <div id="respondModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Respond to Complaint</h2>
            <form id="respondForm" method="POST" action="../../controllers/ComplaintController.php?action=respond">
                <input type="hidden" id="complaintId" name="id">
                <div class="form-group">
                    <label for="response">Response</label>
                    <textarea id="response" name="response" class="form-control" rows="5" placeholder="Write your response here..." required></textarea>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Send Response</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Popup Modal for Viewing Responses -->
    <div id="viewResponsesModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Responses for Complaint</h2>
            <div id="responsesContainer">
                <!-- Responses will be dynamically loaded here -->
            </div>
        </div>
    </div>

    <script>
        // Logout functionality
        document.getElementById('logout-btn').addEventListener('click', function(e) {
            e.preventDefault();
            alert('You have been logged out.');
            window.location.href = '../front/user-management.html'; // Redirect to front login page
        });

        // Modal functionality
        const modal = document.getElementById('resolveModal');
        const closeModal = document.querySelector('.modal .close');
        const resolveButtons = document.querySelectorAll('.resolve-btn');
        const userEmailInput = document.getElementById('userEmail');

        resolveButtons.forEach(button => {
            button.addEventListener('click', () => {
                const userEmail = button.getAttribute('data-email');
                userEmailInput.value = userEmail;
                modal.style.display = 'block';
            });
        });

        closeModal.addEventListener('click', () => {
            modal.style.display = 'none';
        });

        window.addEventListener('click', (event) => {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });

        // Form submission  a
        document.getElementById('resolveForm').addEventListener('submit', (e) => {
            e.preventDefault();
            alert(`Message sent to ${userEmailInput.value}`);
            modal.style.display = 'none';
        });

        // Respond Modal functionality
        const respondModal = document.getElementById('respondModal');
        const closeRespondModal = document.querySelector('.modal .close');
        const respondButtons = document.querySelectorAll('.respond-btn');
        const complaintIdInput = document.getElementById('complaintId');

        respondButtons.forEach(button => {
            button.addEventListener('click', () => {
                const complaintId = button.getAttribute('data-id');
                complaintIdInput.value = complaintId;
                respondModal.style.display = 'block';
            });
        });

        closeRespondModal.addEventListener('click', () => {
            respondModal.style.display = 'none';
        });

        window.addEventListener('click', (event) => {
            if (event.target === respondModal) {
                respondModal.style.display = 'none';
            }
        });

        // View Responses Modal functionality
        const viewResponsesModal = document.getElementById('viewResponsesModal');
        const closeViewResponsesModal = document.querySelector('#viewResponsesModal .close');
        const viewResponsesButtons = document.querySelectorAll('.view-responses-btn');
        const responsesContainer = document.getElementById('responsesContainer');

        viewResponsesButtons.forEach(button => {
            button.addEventListener('click', () => {
                const complaintId = button.getAttribute('data-id');
                fetch(`../../controllers/ComplaintController.php?action=getResponses&id=${complaintId}`)
                    .then(response => response.json())
                    .then(data => {
                        responsesContainer.innerHTML = '';
                        if (data.length > 0) {
                            data.forEach(response => {
                                const responseDiv = document.createElement('div');
                                responseDiv.classList.add('response-item');
                                responseDiv.innerHTML = `
                                    <p><strong>Response:</strong> ${response.reponse}</p>
                                    <p><strong>Date:</strong> ${response.date_reponse}</p>
                                    <hr>
                                `;
                                responsesContainer.appendChild(responseDiv);
                            });
                        } else {
                            responsesContainer.innerHTML = '<p>No responses available for this complaint.</p>';
                        }
                        viewResponsesModal.style.display = 'block';
                    });
            });
        });

        closeViewResponsesModal.addEventListener('click', () => {
            viewResponsesModal.style.display = 'none';
        });

        window.addEventListener('click', (event) => {
            if (event.target === viewResponsesModal) {
                viewResponsesModal.style.display = 'none';
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
