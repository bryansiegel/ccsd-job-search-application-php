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
- **Dependency Management**: Composer 2.0+ for PHP package management
- **Testing Framework**: PHPUnit 9.6+ for automated testing

### Design Patterns
- **MVC-inspired**: Separation of concerns with models, views, and controllers
- **Component-based**: Reusable UI components in `includes/components/`
- **Configuration-driven**: Centralized settings in `includes/config/`

## Project Structure

```
ccsd-job-search/
├── index.php                 # Main application entry point
├── job-creation-sop.php      # Job creation Standard Operating Procedure
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
├── employees/              # File upload storage (updated structure)
│   └── resources/
│       └── pdf/
│           └── desc/
│               ├── ap/               # Administration job files
│               ├── lp/               # Licensed job files
│               └── support-staff/    # Support job files
├── img/                    # Static images
├── tests/                  # PHPUnit test suite
│   ├── Unit/              # Unit tests
│   │   ├── JobModelTest.php        # CRUD operations testing
│   │   ├── SearchFunctionalityTest.php  # Search system testing
│   │   ├── FilterFunctionalityTest.php  # Filter system testing
│   │   └── FileUploadTest.php      # File upload testing
│   ├── Integration/       # Integration tests
│   │   └── AdminEndpointTest.php   # Admin endpoint testing
│   ├── Fixtures/          # Test data
│   │   └── TestData.php    # Sample data for testing
│   ├── bootstrap.php      # Test environment setup
│   └── README.md          # Testing documentation
├── composer.json          # PHP dependencies
├── phpunit.xml           # PHPUnit configuration
├── run-tests.sh          # Test runner script
└── styles.css            # Application styles
```

## File Storage Structure

### Updated File Organization
The application has been updated from the legacy `files/` structure to a more organized hierarchy:

**New Structure (Current):**
```
employees/resources/pdf/desc/
├── ap/               # Administration job files (A-codes)
├── lp/               # Licensed job files (L-codes) 
└── support-staff/    # Support job files (S-codes)
```

**Legacy Structure (Deprecated):**
```
files/
├── administration/   # Old admin location
├── licensed/        # Old licensed location
└── support/         # Old support location
```

### File Naming Convention
- **Administration**: Files named with job code (e.g., `A225.pdf`)
- **Licensed**: Files named with job ID (e.g., `LIC001.pdf`)
- **Support**: Files named with job code (e.g., `0021.pdf`)

### Path Configuration
File paths are configured in:
- `includes/config/app-config.php`: Path constants
- `includes/functions/file-upload.php`: Upload directory function
- `includes/components/job-card.php`: Display link generation

## Dependency Management

### Composer Configuration
The application uses Composer for PHP dependency management and autoloading:

#### composer.json Structure
```json
{
    "name": "ccsd/job-search-portal",
    "description": "CCSD Job Search Portal with CRUD functionality",
    "type": "project",
    "require": {
        "php": ">=7.4",
        "ext-pdo": "*",
        "ext-json": "*",
        "ext-fileinfo": "*"
    },
    "require-dev": {
        "phpunit/phpunit": "^9.5"
    },
    "autoload": {
        "psr-4": {
            "CCSD\\JobPortal\\": "includes/",
            "CCSD\\JobPortal\\Tests\\": "tests/"
        }
    }
}
```

### Production Dependencies
The application maintains minimal production dependencies:
- **PHP**: Core language requirement (7.4+)
- **ext-pdo**: Database connectivity
- **ext-json**: JSON data handling
- **ext-fileinfo**: File type detection for uploads

### Development Dependencies
Testing and development tools:
- **PHPUnit**: Comprehensive testing framework (9.5+)
- **Autoloading**: PSR-4 compliant class loading

