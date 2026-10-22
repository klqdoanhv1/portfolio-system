<?php
session_start();
$host = 'db';
$user = getenv('MYSQL_USER') ?: 'portfolio_user';
$pass = getenv('MYSQL_PASSWORD') ?: 'UserSecretPass123!';
$db   = getenv('MYSQL_DATABASE') ?: 'portfolio_db';
$conn = new mysqli($host, $user, $pass, $db);

// Xử lý Đăng xuất
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    unset($_SESSION['admin_logged']);
    header('Location: /admin.php');
    exit;
}

// Xử lý Đăng nhập (Mật khẩu: admin123)
$login_err = '';
if (isset($_POST['login'])) {
    if ($_POST['username'] === 'admin' && $_POST['password'] === 'admin123') {
        $_SESSION['admin_logged'] = true;
    } else {
        $login_err = 'Sai tài khoản hoặc mật khẩu quản trị!';
    }
}

// Xử lý Thêm dự án (Create)
if (isset($_POST['add_project']) && !empty($_SESSION['admin_logged'])) {
    $title = $conn->real_escape_string($_POST['title']);
    $desc = $conn->real_escape_string($_POST['description']);
    if (!empty($title) && !empty($desc)) {
        $conn->query("INSERT INTO projects (title, description) VALUES ('$title', '$desc')");
    }
    header('Location: /admin.php');
    exit;
}

// Xử lý Xóa dự án (Delete)
if (isset($_GET['delete']) && !empty($_SESSION['admin_logged'])) {
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM projects WHERE id = $id");
    header('Location: /admin.php');
    exit;
}

$projects = [];
if (!empty($_SESSION['admin_logged']) && !$conn->connect_error) {
    $res = $conn->query("SELECT * FROM projects ORDER BY id DESC");
    if ($res) {
        while ($row = $res->fetch_assoc()) $projects[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Admin Portal - Quản Trị Portfolio</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; background: #0b1329; color: #f8fafc; margin: 0; padding: 2rem; }
        .container { max-width: 850px; margin: 0 auto; background: #1e293b; padding: 2rem; border-radius: 12px; }
        h1, h2 { color: #38bdf8; }
        input, textarea { width: 100%; padding: 0.7rem; margin-top: 0.3rem; margin-bottom: 1rem; border-radius: 6px; border: 1px solid #475569; background: #0f172a; color: white; box-sizing: border-box; }
        button { background: #10b981; color: white; border: none; padding: 0.7rem 1.5rem; border-radius: 6px; cursor: pointer; font-weight: bold; }
        button:hover { background: #059669; }
        .btn-delete { background: #ef4444; color: white; padding: 0.3rem 0.6rem; border-radius: 4px; text-decoration: none; font-size: 0.85rem; }
        .item { display: flex; justify-content: space-between; align-items: center; background: #0f172a; padding: 1rem; border-radius: 6px; margin-bottom: 0.8rem; border: 1px solid #334155; }
        .nav { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; }
    </style>
</head>
<body>
<div class="container">
    <?php if (empty($_SESSION['admin_logged'])): ?>
        <h2>Đăng Nhập Quản Trị Viên</h2>
        <?php if ($login_err): ?><p style="color: #ef4444;"><?php echo $login_err; ?></p><?php endif; ?>
        <form method="POST">
            <label>Tài khoản:</label>
            <input type="text" name="username" required placeholder="admin">
            <label>Mật khẩu:</label>
            <input type="password" name="password" required placeholder="admin123">
            <button type="submit" name="login">Đăng Nhập</button>
            <a href="/" style="color: #94a3b8; margin-left: 1rem; text-decoration: none;">&larr; Về trang chủ</a>
        </form>
    <?php else: ?>
        <div class="nav">
            <h2>Bảng Điều Khiển Quản Trị (CRUD Content)</h2>
            <div>
                <a href="/" style="color: #38bdf8; margin-right: 1rem; text-decoration: none;">Xem Website</a>
                <a href="/admin.php?action=logout" style="color: #ef4444; text-decoration: none;">Đăng Xuất</a>
            </div>
        </div>

        <form method="POST" style="background: #0f172a; padding: 1.5rem; border-radius: 8px; margin-bottom: 2rem;">
            <h3 style="margin-top: 0; color: #f59e0b;">Thêm Dự Án Mới</h3>
            <label>Tên dự án:</label>
            <input type="text" name="title" required placeholder="Nhập tên dự án...">
            <label>Mô tả chi tiết:</label>
            <textarea name="description" rows="3" required placeholder="Nhập công nghệ, tính năng dự án..."></textarea>
            <button type="submit" name="add_project">+ Thêm Dự Án</button>
        </form>

        <h3>Danh Sách Dự Án Đang Hiển Thị</h3>
        <?php foreach ($projects as $p): ?>
            <div class="item">
                <div>
                    <strong style="color: #38bdf8; font-size: 1.1rem;"><?php echo htmlspecialchars($p['title']); ?></strong>
                    <div style="color: #94a3b8; font-size: 0.9rem; margin-top: 0.3rem;"><?php echo htmlspecialchars($p['description']); ?></div>
                </div>
                <a href="/admin.php?delete=<?php echo $p['id']; ?>" class="btn-delete" onclick="return confirm('Bạn có chắc muốn xóa dự án này?')">Xóa</a>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
</body>
</html>
