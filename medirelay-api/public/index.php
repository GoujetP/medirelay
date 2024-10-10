<?php
// public/index.php

// Inclure la configuration de la base de données et les routes
include_once '../config/Database.php';
include_once '../config/credentials.php';
include_once '../routes/routes.php';
include_once '../controllers/AuthController.php';


header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Initialiser la connexion à la base de données
$database = new Database($host, $username, $password, $db_name);
$db = $database->getConnection();
// Récupérer la méthode de la requête HTTP (GET, POST, PUT, DELETE)
$requestMethod = $_SERVER['REQUEST_METHOD'];

// Récupérer l'entité (par exemple, "patients") et l'action depuis l'URL
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

// L'entité sera par exemple "patients"
$entity = isset($uri[4]) ? $uri[4] : null;
//Vérifier que le token existe
if ($entity != "login") {

    $headers = apache_request_headers();
    if (isset($headers['Authorization'])) {
        $authHeader = $headers['Authorization'];

        // Vérifier si le header contient le mot "Bearer"
        if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $token = $matches[1];
            if (isset($_GET["role"])) {
                $role = $_GET["role"];
                switch ($role) {
                    case 'Doctor':
                        $query = "SELECT doctor_id FROM doctors WHERE token = :token";
                        $stmt = $db->prepare($query);
                        $stmt->bindParam(":token", $token);
                        $stmt->execute();
                        $user = $stmt->fetch(PDO::FETCH_ASSOC);
                        if (count($user) != 1) {
                            //Soit pas soit + 1 user
                            echo 'Wrong token. Access Denied.';
                            die;

                        }
                        break;
                    case 'Patient':
                        $query = "SELECT patient_id FROM patients WHERE token = :token";
                        $stmt = $db->prepare($query);
                        $stmt->bindParam(":token", $token);
                        $stmt->execute();
                        $user = $stmt->fetch(PDO::FETCH_ASSOC);
                        if (count($user) != 1) {
                            //Soit pas soit + 1 user
                            echo 'Wrong token. Access Denied.';
                            die;

                        }
                        break;
                    case 'Pharmacy':
                        $query = "SELECT pharmacy_id FROM pharmacy WHERE token = :token";
                        $stmt = $db->prepare($query);
                        $stmt->bindParam(":token", $token);
                        $stmt->execute();
                        $user = $stmt->fetch(PDO::FETCH_ASSOC);
                        if (count($user) != 1) {
                            //Soit pas soit + 1 user
                            echo 'Wrong token. Access Denied.';
                            die;

                        }
                        break;
                }
            }
        } else {
            echo 'Wrong Token';
            die;
        }
    } else {
        echo 'No Headers';
        die;
    }
} else {
    //If login
    include_once '../controllers/AuthController.php';
    $role = $_GET["role"];
    $username = $_GET["username"];
    $password = $_GET["password"];
    $controller = new AuthController($db);
    $controller->login($username, $password, $role);
    die;
}

// L'ID sera récupéré via les paramètres GET (par exemple ?id=1)
$entityId = isset($_GET['id']) ? intval($_GET['id']) : null;

// À partir de ce point, le token est valide, et l'utilisateur est authentifié

// Vérifier si l'entité est spécifiée (patients, doctors, pharmacies, etc.)
if (!$entity) {
    http_response_code(400); // Code HTTP 400 : Bad Request
    echo json_encode([
        "message" => "L'entité doit être spécifiée dans l'URL. Par exemple : /patients"
    ]);
    exit();
}

// Initialiser le contrôleur approprié en fonction de l'entité
switch ($entity) {
    case 'patients':
        include_once '../controllers/PatientsController.php';
        $controller = new PatientsController($db, $requestMethod, $entityId);
        break;

    case 'doctors':
        include_once '../controllers/DoctorsController.php';
        $controller = new DoctorsController($db, $requestMethod, $entityId);
        break;

    case 'medicines':
        include_once '../controllers/MedicinesController.php';
        $controller = new MedicinesController($db, $requestMethod, $entityId);
        break;

    case 'orders':
        include_once '../controllers/OrdersController.php';
        $controller = new OrdersController($db, $requestMethod, $entityId);
        break;

    case 'pharmacy':
        include_once '../controllers/PharmacyController.php';
        $controller = new PharmacyController($db, $requestMethod, $entityId);
        break;

    case 'prescriptions':
        include_once '../controllers/PrescriptionsController.php';
        $controller = new PrescriptionsController($db, $requestMethod, $entityId);
        break;

    case 'stocks':
        include_once '../controllers/StocksController.php';
        // Comme la table `stock` a deux clés primaires, il faut capturer `pharmacyId` et `medicineId`
        $pharmacyId = isset($_GET['pharmacy_id']) ? intval($_GET['pharmacy_id']) : null;
        $medicineId = isset($_GET['medicine_id']) ? intval($_GET['medicine_id']) : null;
        $controller = new StocksController($db, $requestMethod, $pharmacyId, $medicineId);
        break;
    default:
        http_response_code(404); // Code HTTP 404 : Not Found
        echo json_encode([
            "message" => "L'entité spécifiée est introuvable."
        ]);
        exit();
}

// Traiter la requête en appelant la méthode appropriée dans le contrôleur
$controller->processRequest();
