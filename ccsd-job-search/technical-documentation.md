# CCSD Job Search Portal - Technical Documentation

## Overview
The CCSD Job Search Portal is a PHP-based web application designed for Clark County School District (CCSD) to manage and display job postings across three categories: Administration, Licensed, and Support positions. The system provides both public job search functionality and administrative management capabilities.

## System Architecture

### Technology Stack
- **Backend**: PHP 7.4+ with PDO for database operations
- **Database**: MySQL 5.7+ / MariaDB 10.2+
- **Frontend**: HTML5, CSS3, JavaScript (vanilla)
- **Web Server**: Apache/Nginx compatible
- **File Storage**: Local filesystem with organized directory structure

### Design Patterns
- **MVC-inspired**: Separation of concerns with models, views, and controllers
- **Component-based**: Reusable UI components in `includes/components/`
- **Configuration-driven**: Centralized settings in `includes/config/`

## Project Structure

```
ccsd-job-search/
├── index.php                 # Main application entry point
├── admin/                    # Administrative interface
│   └── index.php            # Admin panel entry point
├── includes/                 # Core application logic
│   ├── components/          # Reusable UI components
│   │   ├── admin-form.php   # Administrative form component
│   │   ├── job-card.php     # Job display card component
│   │   ├── job-tabs.php     # Tabbed job interface
│   │   ├── navigation.php   # Navigation component
│   │   ├── search-filter.php # Search and filter component
│   │   └── summary-stats.php # Statistics display component
│   ├── config/              # Configuration files
│   │   └── app-config.php   # Application configuration
│   ├── db/                  # Database layer
│   │   ├── model.php        # JobModel class (data access layer)
│   │   └── mysql-connect.php # Database connection
│   └── functions/           # Business logic functions
│       ├── file-upload.php  # File upload handling
│       └── job-processing.php # Job data processing
├── files/                   # File upload storage
│   ├── administration/      # Admin job files
│   ├── licensed/           # Licensed job files
│   └── support/            # Support job files
├── img/                    # Static images
└── styles.css              # Application styles
```

## Database Schema

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

## Core Components

### 1. JobModel Class (`includes/db/model.php`)
Central data access layer providing CRUD operations for all job types.

**Key Methods:**
- `getAllJobs()` - Retrieves all jobs from all tables
- `searchAllJobs($searchTerm)` - Full-text search across job fields
- `getFilterOptions()` - Gets unique values for filter dropdowns
- `createAdminJob($data)` / `updateAdminJob($id, $data)` / `deleteAdminJob($id)` - Admin job CRUD
- `createLicensedJob($data)` / `updateLicensedJob($id, $data)` / `deleteLicensedJob($id)` - Licensed job CRUD
- `createSupportJob($data)` / `updateSupportJob($id, $data)` / `deleteSupportJob($id)` - Support job CRUD

### 2. Database Connection (`includes/db/mysql-connect.php`)
Handles database connectivity with environment variable support.

**Features:**
- `.env` file support for configuration
- PDO with prepared statements for security
- Error handling and connection validation

### 3. Application Configuration (`includes/config/app-config.php`)
Centralized configuration management.

**Key Constants:**
- `APP_NAME` - Application title
- `MAX_FILE_SIZE` - File upload limit (10MB)
- `ALLOWED_FILE_TYPES` - Permitted file extensions (pdf, doc, docx)
- `JOB_TYPES` - Available job categories

**Configuration Arrays:**
- `$job_type_config` - Job type specific field requirements
- `$default_nav_config` - Navigation settings
- `$error_messages` - Standardized error messages

### 4. UI Components (`includes/components/`)

#### Job Card Component (`job-card.php`)
Displays individual job listings with:
- Job title and metadata
- File download links
- Responsive design

#### Search Filter Component (`search-filter.php`)
Provides search and filtering functionality:
- Text search across all job fields
- Dropdown filters for grade, code, division
- Job type filtering

#### Job Tabs Component (`job-tabs.php`)
Tabbed interface for job categories:
- Dynamic tab generation
- Job count display
- Category-specific styling

#### Navigation Component (`navigation.php`)
Application navigation with:
- Logo display
- Configurable links
- Admin/public mode support

## Security Features

### 1. Database Security
- **Prepared Statements**: All database queries use PDO prepared statements
- **Parameter Binding**: User input is safely bound to SQL parameters
- **Error Handling**: Database errors are caught and handled gracefully

