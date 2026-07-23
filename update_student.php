<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id        = (int) $_POST['id'];
    $reg_no    = trim($_POST['reg_no']);
    $full_name = trim($_POST['full_name']);
    $course    = trim($_POST['course']);
    $gender    = trim($_POST['gender']);
    $email     = trim($_POST['email']);

    if (empty($reg_no) || empty($full_name) || empty($course) || empty($gender) || empty($email)) {
        header("Location: edit_student.php?id=$id");
        exit();
    }

    $stmt = $conn->prepare("UPDATE students SET reg_no = ?, full_name = ?, course = ?, gender = ?, email = ? WHERE id = ?");
    $stmt->bind_param("sssssi", $reg_no, $full_name, $course, $gender, $email, $id);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    header("Location: view_students.php?updated=1");
    exit();

} else {
    header("Location: view_students.php");
    exit();
}
