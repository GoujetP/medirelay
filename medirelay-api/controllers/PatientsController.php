<?php

include_once '../models/Patient.php';

class PatientsController {
    private $db;
    private $requestMethod;
    private $patientId;

    public function __construct($db, $requestMethod, $patientId = null) {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->patientId = $patientId;
    }

    public function processRequest() {
        switch ($this->requestMethod) {
            case 'GET':
                if ($this->patientId && !isset($_GET['role'])) {
                    $this->getPatient($this->patientId);
                } else {
                    if (isset($_GET['role']) && $_GET['role'] == 'Doctor' && isset($_GET['id'])) {
                        $this->getAllPatientsDoctor($_GET['id']);
                    } else {
                        $this->getAllPatients();
                    }
                }
                break;
            case 'POST':
                $this->createPatient();
                break;
            case 'PUT':
                $this->updatePatient($this->patientId);
                break;
            case 'DELETE':
                $this->deletePatient($this->patientId);
                break;
            default:
                $this->notFoundResponse();
                break;
        }
    }

    // Récupérer tous les patients
    private function getAllPatients() {
        $patient = new Patient($this->db);
        $result = $patient->readAll();

        if ($result) {
            echo json_encode($result);
        } else {
            echo json_encode(['message' => 'Erreur lors de la récupération des patients.']);
        }
    }

    private function getAllPatientsDoctor($idDoctor) {
        $patient = new Patient($this->db);
        $result = $patient->readAllPatientsDoctor($idDoctor);
        if ($result) {
            echo json_encode($result);
        } else {
            echo json_encode(['message' => 'Erreur lors de la récupération des patients.']);
        }
    }

    // Récupérer un seul patient
    private function getPatient($id) {
        $patient = new Patient($this->db);
        $result = $patient->readOne($id);

        if ($result) {
            echo json_encode($result);
        } else {
            echo json_encode(['message' => 'Patient non trouvé.']);
        }
    }

    // Créer un nouveau patient
    private function createPatient() {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);

        if ($this->validatePatient($input)) {
            $patient = new Patient($this->db);
            if ($patient->create(
                $input['patient_nom'],
                $input['patient_prenom'],
                $input['patient_numero_secu'],
                $input['patient_mutuel'],
                $input['patient_code_postale'],
                $input['medecin_id'],
                $input['ordonnance_id']
            )) {
                echo json_encode(['message' => 'Patient créé avec succès.']);
            } else {
                echo json_encode(['message' => 'Erreur lors de la création du patient.']);
            }
        } else {
            echo json_encode(['message' => 'Les données du patient ne sont pas valides.']);
        }
    }

    // Mettre à jour un patient
    private function updatePatient($id) {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);

        if ($this->validatePatient($input)) {
            $patient = new Patient($this->db);
            if ($patient->update(
                $id,
                $input['patient_nom'],
                $input['patient_prenom'],
                $input['patient_numero_secu'],
                $input['patient_mutuel'],
                $input['patient_code_postale'],
                $input['medecin_id'],
                $input['ordonnance_id']
            )) {
                echo json_encode(['message' => 'Patient mis à jour avec succès.']);
            } else {
                echo json_encode(['message' => 'Erreur lors de la mise à jour du patient.']);
            }
        } else {
            echo json_encode(['message' => 'Les données du patient ne sont pas valides.']);
        }
    }

    // Supprimer un patient
    private function deletePatient($id) {
        $patient = new Patient($this->db);
        if ($patient->delete($id)) {
            echo json_encode(['message' => 'Patient supprimé avec succès.']);
        } else {
            echo json_encode(['message' => 'Erreur lors de la suppression du patient.']);
        }
    }

    // Validation des données du patient
    private function validatePatient($input) {
        if (!isset($input['patient_nom']) || !isset($input['patient_prenom']) || !isset($input['patient_numero_secu']) ||
            !isset($input['patient_mutuel']) || !isset($input['patient_code_postale']) || !isset($input['medecin_id']) || !isset($input['ordonnance_id'])) {
            return false;
        }
        return true;
    }

    // Réponse pour les routes non trouvées
    private function notFoundResponse() {
        echo json_encode(['message' => 'Route non trouvée.']);
    }
}
