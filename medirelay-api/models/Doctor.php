<?php
// models/Doctor.php

class Doctor
{
    private $conn;
    private $table_name = "doctors";

    public function __construct($db)
    {
        $this->conn = $db;
        // Configurer PDO pour lancer des exceptions en cas d'erreur
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    // Créer un nouveau docteur
    public function create($last_name, $first_name, $email, $postal_code)
    {
        $query = "INSERT INTO " . $this->table_name . " 
                  (doctor_last_name, doctor_first_name, doctor_email, doctor_postal_code)
                  VALUES (:doctor_last_name, :doctor_first_name, :doctor_email, :doctor_postal_code)";

        try {
            $stmt = $this->conn->prepare($query);

            // Sécuriser et bind des valeurs
            $stmt->bindParam(":doctor_last_name", $this->secureString($last_name), PDO::PARAM_STR);
            $stmt->bindParam(":doctor_first_name", $this->secureString($first_name), PDO::PARAM_STR);
            $stmt->bindParam(":doctor_email", $this->secureString($email), PDO::PARAM_STR);
            $stmt->bindParam(":doctor_postal_code", $postal_code, PDO::PARAM_INT);

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
        $query = "SELECT * FROM " . $this->table_name . " WHERE doctor_id = :doctor_id LIMIT 0,1";

        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":doctor_id", $id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    // Mettre à jour un docteur
    public function update($id, $last_name, $first_name, $email, $postal_code)
    {
        $query = "UPDATE " . $this->table_name . "
                  SET doctor_last_name = :doctor_last_name, doctor_first_name = :doctor_first_name, 
                      doctor_email = :doctor_email, doctor_postal_code = :doctor_postal_code
                  WHERE doctor_id = :doctor_id";

        try {
            $stmt = $this->conn->prepare($query);

            // Sécuriser et bind des valeurs
            $stmt->bindParam(":doctor_last_name", $this->secureString($last_name), PDO::PARAM_STR);
            $stmt->bindParam(":doctor_first_name", $this->secureString($first_name), PDO::PARAM_STR);
            $stmt->bindParam(":doctor_email", $this->secureString($email), PDO::PARAM_STR);
            $stmt->bindParam(":doctor_postal_code", $postal_code, PDO::PARAM_INT);
            $stmt->bindParam(":doctor_id", $id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    // Supprimer un docteur
    public function delete($id)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE doctor_id = :doctor_id";

        try {
            $stmt = $this->conn->prepare($query);

            // Bind de l'ID avec sécurisation
            $stmt->bindParam(":doctor_id", $id, PDO::PARAM_INT);

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
    private function secureString($string)
    {
        return htmlspecialchars(strip_tags($string));
    }
}
