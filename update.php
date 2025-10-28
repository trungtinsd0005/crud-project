<?php
include 'db.php';

if(isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "Khong tim thay nguoi dung!";
        exit;
    }

}

if(isset($_POST["update"])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];

    $stmt = $conn->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
    $stmt->bind_param("ssi", $name, $email, $id);
    if($stmt->execute()) {
        header("Location: index.php?msg=updated");
        exit;
    } else {
        header("Location: index.php?msg=update_error");
        echo('Update failed' . $stmt->error);
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Cập nhật người dùng</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 50px auto;
            width: 400px;
            background-color: #f7f9fb;
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 20px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }
        input[type="text"], input[type="email"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            margin-top: 15px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background-color: #0056b3;
        }
        a {
            text-decoration: none;
            display: block;
            margin-top: 15px;
            text-align: center;
            color: #333;
        }
        .error {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>
    <h2>📝 Cập nhật người dùng</h2>

    <?php if (isset($error)): ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>

    <form method="POST" action="update.php">
        <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']) ?>">

        <label>Tên người dùng:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>

        <label>Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

        <button type="submit" name="update">Cập nhật</button>
    </form>

    <a href="index.php">← Quay lại danh sách</a>
</body>
</html>