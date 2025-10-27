<?php
/**
 * Application Configuration
 */

// Application settings
define('APP_NAME', 'CCSD Job Search Portal');
define('APP_VERSION', '1.0.0');

// File upload settings
define('MAX_FILE_SIZE', 10 * 1024 * 1024); // 10MB
define('ALLOWED_FILE_TYPES', ['pdf', 'doc', 'docx']);
define('ALLOWED_MIME_TYPES', [
    'application/pdf',
    'application/msword',
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
]);

// Job types
define('JOB_TYPES', ['administration', 'licensed', 'support']);

// Paths
define('BASE_PATH', dirname(dirname(__DIR__)) . '/');
define('FILES_PATH', BASE_PATH . 'files/');
define('ADMIN_FILES_PATH', BASE_PATH . 'employees/resources/pdf/desc/ap/');
define('LICENSED_FILES_PATH', BASE_PATH . 'employees/resources/pdf/desc/lp/');
define('SUPPORT_FILES_PATH', BASE_PATH . 'employees/resources/pdf/desc/support-staff/');

// Default navigation configuration
$default_nav_config = [
    'logo_path' => 'img/ccsd-main-logo-white.png',
    'logo_alt' => 'CCSD',
    'base_path' => ''
];

// Admin navigation links
$admin_nav_links = [
    ['url' => '../job-creation-sop.php', 'text' => 'How to Create Jobs', 'class' => 'utility-link'],
    ['url' => '../index.php', 'text' => '← Job Search', 'class' => 'utility-link']
];

// Public navigation links
$public_nav_links = [
    ['url' => 'job-creation-sop.php', 'text' => 'How to Create Jobs', 'class' => 'utility-link'],
    ['url' => 'admin/index.php', 'text' => 'Login', 'class' => 'utility-link']
];

// Error messages
$error_messages = [
    'file_upload' => [
        UPLOAD_ERR_INI_SIZE => 'File too large (exceeds upload_max_filesize)',
        UPLOAD_ERR_FORM_SIZE => 'File too large (exceeds MAX_FILE_SIZE)',
        UPLOAD_ERR_PARTIAL => 'File was only partially uploaded',
        UPLOAD_ERR_NO_TMP_DIR => 'Missing temporary folder',
        UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk',
        UPLOAD_ERR_EXTENSION => 'File upload stopped by extension'
    ]
];

// Job type specific configurations
$job_type_config = [
    'administration' => [
        'display_name' => 'Administration',
        'required_fields' => ['title', 'grade', 'ccode', 'division', 'description'],
        'optional_fields' => ['filename'],
        'code_field' => 'ccode'
    ],
    'licensed' => [
        'display_name' => 'Licensed',
        'required_fields' => ['title', 'job_id', 'category', 'division', 'certification_type'],
        'optional_fields' => ['active', 'salary_code', 'filename'],
        'code_field' => 'job_id'
    ],
    'support' => [
        'display_name' => 'Support',
        'required_fields' => ['title'],
        'optional_fields' => ['grade', 'job_code', 'department_code', 'union_code', 'filename'],
        'code_field' => 'job_code'
    ]
];

/**
 * Get configuration for specific job type
 * 
 * @param string $jobType Job type
 * @return array Job type configuration
 */
function getJobTypeConfig($jobType) {
    global $job_type_config;
    return $job_type_config[$jobType] ?? [];
}

/**
 * Check if job type is valid
 * 
 * @param string $jobType Job type to check
 * @return bool True if valid
 */
function isValidJobType($jobType) {
    return in_array($jobType, JOB_TYPES);
}

/**
 * Get file upload path for job type
 * 
 * @param string $jobType Job type
 * @return string Upload path
 */
function getFileUploadPath($jobType) {
    switch ($jobType) {
        case 'administration':
            return ADMIN_FILES_PATH;
        case 'licensed':
            return LICENSED_FILES_PATH;
        case 'support':
            return SUPPORT_FILES_PATH;
        default:
            return FILES_PATH;
    }
}