### Composer Commands
```bash
# Installation
composer install                    # Install all dependencies
composer install --no-dev          # Production installation
composer install --optimize-autoloader  # Optimized for production

# Updates
composer update                     # Update all packages
composer update phpunit/phpunit     # Update specific package

# Maintenance
composer audit                      # Security vulnerability check
composer dump-autoload             # Regenerate autoloader
composer validate                  # Validate composer.json

# Information
composer show                       # List installed packages
composer outdated                   # Check for package updates
composer why vendor/package         # Dependency analysis
```

### Autoloading
The application uses PSR-4 autoloading for:
- **Application Classes**: `CCSD\JobPortal\` namespace maps to `includes/`
- **Test Classes**: `CCSD\JobPortal\Tests\` namespace maps to `tests/`

#### Autoloader Usage
```php
// Composer autoloader (automatically included in bootstrap)
require_once 'vendor/autoload.php';

// Manual class loading (legacy compatibility)
require_once 'includes/db/model.php';
require_once 'includes/functions/job-processing.php';
```

### Package Security
- **Regular Updates**: Keep dependencies updated for security patches
- **Vulnerability Scanning**: Use `composer audit` for security checks
- **Lock File**: `composer.lock` ensures consistent dependency versions
- **Version Constraints**: Semantic versioning for stable updates

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

### 5. User Documentation (`job-creation-sop.php`)

#### Standard Operating Procedure
Comprehensive user guide providing:
- Step-by-step job creation process
- Job type specific field requirements
- File upload guidelines and validation rules
- Troubleshooting common issues
- Visual indicators for required fields
- Navigation integration with both public and admin interfaces

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
chmod 755 employees/resources/pdf/desc/
chmod 755 employees/resources/pdf/desc/ap/
chmod 755 employees/resources/pdf/desc/lp/
chmod 755 employees/resources/pdf/desc/support-staff/

# Set ownership (web server user)
chown -R www-data:www-data employees/
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
2. Install Composer dependencies: `composer install --no-dev --optimize-autoloader`
3. Create MySQL database and import schema
4. Configure `.env` file with database credentials
5. Set proper file permissions on `employees/resources/pdf/desc/` directory
6. Configure web server to serve PHP files
7. Test database connectivity and file upload functionality

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
- Check directory permissions on `employees/resources/pdf/desc/` folder
- Verify PHP `upload_max_filesize` and `post_max_size` settings
- Confirm `file_uploads = On` in PHP configuration
- Check available disk space

#### Performance Issues
- Monitor database query execution times
- Check for missing database indexes
- Analyze file upload/download performance
- Review web server error logs

#### Composer/Dependency Issues
- **Missing Composer**: Install Composer from https://getcomposer.org/
- **Permission Errors**: Ensure write permissions on `vendor/` directory
- **Memory Issues**: Increase PHP memory limit (`php -d memory_limit=512M composer install`)
- **Lock File Conflicts**: Delete `vendor/` and `composer.lock`, then run `composer install`
- **Autoloader Issues**: Run `composer dump-autoload` to regenerate autoloader
- **Version Conflicts**: Check `composer.json` constraints and run `composer update`
- **Network Issues**: Use `composer install --no-plugins --no-scripts` for minimal installation

#### Composer Troubleshooting Commands
```bash
# Diagnose Composer issues
composer diagnose

# Clear Composer cache
composer clear-cache

# Validate composer.json
composer validate

# Install with verbose output
composer install -vvv

