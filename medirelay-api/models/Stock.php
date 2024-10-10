<?php
// models/Stock.php

class Stock {
    private $conn;
    private $table_name = "stock";

    public function __construct($db) {
        $this->conn = $db;
        // Configurer PDO pour lancer des exceptions en cas d'erreur
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    // Créer une nouvelle entrée de stock
    public function create($pharmacy_id, $medicine_id, $quantity) {
        $query = "INSERT INTO " . $this->table_name . " 
                  (pharmacy_id, medicine_id, quantity)
                  VALUES (:pharmacy_id, :medicine_id, :quantity)";

        try {
            $stmt = $this->conn->prepare($query);

            // Sécuriser et bind des valeurs
            $stmt->bindParam(":pharmacy_id", $pharmacy_id, PDO::PARAM_INT);
            $stmt->bindParam(":medicine_id", $medicine_id, PDO::PARAM_INT);
            $stmt->bindParam(":quantity", $quantity, PDO::PARAM_INT);

            if ($stmt->execute()) {
                return true;
            }
            return false;

        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    // Mettre à jour une entrée de stock
    public function update($pharmacy_id, $medicine_id, $quantity) {
        $query = "UPDATE " . $this->table_name . "
                  SET quantity = :quantity
                  WHERE pharmacy_id = :pharmacy_id AND medicine_id = :medicine_id";

        try {
            $stmt = $this->conn->prepare($query);

            // Sécuriser et bind des valeurs
            $stmt->bindParam(":pharmacy_id", $pharmacy_id, PDO::PARAM_INT);
            $stmt->bindParam(":medicine_id", $medicine_id, PDO::PARAM_INT);
            $stmt->bindParam(":quantity", $quantity, PDO::PARAM_INT);

            if ($stmt->execute()) {
                return true;
            }
            return false;

        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    // Supprimer une entrée de stock
    public function delete($pharmacy_id, $medicine_id) {
        $query = "DELETE FROM " . $this->table_name . " 
                  WHERE pharmacy_id = :pharmacy_id AND medicine_id = :medicine_id";

        try {
            $stmt = $this->conn->prepare($query);

            // Bind des ID avec sécurisation
            $stmt->bindParam(":pharmacy_id", $pharmacy_id, PDO::PARAM_INT);
            $stmt->bindParam(":medicine_id", $medicine_id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                return true;
            }
            return false;

        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    // Récupérer tous les stocks
    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name;

        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    // Récupérer une seule entrée de stock
    public function readOne($pharmacy_id, $medicine_id) {
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE pharmacy_id = :pharmacy_id AND medicine_id = :medicine_id";

        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":pharmacy_id", $pharmacy_id, PDO::PARAM_INT);
            $stmt->bindParam(":medicine_id", $medicine_id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    // Fonction pour sécuriser les chaînes de caractères
    private function secureString($string) {
        return htmlspecialchars(strip_tags($string));
    }
}
