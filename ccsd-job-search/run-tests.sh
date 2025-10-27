#!/bin/bash

# CCSD Job Search Portal - Test Runner Script
# This script sets up the test environment and runs the PHPUnit test suite

set -e  # Exit on any error

echo "🧪 CCSD Job Search Portal - Test Suite Runner"
echo "=============================================="

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Configuration
DB_NAME="ccsd_jobs_test"
DB_USER="root"
DB_PASS="advanced"

# Function to print colored output
print_status() {
    echo -e "${BLUE}[INFO]${NC} $1"
}

print_success() {
    echo -e "${GREEN}[SUCCESS]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

print_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

# Function to check if command exists
command_exists() {
    command -v "$1" >/dev/null 2>&1
}

# Check prerequisites
print_status "Checking prerequisites..."

if ! command_exists php; then
    print_error "PHP is not installed or not in PATH"
    exit 1
fi

if ! command_exists mysql; then
    print_error "MySQL client is not installed or not in PATH"
    exit 1
fi

if ! command_exists composer; then
    print_error "Composer is not installed or not in PATH"
    exit 1
fi

print_success "All prerequisites are available"

# Check PHP version
PHP_VERSION=$(php -r "echo PHP_VERSION;" 2>/dev/null)
print_status "PHP Version: $PHP_VERSION"

if [[ $(php -r "echo version_compare(PHP_VERSION, '7.4.0', '>=') ? 'yes' : 'no';") == "no" ]]; then
    print_error "PHP 7.4 or higher is required"
    exit 1
fi

# Install dependencies
print_status "Installing/updating dependencies..."
if [ ! -f "composer.json" ]; then
    print_error "composer.json not found. Please run this script from the project root."
    exit 1
fi

composer install --no-interaction --prefer-dist --optimize-autoloader

if [ ! -f "vendor/bin/phpunit" ]; then
    print_error "PHPUnit installation failed"
    exit 1
fi

print_success "Dependencies installed"

# Setup test database
print_status "Setting up test database..."

# Check if MySQL is running
if ! mysql -u"$DB_USER" -p"$DB_PASS" -e "SELECT 1" >/dev/null 2>&1; then
    print_error "Cannot connect to MySQL. Please check your credentials and ensure MySQL is running."
    exit 1
fi

# Create test database if it doesn't exist
mysql -u"$DB_USER" -p"$DB_PASS" -e "CREATE DATABASE IF NOT EXISTS $DB_NAME;" 2>/dev/null

# Import schema
if [ -f "_mysql_dumps/ccsd_jobs_php.sql" ]; then
    print_status "Importing database schema..."
    mysql -u"$DB_USER" -p"$DB_PASS" "$DB_NAME" < _mysql_dumps/ccsd_jobs_php.sql 2>/dev/null
    print_success "Database schema imported"
else
    print_warning "Database dump file not found. Tests may fail if schema is not set up."
fi

# Create test upload directories
print_status "Setting up test directories..."
mkdir -p tests/temp_uploads/{ap,lp,support-staff}
print_success "Test directories created"

# Parse command line arguments
COVERAGE=false
VERBOSE=false
TESTSUITE=""
TESTFILE=""

while [[ $# -gt 0 ]]; do
    case $1 in
        --coverage)
            COVERAGE=true
            shift
            ;;
        --verbose|-v)
            VERBOSE=true
            shift
            ;;
        --unit)
            TESTSUITE="Unit Tests"
            shift
            ;;
        --integration)
            TESTSUITE="Integration Tests"
            shift
            ;;
        --file)
            TESTFILE="$2"
            shift 2
            ;;
        --help|-h)
            echo "Usage: $0 [OPTIONS]"
            echo ""
            echo "Options:"
            echo "  --coverage       Generate HTML coverage report"
            echo "  --verbose, -v    Enable verbose output"
            echo "  --unit          Run only unit tests"
            echo "  --integration   Run only integration tests"
            echo "  --file FILE     Run specific test file"
            echo "  --help, -h      Show this help message"
            echo ""
            echo "Examples:"
            echo "  $0                              # Run all tests"
            echo "  $0 --coverage                  # Run tests with coverage"
            echo "  $0 --unit --verbose            # Run unit tests with verbose output"
            echo "  $0 --file tests/Unit/JobModelTest.php  # Run specific test file"
            exit 0
            ;;
        *)
            print_error "Unknown option: $1"
            print_status "Use --help for usage information"
            exit 1
            ;;
    esac
done

# Build PHPUnit command
PHPUNIT_CMD="./vendor/bin/phpunit"

if [ "$VERBOSE" = true ]; then
    PHPUNIT_CMD="$PHPUNIT_CMD --verbose"
fi

if [ "$COVERAGE" = true ]; then
    print_status "Coverage reporting enabled - this may take longer..."
    PHPUNIT_CMD="$PHPUNIT_CMD --coverage-html coverage/"
fi

if [ -n "$TESTSUITE" ]; then
    PHPUNIT_CMD="$PHPUNIT_CMD --testsuite=\"$TESTSUITE\""
fi

if [ -n "$TESTFILE" ]; then
    if [ ! -f "$TESTFILE" ]; then
        print_error "Test file not found: $TESTFILE"
        exit 1
    fi
    PHPUNIT_CMD="$PHPUNIT_CMD $TESTFILE"
fi

# Run tests
print_status "Running tests..."
echo "Command: $PHPUNIT_CMD"
echo ""

# Execute PHPUnit
if eval $PHPUNIT_CMD; then
    print_success "All tests passed! ✅"
    
    if [ "$COVERAGE" = true ]; then
        print_success "Coverage report generated in coverage/ directory"
        if command_exists open; then
            print_status "Opening coverage report..."
            open coverage/index.html
        elif command_exists xdg-open; then
            print_status "Opening coverage report..."
            xdg-open coverage/index.html
        else
            print_status "Coverage report available at: coverage/index.html"
        fi
    fi
else
    print_error "Some tests failed! ❌"
    exit 1
fi

# Cleanup
print_status "Cleaning up..."
rm -rf tests/temp_uploads

print_success "Test run completed successfully!"

# Additional information
echo ""
echo "📊 Test Statistics:"
echo "  - Test database: $DB_NAME"
echo "  - PHP version: $PHP_VERSION"
echo "  - PHPUnit version: $(./vendor/bin/phpunit --version 2>/dev/null | head -n1 || echo 'Unknown')"

if [ "$COVERAGE" = true ]; then
    echo "  - Coverage report: coverage/index.html"
fi

echo ""
echo "🔧 Available test commands:"
echo "  ./run-tests.sh --unit              # Unit tests only"
echo "  ./run-tests.sh --integration       # Integration tests only"
echo "  ./run-tests.sh --coverage          # With coverage report"
echo "  ./run-tests.sh --verbose           # Detailed output"
echo ""
echo "📁 Test files:"
echo "  tests/Unit/JobModelTest.php        # CRUD operations"
echo "  tests/Unit/SearchFunctionalityTest.php  # Search features"
echo "  tests/Unit/FilterFunctionalityTest.php  # Filter features"
echo "  tests/Unit/FileUploadTest.php      # File upload"
echo "  tests/Integration/AdminEndpointTest.php # Admin endpoints"