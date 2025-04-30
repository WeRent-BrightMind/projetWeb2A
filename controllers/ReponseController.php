<?php
require_once(__DIR__ . '/../config.php');
require_once(__DIR__ . '/../models/Reponse.php');

class ReponseController {
    private $db;

    public function __construct() {
        try {
            $this->db = config::getConnexion();
        } catch (Exception $e) {
            error_log("Erreur de connexion dans ReponseController: " . $e->getMessage());
            throw new Exception("Erreur de connexion à la base de données");
        }
    }

    // Ajout de la méthode getDb pour le débogage
    public function getDb() {
        return $this->db;
    }

    private function updateReclamationStatus($id_reclamation) {
        try {
            // Compter le nombre de réponses pour cette réclamation
            $query = "SELECT COUNT(*) as count FROM reponse WHERE id_reclamation_reponse = :id_reclamation";
            $stmt = $this->db->prepare($query);
            $stmt->execute(['id_reclamation' => $id_reclamation]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Déterminer le statut en fonction du nombre de réponses
            $newStatus = ($result['count'] > 0) ? 'Résolu' : 'En attente';
            
            // Mettre à jour le statut de la réclamation
            $updateQuery = "UPDATE reclamation SET etat_reclamation = :etat 
                          WHERE id_reclamation = :id_reclamation";
            $updateStmt = $this->db->prepare($updateQuery);
            $updateStmt->execute([
                'etat' => $newStatus,
                'id_reclamation' => $id_reclamation
            ]);
            
            return true;
        } catch (Exception $e) {
            error_log("Erreur lors de la mise à jour du statut: " . $e->getMessage());
            return false;
        }
    }

    public function addReponse($id_reclamation, $id_user, $description) {
        try {
            // Vérifier si la réclamation existe
            $checkReclamation = "SELECT id_reclamation FROM reclamation WHERE id_reclamation = :id_reclamation";
            $stmtCheck = $this->db->prepare($checkReclamation);
            $stmtCheck->execute(['id_reclamation' => $id_reclamation]);
            
            if (!$stmtCheck->fetch()) {
                throw new Exception("La réclamation n'existe pas");
            }

            // Préparer la date au format MySQL
            $date = date('Y-m-d H:i:s');

            // Insérer la réponse
            $query = "INSERT INTO reponse (id_reclamation_reponse, id_user_reponse, description_reponse, date_reponse) 
                     VALUES (:id_reclamation, :id_user, :description, :date)";
            
            $stmt = $this->db->prepare($query);
            $result = $stmt->execute([
                'id_reclamation' => $id_reclamation,
                'id_user' => $id_user,
                'description' => $description,
                'date' => $date
            ]);

            if (!$result) {
                throw new Exception("Erreur lors de l'insertion de la réponse");
            }

            // Mettre à jour le statut de la réclamation
            $this->updateReclamationStatus($id_reclamation);

            return true;
        } catch (Exception $e) {
            error_log("Erreur dans ReponseController::addReponse : " . $e->getMessage());
            error_log("Trace : " . $e->getTraceAsString());
            return false;
        }
    }

    public function getReponsesByReclamation($id_reclamation) {
        try {
            error_log("Début getReponsesByReclamation avec id: " . $id_reclamation);
            
            // Vérifier la connexion
            if (!$this->db) {
                error_log("Erreur: Pas de connexion à la base de données");
                throw new Exception("Erreur de connexion à la base de données");
            }

            // Simplifier la requête pour le débogage
            $query = "SELECT * FROM reponse WHERE id_reclamation_reponse = :id_reclamation ORDER BY date_reponse DESC";
            
            error_log("Requête SQL: " . $query);
            
            $stmt = $this->db->prepare($query);
            if (!$stmt) {
                error_log("Erreur de préparation de la requête: " . print_r($this->db->errorInfo(), true));
                throw new Exception("Erreur de préparation de la requête");
            }

            $stmt->bindValue(':id_reclamation', $id_reclamation, PDO::PARAM_INT);
            
            if (!$stmt->execute()) {
                error_log("Erreur d'exécution de la requête: " . print_r($stmt->errorInfo(), true));
                throw new Exception("Erreur d'exécution de la requête");
            }
            
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            error_log("Nombre de résultats trouvés: " . count($results));
            
            return $results;
        } catch (Exception $e) {
            error_log("Erreur complète dans getReponsesByReclamation: " . $e->getMessage());
            error_log("Trace: " . $e->getTraceAsString());
            throw $e;
        }
    }

    public function updateReponse($id_reponse, $description) {
        try {
            $query = "UPDATE reponse 
                     SET description_reponse = :description 
                     WHERE id_reponse = :id_reponse";
            
            $stmt = $this->db->prepare($query);
            $result = $stmt->execute([
                'description' => $description,
                'id_reponse' => $id_reponse
            ]);

            if ($result) {
                // Récupérer l'ID de la réclamation pour mettre à jour son statut
                $query = "SELECT id_reclamation_reponse FROM reponse WHERE id_reponse = :id_reponse";
                $stmt = $this->db->prepare($query);
                $stmt->execute(['id_reponse' => $id_reponse]);
                $reponse = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($reponse) {
                    $this->updateReclamationStatus($reponse['id_reclamation_reponse']);
                }
            }

            return $result;
        } catch (Exception $e) {
            error_log("Erreur dans ReponseController::updateReponse : " . $e->getMessage());
            return false;
        }
    }

    public function deleteReponse($id_reponse) {
        try {
            // Récupérer l'ID de la réclamation avant la suppression
            $query = "SELECT id_reclamation_reponse FROM reponse WHERE id_reponse = :id_reponse";
            $stmt = $this->db->prepare($query);
            $stmt->execute(['id_reponse' => $id_reponse]);
            $reponse = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$reponse) {
                throw new Exception("Réponse non trouvée");
            }
            
            $id_reclamation = $reponse['id_reclamation_reponse'];

            // Supprimer la réponse
            $deleteQuery = "DELETE FROM reponse WHERE id_reponse = :id_reponse";
            $deleteStmt = $this->db->prepare($deleteQuery);
            $result = $deleteStmt->execute(['id_reponse' => $id_reponse]);

            if (!$result) {
                throw new Exception("Erreur lors de la suppression de la réponse");
            }

            // Mettre à jour le statut de la réclamation
            $this->updateReclamationStatus($id_reclamation);

            return true;
        } catch (Exception $e) {
            error_log("Erreur dans ReponseController::deleteReponse : " . $e->getMessage());
            return false;
        }
    }
}
?>