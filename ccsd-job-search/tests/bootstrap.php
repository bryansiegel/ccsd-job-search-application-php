<?php
/**
 * PHPUnit Bootstrap File
 * Sets up the testing environment
 */

// Define test environment
define('TESTING', true);

// Set error reporting for tests
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Load autoloader if available
if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require_once __DIR__ . '/../vendor/autoload.php';
}

// Load application configuration for testing
require_once __DIR__ . '/../includes/config/app-config.php';

// Test-specific database configuration
function getTestDatabaseConnection() {
    static $testPdo = null;
    
    if ($testPdo === null) {
        $host = $_ENV['DB_HOST'] ?? 'localhost';
        $dbname = $_ENV['DB_NAME'] ?? 'ccsd_jobs_test';
        $username = $_ENV['DB_USERNAME'] ?? 'root';
        $password = $_ENV['DB_PASSWORD'] ?? 'advanced';
        
        try {
            $testPdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
            $testPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new Exception("Test Database Connection Error: " . $e->getMessage());
        }
    }
    
    return $testPdo;
}

// Helper function to reset test database
function resetTestDatabase() {
    $pdo = getTestDatabaseConnection();
    
    // Clear all tables
    $tables = ['administration_jobs', 'licensed_jobs', 'support_jobs'];
    foreach ($tables as $table) {
        $pdo->exec("DELETE FROM $table");
        $pdo->exec("ALTER TABLE $table AUTO_INCREMENT = 1");
    }
}

// Helper function to create test file upload directory
function setupTestFileDirectory() {
    $testUploadDir = __DIR__ . '/temp_uploads';
    if (!is_dir($testUploadDir)) {
        mkdir($testUploadDir, 0755, true);
        mkdir($testUploadDir . '/ap', 0755, true);
        mkdir($testUploadDir . '/lp', 0755, true); 
        mkdir($testUploadDir . '/support-staff', 0755, true);
    }
    return $testUploadDir;
}

// Helper function to clean up test files
function cleanupTestFiles() {
    $testUploadDir = __DIR__ . '/temp_uploads';
    if (is_dir($testUploadDir)) {
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($testUploadDir, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::CHILD_FIRST
        );
        
        foreach ($files as $fileinfo) {
            $todo = ($fileinfo->isDir() ? 'rmdir' : 'unlink');
            $todo($fileinfo->getRealPath());
        }
        rmdir($testUploadDir);
    }
}

// Setup test environment
setupTestFileDirectory();