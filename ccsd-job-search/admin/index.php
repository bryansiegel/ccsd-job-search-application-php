<?php
require_once '../includes/db/mysql-connect.php';
require_once '../includes/db/model.php';

$jobModel = new JobModel($pdo);
$success = '';
$error = '';

// Handle file upload function
function handleFileUpload($jobType, $jobData = []) {
    $uploadedFilename = null;
    
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
    
    if (isset($_FILES['job_file']) && $_FILES['job_file']['error'] === UPLOAD_ERR_OK) {
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
        $uploadDir = '';
        switch ($jobType) {
            case 'administration':
                $uploadDir = __DIR__ . '/../files/administration/';
                break;
            case 'licensed':
                $uploadDir = __DIR__ . '/../files/licensed/';
                break;
            case 'support':
                $uploadDir = __DIR__ . '/../files/support/';
                break;
            default:
                throw new Exception("Invalid job type for file upload: " . $jobType);
        }
        
        // Create directory if it doesn't exist
        if (!is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0755, true)) {
                throw new Exception("Failed to create upload directory.");
            }
        }
        
        // Generate filename based on job code
        $jobCode = '';
        switch ($jobType) {
            case 'administration':
                $jobCode = $jobData['ccode'] ?? '';
                break;
            case 'licensed':
                $jobCode = $jobData['job_id'] ?? '';
                break;
            case 'support':
                $jobCode = $jobData['job_code'] ?? '';
                break;
        }
        
        if (empty($jobCode)) {
            throw new Exception("Job code is required for file upload.");
        }
        
        // Clean the job code to make it filesystem-safe
        $cleanJobCode = preg_replace('/[^a-zA-Z0-9._-]/', '_', $jobCode);
        
        // Create filename using job code + original extension
        $filename = $cleanJobCode . '.' . $fileExtension;
        $uploadPath = $uploadDir . $filename;
        
        // Add debugging information
        error_log("File upload debug - Job type: $jobType, Upload dir: $uploadDir, Target: $uploadPath");
        error_log("Directory exists: " . (is_dir($uploadDir) ? 'Yes' : 'No'));
        error_log("Directory writable: " . (is_writable($uploadDir) ? 'Yes' : 'No'));
        error_log("Temp file exists: " . (file_exists($tmpName) ? 'Yes' : 'No'));
        
        // Move uploaded file
        if (move_uploaded_file($tmpName, $uploadPath)) {
            $uploadedFilename = $filename;
            error_log("File upload successful: $uploadPath");
        } else {
            $error_msg = "Failed to upload file. ";
            $error_msg .= "Upload directory: " . $uploadDir . " ";
            $error_msg .= "Target path: " . $uploadPath . " ";
            $error_msg .= "Directory writable: " . (is_writable($uploadDir) ? 'Yes' : 'No') . " ";
            $error_msg .= "Directory exists: " . (is_dir($uploadDir) ? 'Yes' : 'No') . " ";
            $error_msg .= "Temp file exists: " . (file_exists($tmpName) ? 'Yes' : 'No') . " ";
            $error_msg .= "Last PHP error: " . error_get_last()['message'] ?? 'None';
            error_log("File upload failed: $error_msg");
            throw new Exception($error_msg);
        }
    }
    
    return $uploadedFilename;
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $jobType = $_POST['job_type'] ?? '';
    
    try {
        switch ($action) {
            case 'create':
                if ($jobType === 'administration') {
                    $data = [
                        'title' => $_POST['title'],
                        'grade' => $_POST['grade'],
                        'ccode' => $_POST['ccode'],
                        'division' => $_POST['division'],
                        'description' => $_POST['description'],
                        'filename' => $_POST['filename'] ?? null
                    ];
                    
                    // Handle file upload with job data
                    $uploadedFilename = handleFileUpload($jobType, $data);
                    if ($uploadedFilename) {
                        $data['filename'] = $uploadedFilename;
                    }
                    
                    $result = $jobModel->createAdminJob($data);
                    $success = $result ? "Administration job created successfully (ID: $result)" : "Failed to create administration job";
                } elseif ($jobType === 'licensed') {
                    $data = [
                        'title' => $_POST['title'],
                        'job_id' => $_POST['job_id'],
                        'category' => $_POST['category'],
                        'division' => $_POST['division'],
                        'certification_type' => $_POST['certification_type'],
                        'active' => $_POST['active'] ?? 'Y',
                        'salary_code' => $_POST['salary_code'] ?? null,
                        'filename' => $_POST['filename'] ?? null
                    ];
                    
                    // Handle file upload with job data
                    $uploadedFilename = handleFileUpload($jobType, $data);
                    if ($uploadedFilename) {
                        $data['filename'] = $uploadedFilename;
                    }
                    
                    $result = $jobModel->createLicensedJob($data);
                    $success = $result ? "Licensed job created successfully (ID: $result)" : "Failed to create licensed job";
                } elseif ($jobType === 'support') {
                    $data = [
                        'title' => $_POST['title'],
                        'grade' => $_POST['grade'] ?? null,
                        'job_code' => $_POST['job_code'] ?? null,
                        'department_code' => $_POST['department_code'] ?? null,
                        'union_code' => $_POST['union_code'] ?? null,
                        'filename' => $_POST['filename'] ?? null
                    ];
                    
                    // Handle file upload with job data
                    $uploadedFilename = handleFileUpload($jobType, $data);
                    if ($uploadedFilename) {
                        $data['filename'] = $uploadedFilename;
                    }
                    
                    $result = $jobModel->createSupportJob($data);
                    $success = $result ? "Support job created successfully (ID: $result)" : "Failed to create support job";
                }
                break;
                
            case 'update':
                $id = (int)$_POST['id'];
                if ($jobType === 'administration') {
                    $data = [
                        'title' => $_POST['title'],
                        'grade' => $_POST['grade'],
                        'ccode' => $_POST['ccode'],
                        'division' => $_POST['division'],
                        'description' => $_POST['description'],
                        'filename' => $_POST['filename'] ?? null
                    ];
                    
                    // Handle file upload with job data
                    $uploadedFilename = handleFileUpload($jobType, $data);
                    if ($uploadedFilename) {
                        $data['filename'] = $uploadedFilename;
                    }
                    
                    $result = $jobModel->updateAdminJob($id, $data);
                    $success = $result ? "Administration job updated successfully" : "Failed to update administration job";
                } elseif ($jobType === 'licensed') {
                    $data = [
                        'title' => $_POST['title'],
                        'job_id' => $_POST['job_id'],
                        'category' => $_POST['category'],
                        'division' => $_POST['division'],
                        'certification_type' => $_POST['certification_type'],
                        'active' => $_POST['active'] ?? 'Y',
                        'salary_code' => $_POST['salary_code'] ?? null,
                        'filename' => $_POST['filename'] ?? null
                    ];
                    
                    // Handle file upload with job data
                    $uploadedFilename = handleFileUpload($jobType, $data);
                    if ($uploadedFilename) {
                        $data['filename'] = $uploadedFilename;
                    }
                    
                    $result = $jobModel->updateLicensedJob($id, $data);
                    $success = $result ? "Licensed job updated successfully" : "Failed to update licensed job";
                } elseif ($jobType === 'support') {
                    $data = [
                        'title' => $_POST['title'],
                        'grade' => $_POST['grade'] ?? null,
                        'job_code' => $_POST['job_code'] ?? null,
                        'department_code' => $_POST['department_code'] ?? null,
                        'union_code' => $_POST['union_code'] ?? null,
                        'filename' => $_POST['filename'] ?? null
                    ];
                    
                    // Handle file upload with job data
                    $uploadedFilename = handleFileUpload($jobType, $data);
                    if ($uploadedFilename) {
                        $data['filename'] = $uploadedFilename;
                    }
                    
                    $result = $jobModel->updateSupportJob($id, $data);
                    $success = $result ? "Support job updated successfully" : "Failed to update support job";
                }
                break;
                
            case 'delete':
                $id = (int)$_POST['id'];
                if ($jobType === 'administration') {
                    $result = $jobModel->deleteAdminJob($id);
                    $success = $result ? "Administration job deleted successfully" : "Failed to delete administration job";
                } elseif ($jobType === 'licensed') {
                    $result = $jobModel->deleteLicensedJob($id);
                    $success = $result ? "Licensed job deleted successfully" : "Failed to delete licensed job";
                } elseif ($jobType === 'support') {
                    $result = $jobModel->deleteSupportJob($id);
                    $success = $result ? "Support job deleted successfully" : "Failed to delete support job";
                }
                break;
        }
    } catch (Exception $e) {
        $error = "Error: " . $e->getMessage();
    }
}

