<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WeRent - Gestion des Réclamations</title>
    
    <!-- load stylesheets -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/templatemo-style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }
        .complaint-card {
            margin-bottom: 20px;
        }
        .responses-section {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #dee2e6;
        }
        .response-item {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 10px;
        }
        .response-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }
        .response-date {
            font-size: 0.85rem;
            color: #6c757d;
        }
        .response-content {
            margin-bottom: 0;
        }
        .toggle-responses {
            display: flex;
            align-items: center;
            gap: 5px;
            padding: 5px 10px;
            border-radius: 4px;
            background-color: #e9ecef;
            border: none;
            color: #495057;
            cursor: pointer;
            transition: all 0.2s;
        }
        .toggle-responses:hover {
            background-color: #dee2e6;
        }
        .response-count {
            background-color: #0d6efd;
            color: white;
            padding: 2px 6px;
            border-radius: 10px;
            font-size: 0.75rem;
        }
        .responses-list {
            max-height: 400px;
            overflow-y: auto;
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
                        <a class="navbar-brand mr-auto" href="#">
                            <img src="img/logo.png" alt="Site logo">
                            WeRent
                        </a>
                        <button type="button" id="nav-toggle" class="navbar-toggler collapsed" data-toggle="collapse" data-target="#mainNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div id="mainNav" class="collapse navbar-collapse tm-bg-white">
                            <ul class="navbar-nav ml-auto">
                                <li class="nav-item">
                                    <a class="nav-link" href="index.php">Accueil</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" href="front.php">Réclamations</a>
                                </li>
                            </ul>
                        </div>                            
                    </nav>
                </div>
            </div>
        </div>

        <div class="tm-page-wrap mx-auto">
            <div class="container mt-5">
                <?php
                require_once(__DIR__ . '/../../controllers/ReclamationController.php');
                require_once(__DIR__ . '/../../models/Reclamation.php');
                require_once(__DIR__ . '/../../controllers/ReponseController.php');

                $reclamationController = new ReclamationController();
                $reponseController = new ReponseController();

                // Traitement des actions
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    if (isset($_POST['action'])) {
                        switch ($_POST['action']) {
                            case 'addReclamation':
                                $date = date('Y-m-d H:i:s');
                                $description = $_POST['description'];
                                $etat = 'En attente';
                                $reclamation = new Reclamation($date, $description, $etat);
                                if($reclamationController->addReclamation($reclamation)) {
                                    $_SESSION['success'] = "Réclamation ajoutée avec succès";
                                }
                                break;

                            case 'updateReclamation':
                                $id = $_POST['id'];
                                $date = $_POST['date'];
                                $description = $_POST['description'];
                                $etat = 'En attente'; // On garde l'état en "En attente"
                                if($reclamationController->updateReclamation($id, $date, $description, $etat)) {
                                    $_SESSION['success'] = "Réclamation mise à jour avec succès";
                                }
                                break;

                            case 'deleteReclamation':
                                $id = $_POST['id'];
                                if($reclamationController->deleteReclamation($id)) {
                                    $_SESSION['success'] = "Réclamation supprimée avec succès";
                                }
                                break;
                        }
                    }
                }

                // Affichage des messages de succès/erreur
                if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']) ?></div>
                    <?php unset($_SESSION['success']); ?>
                <?php endif; ?>

                <?php if (isset($_SESSION['errors'])): ?>
                    <div class="alert alert-danger">
                        <?php foreach ($_SESSION['errors'] as $error): ?>
                            <?= htmlspecialchars($error) ?><br>
                        <?php endforeach; ?>
                    </div>
                    <?php unset($_SESSION['errors']); ?>
                <?php endif; ?>

                <!-- Formulaire d'ajout de réclamation -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Nouvelle Réclamation</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <input type="hidden" name="action" value="addReclamation">
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" required rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Soumettre</button>
                        </form>
                    </div>
                </div>

                <!-- Liste des réclamations -->
                <h2 class="text-center mb-4">Liste des Réclamations</h2>
                <div class="row">
                    <?php 
                    $reclamations = $reclamationController->getReclamations();
                    foreach ($reclamations as $reclamation): 
                    ?>
                        <div class="col-12 mb-4">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Réclamation #<?php echo htmlspecialchars($reclamation['id_reclamation']); ?></h5>
                                    <div class="complaint-meta">
                                        <small class="text-muted">
                                            <?php echo date('d/m/Y H:i', strtotime($reclamation['date_reclamation'])); ?>
                                        </small>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <p class="card-text"><?php echo nl2br(htmlspecialchars($reclamation['description_reclamation'])); ?></p>
                                    
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-sm btn-primary" data-bs-toggle="collapse" 
                                                data-bs-target="#edit<?php echo $reclamation['id_reclamation']; ?>">
                                            <i class="fas fa-edit"></i> Modifier
                                        </button>
                                        <form method="POST" class="d-inline">
                                            <input type="hidden" name="action" value="deleteReclamation">
                                            <input type="hidden" name="id" value="<?php echo $reclamation['id_reclamation']; ?>">
                                            <button type="submit" class="btn btn-sm btn-danger" 
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette réclamation ?')">
                                                <i class="fas fa-trash"></i> Supprimer
                                            </button>
                                        </form>
                                        <button class="btn btn-sm btn-info text-white" 
                                                onclick="toggleResponses(<?php echo $reclamation['id_reclamation']; ?>)">
                                            <i class="fas fa-comments"></i> 
                                            Réponses
                                            <span class="badge bg-white text-info ms-1" id="response-count-<?php echo $reclamation['id_reclamation']; ?>">0</span>
                                        </button>
                                    </div>

                                    <!-- Section des réponses -->
                                    <div class="responses-section collapse" id="responses-<?php echo $reclamation['id_reclamation']; ?>">
                                        <div class="responses-list" id="responses-list-<?php echo $reclamation['id_reclamation']; ?>">
                                            <!-- Les réponses seront chargées ici -->
                                        </div>
                                    </div>

                                    <!-- Formulaire de modification -->
                                    <div class="collapse mt-3" id="edit<?php echo $reclamation['id_reclamation']; ?>">
                                        <div class="card card-body bg-light">
                                            <h6>Modifier la réclamation</h6>
                                            <form method="POST">
                                                <input type="hidden" name="action" value="updateReclamation">
                                                <input type="hidden" name="id" value="<?php echo $reclamation['id_reclamation']; ?>">
                                                <input type="hidden" name="date" value="<?php echo $reclamation['date_reclamation']; ?>">
                                                <div class="mb-3">
                                                    <label class="form-label">Description</label>
                                                    <textarea class="form-control" name="description" required><?php echo htmlspecialchars($reclamation['description_reclamation']); ?></textarea>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Mettre à jour</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <footer class="tm-container-outer">
            <p class="mb-0">Copyright © <span class="tm-current-year">2024</span> WeRent</p>
        </footer>
    </div>

    <script src="js/jquery-1.11.3.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(function(){
            // Gestion de la barre de navigation fixe
            $(window).on("scroll", function() {
                if($(window).scrollTop() > 100) {
                    $(".tm-top-bar").addClass("active");
                } else {                    
                    $(".tm-top-bar").removeClass("active");
                }
            });

            // Fermeture du menu mobile après clic
            $('.nav-link').click(function(){
                $('#mainNav').removeClass('show');
            });

            // Mise à jour de l'année dans le footer
            $('.tm-current-year').text(new Date().getFullYear());
        });

        function toggleResponses(reclamationId) {
            const responsesSection = document.getElementById(`responses-${reclamationId}`);
            const isCollapsed = !responsesSection.classList.contains('show');
            
            if (isCollapsed) {
                loadResponses(reclamationId);
            }
            
            bootstrap.Collapse.getOrCreateInstance(responsesSection).toggle();
        }

        function loadResponses(reclamationId) {
            fetch(`../../controllers/response_actions.php?action=getResponses&id_reclamation=${reclamationId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const responsesList = document.getElementById(`responses-list-${reclamationId}`);
                        const responseCount = document.getElementById(`response-count-${reclamationId}`);
                        
                        responseCount.textContent = data.data.length;
                        
                        if (data.data.length === 0) {
                            responsesList.innerHTML = '<div class="alert alert-info">Aucune réponse pour cette réclamation.</div>';
                        } else {
                            responsesList.innerHTML = data.data.map(response => `
                                <div class="response-item">
                                    <div class="response-header">
                                        <span class="response-date">
                                            <i class="fas fa-clock"></i>
                                            ${new Date(response.date_reponse).toLocaleString('fr-FR')}
                                        </span>
                                    </div>
                                    <p class="response-content">${response.description_reponse}</p>
                                </div>
                            `).join('');
                        }
                    } else {
                        console.error('Erreur lors du chargement des réponses:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                });
        }
    </script>
</body>
</html>
