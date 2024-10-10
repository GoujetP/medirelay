<?php
// models/Pharmacy.php

class Pharmacy {
    private $conn;
    private $table_name = "pharmacy";

    public function __construct($db) {
        $this->conn = $db;
        // Configurer PDO pour lancer des exceptions en cas d'erreur
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    // Créer une nouvelle pharmacie
    public function create($postal_code, $address, $name) {
        $query = "INSERT INTO " . $this->table_name . " 
                  (pharmacy_postal_code, pharmacy_address, pharmacy_name)
                  VALUES (:pharmacy_postal_code, :pharmacy_address, :pharmacy_name)";

        try {
            $stmt = $this->conn->prepare($query);

            // Sécuriser et bind des valeurs
            $stmt->bindParam(":pharmacy_postal_code", $postal_code, PDO::PARAM_INT);
            $stmt->bindParam(":pharmacy_address", $this->secureString($address), PDO::PARAM_STR);
            $stmt->bindParam(":pharmacy_name", $this->secureString($name), PDO::PARAM_STR);

            if ($stmt->execute()) {
                return true;
            }
            return false;

        } catch (PDOException $e) {
            // Log the exception, do not display error messages to the user
            error_log($e->getMessage());
            return false;
        }
    }

    // Mettre à jour une pharmacie
    public function update($id, $postal_code, $address, $name) {
        $query = "UPDATE " . $this->table_name . "
                  SET pharmacy_postal_code = :pharmacy_postal_code, 
                      pharmacy_address = :pharmacy_address, 
                      pharmacy_name = :pharmacy_name
                  WHERE pharmacy_id = :pharmacy_id";

        try {
            $stmt = $this->conn->prepare($query);

            // Sécuriser et bind des valeurs
            $stmt->bindParam(":pharmacy_postal_code", $postal_code, PDO::PARAM_INT);
            $stmt->bindParam(":pharmacy_address", $this->secureString($address), PDO::PARAM_STR);
            $stmt->bindParam(":pharmacy_name", $this->secureString($name), PDO::PARAM_STR);
            $stmt->bindParam(":pharmacy_id", $id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                return true;
            }
            return false;

        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    // Lire tous les patients
    public function readAll()
    {
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

    // Lire un seul patient par ID
    public function readOne($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE pharmacy_id = :pharmacy_id LIMIT 0,1";

        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":pharmacy_id", $id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    // Supprimer une pharmacie
    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE pharmacy_id = :pharmacy_id";

        try {
            $stmt = $this->conn->prepare($query);

            // Bind de l'ID avec sécurisation
            $stmt->bindParam(":pharmacy_id", $id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                return true;
            }
            return false;

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
