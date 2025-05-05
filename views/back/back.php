<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<<<<<<< HEAD
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
=======
>>>>>>> 4864be3ae163223f95b6db6290a654f10e05cb91
    <title>Réclamations Management</title>
    <style>
        .recent-orders {
            margin-top: 2rem;
            background: var(--color-white);
            padding: 1.5rem;
            border-radius: 1rem;
            box-shadow: var(--box-shadow);
            transition: all 300ms ease;
        }

        .recent-orders:hover {
            box-shadow: none;
        }

        .recent-orders table {
            width: 100%;
            margin-top: 1rem;
        }

        .recent-orders table thead {
            background: var(--color-light);
        }

        .recent-orders table th {
            padding: 0.8rem;
            text-align: left;
            color: var(--color-dark);
            font-weight: 600;
        }

        .recent-orders table td {
            padding: 0.8rem;
            border-bottom: 1px solid var(--color-light);
        }

        .recent-orders table tr:last-child td {
            border-bottom: none;
        }

        .recent-orders table tbody tr:hover {
            background: var(--color-light);
            cursor: pointer;
        }

        .status-select {
            padding: 0.4rem;
            border: 1px solid var(--color-light);
            border-radius: 0.4rem;
            background: var(--color-white);
            color: var(--color-dark);
            width: 100%;
            transition: all 300ms ease;
        }

        .status-select:focus {
            outline: none;
            border-color: var(--color-primary);
        }

        .btn-danger {
            background: var(--color-danger);
            padding: 0.5rem;
            border-radius: 0.4rem;
            color: var(--color-white);
            border: none;
            cursor: pointer;
            transition: all 300ms ease;
        }

        .btn-danger:hover {
            background: var(--color-danger-light);
            transform: scale(1.05);
        }

        .alert {
            padding: 1rem;
            border-radius: 0.4rem;
            margin-bottom: 1rem;
        }

        .alert.success {
            background: var(--color-success);
            color: var(--color-white);
        }

        .alert.error {
            background: var(--color-danger);
            color: var(--color-white);
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .page-header h1 {
            color: var(--color-dark);
            font-size: 1.8rem;
        }

        .status-badge {
            padding: 0.3rem 0.8rem;
            border-radius: 1rem;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .status-en-attente {
            background: var(--color-warning);
            color: var(--color-dark);
        }

        .status-en-cours {
            background: var(--color-primary);
            color: var(--color-white);
        }

        .status-resolu {
            background: var(--color-success);
            color: var(--color-white);
        }

        .status-rejete {
            background: var(--color-danger);
            color: var(--color-white);
        }

        .description-cell {
            max-width: 300px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .description-cell:hover {
            white-space: normal;
            overflow: visible;
        }

        .action-cell {
            width: 100px;
            text-align: center;
        }

        .date-cell {
            width: 150px;
        }

        .id-cell {
            width: 80px;
        }

        @media screen and (max-width: 768px) {
            .recent-orders {
                padding: 1rem;
            }

            .recent-orders table {
                display: block;
                overflow-x: auto;
            }

            .description-cell {
                max-width: 200px;
            }
        }

        /* Styles for response management */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }

        .modal-content {
            background-color: var(--color-white);
            margin: 10% auto;
            padding: 20px;
            border-radius: 10px;
            width: 80%;
            max-width: 600px;
            position: relative;
        }

        .close-modal {
            position: absolute;
            right: 20px;
            top: 10px;
            font-size: 28px;
            cursor: pointer;
        }

        .response-list {
            max-height: 300px;
            overflow-y: auto;
            margin: 20px 0;
        }

        .response-item {
            padding: 10px;
            border-bottom: 1px solid var(--color-light);
            margin-bottom: 10px;
        }

        .response-actions {
            display: flex;
            gap: 10px;
            margin-top: 5px;
        }

        .btn-primary {
            background: var(--color-primary);
            color: var(--color-white);
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 0.4rem;
            cursor: pointer;
        }

        .btn-primary:hover {
            background: var(--color-primary-variant);
        }

        .response-form textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid var(--color-light);
            border-radius: 0.4rem;
            resize: vertical;
        }

        .complaint-row {
            border-bottom: 1px solid var(--color-light);
        }

        .responses-section {
            display: none;
            background: var(--color-light);
            padding: 1rem;
            margin: 0.5rem 2rem;
            border-radius: 0.5rem;
        }

        .responses-section.active {
            display: block;
        }

        .response-item {
            background: var(--color-white);
            padding: 1rem;
            margin-bottom: 0.5rem;
            border-radius: 0.4rem;
            box-shadow: var(--box-shadow);
        }

        .response-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .response-date {
            font-size: 0.8rem;
            color: var(--color-dark-variant);
        }

        .response-actions {
            display: flex;
            gap: 0.5rem;
        }

        .new-response-form {
            margin-top: 1rem;
            background: var(--color-white);
            padding: 1rem;
            border-radius: 0.4rem;
        }

        .new-response-form textarea {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid var(--color-light);
            border-radius: 0.4rem;
            margin-bottom: 0.5rem;
            resize: vertical;
        }

        .toggle-responses {
            background: none;
            border: none;
            color: var(--color-primary);
            cursor: pointer;
            padding: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .toggle-responses:hover {
            color: var(--color-primary-variant);
        }

        .response-count {
            background: var(--color-primary);
            color: var(--color-white);
            padding: 0.2rem 0.5rem;
            border-radius: 1rem;
            font-size: 0.8rem;
        }
<<<<<<< HEAD

        .btn-stats, .btn-export, .btn-sort {
            background: var(--color-primary);
            color: var(--color-white);
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 0.4rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-left: 1rem;
        }

        .btn-stats:hover, .btn-export:hover, .btn-sort:hover {
            background: var(--color-primary-variant);
        }

        .sort-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .btn-sort {
            background: var(--color-dark);
            padding: 0.5rem;
        }

        .btn-sort:hover {
            background: var(--color-dark-variant);
        }

        .btn-sort.active {
            background: var(--color-primary);
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .stats-modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }

        .stats-modal-content {
            background-color: var(--color-white);
            margin: 10% auto;
            padding: 20px;
            border-radius: 10px;
            width: 80%;
            max-width: 600px;
            position: relative;
        }

        .chart-container {
            width: 100%;
            height: 400px;
            margin: 20px 0;
        }

        /* Pagination styles */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 2rem;
            gap: 1rem;
        }

        .pagination-info {
            color: var(--color-dark);
            font-size: 0.9rem;
        }

        .pagination-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .page-btn {
            background: var(--color-light);
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 0.4rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.3rem;
            color: var(--color-dark);
            transition: all 300ms ease;
        }

        .page-btn:hover:not(:disabled) {
            background: var(--color-primary);
            color: var(--color-white);
        }

        .page-btn:disabled {
            cursor: not-allowed;
            opacity: 0.5;
        }

        .page-btn.active {
            background: var(--color-primary);
            color: var(--color-white);
        }

        /* Search bar styles */
        .search-container {
            margin-bottom: 2rem;
            position: relative;
        }

        .search-input {
            width: 100%;
            padding: 1rem;
            padding-left: 3rem;
            border: 1px solid var(--color-light);
            border-radius: 0.5rem;
            font-size: 1rem;
            transition: all 300ms ease;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--color-primary);
            box-shadow: 0 0 0 2px var(--color-primary-light);
        }

        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--color-dark-variant);
        }

        .no-results {
            text-align: center;
            padding: 2rem;
            color: var(--color-dark-variant);
            font-style: italic;
        }
