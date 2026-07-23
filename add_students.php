<?php
include 'db.php';

// Get form data (matches your JS 'data' object keys)
$reg_no = $_POST['regNumber'];
$full_name = $_POST['fullName'];
$course = $_POST['course'];
$gender = $_POST['gender'];
$email = $_POST['email'];

// Generate a server-side reference number (more reliable than JS-generated one)
$year = date("Y");
$rand = rand(1000, 9999);
$reference = "TUK-$year-$rand";

$sql = "INSERT INTO students (reg_no, full_name, course, gender, email) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    header('Content-Type: application/json');
    echo json_encode(["success" => false, "message" => "Prepare failed: " . $conn->error]);
    exit;
}

$stmt->bind_param("sssss", $reg_no, $full_name, $course, $gender, $email);

header('Content-Type: application/json');

if ($stmt->execute()) {
    echo json_encode([
        "success" => true,
        "reference" => $reference,
        "regNumber" => $reg_no,
        "fullName" => $full_name,
        "course" => $course,
        "gender" => $gender,
        "email" => $email
    ]);
} else {
    echo json_encode(["success" => false, "message" => "Error: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>