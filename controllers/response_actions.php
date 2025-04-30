<?php
header('Content-Type: application/json');
require_once('ReponseController.php');

$reponseController = new ReponseController();
$response = ['success' => false, 'message' => '', 'data' => null];

try {
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'getResponses') {
        $id_reclamation = filter_input(INPUT_GET, 'id_reclamation', FILTER_VALIDATE_INT);
        if (!$id_reclamation) {
            throw new Exception('ID de réclamation invalide');
        }
        
        $responses = $reponseController->getReponsesByReclamation($id_reclamation);
        $response['success'] = true;
        $response['data'] = $responses;
    } 
    else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);
        
        switch ($action) {
            case 'addResponse':
                $id_reclamation = filter_input(INPUT_POST, 'id_reclamation', FILTER_VALIDATE_INT);
                $id_user = filter_input(INPUT_POST, 'id_user', FILTER_VALIDATE_INT);
                $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
                
                if (!$id_reclamation || !$id_user || !$description) {
                    throw new Exception('Paramètres invalides');
                }
                
                $success = $reponseController->addReponse($id_reclamation, $id_user, $description);
                if (!$success) {
                    throw new Exception('Erreur lors de l\'ajout de la réponse');
                }
                
                $response['success'] = true;
                $response['message'] = 'Réponse ajoutée avec succès';
                break;
                
            case 'updateResponse':
                $id_reponse = filter_input(INPUT_POST, 'id_reponse', FILTER_VALIDATE_INT);
                $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
                
                if (!$id_reponse || !$description) {
                    throw new Exception('Paramètres invalides');
                }
                
                $success = $reponseController->updateReponse($id_reponse, $description);
                if (!$success) {
                    throw new Exception('Erreur lors de la modification de la réponse');
                }
                
                $response['success'] = true;
                $response['message'] = 'Réponse modifiée avec succès';
                break;
                
            case 'deleteResponse':
                $id_reponse = filter_input(INPUT_POST, 'id_reponse', FILTER_VALIDATE_INT);
                
                if (!$id_reponse) {
                    throw new Exception('ID de réponse invalide');
                }
                
                $success = $reponseController->deleteReponse($id_reponse);
                if (!$success) {
                    throw new Exception('Erreur lors de la suppression de la réponse');
                }
                
                $response['success'] = true;
                $response['message'] = 'Réponse supprimée avec succès';
                break;
                
            default:
                throw new Exception('Action non reconnue');
        }
    }
} catch (Exception $e) {
    $response['success'] = false;
    $response['message'] = $e->getMessage();
}

echo json_encode($response); 