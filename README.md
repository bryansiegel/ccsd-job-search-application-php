# CCSD Job Search Portal

A PHP-based job search and management portal for CCSD (Clark County School District) with CRUD functionality for job postings.

## System Requirements

- **PHP**: 7.4 or higher
- **Web Server**: Apache or Nginx
- **Database**: MySQL 5.7+ or MariaDB 10.2+
- **PHP Extensions**:
  - PDO
  - PDO MySQL
  - Fileinfo (for file uploads)
  - JSON
- **File Permissions**: Write access to `files/` directory

## Installation

### 1. Database Setup

Create a MySQL database and import from _mysql_dumps (ccsd_jobs_php.sql):
- `administration_jobs`
- `licensed_jobs` 
- `support_jobs`

### 2. Database Configuration

Edit `.env` with your database credentials:

```php
$host = 'localhost';
$dbname = 'your_database_name';
$username = 'your_username';
$password = 'your_password';
```

### 3. File Structure

Ensure the following directory structure exists with proper permissions:

```
ccsd-job-search/
├── admin/
├── files/
│   ├── administration/
│   ├── licensed/
│   └── support/
├── img/
├── includes/
└── styles.css
```

### 4. File Permissions

Set proper permissions for file uploads:

```bash
chmod 755 files/
chmod 755 files/administration/
chmod 755 files/licensed/
chmod 755 files/support/
```

Or ensure your web server user (usually `www-data`) has write access:

```bash
chown -R www-data:www-data files/
```

### 5. Web Server Configuration

Place the application in your web server's document root or a subdirectory.

**Apache**: Ensure `.htaccess` support is enabled if needed.

**Nginx**: Configure to serve PHP files through PHP-FPM.

## Database Schema Requirements

### Administration Jobs Table
```sql
CREATE TABLE administration_jobs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    grade VARCHAR(50),
    ccode VARCHAR(50),
    division VARCHAR(255),
    description TEXT,
    filename VARCHAR(255)
);
```

### Licensed Jobs Table
```sql
CREATE TABLE licensed_jobs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    job_id VARCHAR(50),
    category VARCHAR(255),
    division VARCHAR(255),
    certification_type VARCHAR(255),
    active TINYINT(1) DEFAULT 1,
    salary_code VARCHAR(50),
    filename VARCHAR(255)
);
```

### Support Jobs Table
```sql
CREATE TABLE support_jobs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    grade VARCHAR(50),
    job_code VARCHAR(50),
    department_code VARCHAR(50),
    union_code VARCHAR(50),
    filename VARCHAR(255)
);
```

## Configuration

### Application Settings

Modify `includes/config/app-config.php` if needed:

- `APP_NAME`: Application title
- `MAX_FILE_SIZE`: Maximum upload file size (default: 10MB)
- `ALLOWED_FILE_TYPES`: Permitted file extensions

### File Upload Settings

The application accepts:
- **File Types**: PDF, DOC, DOCX
- **Max Size**: 10MB
- **Naming**: Files are renamed using job codes

## Usage

### Public Interface
- **URL**: `http://yourserver/ccsd-job-search/`
- **Features**: Browse and search jobs, filter by type/grade/division

### Admin Interface
- **URL**: `http://yourserver/ccsd-job-search/admin/`
- **Features**: Create, edit, delete jobs, file management

## Troubleshooting

### File Upload Issues
- Check directory permissions on `files/` folder
- Verify PHP `upload_max_filesize` and `post_max_size` settings
- Ensure `file_uploads = On` in PHP configuration

### Database Connection Issues
- Verify credentials in `mysql-connect.php`
- Check MySQL service is running
- Confirm database and tables exist

### Permission Errors
```bash
# Fix file permissions
chmod -R 755 /path/to/ccsd-job-search/
chown -R www-data:www-data /path/to/ccsd-job-search/files/
```

### PHP Errors
- Enable error reporting for debugging:
  ```php
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  ```

## Features

- **Job Search**: Full-text search across all job fields
- **Advanced Filtering**: Filter by job type, grade, code, division
- **CRUD Operations**: Create, read, update, delete jobs
- **File Management**: Upload and manage job description files
- **Responsive Design**: Mobile-friendly interface
- **Tabbed Interface**: Organized job type display
- **Admin Panel**: Complete job management system

## Technical Architecture

- **Frontend**: HTML5, CSS3, JavaScript
- **Backend**: PHP 7.4+ with PDO
- **Database**: MySQL with normalized job tables
- **Components**: Modular PHP include system
- **File Storage**: Local filesystem organization
