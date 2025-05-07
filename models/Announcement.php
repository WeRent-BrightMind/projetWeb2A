<?php
class Announcement {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getDb() {
        return $this->db;
    }

    public function create($name, $address, $description, $phone, $categoryId, $image = null) {
        $stmt = $this->db->prepare("
            INSERT INTO annonces (titre, adresse, description, prix_journalier, id_categorie, image) 
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([$name, $address, $description, $phone, $categoryId, $image]);
    }

    public function getAll() {
        $stmt = $this->db->query("
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
            LEFT JOIN categories c ON a.id_categorie = c.id_categorie
            ORDER BY a.id_annonce DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("
            SELECT 
                id_annonce,
                titre AS name, 
                adresse AS address, 
                description, 
                prix_journalier AS phone, 
                image,
                id_categorie
            FROM annonces 
            WHERE id_annonce = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("SELECT image FROM annonces WHERE id_annonce = ?");
        $stmt->execute([$id]);
        $announcement = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($announcement && !empty($announcement['image'])) {
            $filePath = $_SERVER['DOCUMENT_ROOT'] . parse_url($announcement['image'], PHP_URL_PATH);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $stmt = $this->db->prepare("DELETE FROM annonces WHERE id_annonce = ?");
        return $stmt->execute([$id]);
    }

    public function update($id, $name, $address, $description, $phone, $categoryId, $image = null) {
        if ($image) {
            // Delete old image if exists
            $stmt = $this->db->prepare("SELECT image FROM annonces WHERE id_annonce = ?");
            $stmt->execute([$id]);
            $oldImage = $stmt->fetchColumn();
            
            if ($oldImage) {
                $filePath = $_SERVER['DOCUMENT_ROOT'] . parse_url($oldImage, PHP_URL_PATH);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            $stmt = $this->db->prepare("
                UPDATE annonces 
                SET titre = ?, adresse = ?, description = ?, prix_journalier = ?, id_categorie = ?, image = ? 
                WHERE id_annonce = ?
            ");
            return $stmt->execute([$name, $address, $description, $phone, $categoryId, $image, $id]);
        } else {
            $stmt = $this->db->prepare("
                UPDATE annonces 
                SET titre = ?, adresse = ?, description = ?, prix_journalier = ?, id_categorie = ? 
                WHERE id_annonce = ?
            ");
            return $stmt->execute([$name, $address, $description, $phone, $categoryId, $id]);
        }
    }
}