### 2. File Upload Security
- **File Type Validation**: Only PDF, DOC, DOCX files allowed
- **MIME Type Checking**: Server-side MIME type validation
- **File Size Limits**: 10MB maximum file size
- **Safe File Naming**: Files renamed using job codes to prevent conflicts

### 3. Input Validation
- **HTML Escaping**: Output is escaped using `htmlspecialchars()`
- **Parameter Sanitization**: Input parameters are validated and sanitized
- **Type Checking**: Function parameters include type hints where applicable

## API Reference
There are no api's

### JobModel Methods

#### Data Retrieval
```php
// Get all jobs by type
$jobs = $jobModel->getAdminJobs();
$jobs = $jobModel->getLicensedJobs();
$jobs = $jobModel->getSupportJobs();

// Get jobs with criteria
$jobs = $jobModel->getAdminJobsByCriteria(['grade' => 'A100']);

// Search functionality
$results = $jobModel->searchAllJobs('teacher');

// Get filter options
$options = $jobModel->getFilterOptions();
```

#### CRUD Operations
```php
// Create job
$jobId = $jobModel->createAdminJob([
    'title' => 'Principal',
    'grade' => 'A100',
    'ccode' => 'PRIN',
    'division' => 'Elementary',
    'description' => 'School principal position',
    'filename' => 'principal.pdf'
]);

// Update job
$success = $jobModel->updateAdminJob($jobId, $updatedData);

// Delete job
$success = $jobModel->deleteAdminJob($jobId);
```

### Configuration Functions

```php
// Get job type configuration
$config = getJobTypeConfig('administration');

// Validate job type
$isValid = isValidJobType('licensed');

// Get file upload path
$path = getFileUploadPath('support');
```

## Environment Configuration

### Database Configuration (`.env`)
```env
DB_HOST=localhost
DB_NAME=ccsd_jobs_php
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### Required PHP Extensions
- PDO
- PDO MySQL
- Fileinfo (for file uploads)
- JSON

### File Permissions
```bash
# Set directory permissions
chmod 755 files/
chmod 755 files/administration/
chmod 755 files/licensed/
chmod 755 files/support/

# Set ownership (web server user)
chown -R www-data:www-data files/
```

## Development Guidelines

### Code Standards
- Follow PSR-12 coding standards
- Use meaningful variable and function names
- Include PHPDoc comments for all methods
- Implement proper error handling with try-catch blocks

### Database Practices
- Always use prepared statements
- Implement transaction management for complex operations
- Include proper error handling for database operations
- Use consistent naming conventions for tables and columns

### Security Best Practices
- Validate and sanitize all user input
- Use parameterized queries exclusively
- Implement proper file upload validation
- Escape output data for HTML display
- Never expose sensitive information in error messages

### Performance Considerations
- Use appropriate database indexes
- Implement pagination for large result sets
- Optimize file storage and retrieval
- Monitor database query performance

## Deployment

### Server Requirements
- PHP 7.4 or higher
- MySQL 5.7+ or MariaDB 10.2+
- Web server (Apache/Nginx)
- Minimum 512MB RAM
- Disk space for file uploads

### Installation Steps
1. Deploy files to web server document root
2. Create MySQL database and import schema
3. Configure `.env` file with database credentials
4. Set proper file permissions on `files/` directory
5. Configure web server to serve PHP files
6. Test database connectivity and file upload functionality

### Production Considerations
- Enable HTTPS for secure data transmission
- Implement regular database backups
- Set up error logging and monitoring
- Configure proper PHP error handling
- Implement file upload size limits at server level

## Troubleshooting

### Common Issues

#### Database Connection Errors
- Verify `.env` file exists and contains correct credentials
- Check MySQL service status
- Confirm database and tables exist
- Validate network connectivity to database server

#### File Upload Issues
- Check directory permissions on `files/` folder
- Verify PHP `upload_max_filesize` and `post_max_size` settings
- Confirm `file_uploads = On` in PHP configuration
- Check available disk space

#### Performance Issues
- Monitor database query execution times
- Check for missing database indexes
- Analyze file upload/download performance
- Review web server error logs

### Error Logging
Enable error logging for debugging:
```php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', '/path/to/error.log');
```

## Maintenance

### Regular Tasks
- Database backup and maintenance
- File system cleanup of orphaned files
- Performance monitoring and optimization
- Security updates and patches
- Log file rotation and cleanup

### Monitoring
- Database connection health
- File upload success rates
- Application error rates
- Server resource utilization
- User activity and search patterns