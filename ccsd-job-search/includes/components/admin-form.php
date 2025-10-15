<?php
/**
 * Admin Job Form Component
 * Renders job creation/editing form with dynamic fields based on job type
 * 
 * @param array $form_config Form configuration
 *   - action: Form action URL
 *   - job_type: Current job type (administration, licensed, support)
 *   - job_data: Existing job data for editing (empty for new jobs)
 *   - is_edit: Whether this is an edit form
 */

// Set default configuration
$default_form_config = [
    'action' => '',
    'job_type' => 'administration',
    'job_data' => [],
    'is_edit' => false
];

// Merge with provided config
$form_config = isset($form_config) ? array_merge($default_form_config, $form_config) : $default_form_config;

$job_type = $form_config['job_type'];
$job_data = $form_config['job_data'];
$is_edit = $form_config['is_edit'];
?>

<div class="form-section">
    <h2><?php echo $is_edit ? 'Edit' : 'Create New'; ?> Job</h2>
    
    <form action="<?php echo htmlspecialchars($form_config['action']); ?>" method="post" enctype="multipart/form-data">
        <?php if ($is_edit): ?>
            <input type="hidden" name="action" value="update">
            <input type="hidden" name="job_type" value="<?php echo htmlspecialchars($job_type); ?>">
            <input type="hidden" name="job_id" value="<?php echo htmlspecialchars($job_data['id'] ?? ''); ?>">
        <?php else: ?>
            <input type="hidden" name="action" value="create">
        <?php endif; ?>
        
        <?php if (!$is_edit): ?>
            <div class="job-type-selector">
                <label for="job_type">Job Type:</label>
                <select name="job_type" id="job_type" onchange="updateFormFields()" required>
                    <option value="administration"<?php echo ($job_type === 'administration' ? ' selected' : ''); ?>>Administration</option>
                    <option value="licensed"<?php echo ($job_type === 'licensed' ? ' selected' : ''); ?>>Licensed</option>
                    <option value="support"<?php echo ($job_type === 'support' ? ' selected' : ''); ?>>Support</option>
                </select>
            </div>
        <?php endif; ?>
        
        <!-- Common Fields -->
        <div class="form-row">
            <div class="form-group">
                <label for="title">Job Title *</label>
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($job_data['title'] ?? ''); ?>" required>
            </div>
        </div>
        
        <!-- Administration Fields -->
        <div id="administration-fields" class="job-type-fields" style="display: <?php echo ($job_type === 'administration' ? 'block' : 'none'); ?>"><?php if ($is_edit) echo "<!-- Edit mode: $job_type -->"; ?>
            <div class="form-row">
                <div class="form-group">
                    <label for="grade">Grade *</label>
                    <input type="text" id="grade" name="grade" value="<?php echo htmlspecialchars($job_data['grade'] ?? ''); ?>" <?php echo ($job_type === 'administration' ? 'required' : ''); ?>>
                </div>
                <div class="form-group">
                    <label for="ccode">Code *</label>
                    <input type="text" id="ccode" name="ccode" value="<?php echo htmlspecialchars($job_data['ccode'] ?? ''); ?>" <?php echo ($job_type === 'administration' ? 'required' : ''); ?>>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="division">Division *</label>
                    <input type="text" id="division" name="division" value="<?php echo htmlspecialchars($job_data['division'] ?? ''); ?>" <?php echo ($job_type === 'administration' ? 'required' : ''); ?>>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="description">Description *</label>
                    <textarea id="description" name="description" <?php echo ($job_type === 'administration' ? 'required' : ''); ?>><?php echo htmlspecialchars($job_data['description'] ?? ''); ?></textarea>
                </div>
            </div>
        </div>
        
        <!-- Licensed Fields -->
        <div id="licensed-fields" class="job-type-fields" style="display: <?php echo ($job_type === 'licensed' ? 'block' : 'none'); ?>">
            <div class="form-row">
                <div class="form-group">
                    <label for="job_id">Job ID *</label>
                    <input type="text" id="job_id" name="job_id" value="<?php echo htmlspecialchars($job_data['job_id'] ?? ''); ?>" <?php echo ($job_type === 'licensed' ? 'required' : ''); ?>>
                </div>
                <div class="form-group">
                    <label for="category">Category *</label>
                    <input type="text" id="category" name="category" value="<?php echo htmlspecialchars($job_data['category'] ?? ''); ?>" <?php echo ($job_type === 'licensed' ? 'required' : ''); ?>>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="licensed_division">Division *</label>
                    <input type="text" id="licensed_division" name="division" value="<?php echo htmlspecialchars($job_data['division'] ?? ''); ?>" <?php echo ($job_type === 'licensed' ? 'required' : ''); ?>>
                </div>
                <div class="form-group">
                    <label for="certification_type">Certification Type *</label>
                    <input type="text" id="certification_type" name="certification_type" value="<?php echo htmlspecialchars($job_data['certification_type'] ?? ''); ?>" <?php echo ($job_type === 'licensed' ? 'required' : ''); ?>>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="active">Active</label>
                    <select id="active" name="active">
                        <?php 
                        // Convert database integer values (1/0) back to Y/N for display
                        $activeValue = 'Y'; // default
                        if (isset($job_data['active'])) {
                            $activeValue = ($job_data['active'] == 1) ? 'Y' : 'N';
                        }
                        ?>
                        <option value="Y"<?php echo ($activeValue === 'Y' ? ' selected' : ''); ?>>Yes</option>
                        <option value="N"<?php echo ($activeValue === 'N' ? ' selected' : ''); ?>>No</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="salary_code">Salary Code</label>
                    <input type="text" id="salary_code" name="salary_code" value="<?php echo htmlspecialchars($job_data['salary_code'] ?? ''); ?>">
                </div>
            </div>
        </div>
        
        <!-- Support Fields -->
        <div id="support-fields" class="job-type-fields" style="display: <?php echo ($job_type === 'support' ? 'block' : 'none'); ?>">
            <div class="form-row">
                <div class="form-group">
                    <label for="support_grade">Grade</label>
                    <input type="text" id="support_grade" name="grade" value="<?php echo htmlspecialchars($job_data['grade'] ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label for="job_code">Job Code</label>
                    <input type="text" id="job_code" name="job_code" value="<?php echo htmlspecialchars($job_data['job_code'] ?? ''); ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="department_code">Department Code</label>
                    <input type="text" id="department_code" name="department_code" value="<?php echo htmlspecialchars($job_data['department_code'] ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label for="union_code">Union Code</label>
                    <input type="text" id="union_code" name="union_code" value="<?php echo htmlspecialchars($job_data['union_code'] ?? ''); ?>">
                </div>
            </div>
        </div>
        
        <!-- File Upload -->
        <div class="form-row">
            <div class="form-group">
                <label for="job_file">Job Description File (PDF, DOC, DOCX - Max 10MB)</label>
                <input type="file" id="job_file" name="job_file" accept=".pdf,.doc,.docx">
                <?php if (!empty($job_data['filename'])): ?>
                    <p>Current file: <strong><?php echo htmlspecialchars($job_data['filename']); ?></strong></p>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="form-row">
            <button type="submit" class="btn"><?php echo $is_edit ? 'Update' : 'Create'; ?> Job</button>
            <?php if ($is_edit): ?>
                <a href="?" class="btn btn-secondary">Cancel</a>
            <?php endif; ?>
        </div>
    </form>
