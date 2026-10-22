# Hệ Thống Triển Khai & Quản Trị Website Portfolio

Đề tài 13 - Môn: Triển khai và Quản trị Hệ thống Phần mềm

## Kiến trúc hệ thống
- **Web App**: PHP 8.2 Apache
- **Database**: MySQL 8.0 & phpMyAdmin
- **Reverse Proxy**: Nginx (Hỗ trợ HTTPS SSL tự ký & Security Headers)
- **Monitoring**: Prometheus + Grafana (Commit 2 - Hoàn thành)
- **Logging**: Loki + Promtail + LogQL (Commit 3 - Hoàn thành)
- **Hardening**: Network Isolation, Environment Variables, Least Privilege

## Hướng dẫn cài đặt & khởi chạy
```bash
docker-compose up -d
```
