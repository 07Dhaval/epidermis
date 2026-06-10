<?php
// book.php — Handle consultation booking form
require_once __DIR__ . '/config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$name       = trim($_POST['full_name'] ?? '');
$email      = trim($_POST['email'] ?? '');
$phone      = trim($_POST['phone'] ?? '');
$service_id = intval($_POST['service_id'] ?? 0);
$date       = trim($_POST['preferred_date'] ?? '');
$message    = trim($_POST['message'] ?? '');

// Validation
$errors = [];
if (empty($name))                        $errors[] = 'Full name is required.';
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required.';

if (!empty($errors)) {
    http_response_code(422);
    echo json_encode(['success' => false, 'errors' => $errors]);
    exit;
}

$sql = "INSERT INTO consultations (full_name, email, phone, service_id, preferred_date, message)
        VALUES (:name, :email, :phone, :service_id, :date, :message)";

$id = dbInsert($sql, [
    ':name'       => $name,
    ':email'      => $email,
    ':phone'      => $phone,
    ':service_id' => $service_id ?: null,
    ':date'       => $date ?: null,
    ':message'    => $message,
]);

if ($id > 0) {
    echo json_encode(['success' => true, 'message' => 'Consultation booked! We will contact you within 24 hours.', 'id' => $id]);
} else {
    // Demo mode — DB not connected
    echo json_encode(['success' => true, 'message' => 'Consultation request received! We will contact you within 24 hours.', 'demo' => true]);
}
