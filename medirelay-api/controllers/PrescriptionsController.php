<?php

include_once '../models/Prescription.php';

class PrescriptionsController
{
    private $db;
    private $requestMethod;
    private $prescriptionId;

    public function __construct($db, $requestMethod, $prescriptionId = null)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->prescriptionId = $prescriptionId;
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'GET':
                if ($this->prescriptionId && !isset($_GET['role'])) {
                    $this->getPrescription($this->prescriptionId);
                } else {
                    if (isset($_GET['role']) && $_GET['role'] == 'Patient' && isset($_GET['id'])) {
                        $this->getAllPatientPrescriptions($_GET['id']);
                    } else {
                        $this->getAllPrescriptions();
                    }
                }
                break;
            case 'POST':
                $this->createPrescription();
                break;
            case 'PUT':
                $this->updatePrescription($this->prescriptionId);
                break;
            case 'DELETE':
                $this->deletePrescription($this->prescriptionId);
                break;
            default:
                $this->notFoundResponse();
                break;
        }
    }

    private function getAllPrescriptions()
    {
        $prescription = new Prescription($this->db);
        $result = $prescription->readAll();

        if ($result) {
            echo json_encode($result);
        } else {
            echo json_encode(['message' => 'Erreur lors de la récupération des prescriptions.']);
        }
    }

    private function getAllPatientPrescriptions($idPatient)
    {
        $prescription = new Prescription($this->db);
        $result = $prescription->readAllPatientPrescription($idPatient);
        if ($result) {
            echo json_encode($result);
        } else {
            echo json_encode(['message' => 'Erreur lors de la récupération des patients.']);
        }
    }

    private function getPrescription($id)
    {
        $prescription = new Prescription($this->db);
        $result = $prescription->readOne($id);

        if ($result) {
            echo json_encode($result);
        } else {
            echo json_encode(['message' => 'Prescription non trouvée.']);
        }
    }

    private function createPrescription()
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);

        if ($this->validatePrescription($input)) {
            $prescription = new Prescription($this->db);
            if (
                $prescription->create(
                    $input['medicine_id'],
                    $input['prescription_ordered'],
                    $input['prescription_traitment_duration'],
                    $input['prescription_renewal_date']
                )
            ) {
                echo json_encode(['message' => 'Prescription créée avec succès.']);
            } else {
                echo json_encode(['message' => 'Erreur lors de la création de la prescription.']);
            }
        } else {
            echo json_encode(['message' => 'Les données de la prescription ne sont pas valides.']);
        }
    }

    private function updatePrescription($id)
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);

        if ($this->validatePrescription($input)) {
            $prescription = new Prescription($this->db);
            if (
                $prescription->update(
                    $id,
                    $input['medicine_id'],
                    $input['prescription_ordered'],
                    $input['prescription_traitment_duration'],
                    $input['prescription_renewal_date']
                )
            ) {
                echo json_encode(['message' => 'Prescription mise à jour avec succès.']);
            } else {
                echo json_encode(['message' => 'Erreur lors de la mise à jour de la prescription.']);
            }
        } else {
            echo json_encode(['message' => 'Les données de la prescription ne sont pas valides.']);
        }
    }

    private function deletePrescription($id)
    {
        $prescription = new Prescription($this->db);
        if ($prescription->delete($id)) {
            echo json_encode(['message' => 'Prescription supprimée avec succès.']);
        } else {
            echo json_encode(['message' => 'Erreur lors de la suppression de la prescription.']);
        }
    }

    private function validatePrescription($input)
    {
        if (!isset($input['medicine_id']) || !isset($input['prescription_ordered']) || !isset($input['prescription_traitment_duration']) || !isset($input['prescription_renewal_date'])) {
            return false;
        }
        return true;
    }

    private function notFoundResponse()
    {
        echo json_encode(['message' => 'Route non trouvée.']);
    }
}
