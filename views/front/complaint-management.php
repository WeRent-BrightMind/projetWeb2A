<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WeRent - Complaint Management</title>
    
    <!-- load stylesheets -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/complaint-management.css">
    <link rel="stylesheet" href="css/templatemo-style.css"> 
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

        <div class="tm-page-wrap mx-auto">
            <div class="container mt-5">
                <?php if (isset($_SESSION['success'])): ?>
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

                <h2 class="text-center mb-4">Submit a Complaint</h2>

                <!-- Form for submitting a complaint -->
                <form method="POST" action="complaint-management.php">
                    <input type="hidden" name="action" value="create_complaint">
                    <div class="form-group">
                        <label for="id_annonce">Annonce ID</label>
                        <input type="text" class="form-control" id="id_annonce" name="id_annonce" placeholder="Enter the Annonce ID">
                    </div>
                    <div class="form-group">
                        <label for="sujet">Sujet</label>
                        <input type="text" class="form-control" id="sujet" name="sujet" placeholder="Enter the subject" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="5" placeholder="Enter the description" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="type">Type</label>
                        <select class="form-control" id="type" name="type" required>
                            <option value="annonce">Annonce</option>
                            <option value="utilisateur">Utilisateur</option>
                            <option value="paiement">Paiement</option>
                            <option value="autre">Autre</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="statut">Statut</label>
                        <select class="form-control" id="statut" name="statut" required>
                            <option value="nouveau">Nouveau</option>
                            <option value="en_cours">En cours</option>
                            <option value="resolu">Résolu</option>
                            <option value="rejete">Rejeté</option>
                        </select>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>

                <h2 class="text-center mb-4">Recent Complaints</h2>
                <div class="complaints-list">
                    <?php foreach ($complaints as $complaint_item): ?>
                        <div class="complaint-card mb-4">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div class="user-info d-flex align-items-center">
                                        <img src="<?= htmlspecialchars($complaint_item['avatar']) ?>" alt="User Avatar" class="user-avatar">
                                        <span class="ms-2"><?= htmlspecialchars($complaint_item['nom'] . ' ' . $complaint_item['prenom']) ?></span>
                                    </div>
                                    <div class="complaint-meta">
                                        <span class="badge bg-<?= $complaint_item['statut'] === 'nouveau' ? 'primary' : 
                                                               ($complaint_item['statut'] === 'en_cours' ? 'warning' : 
                                                               ($complaint_item['statut'] === 'resolu' ? 'success' : 'danger')) ?>">
                                            <?= htmlspecialchars($complaint_item['statut']) ?>
                                        </span>
                                        <small class="text-muted ms-2">
                                            <?= date('d/m/Y H:i', strtotime($complaint_item['date_creation'])) ?>
                                        </small>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($complaint_item['sujet']) ?></h5>
                                    <p class="card-text"><?= nl2br(htmlspecialchars($complaint_item['description'])) ?></p>
                                    <div class="complaint-actions">
                                        <?php if ($complaint_item['can_modify']): ?>
                                            <button class="btn btn-primary btn-sm edit-complaint" 
                                                    data-id="<?= $complaint_item['id_reclamation'] ?>"
                                                    data-sujet="<?= htmlspecialchars($complaint_item['sujet']) ?>"
                                                    data-description="<?= htmlspecialchars($complaint_item['description']) ?>"
                                                    data-type="<?= htmlspecialchars($complaint_item['type']) ?>"
                                                    data-statut="<?= htmlspecialchars($complaint_item['statut']) ?>">
                                                Edit
                                            </button>
                                            <button class="btn btn-danger btn-sm delete-complaint" 
                                                    data-id="<?= $complaint_item['id_reclamation'] ?>">
                                                Delete
                                            </button>
                                        <?php endif; ?>
                                        <button class="btn btn-info btn-sm view-responses" 
                                                data-id="<?= $complaint_item['id_reclamation'] ?>">
                                            Responses (<?= count($complaint_item['responses']) ?>)
                                        </button>
                                    </div>
                                </div>
                                <!-- Responses Section -->
                                <div class="responses-section" style="display: none;">
                                    <div class="card-footer">
                                        <h6>Responses:</h6>
                                        <div class="responses-list">
                                            <?php foreach ($complaint_item['responses'] as $response): ?>
                                                <div class="response-item mb-3">
                                                    <div class="d-flex justify-content-between">
                                                        <div class="user-info">
                                                            <img src="<?= htmlspecialchars($response['avatar']) ?>" alt="User Avatar" class="user-avatar">
                                                            <span><?= htmlspecialchars($response['nom'] . ' ' . $response['prenom']) ?></span>
                                                        </div>
                                                        <small class="text-muted"><?= date('d/m/Y H:i', strtotime($response['date_reponse'])) ?></small>
                                                    </div>
                                                    <p class="mt-2"><?= nl2br(htmlspecialchars($response['reponse'])) ?></p>
                                                    <div class="response-actions">
                                                        <button class="btn btn-primary btn-sm edit-response" 
                                                                data-id="<?= $response['id_reponse'] ?>"
                                                                data-reponse="<?= htmlspecialchars($response['reponse']) ?>">
                                                            Edit
                                                        </button>
                                                        <button class="btn btn-danger btn-sm delete-response" 
                                                                data-id="<?= $response['id_reponse'] ?>">
                                                            Delete
                                                        </button>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                        <!-- Add Response Form -->
                                        <form method="POST" class="mt-3">
                                            <input type="hidden" name="action" value="add_response">
                                            <input type="hidden" name="id_reclamation" value="<?= $complaint_item['id_reclamation'] ?>">
                                            <div class="form-group">
                                                <textarea class="form-control" name="response" rows="3" placeholder="Add your response" required></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-sm mt-2">Submit Response</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Edit Complaint Modal -->
                <div class="modal fade" id="editComplaintModal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Complaint</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" id="editComplaintForm">
                                    <input type="hidden" name="action" value="update_complaint">
                                    <input type="hidden" name="id_reclamation" id="editComplaintId">
                                    <div class="form-group">
                                        <label for="editSujet">Sujet</label>
                                        <input type="text" class="form-control" id="editSujet" name="sujet" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="editDescription">Description</label>
                                        <textarea class="form-control" id="editDescription" name="description" rows="5" required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="editType">Type</label>
                                        <select class="form-control" id="editType" name="type" required>
                                            <option value="annonce">Annonce</option>
                                            <option value="utilisateur">Utilisateur</option>
                                            <option value="paiement">Paiement</option>
                                            <option value="autre">Autre</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="editStatut">Statut</label>
                                        <select class="form-control" id="editStatut" name="statut" required>
                                            <option value="nouveau">Nouveau</option>
                                            <option value="en_cours">En cours</option>
                                            <option value="resolu">Résolu</option>
                                            <option value="rejete">Rejeté</option>
                                        </select>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" form="editComplaintForm" class="btn btn-primary">Save Changes</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Edit Response Modal -->
                <div class="modal fade" id="editResponseModal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Response</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" id="editResponseForm">
                                    <input type="hidden" name="action" value="update_response">
                                    <input type="hidden" name="id_reponse" id="editResponseId">
                                    <div class="form-group">
                                        <label for="editResponse">Response</label>
                                        <textarea class="form-control" id="editResponse" name="response" rows="5" required></textarea>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" form="editResponseForm" class="btn btn-primary">Save Changes</button>
                            </div>
                        </div>
                    </div>
                </div>

                <script src="js/jquery-1.11.3.min.js"></script>
                <script src="js/popper.min.js"></script>
                <script src="js/bootstrap.min.js"></script>
                <script>
                $(document).ready(function() {
                    // Handle edit complaint
                    $('.edit-complaint').click(function() {
                        const id = $(this).data('id');
                        const sujet = $(this).data('sujet');
                        const description = $(this).data('description');
                        const type = $(this).data('type');
                        const statut = $(this).data('statut');

                        $('#editComplaintId').val(id);
                        $('#editSujet').val(sujet);
                        $('#editDescription').val(description);
                        $('#editType').val(type);
                        $('#editStatut').val(statut);
                        $('#editComplaintModal').modal('show');
                    });

                    // Handle delete complaint
                    $('.delete-complaint').click(function() {
                        if (confirm('Are you sure you want to delete this complaint?')) {
                            const id = $(this).data('id');
                            const form = $('<form method="POST"></form>');
                            form.append('<input type="hidden" name="action" value="delete_complaint">');
                            form.append(`<input type="hidden" name="id_reclamation" value="${id}">`);
                            $('body').append(form);
                            form.submit();
                        }
                    });

                    // Handle view responses
                    $('.view-responses').click(function() {
                        const responsesSection = $(this).closest('.card-body').next('.responses-section');
                        responsesSection.slideToggle();
                    });

                    // Handle edit response
                    $('.edit-response').click(function() {
                        const id = $(this).data('id');
                        const reponse = $(this).data('reponse');

                        $('#editResponseId').val(id);
                        $('#editResponse').val(reponse);
                        $('#editResponseModal').modal('show');
                    });

                    // Handle delete response
                    $('.delete-response').click(function() {
                        if (confirm('Are you sure you want to delete this response?')) {
                            const id = $(this).data('id');
                            const form = $('<form method="POST"></form>');
                            form.append('<input type="hidden" name="action" value="delete_response">');
                            form.append(`<input type="hidden" name="id_reponse" value="${id}">`);
                            $('body').append(form);
                            form.submit();
                        }
                    });
                });
                </script>
            </div>
        </div>

        <div class="tm-container-outer tm-position-relative" id="tm-section-4">
            <footer class="tm-container-outer">
                <p class="mb-0">Copyright © <span class="tm-current-year">2025</span> WeRent</p>
            </footer>
        </div>
    </div>

    <script>
        $(function(){
            $(window).on("scroll", function() {
                if($(window).scrollTop() > 100) {
                    $(".tm-top-bar").addClass("active");
                } else {                    
                    $(".tm-top-bar").removeClass("active");
                }
            });

            $('.nav-link').click(function(){
                $('#mainNav').removeClass('show');
            });

            $('.tm-current-year').text(new Date().getFullYear());
        });
    </script>
</body>
</html>