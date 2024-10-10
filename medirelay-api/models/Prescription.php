<?php
// models/Prescription.php

class Prescription {
    private $conn;
    private $table_name = "prescriptions";

    public function __construct($db) {
        $this->conn = $db;
        // Configurer PDO pour lancer des exceptions en cas d'erreur
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    // Créer une nouvelle prescription
    public function create($medicine_id, $ordered, $treatment_duration, $renewal_date) {
        $query = "INSERT INTO " . $this->table_name . " 
                  (medicine_id, prescription_ordered, prescription_traitment_duration, prescription_renewal_date)
                  VALUES (:medicine_id, :prescription_ordered, :prescription_traitment_duration, :prescription_renewal_date)";

        try {
            $stmt = $this->conn->prepare($query);

            // Sécuriser et bind des valeurs
            $stmt->bindParam(":medicine_id", $medicine_id, PDO::PARAM_INT);
            $stmt->bindParam(":prescription_ordered", $ordered, PDO::PARAM_INT);
            $stmt->bindParam(":prescription_traitment_duration", $treatment_duration, PDO::PARAM_INT);
            $stmt->bindParam(":prescription_renewal_date", $renewal_date, PDO::PARAM_STR);

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

    // Mettre à jour une prescription
    public function update($id, $medicine_id, $ordered, $treatment_duration, $renewal_date) {
        $query = "UPDATE " . $this->table_name . "
                  SET medicine_id = :medicine_id, 
                      prescription_ordered = :prescription_ordered, 
                      prescription_traitment_duration = :prescription_traitment_duration, 
                      prescription_renewal_date = :prescription_renewal_date
                  WHERE prescription_id = :prescription_id";

        try {
            $stmt = $this->conn->prepare($query);

            // Sécuriser et bind des valeurs
            $stmt->bindParam(":medicine_id", $medicine_id, PDO::PARAM_INT);
            $stmt->bindParam(":prescription_ordered", $ordered, PDO::PARAM_INT);
            $stmt->bindParam(":prescription_traitment_duration", $treatment_duration, PDO::PARAM_INT);
            $stmt->bindParam(":prescription_renewal_date", $renewal_date, PDO::PARAM_STR);
            $stmt->bindParam(":prescription_id", $id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                return true;
            }
            return false;

        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    // Supprimer une prescription
    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE prescription_id = :prescription_id";

        try {
            $stmt = $this->conn->prepare($query);

            // Bind de l'ID avec sécurisation
            $stmt->bindParam(":prescription_id", $id, PDO::PARAM_INT);

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

    public function readAllPatientPrescription($idPatient) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE patient_id = $idPatient";
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
        $query = "SELECT * FROM " . $this->table_name . " WHERE prescription_id = :prescription_id LIMIT 0,1";

        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":prescription_id", $id, PDO::PARAM_INT);
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