=======
>>>>>>> 4864be3ae163223f95b6db6290a654f10e05cb91
    </style>
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
                <a href="#">
                    <span class="material-icons-sharp">
                        insights
                    </span>
                    <h3>Analytics</h3>
                </a>
                <a href="back.php" class="active">
                    <span class="material-icons-sharp">
                        mail_outline
                    </span>
                    <h3>Complaint</h3>
                    <span class="message-count" id="complaints-count">0</span>
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
                    <h3>Announcement</h3>
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
            <div class="page-header">
                <h1>Gestion des Réclamations</h1>
<<<<<<< HEAD
                <div class="header-actions">
                    <div class="sort-buttons">
                        <button class="btn-sort" id="sortAsc" onclick="sortComplaints('asc')" title="Trier par date (plus ancien au plus récent)">
                            <span class="material-icons-sharp">arrow_upward</span>
                        </button>
                        <button class="btn-sort" id="sortDesc" onclick="sortComplaints('desc')" title="Trier par date (plus récent au plus ancien)">
                            <span class="material-icons-sharp">arrow_downward</span>
                        </button>
                    </div>
                    <button class="btn-stats" onclick="openStatsModal()">
                        <span class="material-icons-sharp">pie_chart</span>
                        Statistiques
                    </button>
                    <button class="btn-export" onclick="exportToCSV()">
                        <span class="material-icons-sharp">download</span>
                        Exporter CSV
                    </button>
                    <div class="date">
                        <span class="material-icons-sharp">calendar_today</span>
                        <span id="current-date"></span>
                    </div>
