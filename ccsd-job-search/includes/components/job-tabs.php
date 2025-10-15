<?php
/**
 * Job Tabs Component
 * Renders tabbed interface for different job types
 * 
 * @param array $jobs_data Jobs data organized by type ['administration' => [], 'licensed' => [], 'support' => []]
 * @param array $tab_config Tab configuration
 *   - show_actions: Whether to show action buttons in job cards (default: false)
 *   - base_path: Base path for file links (default: '')
 */

// Set default configuration
$default_tab_config = [
    'show_actions' => false,
    'base_path' => ''
];

// Merge with provided config
$tab_config = isset($tab_config) ? array_merge($default_tab_config, $tab_config) : $default_tab_config;

// Ensure job arrays exist
$jobs_data = $jobs_data ?? [];
if (!isset($jobs_data['administration'])) $jobs_data['administration'] = [];
if (!isset($jobs_data['licensed'])) $jobs_data['licensed'] = [];
if (!isset($jobs_data['support'])) $jobs_data['support'] = [];
?>

<div class="tabs-container">
    <div class="tabs-nav">
        <button class="tab-btn active" data-tab="administration">
            Administration Jobs (<?php echo count($jobs_data['administration']); ?>)
        </button>
        <button class="tab-btn" data-tab="licensed">
            Licensed Jobs (<?php echo count($jobs_data['licensed']); ?>)
        </button>
        <button class="tab-btn" data-tab="support">
            Support Jobs (<?php echo count($jobs_data['support']); ?>)
        </button>
    </div>
    
    <!-- Administration Jobs Tab -->
    <div class="tab-content active" id="administration-tab">
        <div class="jobs-container">
            <?php foreach ($jobs_data['administration'] as $job): ?>
                <?php 
                $card_config = $tab_config;
                $job_type = 'administration';
                include __DIR__ . '/job-card.php'; 
                ?>
            <?php endforeach; ?>
        </div>
    </div>
    
    <!-- Licensed Jobs Tab -->
    <div class="tab-content" id="licensed-tab">
        <div class="jobs-container">
            <?php foreach ($jobs_data['licensed'] as $job): ?>
                <?php 
                $card_config = $tab_config;
                $job_type = 'licensed';
                include __DIR__ . '/job-card.php'; 
                ?>
            <?php endforeach; ?>
        </div>
    </div>
    
    <!-- Support Jobs Tab -->
    <div class="tab-content" id="support-tab">
        <div class="jobs-container">
            <?php foreach ($jobs_data['support'] as $job): ?>
                <?php 
                $card_config = $tab_config;
                $job_type = 'support';
                include __DIR__ . '/job-card.php'; 
                ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabBtns = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');
    
    tabBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const targetTab = this.getAttribute('data-tab');
            
            // Remove active class from all buttons and contents
            tabBtns.forEach(b => b.classList.remove('active'));
            tabContents.forEach(c => c.classList.remove('active'));
            
            // Add active class to clicked button and corresponding content
            this.classList.add('active');
            document.getElementById(targetTab + '-tab').classList.add('active');
        });
    });
});
</script>