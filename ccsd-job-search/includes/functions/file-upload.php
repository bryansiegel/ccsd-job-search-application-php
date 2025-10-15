<?php
/**
 * File Upload Utility Functions
 */

/**
 * Handle file upload for job creation/editing
 * 
 * @param string $jobType Job type (administration, licensed, support)
 * @param array $jobData Job data containing the job code
 * @return string|null Filename if successful, null if no file uploaded
 * @throws Exception If upload fails
 */
function handleFileUpload($jobType, $jobData = []) {
    // Check if file was uploaded
    if (!isset($_FILES['job_file']) || $_FILES['job_file']['error'] !== UPLOAD_ERR_OK) {
        // If no file uploaded or upload error, return null (not an error)
        if (isset($_FILES['job_file']) && $_FILES['job_file']['error'] !== UPLOAD_ERR_NO_FILE) {
            $error_messages = [
                UPLOAD_ERR_INI_SIZE => 'File too large (exceeds upload_max_filesize)',
                UPLOAD_ERR_FORM_SIZE => 'File too large (exceeds MAX_FILE_SIZE)',
                UPLOAD_ERR_PARTIAL => 'File was only partially uploaded',
                UPLOAD_ERR_NO_TMP_DIR => 'Missing temporary folder',
                UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk',
                UPLOAD_ERR_EXTENSION => 'File upload stopped by extension'
            ];
            $error_code = $_FILES['job_file']['error'];
            $error_msg = isset($error_messages[$error_code]) ? $error_messages[$error_code] : 'Unknown upload error';
            throw new Exception("File upload error: " . $error_msg);
        }
        return null;
    }
    
    $tmpName = $_FILES['job_file']['tmp_name'];
    $originalName = $_FILES['job_file']['name'];
    $fileSize = $_FILES['job_file']['size'];
    $fileType = $_FILES['job_file']['type'];
    
    // Validate file type (only allow PDFs and common document formats)
    $allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
    $allowedExtensions = ['pdf', 'doc', 'docx'];
    
    $fileExtension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
    
    if (!in_array($fileType, $allowedTypes) && !in_array($fileExtension, $allowedExtensions)) {
        throw new Exception("Invalid file type. Only PDF, DOC, and DOCX files are allowed.");
    }
    
    // Validate file size (max 10MB)
    if ($fileSize > 10 * 1024 * 1024) {
        throw new Exception("File size too large. Maximum 10MB allowed.");
    }
    
    // Set upload directory based on job type
    $uploadDir = getUploadDirectory($jobType);
    
    // Create directory if it doesn't exist
    if (!is_dir($uploadDir)) {
        if (!mkdir($uploadDir, 0755, true)) {
            throw new Exception("Failed to create upload directory.");
        }
    }
    
    // Generate filename based on job code
    $jobCode = getJobCodeFromData($jobType, $jobData);
    
    if (empty($jobCode)) {
        throw new Exception("Job code is required for file upload.");
    }
    
    // Clean the job code to make it filesystem-safe
    $cleanJobCode = preg_replace('/[^a-zA-Z0-9._-]/', '_', $jobCode);
    
    // Create filename using job code + original extension
    $filename = $cleanJobCode . '.' . $fileExtension;
    $uploadPath = $uploadDir . $filename;
    
    // Move uploaded file to destination
    if (!move_uploaded_file($tmpName, $uploadPath)) {
        throw new Exception("Failed to move uploaded file.");
    }
    
    return $filename;
}

/**
 * Get upload directory for job type
 * 
 * @param string $jobType Job type
 * @return string Upload directory path
 * @throws Exception If invalid job type
 */
function getUploadDirectory($jobType) {
    $baseDir = dirname(dirname(__DIR__)) . '/files/';
    
    switch ($jobType) {
        case 'administration':
            return $baseDir . 'administration/';
        case 'licensed':
            return $baseDir . 'licensed/';
        case 'support':
            return $baseDir . 'support/';
        default:
            throw new Exception("Invalid job type for file upload: " . $jobType);
    }
}

/**
 * Extract job code from job data based on job type
 * 
 * @param string $jobType Job type
 * @param array $jobData Job data array
 * @return string Job code
 */
function getJobCodeFromData($jobType, $jobData) {
    switch ($jobType) {
        case 'administration':
            return $jobData['ccode'] ?? '';
        case 'licensed':
            return $jobData['job_id'] ?? '';
        case 'support':
            return $jobData['job_code'] ?? '';
        default:
            return '';
    }
}

/**
 * Get allowed file extensions
 * 
 * @return array Array of allowed file extensions
 */
function getAllowedFileExtensions() {
    return ['pdf', 'doc', 'docx'];
}

/**
 * Get allowed MIME types
 * 
 * @return array Array of allowed MIME types
 */
function getAllowedMimeTypes() {
    return [
        'application/pdf',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
    ];
}

/**
 * Get maximum file size in bytes
 * 
 * @return int Maximum file size (10MB)
 */
function getMaxFileSize() {
    return 10 * 1024 * 1024; // 10MB
}