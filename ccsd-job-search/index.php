<?php
// Include configuration and dependencies
require_once 'includes/config/app-config.php';
require_once 'includes/db/mysql-connect.php';
require_once 'includes/db/model.php';
require_once 'includes/functions/job-processing.php';

try {
    // Create model instance
    $jobModel = new JobModel($pdo);
    
    // Get request parameters
    $requestParams = [
        'search' => isset($_GET['search']) ? trim($_GET['search']) : '',
        'filter' => isset($_GET['filter']) ? $_GET['filter'] : 'all',
        'grade' => isset($_GET['grade']) ? $_GET['grade'] : '',
        'code' => isset($_GET['code']) ? $_GET['code'] : '',
        'division' => isset($_GET['division']) ? $_GET['division'] : ''
    ];
    
    // Get filter options
    $filterOptions = $jobModel->getFilterOptions();
    
    // Get jobs based on search/filter
    if (!empty($requestParams['search'])) {
        $allJobs = $jobModel->searchAllJobs($requestParams['search']);
    } else {
        $allJobs = $jobModel->getAllJobs();
    }
    
    // Apply filters
    $filters = [
        'type' => $requestParams['filter'],
        'grade' => $requestParams['grade'],
        'code' => $requestParams['code'],
        'division' => $requestParams['division']
    ];
    $allJobs = applyJobFilters($allJobs, $filters);
    
    // Get counts
    $job_counts = $jobModel->getAllJobsCounts();
    $current_counts = calculateCurrentCounts($allJobs);
    
    // Prepare search status
    $search_status = prepareSearchStatus($requestParams);
    
} catch (Exception $e) {
    $error = "Error: " . $e->getMessage();
}

// Navigation configuration
$nav_config = array_merge($default_nav_config, [
    'links' => $public_nav_links
]);

// Search form configuration
$search_config = [
    'action' => '',
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
    'show_actions' => false,
    'base_path' => ''
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo APP_NAME; ?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'includes/components/navigation.php'; ?>

    <div class="main-content" style="margin-left:100px; margin-right: 100px;">
        <?php if (isset($error)): ?>
            <div style="color: red; text-align: center; margin: 20px;">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php else: ?>

            <div style="padding-top:20px;">
                <h1><?php echo APP_NAME; ?></h1>
            </div>
            
            <?php 
            // Include summary statistics
            include 'includes/components/summary-stats.php'; 
            ?>
            
            <?php 
            // Include search/filter form
            include 'includes/components/search-filter.php'; 
            ?>
            
            <?php 
            // Include job tabs
            $jobs_data = $allJobs;
            include 'includes/components/job-tabs.php'; 
            ?>

        <?php endif; ?>
    </div>
</body>
</html>