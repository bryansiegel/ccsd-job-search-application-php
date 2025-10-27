# CCSD Job Search Portal - Test Suite

This directory contains a comprehensive test suite for the CCSD Job Search Portal application using PHPUnit.

## Test Structure

```
tests/
├── Unit/                    # Unit tests for individual components
│   ├── JobModelTest.php     # JobModel CRUD operations
│   ├── SearchFunctionalityTest.php  # Search functionality
│   ├── FilterFunctionalityTest.php  # Filter functionality  
│   └── FileUploadTest.php   # File upload functionality
├── Integration/             # Integration tests for workflows
│   └── AdminEndpointTest.php # Admin endpoint testing
├── Fixtures/                # Test data and utilities
│   └── TestData.php         # Sample data for testing
├── bootstrap.php            # Test environment setup
└── README.md               # This file
```

## Prerequisites

### System Requirements
- PHP 7.4+ with PHPUnit 9.5+
- MySQL/MariaDB with test database
- Web server with write permissions

### Installation
1. Install PHPUnit via Composer:
   ```bash
   composer install
   ```

2. Create test database:
   ```bash
   mysql -u root -p -e "CREATE DATABASE ccsd_jobs_test;"
   mysql -u root -p ccsd_jobs_test < _mysql_dumps/ccsd_jobs_php.sql
   ```

3. Configure test environment in `phpunit.xml`:
   ```xml
   <env name="DB_HOST" value="localhost"/>
   <env name="DB_NAME" value="ccsd_jobs_test"/>
   <env name="DB_USERNAME" value="root"/>
   <env name="DB_PASSWORD" value="your_password"/>
   ```

## Running Tests

### Run All Tests
```bash
./vendor/bin/phpunit
```

### Run Specific Test Suites
```bash
# Unit tests only
./vendor/bin/phpunit --testsuite="Unit Tests"

# Integration tests only  
./vendor/bin/phpunit --testsuite="Integration Tests"
```

### Run Individual Test Files
```bash
# JobModel CRUD tests
./vendor/bin/phpunit tests/Unit/JobModelTest.php

# Search functionality tests
./vendor/bin/phpunit tests/Unit/SearchFunctionalityTest.php

# Filter functionality tests
./vendor/bin/phpunit tests/Unit/FilterFunctionalityTest.php

# File upload tests
./vendor/bin/phpunit tests/Unit/FileUploadTest.php

# Admin endpoint tests
./vendor/bin/phpunit tests/Integration/AdminEndpointTest.php
```

### Run Tests with Coverage
```bash
./vendor/bin/phpunit --coverage-html coverage/
```

### Verbose Output
```bash
./vendor/bin/phpunit --verbose
```

## Test Categories

### Unit Tests

#### JobModelTest.php
Tests all CRUD operations for the JobModel class:
- **Administration Jobs**: Create, read, update, delete, list, count
- **Licensed Jobs**: Create, read, update, delete, list, count  
- **Support Jobs**: Create, read, update, delete, list, count
- **Aggregate Operations**: Get all jobs, get counts across tables
- **Error Handling**: Invalid IDs, missing data, database errors

#### SearchFunctionalityTest.php
Tests the search system across all job types:
- **Basic Search**: By title, category, division, job code, grade, description
- **Cross-table Search**: Search across administration, licensed, and support tables
- **Case Sensitivity**: Case-insensitive search functionality
- **Partial Matching**: Substring and wildcard matching
- **Special Cases**: Empty searches, no results, special characters
- **Result Structure**: Proper array structure and job type tagging

#### FilterFunctionalityTest.php
Tests the filtering system and helper functions:
- **Filter Options**: Grade, code, and division option generation
- **Job Type Filters**: Administration, licensed, support, and "all" filters
- **Individual Filters**: Grade, code, and division filtering
- **Combined Filters**: Multiple filter combinations
- **Helper Functions**: Count calculations, search status preparation
- **Edge Cases**: No matches, empty filters, invalid combinations

