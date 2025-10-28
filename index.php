<?php
include 'db.php';

$result = $conn->query("SELECT * FROM users ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD DEMO</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background: #007bff; color: white; }
        form { margin-bottom: 20px; }
        input[type=text], input[type=email] {
            padding: 8px;
            width: 200px;
            margin-right: 10px;
        }
        button {
            padding: 8px 12px;
            background: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover { background: #0056b3; }
        .msg { padding: 10px; margin-bottom: 10px; border-radius: 5px; }
        .success { background: #d4edda; color: #155724; }
        .error { background: #f8d7da; color: #721c24; }
        .empty { background: #fff3cd; color: #856404; }
    </style>
</head>
<body>
<h2>CREATE USER</h2>
<?php
if(isset($_GET['msg'])) {
    if($_GET['msg'] === 'success') echo "<div class='msg success'>✅ Thêm người dùng thành công!</div>";
    if($_GET['msg'] === 'error') echo "<div class='msg error'>❌ Lỗi khi thêm người dùng!</div>";
    if ($_GET['msg'] === 'empty')   echo "<div class='msg empty'>⚠️ Vui lòng nhập đầy đủ thông tin!</div>";
}
?>
<form method="POST" action="create.php">
<input type="text" name="name" placeholder="Nhập tên" required>
<input type="email" name="email" placeholder="Nhập email" required>
<button type="submit">Thêm</button>
</form>
<h2>📋 Danh sách người dùng</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Tên</th>
        <th>Email</th>
        <th>Ngày tạo</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= htmlspecialchars($row['name']) ?></td>
        <td><?= htmlspecialchars($row['email']) ?></td>
        <td><?= $row['created_at'] ?></td>
    </tr>
    <?php endwhile; ?>
</table>
</body>
</html>
