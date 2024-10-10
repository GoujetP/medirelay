<?php

class AuthController
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }
    // Function to handle login and generate token
    public function login($username, $password, $role)
    {
        switch ($role) {
            case 'Doctor':
                // SQL query to verify the user in the database
                $query = "SELECT doctor_id, doctor_email, doctor_password FROM doctors WHERE doctor_email = :username";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(":username", $username);
                $stmt->execute();
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                // Verify the password
                if ($user && $password == $user['doctor_password']) {
                    // Generate JWT token
                    $token = hash("sha256", $username . time());
                    $query = "UPDATE doctors SET token = :access_token WHERE doctor_email = :email";
                    $stmt = $this->db->prepare($query);
                    $stmt->bindParam(":access_token", $token);
                    $stmt->bindParam(":email", $username);
                    $stmt->execute();
                    http_response_code(200);
                    // Send token in response
                    echo json_encode([
                        'token' => $token,
                        'id' => $user['doctor_id']
                    ]);
                } else {
                    // On failed login
                    http_response_code(401); // Unauthorized
                    echo json_encode(['message' => 'Invalid username or password']);
                }
                break;
            case 'Patient':
                // SQL query to verify the user in the database
                $query = "SELECT patient_id, patient_email, patient_password FROM patients WHERE patient_email = :username";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(":username", $username);
                $stmt->execute();

                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                // Verify the password
                if ($user && $password == $user['patient_password']) {
                    // Generate JWT token
                    $token = hash("sha256", $username . time());
                    $query = "UPDATE patients SET token = :access_token WHERE patient_email = :email";
                    $stmt = $this->db->prepare($query);
                    $stmt->bindParam(":access_token", $token);
                    $stmt->bindParam(":email", $username);
                    $stmt->execute();
                    http_response_code(200);
                    // Send token in response
                    echo json_encode([
                        'token' => $token,
                        'id' => $user['patient_id']
                    ]);
                } else {
                    // On failed login
                    http_response_code(401); // Unauthorized
                    echo json_encode(['message' => 'Invalid username or password']);
                }
                break;
            case 'Pharmacy':
                // SQL query to verify the user in the database
                $query = "SELECT pharmacy_id, pharmacy_email, pharmacy_password FROM pharmacy WHERE pharmacy_email = :username";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(":username", $username);
                $stmt->execute();

                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                // Verify the password
                if ($user && $password == $user['pharmacy_password']) {
                    // Generate JWT token
                    $token = hash("sha256", $username . time());
                    $query = "UPDATE pharmacy SET token = :access_token WHERE pharmacy_email = :email";
                    $stmt = $this->db->prepare($query);
                    $stmt->bindParam(":access_token", $token);
                    $stmt->bindParam(":email", $username);
                    $stmt->execute();
                    http_response_code(200);
                    // Send token in response
                    echo json_encode([
                        'token' => $token,
                        'id' => $user['pharmacy_id']
                    ]);
                } else {
                    // On failed login
                    http_response_code(401); // Unauthorized
                    echo json_encode(['message' => 'Invalid username or password']);
                }
                break;
        }
    }
}
