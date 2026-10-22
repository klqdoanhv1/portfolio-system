<?php
$host = 'db';$user = getenv('MYSQL_USER') ?: 'portfolio_user';
$pass = getenv('MYSQL_PASSWORD') ?: 'UserSecretPass123!';$db   = getenv('MYSQL_DATABASE') ?: 'portfolio_db';

$conn = new mysqli($host, $user,$pass, $db);$db_status = "Connected successfully to Database ($db)";
if ($conn->connect_error) {$db_status = "Connection failed: " . $conn->connect_error;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio - K23C System Admin</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; background: #0f172a; color: #f8fafc; margin: 0; padding: 2rem; }
        .container { max-width: 800px; margin: 0 auto; background: #1e293b; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
        h1 { color: #38bdf8; margin-bottom: 0.5rem; }
        .badge { display: inline-block; padding: 0.25rem 0.75rem; border-radius: 9999px; background: #0284c7; color: white; font-size: 0.875rem; margin-bottom: 1rem; }
        .status { padding: 1rem; border-radius: 8px; background: #334155; margin-top: 1.5rem; border-left: 4px solid #10b981; }
    </style>
</head>
<body>
    <div class="container">
        <span class="badge">Đề tài 13 - Portfolio & Quản trị Hệ thống</span>
        <h1>Website Portfolio Cá Nhân</h1>
        <p>Chào mừng đến với trang Portfolio cá nhân được triển khai trên môi trường Docker Containers tự động hoá, tích hợp Nginx Reverse Proxy, Prometheus, Grafana và Loki.</p>
        
        <div class="status">
            <strong>Trạng thái Cơ sở dữ liệu:</strong> <?php echo htmlspecialchars($db_status); ?>
        </div>
    </div>
</body>
</html>
