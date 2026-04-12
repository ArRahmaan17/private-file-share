# 🚀 FileStream

**FileStream** is a high-performance, secure, and visually stunning file-sharing application designed for ephemeral storage and speed. Built with a premium "Glassmorphism" aesthetic and optimized for production deployment via Docker.

![Premium UI](https://img.shields.io/badge/Design-Glassmorphism-blueviolet)
![Status](https://img.shields.io/badge/Status-Production--Ready-success)
![PHP](https://img.shields.io/badge/PHP-8.4-777bb4)
![Laravel](https://img.shields.io/badge/Laravel-11-ff2d20)

---

## ✨ Key Features

### 🛡️ Secure Sharing
-   **Password Protection**: Add end-to-end optional passwords to any file.
-   **Self-Destruct Mode**: Files can be set to automatically delete themselves immediately after the first successful download.
-   **Link Expiry**: All links expire automatically after 24 hours (configurable).

### ⚡ Advanced Upload System
-   **1MB Chunked Uploads**: Supports large file transfers (up to 110MB) by splitting files into sequential chunks—improving reliability on unstable networks.
-   **Real-time Progress**: High-fidelity progress bars showing overall upload state from 0% to 100%.
-   **Manual Control**: Explicit "Upload" button flow to prevent accidental selections.

### 🎨 Premium User Experience
-   **Glassmorphism aesthetic**: Modern "Frosted Glass" UI with ambient atmospheric backgrounds and smooth micro-animations.
-   **No Frame Bloat**: Built using high-performance Vanilla CSS and minimal JavaScript dependencies.
-   **Fully Responsive**: Seamless experience across mobile, tablet, and desktop devices.

### 📊 Administrative Dashboard
-   **Live Metrics**: Real-time monitoring of disk usage, total file count, and storage availability.
-   **Health Indicators**: Color-coded status dots (Live/Warn/Danger) based on file expiration proximity.
-   **Inline Management**: Quickly copy links, delete files, or adjust expiration dates directly from the table.

---

## 🛠️ Technology Stack
-   **Backend**: Laravel 11 (PHP 8.4-FPM Alpine)
-   **Web Server**: Nginx (Alpine)
-   **Database**: SQLite (default, optimized for container portability)
-   **Frontend**: Vanilla CSS, Blade Templates, Raw XHR for chunking logic.

---

## 🚀 Quick Start (Docker)

Ensure you have [Docker](https://www.docker.com/) and [Docker Compose](https://docs.docker.com/compose/) installed.

1.  **Clone the repository**:
    ```bash
    git clone <your-repo-url>
    cd file-share
    ```

2.  **Configure Environment**:
    Edit the `.env` file (or create one):
    ```env
    APP_NAME=FileStream
    APP_ENV=production
    ADMIN_USERNAME=admin
    ADMIN_PASSWORD=your_secure_password
    ```

3.  **Launch**:
    ```bash
    docker compose up -d --build
    ```

4.  **Access**:
    -   **Homepage**: `http://localhost`
    -   **Admin Panel**: `http://localhost/admin`

---

## ⚙️ Configuration

### Upload Limits
The default limit is set to **110MB**. To increase this:
1. Update `post_max_size` and `upload_max_filesize` in `./build/app/php.ini`.
2. Update the frontend limit in `resources/views/welcome.blade.php`.
3. Update the backend validation in `FileController.php`.

### Storage Cleanup
The application includes a disk-safety check that prevents uploads if storage is `< 10%` free. Files are automatically cleaned up when they expire.

---

## 📜 License
Privately developed for performance and privacy.
