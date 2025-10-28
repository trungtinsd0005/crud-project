<?php
include 'db.php';
if(isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);

    if($stmt->execute()) {
        header("Location: index.php?msg=deleted");
        exit;
    } else {
        header("Location: index.php?msg=delete_error");
        exit;
    }
}
else {
    header("Location: index.php?msg=invalid");
    exit;
}
?>