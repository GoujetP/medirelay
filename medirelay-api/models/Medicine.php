<?php
// models/Medicine.php

class Medicine {
    private $conn;
    private $table_name = "medicine";

    public function __construct($db) {
        $this->conn = $db;
        // Configurer PDO pour lancer des exceptions en cas d'erreur
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    // Créer un nouveau médicament
    public function create($medicine_name, $expiry_date, $barcode) {
        $query = "INSERT INTO " . $this->table_name . " 
                  (medicine_name, medicine_expiry_date, medicine_barcode)
                  VALUES (:medicine_name, :medicine_expiry_date, :medicine_barcode)";

        try {
            $stmt = $this->conn->prepare($query);

            // Sécuriser et bind des valeurs
            $stmt->bindParam(":medicine_name", $this->secureString($medicine_name), PDO::PARAM_STR);
            $stmt->bindParam(":medicine_expiry_date", $expiry_date, PDO::PARAM_STR);
            $stmt->bindParam(":medicine_barcode", $barcode, PDO::PARAM_INT);

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

    // Mettre à jour un médicament
    public function update($id, $medicine_name, $expiry_date, $barcode) {
        $query = "UPDATE " . $this->table_name . "
                  SET medicine_name = :medicine_name, medicine_expiry_date = :medicine_expiry_date, medicine_barcode = :medicine_barcode
                  WHERE medicine_id = :medicine_id";

        try {
            $stmt = $this->conn->prepare($query);

            // Sécuriser et bind des valeurs
            $stmt->bindParam(":medicine_name", $this->secureString($medicine_name), PDO::PARAM_STR);
            $stmt->bindParam(":medicine_expiry_date", $expiry_date, PDO::PARAM_STR);
            $stmt->bindParam(":medicine_barcode", $barcode, PDO::PARAM_INT);
            $stmt->bindParam(":medicine_id", $id, PDO::PARAM_INT);

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

    public function readAllMedicinesPrescription($id)
    {
        $query = "SELECT * FROM " . "medicine_prescription" . " WHERE prescription_id = :prescription_id";
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":prescription_id", $id, PDO::PARAM_INT);
            $stmt->execute();
            $tabMany = $stmt->fetchAll(PDO::FETCH_ASSOC); 
            foreach($tabMany as $tab){
                $query = "SELECT * FROM " . $this->table_name . " WHERE medicine_id = :medicine_id";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(":medicine_id", $tab['medicine_id'], PDO::PARAM_INT);
                $stmt->execute();
                $tabOne = $stmt->fetch(PDO::FETCH_ASSOC);
                $newTab[] = $tabOne;
            }
            if(isset($newTab)){
                return $newTab;
            } else {
                return "No medicines in prescription";
            }
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    // Lire un seul patient par ID
    public function readOne($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE medicine_id = :medicine_id LIMIT 0,1";

        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":medicine_id", $id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    // Supprimer un médicament
    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE medicine_id = :medicine_id";

        try {
            $stmt = $this->conn->prepare($query);

            // Bind de l'ID avec sécurisation
            $stmt->bindParam(":medicine_id", $id, PDO::PARAM_INT);

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