#### FileUploadTest.php
Tests file upload functionality and validation:
- **Directory Management**: Upload path generation for each job type
- **Job Code Extraction**: Code extraction from job data
- **File Validation**: File type, size, and format validation
- **Error Handling**: Upload errors, invalid files, missing codes
- **Filename Processing**: Special character cleaning and sanitization
- **Integration Workflows**: Complete upload process testing

### Integration Tests

#### AdminEndpointTest.php
Tests the admin interface endpoints and workflows:
- **CRUD Endpoints**: Create, update, delete for all job types
- **Search/Filter Endpoints**: Search and filtering through admin interface
- **Data Sanitization**: Input cleaning and XSS protection
- **Error Handling**: Invalid requests, missing fields, non-existent records
- **Complete Workflows**: End-to-end job management processes

## Test Data

### Test Fixtures (TestData.php)
Provides sample data for all job types:
- Single job records for basic testing
- Multiple job records for filter/search testing
- PDF content generation for file upload testing
- Diverse data sets covering edge cases

### Database Management
- **Setup**: Automatic test database creation and schema import
- **Isolation**: Each test runs with a clean database state
- **Cleanup**: Automatic cleanup after each test
- **Reset**: Helper functions to reset database state

## Configuration

### PHPUnit Configuration (phpunit.xml)
- **Test Discovery**: Automatic test file discovery
- **Environment Variables**: Database credentials and app settings
- **Coverage Reporting**: Code coverage configuration
- **Bootstrap**: Test environment initialization

### Test Environment (bootstrap.php)
- **Database Connection**: Test database setup
- **Helper Functions**: Utility functions for testing
- **File Management**: Temporary file creation and cleanup
- **Error Handling**: Test-specific error reporting

## Best Practices

### Writing Tests
1. **Isolation**: Each test should be independent
2. **Cleanup**: Always clean up test data and files
3. **Assertions**: Use specific assertions for better error messages
4. **Data**: Use TestData fixtures for consistent test data
5. **Naming**: Descriptive test method names

### Running Tests
1. **Before Commits**: Run full test suite before committing code
2. **Feature Development**: Run relevant test suites during development
3. **Continuous Integration**: Integrate with CI/CD pipelines
4. **Coverage Monitoring**: Maintain high test coverage

### Debugging Tests
1. **Verbose Mode**: Use `--verbose` flag for detailed output
2. **Individual Tests**: Run single tests for focused debugging
3. **Database State**: Check test database state when tests fail
4. **Error Messages**: Review PHPUnit error messages carefully

## Coverage Goals

- **Unit Tests**: 95%+ coverage of core business logic
- **Integration Tests**: 80%+ coverage of endpoint workflows
- **Critical Paths**: 100% coverage of CRUD operations
- **Error Handling**: 90%+ coverage of exception paths

## Continuous Integration

### Automated Testing
```bash
# Example CI script
composer install
mysql -e "CREATE DATABASE ccsd_jobs_test;"
mysql ccsd_jobs_test < _mysql_dumps/ccsd_jobs_php.sql
./vendor/bin/phpunit --coverage-clover coverage.xml
```

### Test Reports
- **Coverage Reports**: HTML coverage reports in `coverage/` directory
- **JUnit XML**: Compatible with CI/CD systems
- **Failure Logs**: Detailed failure information for debugging

## Troubleshooting

### Common Issues

#### Database Connection Errors
```bash
# Check database credentials in phpunit.xml
# Ensure test database exists
mysql -e "SHOW DATABASES;" | grep ccsd_jobs_test
```

#### File Permission Errors
```bash
# Ensure test directory has write permissions
chmod -R 755 tests/
```

#### Memory Issues
```bash
# Increase PHP memory limit for large test suites
php -d memory_limit=512M ./vendor/bin/phpunit
```

#### Test Failures
1. Check test database state
2. Verify test data fixtures
3. Review error messages
4. Run individual tests for isolation

### Getting Help
- Review test output for specific error messages
- Check application logs for underlying issues
- Ensure test environment matches production requirements
- Verify database schema is up to date