</div>

<script>
function updateFormFields() {
    // Get job type from selector or from hidden input for edit mode
    let jobType;
    const jobTypeSelect = document.getElementById('job_type');
    if (jobTypeSelect) {
        jobType = jobTypeSelect.value;
    } else {
        // In edit mode, get job type from hidden input
        const hiddenJobType = document.querySelector('input[name="job_type"]');
        jobType = hiddenJobType ? hiddenJobType.value : 'administration';
    }
    
    const allFields = document.querySelectorAll('.job-type-fields');
    
    // Hide all fields and disable their inputs
    allFields.forEach(field => {
        field.style.display = 'none';
        // Disable all inputs in hidden sections to prevent conflicts
        const inputs = field.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.disabled = true;
        });
    });
    
    // Show relevant fields and enable their inputs
    const relevantFields = document.getElementById(jobType + '-fields');
    if (relevantFields) {
        relevantFields.style.display = 'block';
        // Enable all inputs in the visible section
        const inputs = relevantFields.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.disabled = false;
        });
    }
    
    // Also always enable the common title field
    const titleField = document.getElementById('title');
    if (titleField) {
        titleField.disabled = false;
    }
    
    // Update required attributes
    updateRequiredFields(jobType);
}

function updateRequiredFields(jobType) {
    // Remove all required attributes first from all fields
    document.querySelectorAll('.job-type-fields input, .job-type-fields textarea, .job-type-fields select').forEach(field => {
        field.removeAttribute('required');
    });
    
    // Add required attributes based on job type only to enabled fields
    const requiredFields = {
        administration: ['grade', 'ccode', 'division', 'description'],
        licensed: ['job_id', 'category', 'licensed_division', 'certification_type'],
        support: [] // No additional required fields for support
    };
    
    if (requiredFields[jobType]) {
        requiredFields[jobType].forEach(fieldName => {
            const field = document.getElementById(fieldName);
            if (field && !field.disabled) {
                field.setAttribute('required', 'required');
            }
        });
    }
}

// Initialize form on page load
document.addEventListener('DOMContentLoaded', function() {
    updateFormFields();
    
    // Debug: log form configuration for troubleshooting
    console.log('Form initialized:', {
        isEdit: <?php echo json_encode($is_edit); ?>,
        jobType: '<?php echo $job_type; ?>',
        hasJobData: <?php echo json_encode(!empty($job_data)); ?>
    });
});
</script>