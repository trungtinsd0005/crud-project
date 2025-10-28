<?php
include 'db.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';

    if(!empty($name) && !empty($email)) {
        $stmt = $conn->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $email);

        if($stmt->execute()) {
            header("Location: index.php?msg=success");
            exit;
        } else {
            header("Location: index.php?msg=error");
            exit;
        }
    } else {
        header("Location: index.php?msg=empty");
        exit;
    }
}
?>