<?php

include_once '../models/Pharmacy.php';

class PharmacyController {
    private $db;
    private $requestMethod;
    private $pharmacyId;

    public function __construct($db, $requestMethod, $pharmacyId = null) {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->pharmacyId = $pharmacyId;
    }

    public function processRequest() {
        switch ($this->requestMethod) {
            case 'GET':
                if ($this->pharmacyId) {
                    $this->getPharmacy($this->pharmacyId);
                } else {
                    $this->getAllPharmacies();
                }
                break;
            case 'POST':
                $this->createPharmacy();
                break;
            case 'PUT':
                $this->updatePharmacy($this->pharmacyId);
                break;
            case 'DELETE':
                $this->deletePharmacy($this->pharmacyId);
                break;
            default:
                $this->notFoundResponse();
                break;
        }
    }

    private function getAllPharmacies() {
        $pharmacy = new Pharmacy($this->db);
        $result = $pharmacy->readAll();

        if ($result) {
            echo json_encode($result);
        } else {
            echo json_encode(['message' => 'Erreur lors de la récupération des pharmacies.']);
        }
    }

    private function getPharmacy($id) {
        $pharmacy = new Pharmacy($this->db);
        $result = $pharmacy->readOne($id);

        if ($result) {
            echo json_encode($result);
        } else {
            echo json_encode(['message' => 'Pharmacie non trouvée.']);
        }
    }

    private function createPharmacy() {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);

        if ($this->validatePharmacy($input)) {
            $pharmacy = new Pharmacy($this->db);
            if ($pharmacy->create(
                $input['pharmacy_postal_code'],
                $input['pharmacy_address'],
                $input['pharmacy_name']
            )) {
                echo json_encode(['message' => 'Pharmacie créée avec succès.']);
            } else {
                echo json_encode(['message' => 'Erreur lors de la création de la pharmacie.']);
            }
        } else {
            echo json_encode(['message' => 'Les données de la pharmacie ne sont pas valides.']);
        }
    }

    private function updatePharmacy($id) {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);

        if ($this->validatePharmacy($input)) {
            $pharmacy = new Pharmacy($this->db);
            if ($pharmacy->update(
                $id,
                $input['pharmacy_postal_code'],
                $input['pharmacy_address'],
                $input['pharmacy_name']
            )) {
                echo json_encode(['message' => 'Pharmacie mise à jour avec succès.']);
            } else {
                echo json_encode(['message' => 'Erreur lors de la mise à jour de la pharmacie.']);
            }
        } else {
            echo json_encode(['message' => 'Les données de la pharmacie ne sont pas valides.']);
        }
    }

    private function deletePharmacy($id) {
        $pharmacy = new Pharmacy($this->db);
        if ($pharmacy->delete($id)) {
            echo json_encode(['message' => 'Pharmacie supprimée avec succès.']);
        } else {
            echo json_encode(['message' => 'Erreur lors de la suppression de la pharmacie.']);
        }
    }

    private function validatePharmacy($input) {
        if (!isset($input['pharmacy_postal_code']) || !isset($input['pharmacy_address']) || !isset($input['pharmacy_name'])) {
            return false;
        }
        return true;
    }

    private function notFoundResponse() {
        echo json_encode(['message' => 'Route non trouvée.']);
    }
}