# Reinstall everything
rm -rf vendor/ composer.lock
composer install
```

### Error Logging
Enable error logging for debugging:
```php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', '/path/to/error.log');
```

## Testing Framework

### Overview
The application includes a comprehensive PHPUnit test suite with 90+ individual tests covering all major functionality:

### Test Structure
```
tests/
├── Unit/                           # Component-level testing
│   ├── JobModelTest.php           # Database operations (25+ tests)
│   ├── SearchFunctionalityTest.php # Search system (20+ tests)
│   ├── FilterFunctionalityTest.php # Filter system (25+ tests)
│   └── FileUploadTest.php         # File handling (20+ tests)
├── Integration/                    # Workflow testing
│   └── AdminEndpointTest.php      # Admin interface (15+ tests)
├── Fixtures/                      # Test data
│   └── TestData.php               # Sample data generation
├── bootstrap.php                  # Test environment setup
└── README.md                      # Testing documentation
```

### Test Categories

#### Unit Tests
- **JobModelTest**: Complete CRUD operations for all job types
  - Create, read, update, delete operations
  - Data validation and sanitization
  - Error handling and edge cases
  - Aggregate operations (counts, listings)

- **SearchFunctionalityTest**: Cross-table search capabilities
  - Multi-field search across all job types
  - Case-insensitive and partial matching
  - Special character handling
  - Empty search and no-result scenarios

- **FilterFunctionalityTest**: Advanced filtering system
  - Job type, grade, code, division filters
  - Multiple filter combinations
  - Filter option generation
  - Edge cases and invalid filters

- **FileUploadTest**: File management system
  - File validation (type, size, format)
  - Directory path generation
  - Upload error handling
  - Filename sanitization

#### Integration Tests
- **AdminEndpointTest**: Complete workflow testing
  - Admin interface CRUD operations
  - Search and filter endpoints
  - Data sanitization and security
  - Error handling and validation

### Test Configuration

#### PHPUnit Setup (phpunit.xml)
```xml
<phpunit bootstrap="tests/bootstrap.php">
    <testsuites>
        <testsuite name="Unit Tests">
            <directory>tests/Unit</directory>
        </testsuite>
        <testsuite name="Integration Tests">
            <directory>tests/Integration</directory>
        </testsuite>
    </testsuites>
    <php>
        <env name="DB_NAME" value="ccsd_jobs_test"/>
        <env name="APP_ENV" value="testing"/>
    </php>
</phpunit>
```

#### Test Database
- **Isolation**: Each test runs with clean database state
- **Setup**: Automatic schema import and data cleanup
- **Environment**: Separate test database (`ccsd_jobs_test`)
- **Transactions**: Rollback capabilities for data integrity

### Running Tests

#### Basic Commands
```bash
# Install dependencies
composer install

# Run all tests
./run-tests.sh

# Run with verbose output
./run-tests.sh --verbose

# Generate coverage report
./run-tests.sh --coverage
```

#### Specific Test Suites
```bash
# Unit tests only
./run-tests.sh --unit
./vendor/bin/phpunit --testsuite="Unit Tests"

# Integration tests only  
./run-tests.sh --integration
./vendor/bin/phpunit --testsuite="Integration Tests"

