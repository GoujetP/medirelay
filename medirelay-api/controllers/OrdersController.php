<?php

include_once '../models/Order.php';

class OrdersController
{
    private $db;
    private $requestMethod;
    private $orderId;

    public function __construct($db, $requestMethod, $orderId = null)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->orderId = $orderId;
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'GET':
                if ($this->orderId && !isset($_GET['role'])) {
                    $this->getOrder($this->orderId);
                } else {
                    if (isset($_GET['role']) && $_GET['role'] == 'Pharmacy' && isset($_GET['id'])) {
                        $this->getAllOrdersPharmacy($_GET['id']);
                    } else {
                        $this->getAllOrders();
                    }
                }
                break;
            case 'POST':
                $this->createOrder();
                break;
            case 'PUT':
                $this->updateOrder($this->orderId);
                break;
            case 'DELETE':
                $this->deleteOrder($this->orderId);
                break;
            default:
                $this->notFoundResponse();
                break;
        }
    }

    private function getAllOrders()
    {
        $order = new Order($this->db);
        $result = $order->readAll();

        if ($result) {
            echo json_encode($result);
        } else {
            echo json_encode(['message' => 'Erreur lors de la récupération des commandes.']);
        }
    }
    private function getAllOrdersPharmacy($idPharmacy): void
    {
        $orders = new Order($this->db);
        $result = $orders->readAllOrdersPharmacy($idPharmacy);
        if ($result) {
            echo json_encode($result);
        } else {
            echo json_encode(['message' => 'Erreur lors de la récupération des patients.']);
        }
    }
    private function getOrder($id)
    {
        $order = new Order($this->db);
        $result = $order->readOne($id);

        if ($result) {
            echo json_encode($result);
        } else {
            echo json_encode(['message' => 'Commande non trouvée.']);
        }
    }

    private function createOrder()
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);

        if ($this->validateOrder($input)) {
            $order = new Order($this->db);
            if (
                $order->create(
                    $input['pharmacy_id'],
                    $input['prescription_id'],
                    $input['order_statut']
                )
            ) {
                echo json_encode(['message' => 'Commande créée avec succès.']);
            } else {
                echo json_encode(['message' => 'Erreur lors de la création de la commande.']);
            }
        } else {
            echo json_encode(['message' => 'Les données de la commande ne sont pas valides.']);
        }
    }

    private function updateOrder($id)
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);

        if ($this->validateOrder($input)) {
            $order = new Order($this->db);
            if (
                $order->update(
                    $id,
                    $input['pharmacy_id'],
                    $input['prescription_id'],
                    $input['order_statut']
                )
            ) {
                echo json_encode(['message' => 'Commande mise à jour avec succès.']);
            } else {
                echo json_encode(['message' => 'Erreur lors de la mise à jour de la commande.']);
            }
        } else {
            echo json_encode(['message' => 'Les données de la commande ne sont pas valides.']);
        }
    }

    private function deleteOrder($id)
    {
        $order = new Order($this->db);
        if ($order->delete($id)) {
            echo json_encode(['message' => 'Commande supprimée avec succès.']);
        } else {
            echo json_encode(['message' => 'Erreur lors de la suppression de la commande.']);
        }
    }

    private function validateOrder($input)
    {
        if (!isset($input['pharmacy_id']) || !isset($input['prescription_id']) || !isset($input['order_statut'])) {
            return false;
        }
        return true;
    }

    private function notFoundResponse()
    {
        echo json_encode(['message' => 'Route non trouvée.']);
    }
}
