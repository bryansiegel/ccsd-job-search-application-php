<?php
// Include configuration and dependencies
require_once '../includes/config/app-config.php';
require_once '../includes/db/mysql-connect.php';
require_once '../includes/db/model.php';
require_once '../includes/functions/file-upload.php';
require_once '../includes/functions/job-processing.php';

$jobModel = new JobModel($pdo);
$success = '';
$error = '';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $jobType = $_POST['job_type'] ?? '';
    
    try {
        switch ($action) {
            case 'create':
                // Sanitize job data
                $data = sanitizeJobData($_POST, $jobType);
                
                // Handle file upload
                $uploadedFilename = handleFileUpload($jobType, $data);
                if ($uploadedFilename) {
                    $data['filename'] = $uploadedFilename;
                }
                
                // Create job based on type
                switch ($jobType) {
                    case 'administration':
                        $result = $jobModel->createAdminJob($data);
                        break;
                    case 'licensed':
                        $result = $jobModel->createLicensedJob($data);
                        break;
                    case 'support':
                        $result = $jobModel->createSupportJob($data);
                        break;
                    default:
                        throw new Exception("Invalid job type: " . $jobType);
                }
                
                $success = $result ? getJobTypeDisplayName($jobType) . " job created successfully (ID: $result)" : "Failed to create " . getJobTypeDisplayName($jobType) . " job";
                break;
                
            case 'update':
                $id = (int)($_POST['job_id'] ?? $_POST['id']);
                $data = sanitizeJobData($_POST, $jobType);
                
                // Handle file upload
                $uploadedFilename = handleFileUpload($jobType, $data);
                if ($uploadedFilename) {
                    $data['filename'] = $uploadedFilename;
                }
                
                // Update job based on type
                switch ($jobType) {
                    case 'administration':
                        $result = $jobModel->updateAdminJob($id, $data);
                        break;
                    case 'licensed':
                        $result = $jobModel->updateLicensedJob($id, $data);
                        break;
                    case 'support':
                        $result = $jobModel->updateSupportJob($id, $data);
                        break;
                    default:
                        throw new Exception("Invalid job type: " . $jobType);
                }
                
                $success = $result ? getJobTypeDisplayName($jobType) . " job updated successfully" : "Failed to update " . getJobTypeDisplayName($jobType) . " job";
                break;
                
            case 'delete':
                $id = (int)($_GET['id'] ?? $_POST['id']);
                $jobType = $_GET['type'] ?? $_POST['job_type'];
                
                // Delete job based on type
                switch ($jobType) {
                    case 'administration':
                        $result = $jobModel->deleteAdminJob($id);
                        break;
                    case 'licensed':
                        $result = $jobModel->deleteLicensedJob($id);
                        break;
                    case 'support':
                        $result = $jobModel->deleteSupportJob($id);
                        break;
                    default:
                        throw new Exception("Invalid job type: " . $jobType);
                }
                
                $success = $result ? getJobTypeDisplayName($jobType) . " job deleted successfully" : "Failed to delete " . getJobTypeDisplayName($jobType) . " job";
                break;
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

// Handle GET actions (edit, delete)
$currentAction = $_GET['action'] ?? '';
$currentJobType = $_GET['type'] ?? 'administration';
$currentJobId = $_GET['id'] ?? '';
$editingJob = null;

if ($currentAction === 'edit' && $currentJobId) {
    try {
        switch ($currentJobType) {
            case 'administration':
                $editingJob = $jobModel->getAdminJobById($currentJobId);
                break;
            case 'licensed':
                $editingJob = $jobModel->getLicensedJobById($currentJobId);
                break;
            case 'support':
                $editingJob = $jobModel->getSupportJobById($currentJobId);
                break;
        }
    } catch (Exception $e) {
        $error = "Error loading job for editing: " . $e->getMessage();
    }
} elseif ($currentAction === 'delete' && $currentJobId) {
    // Handle delete confirmation
    try {
        switch ($currentJobType) {
            case 'administration':
                $result = $jobModel->deleteAdminJob($currentJobId);
                break;
            case 'licensed':
                $result = $jobModel->deleteLicensedJob($currentJobId);
                break;
            case 'support':
                $result = $jobModel->deleteSupportJob($currentJobId);
                break;
        }
        $success = $result ? getJobTypeDisplayName($currentJobType) . " job deleted successfully" : "Failed to delete job";
    } catch (Exception $e) {
        $error = "Error deleting job: " . $e->getMessage();
    }
}

// Get all jobs for display
try {
    $allJobs = $jobModel->getAllJobs();
    
    // Get request parameters for search/filter
    $requestParams = [
        'search' => isset($_GET['search']) ? trim($_GET['search']) : '',
        'filter' => isset($_GET['filter']) ? $_GET['filter'] : 'all',
        'grade' => isset($_GET['grade']) ? $_GET['grade'] : '',
        'code' => isset($_GET['code']) ? $_GET['code'] : '',
        'division' => isset($_GET['division']) ? $_GET['division'] : ''
    ];
    
    // Apply filters if any
    if (!empty($requestParams['search']) || $requestParams['filter'] !== 'all' || 
        !empty($requestParams['grade']) || !empty($requestParams['code']) || !empty($requestParams['division'])) {
        
        if (!empty($requestParams['search'])) {
            $allJobs = $jobModel->searchAllJobs($requestParams['search']);
        }
        
        $filters = [
            'type' => $requestParams['filter'],
            'grade' => $requestParams['grade'],
            'code' => $requestParams['code'],
            'division' => $requestParams['division']
        ];
        $allJobs = applyJobFilters($allJobs, $filters);
    }
    
    // Get filter options
    $filterOptions = $jobModel->getFilterOptions();
    
    // Get total counts for summary stats
    $job_counts = $jobModel->getAllJobsCounts();
    $current_counts = calculateCurrentCounts($allJobs);
    
    // Prepare search status
    $search_status = prepareSearchStatus($requestParams);
    
} catch (Exception $e) {
    $error = "Error loading jobs: " . $e->getMessage();
    $allJobs = ['administration' => [], 'licensed' => [], 'support' => []];
    $filterOptions = ['grades' => [], 'codes' => [], 'divisions' => []];
    $job_counts = ['administration' => 0, 'licensed' => 0, 'support' => 0, 'total' => 0];
    $current_counts = ['administration' => 0, 'licensed' => 0, 'support' => 0];
    $search_status = [];
}

// Navigation configuration
$nav_config = array_merge($default_nav_config, [
    'links' => $admin_nav_links,
    'base_path' => '../'
]);

// Search form configuration
$search_config = [
    'action' => '?',
    'method' => 'GET',
    'search_term' => $requestParams['search'],
    'filter_type' => $requestParams['filter'],
    'filter_grade' => $requestParams['grade'],
    'filter_code' => $requestParams['code'],
    'filter_division' => $requestParams['division'],
    'filter_options' => $filterOptions,
    'show_clear' => true
];

// Job tabs configuration
$tab_config = [
    'show_actions' => true,
    'base_path' => '../'
];

// Form configuration
$form_config = [
    'action' => '',
    'job_type' => $editingJob ? $currentJobType : 'administration',
    'job_data' => $editingJob ?: [],
    'is_edit' => !empty($editingJob)
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Management - <?php echo APP_NAME; ?></title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <?php include '../includes/components/navigation.php'; ?>

    <div class="main-content" style="margin-left:100px; margin-right: 100px;">
        <div style="padding-top:20px;">
            <h1><?php echo APP_NAME; ?> Admin Panel</h1>
        </div>

        <div class="admin-nav">
            <a href="../index.php">← Back to Job Search</a>
            <a href="#create">Create Job</a>
            <a href="#manage">Manage Jobs</a>
        </div>
        
        <?php 
        // Include summary statistics
        include '../includes/components/summary-stats.php'; 
        ?>
        
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <?php if (!empty($editingJob)): ?>
            <div class="alert alert-success">
                Editing <?php echo getJobTypeDisplayName($currentJobType); ?> job: <?php echo htmlspecialchars($editingJob['title'] ?? 'Unknown'); ?> (ID: <?php echo htmlspecialchars($currentJobId); ?>)
            </div>
        <?php endif; ?>
        
        <div id="create">
            <?php include '../includes/components/admin-form.php'; ?>
        </div>
        
        <div id="manage">
            <?php include '../includes/components/search-filter.php'; ?>
            
            <div class="jobs-list">
                <h2>Manage Jobs</h2>
                <?php 
                $jobs_data = $allJobs;
                include '../includes/components/job-tabs.php'; 
                ?>
            </div>
        </div>
    </div>
</body>
</html>