=======
                <div class="date">
                    <span class="material-icons-sharp">calendar_today</span>
                    <span id="current-date"></span>
>>>>>>> 4864be3ae163223f95b6db6290a654f10e05cb91
                </div>
            </div>
            
            <?php
            require_once(__DIR__ . '/../../controllers/ReclamationController.php');
            require_once(__DIR__ . '/../../models/Reclamation.php');

            $reclamationController = new ReclamationController();

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($_POST['action'])) {
                    switch ($_POST['action']) {
                        case 'updateReclamation':
                            $id = $_POST['id'];
                            $date = $_POST['date'];
                            $description = $_POST['description'];
                            $etat = $_POST['etat'];
                            if($reclamationController->updateReclamation($id, $date, $description, $etat)) {
                                echo "<div class='alert success'>Statut de la réclamation mis à jour avec succès</div>";
                            }
                            break;

                        case 'deleteReclamation':
                            $id = $_POST['id'];
                            if($reclamationController->deleteReclamation($id)) {
                                echo "<div class='alert success'>Réclamation supprimée avec succès</div>";
                            }
                            break;
                    }
                }
            }
            ?>

            <div class="recent-orders">
<<<<<<< HEAD
                <div class="search-container">
                    <span class="material-icons-sharp search-icon">search</span>
                    <input type="text" 
                           id="searchInput" 
                           class="search-input" 
                           placeholder="Rechercher dans les descriptions..."
                           oninput="handleSearch(this.value)">
                </div>
=======
>>>>>>> 4864be3ae163223f95b6db6290a654f10e05cb91
                <table>
                    <thead>
                        <tr>
                            <th class="id-cell">ID</th>
                            <th class="date-cell">Date</th>
                            <th>Description</th>
                            <th>Statut</th>
                            <th class="action-cell">Actions</th>
                        </tr>
                    </thead>
<<<<<<< HEAD
                    <tbody id="complaintsTableBody">
=======
                    <tbody>
>>>>>>> 4864be3ae163223f95b6db6290a654f10e05cb91
                        <?php 
                        $reclamations = $reclamationController->getReclamations();
                        foreach ($reclamations as $reclamation): 
                            $statusClass = 'status-' . strtolower(str_replace(' ', '-', $reclamation['etat_reclamation']));
                        ?>
                        <tr class="complaint-row">
                            <td class="id-cell"><?php echo htmlspecialchars($reclamation['id_reclamation']); ?></td>
                            <td class="date-cell"><?php echo date('d/m/Y H:i', strtotime($reclamation['date_reclamation'])); ?></td>
                            <td class="description-cell"><?php echo nl2br(htmlspecialchars($reclamation['description_reclamation'])); ?></td>
                            <td>
                                <form method="POST" class="status-form">
                                    <input type="hidden" name="action" value="updateReclamation">
                                    <input type="hidden" name="id" value="<?php echo $reclamation['id_reclamation']; ?>">
                                    <input type="hidden" name="date" value="<?php echo $reclamation['date_reclamation']; ?>">
                                    <input type="hidden" name="description" value="<?php echo htmlspecialchars($reclamation['description_reclamation']); ?>">
                                    <select class="status-select <?php echo $statusClass; ?>" name="etat" onchange="this.form.submit()">
                                        <option value="En attente" <?php echo $reclamation['etat_reclamation'] === 'En attente' ? 'selected' : ''; ?>>En attente</option>
                                        <option value="En cours" <?php echo $reclamation['etat_reclamation'] === 'En cours' ? 'selected' : ''; ?>>En cours</option>
                                        <option value="Résolu" <?php echo $reclamation['etat_reclamation'] === 'Résolu' ? 'selected' : ''; ?>>Résolu</option>
                                        <option value="Rejeté" <?php echo $reclamation['etat_reclamation'] === 'Rejeté' ? 'selected' : ''; ?>>Rejeté</option>
                                    </select>
                                </form>
                            </td>
                            <td class="action-cell">
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="action" value="deleteReclamation">
                                    <input type="hidden" name="id" value="<?php echo $reclamation['id_reclamation']; ?>">
                                    <button type="submit" class="btn-danger" 
                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette réclamation ?')">
                                        <span class="material-icons-sharp">delete</span>
                                    </button>
                                </form>
                                <button class="toggle-responses" onclick="toggleResponses(<?php echo $reclamation['id_reclamation']; ?>)">
                                    <span class="material-icons-sharp">chat</span>
                                    <span class="response-count" id="response-count-<?php echo $reclamation['id_reclamation']; ?>">0</span>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5">
                                <div class="responses-section" id="responses-<?php echo $reclamation['id_reclamation']; ?>">
                                    <div class="responses-list" id="responses-list-<?php echo $reclamation['id_reclamation']; ?>">
                                        <!-- Responses will be loaded here -->
                                    </div>
                                    <form class="new-response-form" onsubmit="addResponse(event, <?php echo $reclamation['id_reclamation']; ?>)">
                                        <textarea name="response" rows="3" placeholder="Votre réponse..." required></textarea>
                                        <button type="submit" class="btn-primary">
                                            <span class="material-icons-sharp">send</span> Répondre
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
<<<<<<< HEAD
                <div class="pagination">
                    <div class="pagination-buttons">
                        <button class="page-btn" id="prevPage" onclick="changePage(-1)" disabled>
                            <span class="material-icons-sharp">chevron_left</span>
                            Précédent
                        </button>
                        <button class="page-btn" id="nextPage" onclick="changePage(1)">
                            Suivant
                            <span class="material-icons-sharp">chevron_right</span>
                        </button>
                    </div>
                    <div class="pagination-info">
                        Page <span id="currentPage">1</span> sur <span id="totalPages">1</span>
                    </div>
                </div>
