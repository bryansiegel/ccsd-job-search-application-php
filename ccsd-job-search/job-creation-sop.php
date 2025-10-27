<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Creation SOP - CCSD Job Search Portal</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .sop-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .sop-header {
            text-align: center;
            margin-bottom: 30px;
            color: #2c3e50;
        }
        .step {
            margin: 20px 0;
            padding: 15px;
            border-left: 4px solid #3498db;
            background: #f8f9fa;
        }
        .step-number {
            font-weight: bold;
            color: #3498db;
            font-size: 1.2em;
        }
        .step-title {
            font-weight: bold;
            margin: 5px 0;
            color: #2c3e50;
        }
        .step-description {
            margin: 10px 0;
            line-height: 1.6;
        }
        .note {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            padding: 10px;
            border-radius: 4px;
            margin: 10px 0;
        }
        .warning {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            padding: 10px;
            border-radius: 4px;
            margin: 10px 0;
        }
        .field-list {
            list-style-type: none;
            padding-left: 20px;
        }
        .field-list li {
            margin: 5px 0;
        }
        .required {
            color: #e74c3c;
            font-weight: bold;
        }
        .navigation-links {
            text-align: center;
            margin: 30px 0;
        }
        .navigation-links a {
            display: inline-block;
            margin: 0 15px;
            padding: 10px 20px;
            background: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            transition: background 0.3s;
        }
        .navigation-links a:hover {
            background: #2980b9;
        }
    </style>
</head>
<body>
    <div class="sop-container">
        <div class="sop-header">
            <h1>Job Creation Standard Operating Procedure</h1>
            <p>CCSD Job Search Portal - Administrative Guide</p>
        </div>

        <div class="step">
            <div class="step-number">Step 1</div>
            <div class="step-title">Access the Admin Interface</div>
            <div class="step-description">
                Navigate to the admin panel at: <strong>yoursite.com/ccsd-job-search/admin/</strong>
                <div class="note">
                    <strong>Note:</strong> Ensure you have proper administrative access before proceeding.
                </div>
            </div>
        </div>

        <div class="step">
            <div class="step-number">Step 2</div>
            <div class="step-title">Select Job Type</div>
            <div class="step-description">
                Choose the appropriate job type from the dropdown menu:
                <ul>
                    <li><strong>Administration</strong> - For administrative positions (principals, directors, etc.)</li>
                    <li><strong>Licensed</strong> - For licensed teaching positions</li>
                    <li><strong>Support</strong> - For support staff positions</li>
                </ul>
            </div>
        </div>

        <div class="step">
            <div class="step-number">Step 3</div>
            <div class="step-title">Fill Out Job Information</div>
            <div class="step-description">
                Complete all required fields based on the selected job type:

                <h4>Administration Jobs:</h4>
                <ul class="field-list">
                    <li><span class="required">*</span> Job Title</li>
                    <li>Grade (e.g., A100, A200)</li>
                    <li>Classification Code (CCODE)</li>
                    <li>Division</li>
                    <li>Job Description</li>
                </ul>

                <h4>Licensed Jobs:</h4>
                <ul class="field-list">
                    <li><span class="required">*</span> Job Title</li>
                    <li>Job ID</li>
                    <li>Category</li>
                    <li>Division</li>
                    <li>Certification Type</li>
                    <li>Salary Code</li>
                    <li>Active Status</li>
                </ul>

                <h4>Support Jobs:</h4>
                <ul class="field-list">
                    <li><span class="required">*</span> Job Title</li>
                    <li>Grade</li>
                    <li>Job Code</li>
                    <li>Department Code</li>
                    <li>Union Code</li>
                </ul>

                <div class="note">
                    <strong>Required Fields:</strong> Fields marked with <span class="required">*</span> are required and must be completed.
                </div>
            </div>
        </div>

        <div class="step">
            <div class="step-number">Step 4</div>
            <div class="step-title">Upload Job Description File</div>
            <div class="step-description">
                Upload the job description document:
                <ul>
                    <li><strong>Accepted formats:</strong> PDF, DOC, DOCX</li>
                    <li><strong>Maximum file size:</strong> 10MB</li>
                    <li><strong>File naming:</strong> Files will be automatically renamed based on job codes</li>
                </ul>
                
                <div class="warning">
                    <strong>Important:</strong> Ensure the file contains the complete job description and requirements.
                </div>
            </div>
        </div>

        <div class="step">
            <div class="step-number">Step 5</div>
            <div class="step-title">Review and Submit</div>
            <div class="step-description">
                <ol>
                    <li>Review all entered information for accuracy</li>
                    <li>Verify the uploaded file is correct</li>
                    <li>Click the <strong>"Create Job"</strong> button</li>
                    <li>Wait for confirmation message</li>
                </ol>
                
                <div class="note">
                    <strong>Success:</strong> You should see a green confirmation message when the job is created successfully.
                </div>
            </div>
        </div>

        <div class="step">
            <div class="step-number">Step 6</div>
            <div class="step-title">Verify Job Creation</div>
            <div class="step-description">
                After successful creation:
                <ul>
                    <li>The job will appear in the job listings</li>
                    <li>The file will be stored in the appropriate directory:
                        <ul>
                            <li>Administration: <code>employees/resources/pdf/desc/ap/</code></li>
                            <li>Licensed: <code>employees/resources/pdf/desc/lp/</code></li>
                            <li>Support: <code>employees/resources/pdf/desc/support-staff/</code></li>
                        </ul>
                    </li>
                    <li>The job will be searchable on the public interface</li>
                </ul>
            </div>
        </div>

        <div class="step">
            <div class="step-number">Troubleshooting</div>
            <div class="step-title">Common Issues and Solutions</div>
            <div class="step-description">
                <h4>File Upload Errors:</h4>
                <ul>
                    <li>Check file size (must be under 10MB)</li>
                    <li>Verify file format (PDF, DOC, DOCX only)</li>
                    <li>Ensure stable internet connection</li>
                </ul>

                <h4>Form Validation Errors:</h4>
                <ul>
                    <li>Complete all required fields marked with <span class="required">*</span></li>
                    <li>Check for special characters in text fields</li>
                    <li>Ensure job codes follow proper format</li>
                </ul>

                <h4>Database Errors:</h4>
                <ul>
                    <li>Check for duplicate job codes/IDs</li>
                    <li>Verify database connectivity</li>
                    <li>Contact system administrator if issues persist</li>
                </ul>
            </div>
        </div>

        <div class="navigation-links">
            <a href="index.php">← Back to Job Search</a>
            <a href="admin/index.php">Go to Admin Panel →</a>
        </div>

        <div style="text-align: center; margin-top: 30px; color: #7f8c8d; font-size: 0.9em;">
            <p>CCSD Job Search Portal - Administrative Documentation</p>
            <p>For technical support, contact your system administrator</p>
        </div>
    </div>
</body>
</html>