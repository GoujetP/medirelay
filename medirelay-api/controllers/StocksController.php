<?php

include_once '../models/Stock.php';

class StocksController {
    private $db;
    private $requestMethod;
    private $pharmacyId;
    private $medicineId;

    public function __construct($db, $requestMethod, $pharmacyId = null, $medicineId = null) {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->pharmacyId = $pharmacyId;
        $this->medicineId = $medicineId;
    }

    public function processRequest() {
        switch ($this->requestMethod) {
            case 'GET':
                if ($this->pharmacyId && $this->medicineId) {
                    $this->getStock($this->pharmacyId, $this->medicineId);
                } else {
                    $this->getAllStocks();
                }
                break;
            case 'POST':
                $this->createStock();
                break;
            case 'PUT':
                $this->updateStock($this->pharmacyId, $this->medicineId);
                break;
            case 'DELETE':
                $this->deleteStock($this->pharmacyId, $this->medicineId);
                break;
            default:
                $this->notFoundResponse();
                break;
        }
    }

    private function getAllStocks() {
        $stock = new Stock($this->db);
        $result = $stock->readAll();

        if ($result) {
            echo json_encode($result);
        } else {
            echo json_encode(['message' => 'Erreur lors de la récupération des stocks.']);
        }
    }

    private function getStock($pharmacyId, $medicineId) {
        $stock = new Stock($this->db);
        $result = $stock->readOne($pharmacyId, $medicineId);

        if ($result) {
            echo json_encode($result);
        } else {
            echo json_encode(['message' => 'Stock non trouvé.']);
        }
    }

    private function createStock() {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);

        if ($this->validateStock($input)) {
            $stock = new Stock($this->db);
            if ($stock->create(
                $input['pharmacy_id'],
                $input['medicine_id'],
                $input['quantity']
            )) {
                echo json_encode(['message' => 'Stock créé avec succès.']);
            } else {
                echo json_encode(['message' => 'Erreur lors de la création du stock.']);
            }
        } else {
            echo json_encode(['message' => 'Les données du stock ne sont pas valides.']);
        }
    }

    private function updateStock($pharmacyId, $medicineId) {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);

        if ($this->validateStock($input)) {
            $stock = new Stock($this->db);
            if ($stock->update(
                $pharmacyId,
                $medicineId,
                $input['quantity']
            )) {
                echo json_encode(['message' => 'Stock mis à jour avec succès.']);
            } else {
                echo json_encode(['message' => 'Erreur lors de la mise à jour du stock.']);
            }
        } else {
            echo json_encode(['message' => 'Les données du stock ne sont pas valides.']);
        }
    }

    private function deleteStock($pharmacyId, $medicineId) {
        $stock = new Stock($this->db);
        if ($stock->delete($pharmacyId, $medicineId)) {
            echo json_encode(['message' => 'Stock supprimé avec succès.']);
        } else {
            echo json_encode(['message' => 'Erreur lors de la suppression du stock.']);
        }
    }

    private function validateStock($input) {
        if (!isset($input['pharmacy_id']) || !isset($input['medicine_id']) || !isset($input['quantity'])) {
            return false;
        }
        return true;
    }

    private function notFoundResponse() {
        echo json_encode(['message' => 'Route non trouvée.']);
    }
}