=======
>>>>>>> 4864be3ae163223f95b6db6290a654f10e05cb91
            </div>
        </main>
        <!-- End of Main Content -->
    </div>

    <!-- Modal for Response Management -->
    <div id="responseModal" class="modal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeResponseModal()">&times;</span>
            <h2>Gérer les réponses</h2>
            <div id="responseList" class="response-list">
                <!-- Responses will be loaded here -->
            </div>
            <form id="responseForm" class="response-form">
                <input type="hidden" id="reclamationId" name="reclamationId">
                <textarea id="responseText" name="responseText" rows="4" placeholder="Votre réponse..." required></textarea>
                <button type="submit" class="btn-primary">Envoyer la réponse</button>
            </form>
        </div>
    </div>

<<<<<<< HEAD
    <!-- Modal for Statistics -->
    <div id="statsModal" class="stats-modal">
        <div class="stats-modal-content">
            <span class="close-modal" onclick="closeStatsModal()">&times;</span>
            <h2>Statistiques des Réclamations</h2>
            <div class="chart-container">
                <canvas id="complaintsChart"></canvas>
            </div>
        </div>
    </div>

=======
>>>>>>> 4864be3ae163223f95b6db6290a654f10e05cb91
    <script>
        // Mise à jour du compteur de réclamations
        document.addEventListener('DOMContentLoaded', function() {
            const complaints = document.querySelectorAll('table tbody tr');
            const complaintsCount = document.getElementById('complaints-count');
            complaintsCount.textContent = complaints.length;

            // Affichage de la date actuelle
            const currentDate = new Date();
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            document.getElementById('current-date').textContent = currentDate.toLocaleDateString('fr-FR', options);

            // Animation des alertes
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 300);
                }, 3000);
            });
        });

        // Gestion du logout
        document.getElementById('logout-btn').addEventListener('click', function(e) {
            e.preventDefault();
            alert('You have been logged out.');
            window.location.href = '../front/user-management.html';
        });

        // Response Management
        const responseModal = document.getElementById('responseModal');
        const responseList = document.getElementById('responseList');
        const responseForm = document.getElementById('responseForm');
        const reclamationIdInput = document.getElementById('reclamationId');
        let currentReclamationId = null;

        function openResponseModal(reclamationId) {
            currentReclamationId = reclamationId;
            reclamationIdInput.value = reclamationId;
            responseModal.style.display = 'block';
            loadResponses(reclamationId);
        }

        function closeResponseModal() {
            responseModal.style.display = 'none';
            responseForm.reset();
        }

        function loadResponses(reclamationId) {
            fetch(`../../controllers/response_actions.php?action=getResponses&id_reclamation=${reclamationId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const responsesList = document.getElementById(`responses-list-${reclamationId}`);
                        const responseCount = document.getElementById(`response-count-${reclamationId}`);
                        
                        responseCount.textContent = data.data.length;
                        
                        responsesList.innerHTML = data.data.map(response => `
                            <div class="response-item" id="response-${response.id_reponse}">
                                <div class="response-header">
                                    <span class="response-date">Le ${new Date(response.date_reponse).toLocaleString()}</span>
                                    <div class="response-actions">
                                        <button class="btn-primary" onclick="editResponse(${response.id_reponse}, '${response.description_reponse}')">
                                            <span class="material-icons-sharp">edit</span>
                                        </button>
                                        <button class="btn-danger" onclick="deleteResponse(${response.id_reponse}, ${reclamationId})">
                                            <span class="material-icons-sharp">delete</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="response-content">${response.description_reponse}</div>
                            </div>
                        `).join('');
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        function addResponse(event, reclamationId) {
            event.preventDefault();
            const form = event.target;
            const description = form.response.value;

            const formData = new FormData();
            formData.append('action', 'addResponse');
            formData.append('id_reclamation', reclamationId);
            formData.append('id_user', '1'); // Replace with actual user ID from session
            formData.append('description', description);

            fetch('../../controllers/response_actions.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    form.reset();
                    loadResponses(reclamationId);
                } else {
                    alert('Erreur lors de l\'ajout de la réponse: ' + data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        }

        function editResponse(responseId, currentDescription) {
            const newDescription = prompt('Modifier la réponse:', currentDescription);
            if (newDescription && newDescription !== currentDescription) {
                const formData = new FormData();
                formData.append('action', 'updateResponse');
                formData.append('id_reponse', responseId);
                formData.append('description', newDescription);

                fetch('../../controllers/response_actions.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const responseElement = document.getElementById(`response-${responseId}`);
                        const contentElement = responseElement.querySelector('.response-content');
                        contentElement.textContent = newDescription;
                    } else {
                        alert('Erreur lors de la modification de la réponse: ' + data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        }

        function deleteResponse(responseId, reclamationId) {
            if (confirm('Êtes-vous sûr de vouloir supprimer cette réponse ?')) {
                const formData = new FormData();
                formData.append('action', 'deleteResponse');
                formData.append('id_reponse', responseId);

                fetch('../../controllers/response_actions.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        loadResponses(reclamationId);
                    } else {
                        alert('Erreur lors de la suppression de la réponse: ' + data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        }

        function toggleResponses(reclamationId) {
            const responsesSection = document.getElementById(`responses-${reclamationId}`);
            responsesSection.classList.toggle('active');
            
            if (responsesSection.classList.contains('active')) {
                loadResponses(reclamationId);
            }
<<<<<<< HEAD
            
            // Update pagination to ensure proper display of expanded/collapsed rows
            updatePagination();
        }

        // Statistics Management
        const statsModal = document.getElementById('statsModal');
        let complaintsChart = null;

        function openStatsModal() {
            statsModal.style.display = 'block';
            loadStatistics();
        }

        function closeStatsModal() {
            statsModal.style.display = 'none';
            if (complaintsChart) {
                complaintsChart.destroy();
            }
        }

        function loadStatistics() {
            const complaints = document.querySelectorAll('table tbody tr.complaint-row');
            const stats = {
                'En attente': 0,
                'En cours': 0,
                'Résolu': 0,
                'Rejeté': 0
            };

            complaints.forEach(complaint => {
                const status = complaint.querySelector('.status-select').value;
                stats[status]++;
            });

            const ctx = document.getElementById('complaintsChart').getContext('2d');
            
            if (complaintsChart) {
                complaintsChart.destroy();
            }

            complaintsChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: Object.keys(stats),
                    datasets: [{
                        data: Object.values(stats),
                        backgroundColor: [
                            '#ffd700', // En attente - yellow
                            '#007bff', // En cours - blue
                            '#28a745', // Résolu - green
                            '#dc3545'  // Rejeté - red
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        },
                        title: {
                            display: true,
                            text: 'Répartition des Réclamations par Statut',
                            font: {
                                size: 16
                            }
                        }
                    }
                }
            });
        }

        // Close modals when clicking outside
=======
        }

        // Close modal when clicking outside
>>>>>>> 4864be3ae163223f95b6db6290a654f10e05cb91
        window.onclick = function(event) {
            if (event.target == responseModal) {
                closeResponseModal();
            }
<<<<<<< HEAD
            if (event.target == statsModal) {
                closeStatsModal();
            }
        }

        // Export to CSV functionality
        function exportToCSV() {
            // Get all complaint rows
            const complaints = document.querySelectorAll('table tbody tr.complaint-row');
            
            // Prepare CSV content
            let csvContent = "ID,Date,Description,Statut\n"; // CSV header
            
            complaints.forEach(complaint => {
                const id = complaint.querySelector('.id-cell').textContent;
                const date = complaint.querySelector('.date-cell').textContent;
                const description = complaint.querySelector('.description-cell').textContent.replace(/,/g, ';').replace(/\n/g, ' ');
                const status = complaint.querySelector('.status-select').value;
                
                // Add row to CSV content
                csvContent += `${id},${date},"${description}",${status}\n`;
            });
            
            // Create blob and download link
            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement("a");
            
            // Create download link
            if (navigator.msSaveBlob) { // IE 10+
                navigator.msSaveBlob(blob, "reclamations.csv");
            } else {
                link.href = URL.createObjectURL(blob);
                link.setAttribute("download", "reclamations.csv");
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }
        }

        // Sorting functionality
        function sortComplaints(order) {
            const tbody = document.querySelector('tbody');
            const rows = Array.from(document.querySelectorAll('tr.complaint-row'));
            
            rows.sort((a, b) => {
                const dateA = new Date(a.querySelector('.date-cell').textContent.split(' ')[0].split('/').reverse().join('-'));
                const dateB = new Date(b.querySelector('.date-cell').textContent.split(' ')[0].split('/').reverse().join('-'));
                return order === 'asc' ? dateA - dateB : dateB - dateA;
            });

            // Remove all rows
            rows.forEach(row => {
                const nextRow = row.nextElementSibling;
                if (nextRow && !nextRow.classList.contains('complaint-row')) {
                    tbody.removeChild(nextRow);
                }
                tbody.removeChild(row);
            });

            // Add sorted rows back
            rows.forEach(row => {
                tbody.appendChild(row);
                const responseRow = row.nextElementSibling;
                if (responseRow && !responseRow.classList.contains('complaint-row')) {
                    tbody.appendChild(responseRow.cloneNode(true));
                }
            });

            // Update original and filtered rows
            originalRows = rows;
            
            // Reapply current search if any
            const searchInput = document.getElementById('searchInput');
            if (searchInput.value.trim() !== '') {
                performSearch(searchInput.value);
            } else {
                filteredRows = [...originalRows];
                currentPage = 1;
                totalPages = Math.ceil(filteredRows.length / ITEMS_PER_PAGE);
                document.getElementById('totalPages').textContent = totalPages;
                updatePaginationDisplay();
            }
        }

        // Pagination functionality
        const ITEMS_PER_PAGE = 3;
        let currentPage = 1;
        let totalPages = 1;

        function initializePagination() {
            const rows = document.querySelectorAll('tr.complaint-row');
            totalPages = Math.ceil(rows.length / ITEMS_PER_PAGE);
            
            document.getElementById('totalPages').textContent = totalPages;
            updatePagination();
        }

        function updatePagination() {
            const rows = Array.from(document.querySelectorAll('tbody tr.complaint-row'));
            const responseRows = Array.from(document.querySelectorAll('tbody tr:not(.complaint-row)'));
            
            // Hide all complaint rows first
            rows.forEach(row => row.style.display = 'none');
            responseRows.forEach(row => row.style.display = 'none');
            
            // Show only rows for current page
            const start = (currentPage - 1) * ITEMS_PER_PAGE;
            const end = start + ITEMS_PER_PAGE;
            
            rows.slice(start, end).forEach(row => {
                row.style.display = 'table-row';
                // Show associated response row if it exists and is expanded
                const nextRow = row.nextElementSibling;
                if (nextRow && !nextRow.classList.contains('complaint-row')) {
                    const responsesSection = nextRow.querySelector('.responses-section');
                    if (responsesSection && responsesSection.classList.contains('active')) {
                        nextRow.style.display = 'table-row';
                    }
                }
            });
            
            // Update pagination controls
            document.getElementById('currentPage').textContent = currentPage;
            document.getElementById('prevPage').disabled = currentPage === 1;
            document.getElementById('nextPage').disabled = currentPage === totalPages;
        }

        function changePage(delta) {
            currentPage += delta;
            if (currentPage < 1) currentPage = 1;
            if (currentPage > totalPages) currentPage = totalPages;
            updatePagination();
        }

        // Search functionality
        let originalRows = [];
        let filteredRows = [];
        let searchTimeout = null;

        function initializeSearch() {
            // Store original rows for filtering
            originalRows = Array.from(document.querySelectorAll('tr.complaint-row'));
            filteredRows = [...originalRows];
        }

        function handleSearch(searchTerm) {
            // Clear previous timeout
            if (searchTimeout) {
                clearTimeout(searchTimeout);
            }

            // Set new timeout to avoid too many updates
            searchTimeout = setTimeout(() => {
                performSearch(searchTerm);
            }, 300);
        }

        function performSearch(searchTerm) {
            searchTerm = searchTerm.toLowerCase().trim();
            const tbody = document.querySelector('tbody');
            
            // Remove any existing no-results message
            const existingNoResults = document.querySelector('.no-results');
            if (existingNoResults) {
                existingNoResults.remove();
            }

            // If search is empty, restore original state
            if (searchTerm === '') {
                filteredRows = [...originalRows];
            } else {
                // Filter rows based on search term
                filteredRows = originalRows.filter(row => {
                    const description = row.querySelector('.description-cell').textContent.toLowerCase();
                    return description.includes(searchTerm);
                });
            }

            // Hide all rows first
            originalRows.forEach(row => {
                row.style.display = 'none';
                // Hide associated response row
                const nextRow = row.nextElementSibling;
                if (nextRow && !nextRow.classList.contains('complaint-row')) {
                    nextRow.style.display = 'none';
                }
            });

            // Show no results message if needed
            if (filteredRows.length === 0) {
                const noResults = document.createElement('tr');
                noResults.className = 'no-results';
                noResults.innerHTML = `
                    <td colspan="5">
                        <div class="no-results">
                            <span class="material-icons-sharp">search_off</span>
                            <p>Aucune réclamation ne correspond à votre recherche</p>
                        </div>
                    </td>
                `;
                tbody.appendChild(noResults);
            }

            // Reset pagination
            currentPage = 1;
            totalPages = Math.ceil(filteredRows.length / ITEMS_PER_PAGE);
            document.getElementById('totalPages').textContent = totalPages;
            
            updatePaginationDisplay();
        }

        function updatePaginationDisplay() {
            // Calculate start and end indices for current page
            const start = (currentPage - 1) * ITEMS_PER_PAGE;
            const end = Math.min(start + ITEMS_PER_PAGE, filteredRows.length);
            
            // Hide all rows first
            originalRows.forEach(row => {
                row.style.display = 'none';
                const nextRow = row.nextElementSibling;
                if (nextRow && !nextRow.classList.contains('complaint-row')) {
                    nextRow.style.display = 'none';
                }
            });

            // Show only rows for current page
            for (let i = start; i < end; i++) {
                const row = filteredRows[i];
                if (row) {
                    row.style.display = 'table-row';
                    // Show associated response row if it's expanded
                    const nextRow = row.nextElementSibling;
                    if (nextRow && !nextRow.classList.contains('complaint-row')) {
                        const responsesSection = nextRow.querySelector('.responses-section');
                        if (responsesSection && responsesSection.classList.contains('active')) {
                            nextRow.style.display = 'table-row';
                        }
                    }
                }
            }

            // Update pagination controls
            document.getElementById('currentPage').textContent = currentPage;
            document.getElementById('prevPage').disabled = currentPage === 1;
            document.getElementById('nextPage').disabled = currentPage === totalPages || totalPages === 0;
        }

        // Initialize when page loads
        document.addEventListener('DOMContentLoaded', function() {
            initializeSearch();
            totalPages = Math.ceil(filteredRows.length / ITEMS_PER_PAGE);
            document.getElementById('totalPages').textContent = totalPages;
            updatePaginationDisplay();
            
            // ... existing DOMContentLoaded code ...
        });
=======
        }
>>>>>>> 4864be3ae163223f95b6db6290a654f10e05cb91
    </script>
</body>
</html>
