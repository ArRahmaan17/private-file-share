# 🚀 FileStream

**FileStream** is a high-performance, secure, and visually stunning file-sharing application designed for ephemeral storage and speed. Built with a premium "Glassmorphism" aesthetic and optimized for production deployment via Docker.

![Premium UI](https://img.shields.io/badge/Design-Glassmorphism-blueviolet)
![Status](https://img.shields.io/badge/Status-Production--Ready-success)
![PHP](https://img.shields.io/badge/PHP-8.3+-777bb4)
![Laravel](https://img.shields.io/badge/Laravel-13-ff2d20)

---

## ✨ Key Features

### 🛡️ Secure Sharing
-   **Password Protection**: Add end-to-end optional passwords to any file.
-   **Self-Destruct Mode**: Files can be set to automatically delete themselves immediately after the first successful download.
-   **Link Expiry**: All links expire automatically after **1 hour** to maintain privacy and system health.

### ⚡ Advanced Upload System
-   **1MB Chunked Uploads**: Supports large file transfers (up to 1GB) by splitting files into sequential chunks—improving reliability on unstable networks.
-   **Real-time Progress**: High-fidelity progress bars showing overall upload state from 0% to 100%.
-   **System Quota**: Hard cap on total storage (default **5GB**) to protect the host environment.

### 🎨 Premium User Experience
-   **Glassmorphism aesthetic**: Modern "Frosted Glass" UI with ambient atmospheric backgrounds and smooth micro-animations.
-   **Recent Local Links**: The homepage keeps a browser-local list of recent generated share links for up to **1 hour**, including refresh recovery for the latest uploaded file on the same device.
-   **Rich Meta Tags**: Full Open Graph (OG) and Twitter card support for beautiful link previews.
-   **High Performance**: Minimal JavaScript, optimized CSS, and Blade X-Components for a modular architecture.

### 📊 Administrative Dashboard
-   **Live Metrics**: Real-time monitoring of disk usage, total file count, and storage availability.
-   **Health Indicators**: Color-coded status dots (Live/Warn/Danger) based on file expiration proximity.
-   **Inline Management**: Quickly copy links, delete files, or adjust expiration dates directly from the table.

---

## 🛠️ Technology Stack
-   **Backend**: Laravel 13 (PHP 8.3-FPM Alpine)
-   **Web Server**: Nginx (Alpine)
-   **Database**: SQLite (default, optimized for container portability)
-   **Resource Managed**: Hardened with Docker `deploy.resources` limits (CPU/RAM).

---

## 🚀 Quick Start (Docker)

Ensure you have [Docker](https://www.docker.com/) and [Docker Compose](https://docs.docker.com/compose/) installed.

1.  **Clone the repository**:
    ```bash
    git clone <your-repo-url>
    cd file-share
    ```

2.  **Configure Environment**:
    Edit the `applications/.env` file:
    ```env
    APP_NAME=FileStream
    APP_ENV=production
    ADMIN_PASSWORD=your_secure_password
    TOTAL_STORAGE_LIMIT_GB=5
    ```

3.  **Launch**:
    ```bash
    docker compose up -d --build
    ```

4.  **Access**:
    -   **Homepage**: `http://localhost`
    -   **Admin Panel**: `http://localhost/admin` (Password protected)

---

## ⚙️ Configuration

### Resource Limits (Docker)
The `app` container is limited to **0.5 CPU** and **512MB RAM** by default. Adjust these in `docker-compose.yml` if needed.

### Storage Quota
The application enforces a global storage limit defined by `TOTAL_STORAGE_LIMIT_GB` in your `.env`. Exceeding this will return a `507 Insufficient Storage` error to users.

### Upload Limits
Single-file uploads are capped at **1GB** in application logic. The browser uploads files in **1MB chunks**, so the bundled PHP/Nginx request-size limits only need to be large enough for each chunk plus multipart overhead.

### Browser Storage
The homepage stores recent generated download links in browser `localStorage` for up to **1 hour** on the same device. The latest link is restored after refresh, and the recent-links list can be cleared directly from the homepage.

---

## 📜 License
Privately developed for performance and privacy.
