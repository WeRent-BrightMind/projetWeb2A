<?php
require_once __DIR__ . '/../models/Announcement.php';
require_once __DIR__ . '/../config/Database.php';

class AnnouncementController {
    private $announcementModel;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->announcementModel = new Announcement($db);
    }

    public function getAnnouncementModel() {
        return $this->announcementModel;
    }

    public function createAnnouncement($data, $files) {
        $errors = $this->validateAnnouncementData($data);
        
        if (!empty($errors)) {
            $_SESSION['announcement_errors'] = $errors;
            return false;
        }

        $imagePath = null;
        if (!empty($files['image']['name'])) {
            $imagePath = $this->handleImageUpload($files['image']);
            if (!$imagePath) {
                $_SESSION['announcement_errors']['image'] = 'Failed to upload image.';
                return false;
            }
        }

        return $this->announcementModel->create(
            $data['name'],
            $data['address'],
            $data['description'],
            $data['phone'],
            $data['category_id'],
            $imagePath
        );
    }
    public function getAnnouncementById($id) {
        return $this->announcementModel->getById($id);
    }


    public function getAnnouncements($category_id = null) {
        $query = "
        SELECT 
            a.id_annonce,
            a.titre AS name, 
            a.adresse AS address, 
            a.description, 
            a.prix_journalier AS phone, 
            a.image,
            a.id_categorie,
            c.nom AS category_name
        FROM annonces a
        LEFT JOIN categories c ON a.id_categorie = c.id_categorie";

        if ($category_id) {
            $query .= " WHERE a.id_categorie = :category_id";
        }
        
        $query .= " ORDER BY a.id_annonce DESC";
        $stmt = $this->announcementModel->getDb()->prepare($query);
        
        if ($category_id) {
            $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
        }
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createCategory($name, $description = null) {
        $stmt = $this->announcementModel->getDb()->prepare("
            INSERT INTO categories (nom, description) 
            VALUES (?, ?)
        ");
        return $stmt->execute([$name, $description]);
    }

    public function updateCategory($id, $name, $description = null) {
        $stmt = $this->announcementModel->getDb()->prepare("
            UPDATE categories 
            SET nom = ?, description = ? 
            WHERE id_categorie = ?
        ");
        return $stmt->execute([$name, $description, $id]);
    }

    public function deleteCategory($id) {
        $stmt = $this->announcementModel->getDb()->prepare("
            SELECT COUNT(*) FROM annonces WHERE id_categorie = ?
        ");
        $stmt->execute([$id]);
        $count = $stmt->fetchColumn();
        
        if ($count > 0) {
            return 'in_use';
        }
        
        $stmt = $this->announcementModel->getDb()->prepare("
            DELETE FROM categories WHERE id_categorie = ?
        ");
        return $stmt->execute([$id]);
    }

    public function getCategories() {
        $stmt = $this->announcementModel->getDb()->query("
            SELECT id_categorie, nom, description 
            FROM categories
            ORDER BY nom
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteAnnouncement($id) {
        if (empty($id)) {
            $_SESSION['announcement_errors']['delete'] = 'Invalid announcement ID.';
            return false;
        }
        return $this->announcementModel->delete($id);
    }

    public function updateAnnouncement($id, $data, $files = null) {
        $errors = $this->validateAnnouncementData($data);
        
        if (!empty($errors)) {
            $_SESSION['announcement_errors'] = $errors;
            return false;
        }

        $imagePath = null;
        if (!empty($files['image']['name'])) {
            $imagePath = $this->handleImageUpload($files['image']);
            if (!$imagePath) {
                $_SESSION['announcement_errors']['image'] = 'Failed to upload image.';
                return false;
            }
        }

        return $this->announcementModel->update(
            $id,
            $data['name'],
            $data['address'],
            $data['description'],
            $data['phone'],
            $data['category_id'],
            $imagePath
        );
    }

    private function validateAnnouncementData($data) {
        $errors = [];

        if (empty($data['name'])) {
            $errors['name'] = 'Name is required.';
        } elseif (strlen($data['name']) > 255) {
            $errors['name'] = 'Name must be less than 255 characters.';
        }

        if (empty($data['address'])) {
            $errors['address'] = 'Address is required.';
        }

        if (empty($data['description'])) {
            $errors['description'] = 'Description is required.';
        }

        if (empty($data['phone'])) {
            $errors['phone'] = 'Phone number is required.';
        } elseif (!preg_match('/^[0-9]{8,8}$/', $data['phone'])) {
            $errors['phone'] = 'Invalid phone number format.';
        }

        if (empty($data['category_id'])) {
            $errors['category_id'] = 'Category is required.';
        }

        return $errors;
    }

    private function handleImageUpload($imageFile) {
        $uploadDir = 'uploads/announcements/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $maxSize = 2 * 1024 * 1024; // 2MB

        if (!in_array($imageFile['type'], $allowedTypes)) {
            $_SESSION['announcement_errors']['image'] = 'Only JPG, PNG, and GIF files are allowed.';
            return false;
        }

        if ($imageFile['size'] > $maxSize) {
            $_SESSION['announcement_errors']['image'] = 'File size must be less than 2MB.';
            return false;
        }

        $extension = pathinfo($imageFile['name'], PATHINFO_EXTENSION);
        $fileName = uniqid('announcement_') . '.' . $extension;
        $destination = $uploadDir . $fileName;

        if (move_uploaded_file($imageFile['tmp_name'], $destination)) {
            return '/' . $destination;
        }

        return false;
    }
}