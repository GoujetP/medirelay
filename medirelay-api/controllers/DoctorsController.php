<?php

include_once '../models/Doctor.php';

class DoctorsController {
    private $db;
    private $requestMethod;
    private $doctorId;

    public function __construct($db, $requestMethod, $doctorId = null) {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->doctorId = $doctorId;
    }

    public function processRequest() {
        switch ($this->requestMethod) {
            case 'GET':
                if ($this->doctorId) {
                    $this->getDoctor($this->doctorId);
                } else {
                    $this->getAllDoctors();
                }
                break;
            case 'POST':
                $this->createDoctor();
                break;
            case 'PUT':
                $this->updateDoctor($this->doctorId);
                break;
            case 'DELETE':
                $this->deleteDoctor($this->doctorId);
                break;
            default:
                $this->notFoundResponse();
                break;
        }
    }

    

    private function getAllDoctors() {
        $doctor = new Doctor($this->db);
        $result = $doctor->readAll();

        if ($result) {
            echo json_encode($result);
        } else {
            echo json_encode(['message' => 'Erreur lors de la récupération des médecins.']);
        }
    }

    private function getDoctor($id) {
        $doctor = new Doctor($this->db);
        $result = $doctor->readOne($id);

        if ($result) {
            echo json_encode($result);
        } else {
            echo json_encode(['message' => 'Médecin non trouvé.']);
        }
    }

    private function createDoctor() {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);

        if ($this->validateDoctor($input)) {
            $doctor = new Doctor($this->db);
            if ($doctor->create(
                $input['doctor_last_name'],
                $input['doctor_first_name'],
                $input['doctor_email'],
                $input['doctor_postal_code']
            )) {
                echo json_encode(['message' => 'Médecin créé avec succès.']);
            } else {
                echo json_encode(['message' => 'Erreur lors de la création du médecin.']);
            }
        } else {
            echo json_encode(['message' => 'Les données du médecin ne sont pas valides.']);
        }
    }

    private function updateDoctor($id) {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);

        if ($this->validateDoctor($input)) {
            $doctor = new Doctor($this->db);
            if ($doctor->update(
                $id,
                $input['doctor_last_name'],
                $input['doctor_first_name'],
                $input['doctor_email'],
                $input['doctor_postal_code']
            )) {
                echo json_encode(['message' => 'Médecin mis à jour avec succès.']);
            } else {
                echo json_encode(['message' => 'Erreur lors de la mise à jour du médecin.']);
            }
        } else {
            echo json_encode(['message' => 'Les données du médecin ne sont pas valides.']);
        }
    }

    private function deleteDoctor($id) {
        $doctor = new Doctor($this->db);
        if ($doctor->delete($id)) {
            echo json_encode(['message' => 'Médecin supprimé avec succès.']);
        } else {
            echo json_encode(['message' => 'Erreur lors de la suppression du médecin.']);
        }
    }

    private function validateDoctor($input) {
        if (!isset($input['doctor_last_name']) || !isset($input['doctor_first_name']) || !isset($input['doctor_email']) || !isset($input['doctor_postal_code'])) {
            return false;
        }
        return true;
    }

    private function notFoundResponse() {
        echo json_encode(['message' => 'Route non trouvée.']);
    }
}
