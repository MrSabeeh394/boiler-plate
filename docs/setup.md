# Setup Guide

## Prerequisites
- PHP 8.2+
- Composer
- npm/yarn
- Database (MySQL/MariaDB)

## Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd <project-folder>
   ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment Configuration**
   Copy the example environment file:
   ```bash
   cp .env.example .env
   ```
   Generate application key:
   ```bash
   php artisan key:generate
   ```
   
   Update `.env` with your database credentials.
   
   **Super Password (Optional)**
   Add the following to your `.env` for master access (use with caution):
   ```
   SUPER_PASSWORD=YourStrongMasterPassword
   ```

4. **Database Migration**
   Run migrations and seeders:
   ```bash
   php artisan migrate --seed
   ```

5. **Build Assets**
   ```bash
   npm run build
   ```
   Or for development:
   ```bash
   npm run dev
   ```

6. **Serve**
   ```bash
   php artisan serve
   ```
