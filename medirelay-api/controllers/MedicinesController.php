<?php

include_once '../models/Medicine.php';

class MedicinesController
{
    private $db;
    private $requestMethod;
    private $medicineId;

    public function __construct($db, $requestMethod, $medicineId = null)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->medicineId = $medicineId;
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'GET':
                if ($this->medicineId && !isset($_GET['role'])) {
                    $this->getMedicine($this->medicineId);
                } else {
                    if (isset($_GET['role']) && $_GET['role'] == 'All' && isset($_GET['id'])) {
                        $this->getAllMedicinesPrescription($_GET['id']);
                    } else {
                        $this->getAllMedicines();
                    }
                }
                break;
            case 'POST':
                $this->createMedicine();
                break;
            case 'PUT':
                $this->updateMedicine($this->medicineId);
                break;
            case 'DELETE':
                $this->deleteMedicine($this->medicineId);
                break;
            default:
                $this->notFoundResponse();
                break;
        }
    }

    private function getAllMedicines()
    {
        $medicine = new Medicine($this->db);
        $result = $medicine->readAll();

        if ($result) {
            echo json_encode($result);
        } else {
            echo json_encode(['message' => 'Erreur lors de la récupération des médicaments.']);
        }
    }

    private function getMedicine($id)
    {
        $medicine = new Medicine($this->db);
        $result = $medicine->readOne($id);

        if ($result) {
            echo json_encode($result);
        } else {
            echo json_encode(['message' => 'Médicament non trouvé.']);
        }
    }

    private function getAllMedicinesPrescription($id)
    {
        $medicine = new Medicine($this->db);
        $result = $medicine->readAllMedicinesPrescription($id);

        if ($result) {
            echo json_encode($result);
        } else {
            echo json_encode(['message' => 'Médicament non trouvé.']);
        }
    }

    private function createMedicine()
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);

        if ($this->validateMedicine($input)) {
            $medicine = new Medicine($this->db);
            if (
                $medicine->create(
                    $input['medicine_name'],
                    $input['medicine_expiry_date'],
                    $input['medicine_barcode']
                )
            ) {
                echo json_encode(['message' => 'Médicament créé avec succès.']);
            } else {
                echo json_encode(['message' => 'Erreur lors de la création du médicament.']);
            }
        } else {
            echo json_encode(['message' => 'Les données du médicament ne sont pas valides.']);
        }
    }

    private function updateMedicine($id)
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);

        if ($this->validateMedicine($input)) {
            $medicine = new Medicine($this->db);
            if (
                $medicine->update(
                    $id,
                    $input['medicine_name'],
                    $input['medicine_expiry_date'],
                    $input['medicine_barcode']
                )
            ) {
                echo json_encode(['message' => 'Médicament mis à jour avec succès.']);
            } else {
                echo json_encode(['message' => 'Erreur lors de la mise à jour du médicament.']);
            }
        } else {
            echo json_encode(['message' => 'Les données du médicament ne sont pas valides.']);
        }
    }

    private function deleteMedicine($id)
    {
        $medicine = new Medicine($this->db);
        if ($medicine->delete($id)) {
            echo json_encode(['message' => 'Médicament supprimé avec succès.']);
        } else {
            echo json_encode(['message' => 'Erreur lors de la suppression du médicament.']);
        }
    }

    private function validateMedicine($input)
    {
        if (!isset($input['medicine_name']) || !isset($input['medicine_expiry_date']) || !isset($input['medicine_barcode'])) {
            return false;
        }
        return true;
    }

    private function notFoundResponse()
    {
        echo json_encode(['message' => 'Route non trouvée.']);
    }
}
