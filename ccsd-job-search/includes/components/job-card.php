<?php
/**
 * Job Card Component
 * Renders a single job card with type-specific fields
 * 
 * @param array $job Job data array
 * @param string $job_type Job type (administration, licensed, support)
 * @param array $config Display configuration
 *   - show_actions: Whether to show edit/delete actions (default: false)
 *   - base_path: Base path for file links (default: '')
 *   - actions_config: Configuration for action buttons
 */

// Set default configuration
$default_config = [
    'show_actions' => false,
    'base_path' => '',
    'actions_config' => []
];

// Merge with provided config
$card_config = isset($card_config) ? array_merge($default_config, $card_config) : $default_config;

// Get job type class
$job_type_class = $job_type . '-job';
$job_type_display = ucfirst($job_type);
?>

<div class="job-item <?php echo htmlspecialchars($job_type_class); ?>">
    <h3><?php echo htmlspecialchars($job['title']); ?></h3>
    
    <?php if ($job_type === 'administration'): ?>
        <p><strong>Grade:</strong> <?php echo htmlspecialchars($job['grade']); ?></p>
        <p><strong>Code:</strong> <?php echo htmlspecialchars($job['ccode']); ?></p>
        <p><strong>Division:</strong> <?php echo htmlspecialchars($job['division']); ?></p>
        <p><strong>Description:</strong> <?php echo htmlspecialchars($job['description']); ?></p>
        
    <?php elseif ($job_type === 'licensed'): ?>
        <?php if (!empty($job['job_id'])): ?>
            <p><strong>Job ID:</strong> <?php echo htmlspecialchars($job['job_id']); ?></p>
        <?php endif; ?>
        <p><strong>Category:</strong> <?php echo htmlspecialchars($job['category']); ?></p>
        <p><strong>Division:</strong> <?php echo htmlspecialchars($job['division']); ?></p>
        <p><strong>Certification:</strong> <?php echo htmlspecialchars($job['certification_type']); ?></p>
        <p><strong>Active:</strong> <?php echo ($job['active'] == 1) ? 'Yes' : 'No'; ?></p>
        <?php if (!empty($job['salary_code'])): ?>
            <p><strong>Salary Code:</strong> <?php echo htmlspecialchars($job['salary_code']); ?></p>
        <?php endif; ?>
        
    <?php elseif ($job_type === 'support'): ?>
        <?php if (!empty($job['grade'])): ?>
            <p><strong>Grade:</strong> <?php echo htmlspecialchars($job['grade']); ?></p>
        <?php endif; ?>
        <?php if (!empty($job['job_code'])): ?>
            <p><strong>Job Code:</strong> <?php echo htmlspecialchars($job['job_code']); ?></p>
        <?php endif; ?>
        <?php if (!empty($job['department_code'])): ?>
            <p><strong>Department:</strong> <?php echo htmlspecialchars($job['department_code']); ?></p>
        <?php endif; ?>
        <?php if (!empty($job['union_code'])): ?>
            <p><strong>Union Code:</strong> <?php echo htmlspecialchars($job['union_code']); ?></p>
        <?php endif; ?>
    <?php endif; ?>
    
    <?php if (!empty($job['filename'])): ?>
        <p><strong>File:</strong> 
            <a href="<?php echo htmlspecialchars($card_config['base_path'] . 'files/' . $job_type . '/' . $job['filename']); ?>" 
               target="_blank" style="color: #3498db; text-decoration: underline;">
                <?php echo htmlspecialchars($job['filename']); ?>
            </a>
        </p>
    <?php endif; ?>
    
    <span class="job-type"><?php echo htmlspecialchars($job_type_display); ?></span>
    
    <?php if ($card_config['show_actions']): ?>
        <div class="job-actions">
            <a href="?action=edit&type=<?php echo urlencode($job_type); ?>&id=<?php echo urlencode($job['id']); ?>" class="btn btn-secondary">Edit</a>
            <a href="?action=delete&type=<?php echo urlencode($job_type); ?>&id=<?php echo urlencode($job['id']); ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this job?')">Delete</a>
        </div>
    <?php endif; ?>
</div>