# Individual test files
./vendor/bin/phpunit tests/Unit/JobModelTest.php
./vendor/bin/phpunit tests/Unit/SearchFunctionalityTest.php
```

### Test Data Management

#### Fixtures (TestData.php)
- Sample job data for all job types
- Multiple data sets for comprehensive testing
- PDF content generation for file testing
- Edge case data scenarios

#### Database Management
```php
// Test helper functions
resetTestDatabase();           // Clean slate for each test
setupTestFileDirectory();     // Temporary file handling
cleanupTestFiles();          // Post-test cleanup
```

### Continuous Integration

#### Automated Testing Pipeline
```bash
# CI/CD Script Example
composer install --no-interaction
mysql -e "CREATE DATABASE ccsd_jobs_test;"
mysql ccsd_jobs_test < _mysql_dumps/ccsd_jobs_php.sql
./vendor/bin/phpunit --coverage-clover coverage.xml
```

#### Coverage Goals
- **Unit Tests**: 95%+ coverage of business logic
- **Integration Tests**: 80%+ coverage of endpoints
- **Critical Paths**: 100% coverage of CRUD operations
- **Error Handling**: 90%+ coverage of exception paths

### Test Quality Metrics

#### Coverage Areas
- ✅ **CRUD Operations**: All create, read, update, delete functions
- ✅ **Search System**: Cross-table search with all field types
- ✅ **Filter System**: All filter combinations and edge cases
- ✅ **File Upload**: Complete upload pipeline and validation
- ✅ **Admin Interface**: Full endpoint workflow testing
- ✅ **Error Handling**: Exception cases and invalid input
- ✅ **Data Integrity**: Database transactions and cleanup

#### Test Statistics
- **Total Tests**: 90+ individual test methods
- **Test Files**: 5 comprehensive test classes
- **Code Coverage**: Targets 90%+ for critical components
- **Database Operations**: Full transaction testing
- **File Operations**: Upload, validation, cleanup testing

### Development Workflow

#### Test-Driven Development
1. **Write Tests First**: Define expected behavior
2. **Implement Features**: Code to pass tests
3. **Refactor**: Improve code while maintaining tests
4. **Regression Testing**: Ensure changes don't break existing functionality

#### Pre-Commit Testing
```bash
# Recommended pre-commit workflow
./run-tests.sh --verbose        # Full test suite
./run-tests.sh --coverage      # Coverage verification
git add . && git commit        # Commit if tests pass
```

### Debugging Tests

#### Common Debugging Techniques
```bash
# Run single test with verbose output
./vendor/bin/phpunit tests/Unit/JobModelTest.php::testCreateAdminJob --verbose

# Debug with error output
./vendor/bin/phpunit --debug tests/Unit/JobModelTest.php

# Check test database state
mysql -u root -p ccsd_jobs_test -e "SELECT * FROM administration_jobs;"
```

#### Test Environment Variables
```php
// Custom test configuration
define('TESTING', true);
$_ENV['APP_ENV'] = 'testing';
$_ENV['DB_NAME'] = 'ccsd_jobs_test';
```

## User Guide

### Job Creation Standard Operating Procedure

The application includes a built-in user guide accessible at `job-creation-sop.php` that provides:

#### Access Points
- **Public Interface**: "How to Create Jobs" link in main navigation (left of Login)
- **Admin Interface**: "How to Create Jobs" link in admin navigation (left of Job Search)
- **Direct URL**: `/job-creation-sop.php`

#### SOP Content Structure
1. **Access Requirements**: Administrative interface navigation
2. **Job Type Selection**: Administration, Licensed, Support position types
3. **Field Requirements**: Job type specific required and optional fields
4. **File Upload Process**: Document upload guidelines and validation
5. **Review and Submission**: Final validation and submission steps
6. **Verification Process**: Confirming successful job creation
7. **Troubleshooting Guide**: Common issues and solutions

#### Field Requirements by Job Type

**Administration Jobs:**
- Required: Job Title
- Optional: Grade, Classification Code (CCODE), Division, Description

**Licensed Jobs:**
- Required: Job Title
- Optional: Job ID, Category, Division, Certification Type, Salary Code, Active Status

**Support Jobs:**
- Required: Job Title
- Optional: Grade, Job Code, Department Code, Union Code

#### File Upload Guidelines
- **Accepted Formats**: PDF, DOC, DOCX
- **Maximum Size**: 10MB
- **Automatic Naming**: Files renamed based on job codes
- **Storage Locations**: Organized by job type in `employees/resources/pdf/desc/`

#### Troubleshooting Coverage
- File upload errors (size, format, connection issues)
- Form validation errors (required fields, special characters)
- Database errors (duplicates, connectivity, permissions)

## Maintenance

### Regular Tasks
- Database backup and maintenance
- File system cleanup of orphaned files
- Performance monitoring and optimization
- Security updates and patches
- Log file rotation and cleanup
- **Test Suite Maintenance**: Keep tests updated with code changes
- **Coverage Monitoring**: Maintain high test coverage standards
- **User Documentation Updates**: Keep SOP current with interface changes

### Monitoring
- Database connection health
- File upload success rates
- Application error rates
- Server resource utilization
- User activity and search patterns