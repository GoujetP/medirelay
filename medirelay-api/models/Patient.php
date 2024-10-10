<?php
// models/Patient.php

class Patient {
    private $conn;
    private $table_name = "patients";

    public function __construct($db) {
        $this->conn = $db;
        // Configurer PDO pour lancer des exceptions en cas d'erreur
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    // Créer un nouveau patient
    public function create($nom, $prenom, $numero_secu, $mutuel, $code_postale, $medecin_id, $ordonnance_id) {
        $query = "INSERT INTO " . $this->table_name . " 
                  (patient_nom, patient_prenom, patient_numero_secu, patient_mutuel, patient_code_postale, medecin_id, ordonnance_id)
                  VALUES (:patient_nom, :patient_prenom, :patient_numero_secu, :patient_mutuel, :patient_code_postale, :medecin_id, :ordonnance_id)";

        try {
            $stmt = $this->conn->prepare($query);

            // Sécuriser et bind des valeurs
            $stmt->bindParam(":patient_nom", $this->secureString($nom), PDO::PARAM_STR);
            $stmt->bindParam(":patient_prenom", $this->secureString($prenom), PDO::PARAM_STR);
            $stmt->bindParam(":patient_numero_secu", $numero_secu, PDO::PARAM_INT);
            $stmt->bindParam(":patient_mutuel", $this->secureString($mutuel), PDO::PARAM_STR);
            $stmt->bindParam(":patient_code_postale", $code_postale, PDO::PARAM_INT);
            $stmt->bindParam(":medecin_id", $medecin_id, PDO::PARAM_INT);
            $stmt->bindParam(":ordonnance_id", $ordonnance_id, PDO::PARAM_INT);

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

    public function readAllPatientsDoctor($idDoctor) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE doctor_id = $idDoctor";
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
    public function readOne($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE patient_id = :patient_id LIMIT 0,1";
        
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":patient_id", $id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    // Mettre à jour un patient
    public function update($id, $nom, $prenom, $numero_secu, $mutuel, $code_postale, $medecin_id, $ordonnance_id) {
        $query = "UPDATE " . $this->table_name . "
                  SET patient_nom = :patient_nom, patient_prenom = :patient_prenom, patient_numero_secu = :patient_numero_secu, 
                      patient_mutuel = :patient_mutuel, patient_code_postale = :patient_code_postale, medecin_id = :medecin_id, ordonnance_id = :ordonnance_id
                  WHERE patient_id = :patient_id";

        try {
            $stmt = $this->conn->prepare($query);

            // Sécuriser et bind des valeurs
            $stmt->bindParam(":patient_nom", $this->secureString($nom), PDO::PARAM_STR);
            $stmt->bindParam(":patient_prenom", $this->secureString($prenom), PDO::PARAM_STR);
            $stmt->bindParam(":patient_numero_secu", $numero_secu, PDO::PARAM_INT);
            $stmt->bindParam(":patient_mutuel", $this->secureString($mutuel), PDO::PARAM_STR);
            $stmt->bindParam(":patient_code_postale", $code_postale, PDO::PARAM_INT);
            $stmt->bindParam(":medecin_id", $medecin_id, PDO::PARAM_INT);
            $stmt->bindParam(":ordonnance_id", $ordonnance_id, PDO::PARAM_INT);
            $stmt->bindParam(":patient_id", $id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                return true;
            }
            return false;

        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    // Supprimer un patient
    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE patient_id = :patient_id";

        try {
            $stmt = $this->conn->prepare($query);

            // Bind de l'ID avec sécurisation
            $stmt->bindParam(":patient_id", $id, PDO::PARAM_INT);

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