// Handle search and filter for admin interface
$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';
$filterType = isset($_GET['filter']) ? $_GET['filter'] : 'all';
$filterGrade = isset($_GET['grade']) ? $_GET['grade'] : '';
$filterCode = isset($_GET['code']) ? $_GET['code'] : '';
$filterDivision = isset($_GET['division']) ? $_GET['division'] : '';

// Get jobs for display
try {
    // Get filter options
    $filterOptions = $jobModel->getFilterOptions();
    
    // Get jobs based on search/filter
    if (!empty($searchTerm)) {
        $allJobs = $jobModel->searchAllJobs($searchTerm);
    } else {
        $allJobs = $jobModel->getAllJobs();
    }
    
    // Initialize empty arrays for job types that don't exist
    if (!isset($allJobs['administration'])) $allJobs['administration'] = [];
    if (!isset($allJobs['licensed'])) $allJobs['licensed'] = [];
    if (!isset($allJobs['support'])) $allJobs['support'] = [];
    
    // Apply job type filter if specified (keep all arrays but filter content)
    if ($filterType !== 'all') {
        $tempJobs = $allJobs;
        $allJobs = [
            'administration' => [],
            'licensed' => [],
            'support' => []
        ];
        $allJobs[$filterType] = isset($tempJobs[$filterType]) ? $tempJobs[$filterType] : [];
    }
    
    // Apply additional filters (grade, code, division)
    if (!empty($filterGrade) || !empty($filterCode) || !empty($filterDivision)) {
        foreach ($allJobs as $jobType => &$jobs) {
            $jobs = array_filter($jobs, function($job) use ($filterGrade, $filterCode, $filterDivision) {
                $gradeMatch = empty($filterGrade) || (isset($job['grade']) && $job['grade'] === $filterGrade);
                
                $codeMatch = empty($filterCode) || 
                           (isset($job['ccode']) && $job['ccode'] === $filterCode) ||
                           (isset($job['job_id']) && $job['job_id'] === $filterCode) ||
                           (isset($job['job_code']) && $job['job_code'] === $filterCode);
                
                $divisionMatch = empty($filterDivision) || (isset($job['division']) && $job['division'] === $filterDivision);
                
                return $gradeMatch && $codeMatch && $divisionMatch;
            });
        }
    }
    
    // Get total counts (always show full counts)
    $jobCounts = $jobModel->getAllJobsCounts();
    
    // Get specific job for editing if requested
    $editJob = null;
    $editType = '';
    if (isset($_GET['edit']) && isset($_GET['type'])) {
        $editId = (int)$_GET['edit'];
        $editType = $_GET['type'];
        
        if ($editType === 'administration') {
            $editJob = $jobModel->getAdminJobById($editId);
        } elseif ($editType === 'licensed') {
            $editJob = $jobModel->getLicensedJobById($editId);
        } elseif ($editType === 'support') {
            $editJob = $jobModel->getSupportJobById($editId);
        }
    }
} catch (Exception $e) {
    $error = "Error loading jobs: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Management - CCSD Admin</title>
    <link rel="stylesheet" href="../styles.css">
    <style>
        /* Admin-specific styles to extend the main design */
        .admin-nav {
            background: #fff;
            padding: 15px 20px;
            border-radius: 8px;
            margin: 20px 100px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .admin-nav a {
            color: #007bbf;
            text-decoration: none;
            margin-right: 20px;
            font-weight: 500;
            padding: 8px 16px;
            border-radius: 5px;
            transition: all 0.3s ease;
        }
        .admin-nav a:hover {
            background: #e3f2fd;
            color: #005a8a;
        }
        .form-section {
            background: white;
            border-radius: 8px;
            padding: 30px;
            margin: 20px 100px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .form-section h2 {
            color: #2c3e50;
            border-bottom: 3px solid #3498db;
            padding-bottom: 10px;
            margin-bottom: 30px;
            margin-top: 0;
        }
        .form-row {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
            flex-wrap: wrap;
        }
        .form-group {
            flex: 1;
            min-width: 200px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #2c3e50;
            font-size: 14px;
        }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s ease;
            box-sizing: border-box;
        }
        .form-group input[type="file"] {
            padding: 8px;
            border: 2px dashed #ddd;
            background: #f9f9f9;
        }
        .form-group input[type="file"]:hover {
            border-color: #3498db;
            background: #f0f9ff;
        }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }
        .form-group textarea {
            height: 80px;
            resize: vertical;
        }
        .btn {
            padding: 12px 20px;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-right: 10px;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background: #2980b9;
            text-decoration: none;
            color: white;
        }
        .btn-danger {
            background: #e74c3c;
        }
        .btn-danger:hover {
            background: #c0392b;
        }
        .btn-secondary {
            background: #95a5a6;
        }
        .btn-secondary:hover {
            background: #7f8c8d;
        }
        .jobs-list {
            background: white;
            border-radius: 8px;
            padding: 30px;
            margin: 20px 100px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .jobs-list h2 {
            color: #2c3e50;
            border-bottom: 3px solid #3498db;
            padding-bottom: 10px;
            margin-bottom: 20px;
            margin-top: 0;
        }
        .job-actions {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #e2e8f0;
            text-align: center;
        }
        .job-actions .btn {
            padding: 8px 15px;
            font-size: 14px;
            margin: 0 5px;
        }
        
        /* Reset job items padding since buttons are no longer at top */
        .jobs-container .job-item {
            padding: 20px;
            min-height: auto;
        }
        
        /* Override main site's 4-column layout to use 3 columns in admin */
        .jobs-container {
            grid-template-columns: repeat(3, 1fr) !important;
        }
        .alert {
            padding: 15px 20px;
            border-radius: 5px;
            margin: 20px 100px;
            border-left: 4px solid;
        }
        .alert-success {
            background: #d4edda;
            border-left-color: #27ae60;
            color: #155724;
        }
        .alert-error {
            background: #f8d7da;
            border-left-color: #e74c3c;
            color: #721c24;
        }
        .tabs {
            margin-bottom: 20px;
        }
        .tab-buttons {
            display: flex;
            border-bottom: 3px solid #ddd;
            margin-bottom: 20px;
            background: #f8f9fa;
            border-radius: 8px 8px 0 0;
        }
        .tab-button {
            background: none;
            border: none;
            padding: 15px 25px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            color: #666;
            border-radius: 8px 8px 0 0;
            transition: all 0.3s ease;
            flex: 1;
            text-align: center;
        }
        .tab-button:hover {
            background: #e9ecef;
            color: #2c3e50;
        }
        .tab-button.active {
            background: #fff;
            color: #2c3e50;
            border-bottom: 3px solid #3498db;
            margin-bottom: -3px;
        }
        .tab-content {
            display: none;
            padding: 20px 0;
            animation: fadeIn 0.3s ease-in;
        }
        .tab-content.active {
            display: block;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .job-type-selector {
            margin-bottom: 20px;
        }
        .job-type-selector label {
            font-weight: bold;
            color: #2c3e50;
            font-size: 14px;
        }
        
        /* Search and filter status styling */
        .search-status, .filter-status {
            background: #e3f2fd;
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
            border-left: 4px solid #2196f3;
        }
        
        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .admin-nav, .form-section, .jobs-list, .alert {
                margin: 20px 20px;
            }
            
            .form-row {
                flex-direction: column;
            }
            
            .tab-buttons {
                flex-direction: column;
            }
            
            .tab-button {
                border-radius: 0;
                border-bottom: 1px solid #ddd;
            }
            
            .tab-button:last-child {
                border-bottom: none;
            }
            
            .tab-button.active {
                border-bottom: none;
                border-left: 4px solid #3498db;
                margin-bottom: 0;
                margin-left: -4px;
            }
        }
    </style>
</head>
<body>
    <!-- Top Navigation Bar -->
    <nav class="top-navbar">
        <div class="nav-container">
            <div class="nav-logo">
                <img src="../img/ccsd-main-logo-white.png" alt="CCSD Logo" class="logo">
            </div>
            
            <div class="nav-menu">
                <ul class="nav-utility">
                    <li><a href="../index.php" class="utility-link">← Job Search</a></li>
<!--                    <li><a href="#" class="utility-link">Admin Panel</a></li>-->
                </ul>
            </div>
        </div>
    </nav>

    <div class="main-content" style="margin-left:100px; margin-right: 100px;">
        <div style="padding-top:20px;">
            <h1>CCSD Job Management System Admin Panel</h1>
        </div>

        <div class="admin-nav">
            <a href="../index.php">← Back to Job Search</a>
            <a href="#create">Create Job</a>
            <a href="#manage">Manage Jobs</a>
        </div>
        
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <!-- Job Creation/Edit Form -->
        <div class="form-section" id="create">
            <h2><?php echo $editJob ? 'Edit Job' : 'Create New Job'; ?></h2>
            
            <form method="POST" action="" enctype="multipart/form-data">
                <input type="hidden" name="action" value="<?php echo $editJob ? 'update' : 'create'; ?>">
                <?php if ($editJob): ?>
                    <input type="hidden" name="id" value="<?php echo $editJob['id']; ?>">
                <?php endif; ?>
                
                <div class="job-type-selector">
                    <label for="job_type">Job Type:</label>
                    <select name="job_type" id="job_type" required onchange="toggleFormFields()">
                        <option value="">Select Job Type</option>
                        <option value="administration" <?php echo ($editType === 'administration') ? 'selected' : ''; ?>>Administration</option>
                        <option value="licensed" <?php echo ($editType === 'licensed') ? 'selected' : ''; ?>>Licensed</option>
                        <option value="support" <?php echo ($editType === 'support') ? 'selected' : ''; ?>>Support</option>
                    </select>
                </div>
                
                <!-- Common Fields -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="title">Title *</label>
                        <input type="text" name="title" id="title" required value="<?php echo $editJob ? htmlspecialchars($editJob['title']) : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="filename">Current Filename</label>
                        <input type="text" name="filename" id="filename" value="<?php echo $editJob ? htmlspecialchars($editJob['filename'] ?? '') : ''; ?>" placeholder="No file uploaded yet" readonly>
                    </div>
                </div>
                
                <!-- File Upload -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="job_file"><?php echo $editJob ? 'Replace File (Optional)' : 'Upload File (Optional)'; ?></label>
                        <input type="file" name="job_file" id="job_file" accept=".pdf,.doc,.docx">
                        <small style="color: #666; font-size: 12px; display: block; margin-top: 5px;">
                            Accepted formats: PDF, DOC, DOCX. Maximum size: 10MB.
                            <?php if ($editJob && $editJob['filename']): ?>
                                <br>Current file: <?php echo htmlspecialchars($editJob['filename']); ?>
                            <?php endif; ?>
                        </small>
                    </div>
                </div>
                
                <!-- Administration Fields -->
                <div id="admin-fields" style="display: none;">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="grade">Grade *</label>
                            <input type="text" name="grade" id="grade" value="<?php echo ($editType === 'administration' && $editJob) ? htmlspecialchars($editJob['grade']) : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label for="ccode">Code *</label>
                            <input type="text" name="ccode" id="ccode" value="<?php echo ($editType === 'administration' && $editJob) ? htmlspecialchars($editJob['ccode']) : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label for="division">Division *</label>
                            <input type="text" name="division" id="division" value="<?php echo ($editType === 'administration' && $editJob) ? htmlspecialchars($editJob['division']) : ''; ?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="description">Description *</label>
                            <textarea name="description" id="description"><?php echo ($editType === 'administration' && $editJob) ? htmlspecialchars($editJob['description']) : ''; ?></textarea>
                        </div>
                    </div>
                </div>
                
                <!-- Licensed Fields -->
                <div id="licensed-fields" style="display: none;">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="job_id">Job ID *</label>
                            <input type="text" name="job_id" id="job_id" value="<?php echo ($editType === 'licensed' && $editJob) ? htmlspecialchars($editJob['job_id']) : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label for="category">Category *</label>
                            <input type="text" name="category" id="category" value="<?php echo ($editType === 'licensed' && $editJob) ? htmlspecialchars($editJob['category']) : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label for="division_licensed">Division *</label>
                            <input type="text" name="division" id="division_licensed" value="<?php echo ($editType === 'licensed' && $editJob) ? htmlspecialchars($editJob['division']) : ''; ?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="certification_type">Certification Type *</label>
                            <input type="text" name="certification_type" id="certification_type" value="<?php echo ($editType === 'licensed' && $editJob) ? htmlspecialchars($editJob['certification_type']) : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label for="active">Active</label>
                            <select name="active" id="active">
                                <option value="Y" <?php echo ($editType === 'licensed' && $editJob && $editJob['active'] === 'Y') ? 'selected' : ''; ?>>Yes</option>
                                <option value="N" <?php echo ($editType === 'licensed' && $editJob && $editJob['active'] === 'N') ? 'selected' : ''; ?>>No</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="salary_code">Salary Code</label>
                            <input type="text" name="salary_code" id="salary_code" value="<?php echo ($editType === 'licensed' && $editJob) ? htmlspecialchars($editJob['salary_code'] ?? '') : ''; ?>">
                        </div>
                    </div>
                </div>
                
                <!-- Support Fields -->
                <div id="support-fields" style="display: none;">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="grade_support">Grade</label>
                            <input type="text" name="grade" id="grade_support" value="<?php echo ($editType === 'support' && $editJob) ? htmlspecialchars($editJob['grade'] ?? '') : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label for="job_code">Job Code</label>
                            <input type="text" name="job_code" id="job_code" value="<?php echo ($editType === 'support' && $editJob) ? htmlspecialchars($editJob['job_code'] ?? '') : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label for="department_code">Department Code</label>
                            <input type="text" name="department_code" id="department_code" value="<?php echo ($editType === 'support' && $editJob) ? htmlspecialchars($editJob['department_code'] ?? '') : ''; ?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="union_code">Union Code</label>
                            <input type="text" name="union_code" id="union_code" value="<?php echo ($editType === 'support' && $editJob) ? htmlspecialchars($editJob['union_code'] ?? '') : ''; ?>">
                        </div>
                    </div>
                </div>
                
                <div class="form-row">
                    <button type="submit" class="btn"><?php echo $editJob ? 'Update Job' : 'Create Job'; ?></button>
                    <?php if ($editJob): ?>
                        <a href="index.php" class="btn btn-secondary">Cancel</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
        
        <!-- Search and Filter Form -->
        <div class='search-filter-container'>
            <form method='GET' action='' class='search-form'>
                <div class='search-input-group'>
                    <input type='text' name='search' placeholder='Search jobs by title, grade, division, code, etc...' value='<?php echo htmlspecialchars($searchTerm); ?>' class='search-input'>
                </div>
                
                <div class='filter-group'>
                    <label for='filter'>Filter by type:</label>
                    <select name='filter' id='filter' class='filter-select'>
                        <option value='all'<?php echo ($filterType === 'all' ? ' selected' : ''); ?>>All Jobs</option>
                        <option value='administration'<?php echo ($filterType === 'administration' ? ' selected' : ''); ?>>Administration</option>
                        <option value='licensed'<?php echo ($filterType === 'licensed' ? ' selected' : ''); ?>>Licensed</option>
                        <option value='support'<?php echo ($filterType === 'support' ? ' selected' : ''); ?>>Support</option>
                    </select>
                </div>
                
                <div class='filter-group'>
                    <label for='grade'>Filter by grade:</label>
                    <select name='grade' id='grade' class='filter-select'>
                        <option value=''>All Grades</option>
                        <?php foreach ($filterOptions['grades'] as $grade): ?>
                            <option value='<?php echo htmlspecialchars($grade); ?>'<?php echo ($filterGrade === $grade) ? ' selected' : ''; ?>><?php echo htmlspecialchars($grade); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class='filter-group'>
                    <label for='code'>Filter by code:</label>
                    <select name='code' id='code' class='filter-select'>
                        <option value=''>All Codes</option>
                        <?php foreach ($filterOptions['codes'] as $code): ?>
                            <option value='<?php echo htmlspecialchars($code); ?>'<?php echo ($filterCode === $code) ? ' selected' : ''; ?>><?php echo htmlspecialchars($code); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class='filter-group'>
                    <label for='division'>Filter by division:</label>
                    <select name='division' id='division' class='filter-select'>
                        <option value=''>All Divisions</option>
                        <?php foreach ($filterOptions['divisions'] as $division): ?>
                            <option value='<?php echo htmlspecialchars($division); ?>'<?php echo ($filterDivision === $division) ? ' selected' : ''; ?>><?php echo htmlspecialchars($division); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class='button-group'>
                    <button type='submit' class='search-btn'>Search</button>
                    <?php if (!empty($searchTerm) || $filterType !== 'all' || !empty($filterGrade) || !empty($filterCode) || !empty($filterDivision)): ?>
                        <a href='index.php' class='clear-filters'>Clear Filters</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
        
        <!-- Job Management -->
        <div class="jobs-list" id="manage">
            <h2>Manage Jobs</h2>
            
            <?php
            // Show search/filter status
            if (!empty($searchTerm)): ?>
                <p class='search-status'><strong>Search results for:</strong> "<?php echo htmlspecialchars($searchTerm); ?>"</p>
            <?php endif; ?>
            
            <?php if ($filterType !== 'all'): ?>
                <p class='filter-status'><strong>Filtered by:</strong> <?php echo ucfirst($filterType); ?> Jobs</p>
            <?php endif; ?>
            
            <?php
            // Calculate filtered counts
            $currentCounts = [
                'administration' => isset($allJobs['administration']) ? count($allJobs['administration']) : 0,
                'licensed' => isset($allJobs['licensed']) ? count($allJobs['licensed']) : 0,
                'support' => isset($allJobs['support']) ? count($allJobs['support']) : 0
            ];
            $currentTotal = $currentCounts['administration'] + $currentCounts['licensed'] + $currentCounts['support'];
            
            if (!empty($searchTerm) || $filterType !== 'all' || !empty($filterGrade) || !empty($filterCode) || !empty($filterDivision)): ?>
                <p><strong>Results Found:</strong></p>
                <?php if ($currentCounts['administration'] > 0): ?>
                    <p>Administration Jobs: <?php echo $currentCounts['administration']; ?></p>
                <?php endif; ?>
                <?php if ($currentCounts['licensed'] > 0): ?>
                    <p>Licensed Jobs: <?php echo $currentCounts['licensed']; ?></p>
                <?php endif; ?>
                <?php if ($currentCounts['support'] > 0): ?>
                    <p>Support Jobs: <?php echo $currentCounts['support']; ?></p>
                <?php endif; ?>
                <p><strong>Total Results: <?php echo $currentTotal; ?></strong></p>
                <hr>
                <p><em>Total Available Jobs:</em></p>
            <?php endif; ?>
            
            <p>Total Jobs: <?php echo $jobCounts['total']; ?> | Administration: <?php echo $jobCounts['administration']; ?> | Licensed: <?php echo $jobCounts['licensed']; ?> | Support: <?php echo $jobCounts['support']; ?></p>
            
            <div class="tabs">
                <div class="tab-buttons">
                    <button class="tab-button active" onclick="switchTab('administration')">Administration (<?php echo count($allJobs['administration']); ?>)</button>
                    <button class="tab-button" onclick="switchTab('licensed')">Licensed (<?php echo count($allJobs['licensed']); ?>)</button>
                    <button class="tab-button" onclick="switchTab('support')">Support (<?php echo count($allJobs['support']); ?>)</button>
                </div>
                
                <div id="administration-tab" class="tab-content active">
                    <div class="jobs-container">
                        <?php foreach ($allJobs['administration'] as $job): ?>
                            <div class="job-item admin-job">
                                <h3><?php echo htmlspecialchars($job['title']); ?></h3>
                                <p><strong>ID:</strong> <?php echo $job['id']; ?></p>
                                <p><strong>Grade:</strong> <?php echo htmlspecialchars($job['grade']); ?></p>
                                <p><strong>Code:</strong> <?php echo htmlspecialchars($job['ccode']); ?></p>
                                <p><strong>Division:</strong> <?php echo htmlspecialchars($job['division']); ?></p>
                                <p><strong>Description:</strong> <?php echo htmlspecialchars($job['description']); ?></p>
                                <?php if ($job['filename']): ?>
                                    <p><strong>File:</strong> 
                                        <a href="../files/administration/<?php echo htmlspecialchars($job['filename']); ?>" 
                                           target="_blank" style="color: #3498db; text-decoration: none;">
                                            <?php echo htmlspecialchars($job['filename']); ?>
                                        </a>
                                    </p>
                                <?php endif; ?>
                                <span class='job-type'>Administration</span>
                                <div class="job-actions">
                                    <a href="?edit=<?php echo $job['id']; ?>&type=administration" class="btn btn-secondary">Edit</a>
                                    <form method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this job?');">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="job_type" value="administration">
                                        <input type="hidden" name="id" value="<?php echo $job['id']; ?>">
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php if (empty($allJobs['administration'])): ?>
                        <p style="text-align: center; color: #666; padding: 40px;">No administration jobs found.</p>
                    <?php endif; ?>
                </div>
                
                <div id="licensed-tab" class="tab-content">
                    <div class="jobs-container">
                        <?php foreach ($allJobs['licensed'] as $job): ?>
                            <div class="job-item licensed-job">
                                <h3><?php echo htmlspecialchars($job['title']); ?></h3>
                                <p><strong>ID:</strong> <?php echo $job['id']; ?></p>
                                <p><strong>Job ID:</strong> <?php echo htmlspecialchars($job['job_id']); ?></p>
                                <p><strong>Category:</strong> <?php echo htmlspecialchars($job['category']); ?></p>
                                <p><strong>Division:</strong> <?php echo htmlspecialchars($job['division']); ?></p>
                                <p><strong>Certification:</strong> <?php echo htmlspecialchars($job['certification_type']); ?></p>
                                <p><strong>Active:</strong> <?php echo htmlspecialchars($job['active']); ?></p>
                                <?php if ($job['salary_code']): ?>
                                    <p><strong>Salary Code:</strong> <?php echo htmlspecialchars($job['salary_code']); ?></p>
                                <?php endif; ?>
                                <?php if ($job['filename']): ?>
                                    <p><strong>File:</strong> 
                                        <a href="../files/licensed/<?php echo htmlspecialchars($job['filename']); ?>" 
                                           target="_blank" style="color: #3498db; text-decoration: none;">
                                            <?php echo htmlspecialchars($job['filename']); ?>
                                        </a>
                                    </p>
                                <?php endif; ?>
                                <span class='job-type'>Licensed</span>
                                <div class="job-actions">
                                    <a href="?edit=<?php echo $job['id']; ?>&type=licensed" class="btn btn-secondary">Edit</a>
                                    <form method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this job?');">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="job_type" value="licensed">
                                        <input type="hidden" name="id" value="<?php echo $job['id']; ?>">
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php if (empty($allJobs['licensed'])): ?>
                        <p style="text-align: center; color: #666; padding: 40px;">No licensed jobs found.</p>
                    <?php endif; ?>
                </div>
                
                <div id="support-tab" class="tab-content">
                    <div class="jobs-container">
                        <?php foreach ($allJobs['support'] as $job): ?>
                            <div class="job-item support-job">
                                <h3><?php echo htmlspecialchars($job['title']); ?></h3>
                                <p><strong>ID:</strong> <?php echo $job['id']; ?></p>
                                <?php if ($job['grade']): ?>
                                    <p><strong>Grade:</strong> <?php echo htmlspecialchars($job['grade']); ?></p>
                                <?php endif; ?>
                                <?php if ($job['job_code']): ?>
                                    <p><strong>Job Code:</strong> <?php echo htmlspecialchars($job['job_code']); ?></p>
                                <?php endif; ?>
                                <?php if ($job['department_code']): ?>
                                    <p><strong>Department Code:</strong> <?php echo htmlspecialchars($job['department_code']); ?></p>
                                <?php endif; ?>
                                <?php if ($job['union_code']): ?>
                                    <p><strong>Union Code:</strong> <?php echo htmlspecialchars($job['union_code']); ?></p>
                                <?php endif; ?>
                                <?php if ($job['filename']): ?>
                                    <p><strong>File:</strong> 
                                        <a href="../files/support/<?php echo htmlspecialchars($job['filename']); ?>" 
                                           target="_blank" style="color: #3498db; text-decoration: none;">
                                            <?php echo htmlspecialchars($job['filename']); ?>
                                        </a>
                                    </p>
                                <?php endif; ?>
                                <span class='job-type'>Support</span>
                                <div class="job-actions">
                                    <a href="?edit=<?php echo $job['id']; ?>&type=support" class="btn btn-secondary">Edit</a>
                                    <form method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this job?');">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="job_type" value="support">
                                        <input type="hidden" name="id" value="<?php echo $job['id']; ?>">
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php if (empty($allJobs['support'])): ?>
                        <p style="text-align: center; color: #666; padding: 40px;">No support jobs found.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    </div> <!-- Close main-content -->
    
    <script>
        function toggleFormFields() {
            const jobType = document.getElementById('job_type').value;
            
            // Hide all field groups
            document.getElementById('admin-fields').style.display = 'none';
            document.getElementById('licensed-fields').style.display = 'none';
            document.getElementById('support-fields').style.display = 'none';
            
            // Show relevant fields
            if (jobType === 'administration') {
                document.getElementById('admin-fields').style.display = 'block';
            } else if (jobType === 'licensed') {
                document.getElementById('licensed-fields').style.display = 'block';
            } else if (jobType === 'support') {
                document.getElementById('support-fields').style.display = 'block';
            }
        }
        
        function switchTab(tabName) {
            // Hide all tab contents
            const tabContents = document.querySelectorAll('.tab-content');
            tabContents.forEach(content => content.classList.remove('active'));
            
            // Remove active class from all buttons
            const tabButtons = document.querySelectorAll('.tab-button');
            tabButtons.forEach(button => button.classList.remove('active'));
            
            // Show selected tab content
            document.getElementById(tabName + '-tab').classList.add('active');
            
            // Add active class to clicked button
            event.target.classList.add('active');
        }
        
        // Initialize form fields based on current selection
        document.addEventListener('DOMContentLoaded', function() {
            toggleFormFields();
        });
    </script>
</body>
</html>