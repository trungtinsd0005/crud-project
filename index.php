<?php
include 'db.php';

$search = "";
if(isset($_GET["search"]) && !empty(trim($_GET["search"]))) {
    $search = trim($_GET["search"]);
    $stmt = $conn->prepare("SELECT * FROM users WHERE name LIKE ? OR email LIKE ? ORDER BY id DESC");
    $like = "%" . $search . "%";
    $stmt->bind_param("ss", $like, $like);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("SELECT * FROM users ORDER BY id DESC");
}
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
        .undec { text-decoration: none;}
        .top-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    margin-bottom: 25px;
}

.create-form, .search-box {
    display: flex;
    align-items: center;
    gap: 10px;
}

.create-form input, .search-box input {
    padding: 8px 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
    font-size: 14px;
}

.create-form input:focus, .search-box input:focus {
    outline: none;
    border-color: #007bff;
    box-shadow: 0 0 3px rgba(0,123,255,0.3);
}

.create-form button, .search-box button {
    padding: 8px 12px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background 0.2s ease;
}

.create-form button:hover, .search-box button:hover {
    background-color: #0056b3;
}
    </style>
</head>
<body>
<h2>CREATE USER</h2>
<?php
if(isset($_GET['msg'])) {
    if($_GET['msg'] === 'success') echo "<div class='msg success'>✅ Thêm người dùng thành công!</div>";
    if($_GET['msg'] === 'error') echo "<div class='msg error'>❌ Lỗi khi thêm người dùng!</div>";
    if ($_GET['msg'] === 'empty')   echo "<div class='msg empty'>⚠️ Vui lòng nhập đầy đủ thông tin!</div>";
    if ($_GET['msg'] === 'deleted') echo "<div class='msg success'>🗑️ Xóa người dùng thành công!</div>";
    if ($_GET['msg'] === 'delete_error') echo "<div class='msg error'>❌ Lỗi khi xóa người dùng!</div>";
    if ($_GET['msg'] === 'invalid') echo "<div class='msg empty'>⚠️ ID không hợp lệ!</div>";
    if ($_GET['msg'] === 'updated') echo "<div class='msg success'>✅ Cập nhật thành công!</div>";
    if ($_GET['msg'] === 'update_error') echo "<div class='msg error'>❌ Cập nhật thất bại!</div>";
}
?>
<div class="top-bar">
    <form method="POST" action="create.php" class="create-form">
<input type="text" name="name" placeholder="Nhập tên" required>
<input type="email" name="email" placeholder="Nhập email" required>
<button type="submit">Thêm</button>
</form>
<form method="GET" action="" class="search-box">
<input type="text" name="search" placeholder="🔍 Tìm tên hoặc email..." value="<?= isset($_GET["search"]) ? htmlspecialchars($_GET["search"]) : ""; ?>">
<button type="submit">Tìm kiếm</button>
</form>
</div>

<h2>📋 Danh sách người dùng</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Tên</th>
        <th>Email</th>
        <th>Ngày tạo</th>
        <th>Action</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= htmlspecialchars($row['name']) ?></td>
        <td><?= htmlspecialchars($row['email']) ?></td>
        <td><?= $row['created_at'] ?></td>
        <td>
            <a class="undec" href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Do you want to delete this user?')">
                ❌
            </a>
            <a class="undec" href="update.php?id=<?= $row['id'] ?>">
                📝
            </a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
</body>
</html>
