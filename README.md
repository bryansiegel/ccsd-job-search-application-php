# CCSD Job Search Portal

A PHP-based job search and management portal for CCSD (Clark County School District) with CRUD functionality for job postings.

## System Requirements

- **PHP**: 7.4 or higher
- **Composer**: 2.0+ for dependency management
- **Web Server**: Apache or Nginx
- **Database**: MySQL 5.7+ or MariaDB 10.2+
- **PHP Extensions**:
    - PDO
    - PDO MySQL
    - Fileinfo (for file uploads)
    - JSON
- **File Permissions**: Write access to upload directories

## Installation

### 1. Install Dependencies

The application uses Composer for dependency management. Install Composer if not already available:

```bash
# Install Composer globally (recommended)
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer

# OR download locally to project directory
curl -sS https://getcomposer.org/installer | php
```

Install project dependencies:

```bash
# With global Composer
composer install

# OR with local composer.phar
php composer.phar install

# For production (skip dev dependencies)
composer install --no-dev --optimize-autoloader
```

### 2. Database Setup

Create a MySQL database and import from _mysql_dumps (ccsd_jobs_php.sql):
- `administration_jobs`
- `licensed_jobs`
- `support_jobs`

### 3. Database Configuration

Edit `.env` with your database credentials:

```env
DB_HOST=localhost
DB_NAME=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 4. File Structure

Ensure the following directory structure exists with proper permissions:

```
ccsd-job-search/
├── admin/
├── employees/
│   └── resources/
│       └── pdf/
│           └── desc/
│               ├── ap/               # Administration job files
│               ├── lp/               # Licensed job files
│               └── support-staff/    # Support job files
├── img/
├── includes/
├── job-creation-sop.php
└── styles.css
```

**Note**: The file storage uses the organized `employees/resources/pdf/desc/` structure with separate subdirectories for each job type (ap/, lp/, support-staff/).

### 5. File Permissions

Set proper permissions for file uploads:

```bash
chmod 755 employees/resources/pdf/desc/
chmod 755 employees/resources/pdf/desc/ap/
chmod 755 employees/resources/pdf/desc/lp/
chmod 755 employees/resources/pdf/desc/support-staff/
```

Or ensure your web server user (usually `www-data`) has write access:

```bash
chown -R www-data:www-data employees/
```

### 6. Web Server Configuration

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

### Job Creation Guide
- **URL**: `http://yourserver/ccsd-job-search/job-creation-sop.php`
- **Features**: Step-by-step Standard Operating Procedure for creating jobs
- **Access**: Available from both public and admin interfaces via navigation links

## Troubleshooting

### File Upload Issues
- Check directory permissions on `employees/resources/pdf/desc/` folder
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
chown -R www-data:www-data /path/to/ccsd-job-search/employees/
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
- **User Documentation**: Built-in Standard Operating Procedure (SOP) for job creation
- **Comprehensive Testing**: PHPUnit test suite with 90+ tests
- **Quality Assurance**: Automated testing for all functionality

## Technical Architecture

- **Frontend**: HTML5, CSS3, JavaScript
- **Backend**: PHP 7.4+ with PDO
- **Database**: MySQL with normalized job tables
- **Components**: Modular PHP include system
- **File Storage**: Organized filesystem with updated structure
- **Dependency Management**: Composer for PHP packages
- **Testing**: PHPUnit 9.6+ with comprehensive test coverage
- **Quality Control**: Automated testing pipeline

## Dependencies

### Production Dependencies
The application has minimal production dependencies for optimal performance:

```json
{
    "require": {
        "php": ">=7.4",
        "ext-pdo": "*",
        "ext-json": "*",
        "ext-fileinfo": "*"
    }
}
```

### Development Dependencies
Development and testing tools:

```json
{
    "require-dev": {
        "phpunit/phpunit": "^9.5"
    }
}
```

### Composer Commands
```bash
# Install all dependencies (development + production)
composer install

# Install production dependencies only
composer install --no-dev

# Update dependencies
composer update

# Check for security vulnerabilities
composer audit

# Optimize autoloader for production
composer dump-autoload --optimize
```

## Documentation

For detailed technical information, system architecture, and development guidelines, see the [Technical Documentation](technical-documentation.md).

The technical documentation includes:
- Detailed system architecture
- Component structure and relationships
- Database schema and relationships
- File management system
- API endpoints and functionality
- Development workflows
- Comprehensive testing procedures
- User guides and standard operating procedures

### User Documentation
- **Job Creation SOP**: [job-creation-sop.php](job-creation-sop.php) - Step-by-step guide for creating jobs in the admin interface

## Testing

This application includes a comprehensive PHPUnit test suite with 90+ tests covering:

### Test Categories
- **Unit Tests**: JobModel CRUD, Search, Filters, File Upload
- **Integration Tests**: Admin endpoints and complete workflows

### Running Tests
```bash
# Install dependencies
composer install

# Run all tests
./run-tests.sh

# Run with coverage report
./run-tests.sh --coverage

# Run specific test suites
./run-tests.sh --unit              # Unit tests only
./run-tests.sh --integration       # Integration tests only
```

### Test Files
- `tests/Unit/JobModelTest.php` - CRUD operations testing
- `tests/Unit/SearchFunctionalityTest.php` - Search system testing
- `tests/Unit/FilterFunctionalityTest.php` - Filter system testing
- `tests/Unit/FileUploadTest.php` - File upload testing
- `tests/Integration/AdminEndpointTest.php` - Endpoint testing

### Prerequisites for Testing
- PHPUnit 9.6+
- Test database: `ccsd_jobs_test`
- PHP 7.4+ with required extensions

See [tests/README.md](tests/README.md) for detailed testing documentation.