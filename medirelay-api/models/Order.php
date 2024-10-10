<?php
// models/Order.php

class Order
{
    private $conn;
    private $table_name = "orders";

    public function __construct($db)
    {
        $this->conn = $db;
        // Configurer PDO pour lancer des exceptions en cas d'erreur
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    // Créer une nouvelle commande
    public function create($pharmacy_id, $prescription_id, $order_statut)
    {
        $query = "INSERT INTO " . $this->table_name . " 
                  (pharmacy_id, prescription_id, order_statut)
                  VALUES (:pharmacy_id, :prescription_id, :order_statut)";

        try {
            $stmt = $this->conn->prepare($query);

            // Sécuriser et bind des valeurs
            $stmt->bindParam(":pharmacy_id", $pharmacy_id, PDO::PARAM_INT);
            $stmt->bindParam(":prescription_id", $prescription_id, PDO::PARAM_INT);
            $stmt->bindParam(":order_statut", $this->secureString($order_statut), PDO::PARAM_STR);

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

    public function readAllOrdersPharmacy($idPharmacy) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE pharmacy_id = $idPharmacy";
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach($orders as $order){
                $query = "SELECT * FROM " . "prescriptions" . " WHERE prescription_id = :prescription_id";
                $prescription = $this->conn->prepare($query);
                $prescription->bindParam(":prescription_id", $order['prescription_id'], PDO::PARAM_INT);
                $prescription->execute();
                $prescriptions = $prescription->fetch(PDO::FETCH_ASSOC);
                $tabOne["prescription"] = $prescriptions["prescription_id"];
                $query = "SELECT * FROM " . "patients" . " WHERE patient_id = :patient_id";
                $patient = $this->conn->prepare($query);
                $patient->bindParam(":patient_id", $prescriptions["patient_id"], PDO::PARAM_INT);
                $patient->execute();
                $tabPatient = $patient->fetch(PDO::FETCH_ASSOC);
                $tabOne["patient_last_name"] = $tabPatient["patient_last_name"];
                $tabOne["patient_first_name"] = $tabPatient["patient_first_name"];
                $query = "SELECT * FROM " . "doctors" . " WHERE doctor_id = :doctor_id";
                $doctor = $this->conn->prepare($query);
                $doctor->bindParam(":doctor_id", $tabPatient['doctor_id'], PDO::PARAM_INT);
                $doctor->execute();
                $tabDoctor = $doctor->fetch(PDO::FETCH_ASSOC);
                $tabOne["doctor_last_name"] = $tabDoctor["doctor_last_name"];
                $tabOne["doctor_first_name"] = $tabDoctor["doctor_first_name"];
                $newTab[] = $tabOne;
            }
            if (isset($newTab)) {
                return $newTab;
            } else {
                return "No orders found.";
            }
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    // Lire un seul patient par ID
    public function readOne($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE order_id = :order_id LIMIT 0,1";

        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":order_id", $id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }
    // Mettre à jour une commande
    public function update($id, $pharmacy_id, $prescription_id, $order_statut)
    {
        $query = "UPDATE " . $this->table_name . "
                  SET pharmacy_id = :pharmacy_id, prescription_id = :prescription_id, order_statut = :order_statut
                  WHERE order_id = :order_id";

        try {
            $stmt = $this->conn->prepare($query);

            // Sécuriser et bind des valeurs
            $stmt->bindParam(":pharmacy_id", $pharmacy_id, PDO::PARAM_INT);
            $stmt->bindParam(":prescription_id", $prescription_id, PDO::PARAM_INT);
            $stmt->bindParam(":order_statut", $this->secureString($order_statut), PDO::PARAM_STR);
            $stmt->bindParam(":order_id", $id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    // Supprimer une commande
    public function delete($id)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE order_id = :order_id";

        try {
            $stmt = $this->conn->prepare($query);

            // Bind de l'ID avec sécurisation
            $stmt->bindParam(":order_id", $id, PDO::PARAM_INT);

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
