<?php

class TestData
{
    /**
     * Get sample administration job data
     */
    public static function getAdministrationJobData(): array
    {
        return [
            'title' => 'Test Administrator Position',
            'grade' => '40',
            'ccode' => 'TEST001',
            'division' => 'Test Division',
            'description' => 'This is a test administrator position for unit testing',
            'filename' => 'TEST001.pdf'
        ];
    }

    /**
     * Get sample licensed job data
     */
    public static function getLicensedJobData(): array
    {
        return [
            'title' => 'Test Licensed Teacher',
            'job_id' => 'LIC001',
            'category' => 'Elementary',
            'division' => 'Education Services',
            'certification_type' => 'Teaching License',
            'active' => 1,
            'salary_code' => 'TC-15',
            'filename' => 'LIC001.pdf'
        ];
    }

    /**
     * Get sample support job data
     */
    public static function getSupportJobData(): array
    {
        return [
            'title' => 'Test Support Staff',
            'grade' => '31',
            'job_code' => 'SUP001',
            'department_code' => 'DEPT001',
            'union_code' => 'UNION001',
            'filename' => 'SUP001.pdf'
        ];
    }

    /**
     * Get multiple administration jobs for testing filters
     */
    public static function getMultipleAdministrationJobs(): array
    {
        return [
            [
                'title' => 'Principal Elementary School',
                'grade' => '45',
                'ccode' => 'A816',
                'division' => 'Education Services',
                'description' => 'Elementary school principal position',
                'filename' => 'A816.pdf'
            ],
            [
                'title' => 'Assistant Principal Secondary',
                'grade' => '40',
                'ccode' => 'A066',
                'division' => 'Education Services',
                'description' => 'Secondary school assistant principal',
                'filename' => 'A066.pdf'
            ],
            [
                'title' => 'Coordinator Finance',
                'grade' => '38',
                'ccode' => 'A225',
                'division' => 'Business and Finance',
                'description' => 'Financial coordinator position',
                'filename' => 'A225.pdf'
            ]
        ];
    }

    /**
     * Get multiple licensed jobs for testing filters
     */
    public static function getMultipleLicensedJobs(): array
    {
        return [
            [
                'title' => 'Teacher Elementary Art',
                'job_id' => '1',
                'category' => 'Elementary',
                'division' => 'Curriculum and Instruction',
                'certification_type' => 'Art Education',
                'active' => 1,
                'salary_code' => 'TC-12',
                'filename' => 'teacher-art.pdf'
            ],
            [
                'title' => 'Teacher Secondary Mathematics',
                'job_id' => '15',
                'category' => 'Secondary',
                'division' => 'Curriculum and Instruction',
                'certification_type' => 'Mathematics Education',
                'active' => 1,
                'salary_code' => 'TC-15',
                'filename' => 'teacher-math.pdf'
            ],
            [
                'title' => 'School Counselor',
                'job_id' => '25',
                'category' => 'Student Services',
                'division' => 'Student Services',
                'certification_type' => 'School Counseling',
                'active' => 0,
                'salary_code' => 'SC-20',
                'filename' => 'counselor.pdf'
            ]
        ];
    }

    /**
     * Get multiple support jobs for testing filters
     */
    public static function getMultipleSupportJobs(): array
    {
        return [
            [
                'title' => 'School Police Officer',
                'grade' => '31',
                'job_code' => '0021',
                'department_code' => 'POLICE',
                'union_code' => 'CCPOA',
                'filename' => '0021.pdf'
            ],
            [
                'title' => 'Administrative Assistant',
                'grade' => '25',
                'job_code' => '0101',
                'department_code' => 'ADMIN',
                'union_code' => 'CCSD-S',
                'filename' => '0101.pdf'
            ],
            [
                'title' => 'Maintenance Worker',
                'grade' => '20',
                'job_code' => '0155',
                'department_code' => 'FACILITIES',
                'union_code' => 'SEIU',
                'filename' => '0155.pdf'
            ]
        ];
    }

    /**
     * Create a test PDF file content
     */
    public static function createTestPdfContent(string $title = 'Test Document'): string
    {
        return "%PDF-1.4
1 0 obj
<<
/Type /Catalog
/Pages 2 0 R
>>
endobj

2 0 obj
<<
/Type /Pages
/Kids [3 0 R]
/Count 1
>>
endobj

3 0 obj
<<
/Type /Page
/Parent 2 0 R
/MediaBox [0 0 612 792]
/Contents 4 0 R
>>
endobj

4 0 obj
<<
/Length " . (strlen($title) + 20) . "
>>
stream
BT
/F1 12 Tf
72 720 Td
($title) Tj
ET
endstream
endobj

xref
0 5
0000000000 65535 f 
0000000009 00000 n 
0000000058 00000 n 
0000000115 00000 n 
0000000204 00000 n 
trailer
<<
/Size 5
/Root 1 0 R
>>
startxref
" . (296 + strlen($title)) . "
%%EOF";
    }
}