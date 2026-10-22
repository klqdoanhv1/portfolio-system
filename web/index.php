<?php
$host = 'db';
$user = getenv('MYSQL_USER') ?: 'portfolio_user';
$pass = getenv('MYSQL_PASSWORD') ?: 'UserSecretPass123!';
$db   = getenv('MYSQL_DATABASE') ?: 'portfolio_db';

$conn = new mysqli($host, $user, $pass, $db);
$db_status = "Connected successfully to Database ($db)";
$projects = [];

if ($conn->connect_error) {
    $db_status = "Connection failed: " . $conn->connect_error;
} else {
    $res = $conn->query("SELECT * FROM projects ORDER BY id DESC");
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $projects[] = $row;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio - Lã Quý Doanh DTC245180141</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; background: #0f172a; color: #f8fafc; margin: 0; padding: 2rem; }
        .container { max-width: 900px; margin: 0 auto; background: #1e293b; padding: 2.5rem; border-radius: 12px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.3); }
        .header { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #334155; padding-bottom: 1rem; margin-bottom: 1.5rem; }
        h1 { color: #38bdf8; margin: 0; }
        .badge { display: inline-block; padding: 0.35rem 0.8rem; border-radius: 9999px; background: #0284c7; color: white; font-size: 0.85rem; }
        .status { padding: 1rem; border-radius: 8px; background: #334155; margin-bottom: 2rem; border-left: 4px solid #10b981; }
        .btn-admin { background: #38bdf8; color: #0f172a; padding: 0.6rem 1.2rem; border-radius: 6px; text-decoration: none; font-weight: bold; }
        .project-card { background: #0f172a; padding: 1.2rem; border-radius: 8px; margin-bottom: 1rem; border: 1px solid #334155; }
        .project-title { color: #f59e0b; font-size: 1.2rem; font-weight: bold; margin-bottom: 0.5rem; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div>
                <span class="badge">Đề tài 13 - Portfolio & Quản trị Hệ thống</span>
                <h1>Lã Quý Doanh - Software Engineer</h1>
                <p style="color: #94a3b8; margin: 0.3rem 0 0 0;">MSSV: DTC245180141 | Lớp: K23C</p>
            </div>
            <a href="/admin.php" class="btn-admin">Vào Trang Quản Trị &rarr;</a>
        </div>

        <div class="status">
            <strong>Trạng thái Cơ sở dữ liệu:</strong> <?php echo htmlspecialchars($db_status); ?>
        </div>

        <h2 style="color: #e2e8f0;">Dự án Nổi bật (Dynamic DB Content)</h2>
        <?php if (empty($projects)): ?>
            <p style="color: #94a3b8;">Chưa có dự án nào được thêm.</p>
        <?php else: ?>
            <?php foreach ($projects as $p): ?>
                <div class="project-card">
                    <div class="project-title"><?php echo htmlspecialchars($p['title']); ?></div>
                    <div style="color: #cbd5e1;"><?php echo nl2br(htmlspecialchars($p['description'])); ?></div>
                    <small style="color: #64748b; display: block; margin-top: 0.5rem;">Khởi tạo lúc: <?php echo $p['created_at']; ?></small>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>
