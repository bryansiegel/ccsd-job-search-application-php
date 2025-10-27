<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../includes/db/model.php';
require_once __DIR__ . '/../../includes/functions/job-processing.php';
require_once __DIR__ . '/../Fixtures/TestData.php';

class FilterFunctionalityTest extends TestCase
{
    private JobModel $jobModel;
    private PDO $pdo;

    protected function setUp(): void
    {
        $this->pdo = getTestDatabaseConnection();
        $this->jobModel = new JobModel($this->pdo);
        resetTestDatabase();
        
        // Set up comprehensive test data for filtering
        $this->createFilterTestData();
    }

    protected function tearDown(): void
    {
        resetTestDatabase();
    }

    private function createFilterTestData(): void
    {
        // Administration jobs with diverse filter criteria
        $adminJobs = [
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
                'description' => 'Secondary assistant principal',
                'filename' => 'A066.pdf'
            ],
            [
                'title' => 'Coordinator Finance',
                'grade' => '38',
                'ccode' => 'A225',
                'division' => 'Business and Finance',
                'description' => 'Financial coordinator',
                'filename' => 'A225.pdf'
            ],
            [
                'title' => 'Director Technology',
                'grade' => '50',
                'ccode' => 'A300',
                'division' => 'Technology Services',
                'description' => 'Technology director position',
                'filename' => 'A300.pdf'
            ],
            [
                'title' => 'Manager Facilities',
                'grade' => '40',
                'ccode' => 'A400',
                'division' => 'Facilities Services',
                'description' => 'Facilities management',
                'filename' => 'A400.pdf'
            ]
        ];

        // Licensed jobs with diverse categories and divisions
        $licensedJobs = [
            [
                'title' => 'Teacher Elementary Mathematics',
                'job_id' => '1',
                'category' => 'Elementary',
                'division' => 'Curriculum and Instruction',
                'certification_type' => 'Mathematics Education',
                'active' => 1,
                'salary_code' => 'TC-12',
                'filename' => 'teacher-math.pdf'
            ],
            [
                'title' => 'Teacher Secondary Science',
                'job_id' => '15',
                'category' => 'Secondary',
                'division' => 'Curriculum and Instruction',
                'certification_type' => 'Science Education',
                'active' => 1,
                'salary_code' => 'TC-15',
                'filename' => 'teacher-science.pdf'
            ],
            [
                'title' => 'School Counselor Elementary',
                'job_id' => '25',
                'category' => 'Elementary',
                'division' => 'Student Services',
                'certification_type' => 'School Counseling',
                'active' => 0,
                'salary_code' => 'SC-20',
                'filename' => 'counselor-elem.pdf'
            ],
            [
                'title' => 'Teacher Special Education',
                'job_id' => '30',
                'category' => 'Special Education',
                'division' => 'Special Services',
                'certification_type' => 'Special Education',
                'active' => 1,
                'salary_code' => 'TC-18',
                'filename' => 'teacher-sped.pdf'
            ]
        ];

        // Support jobs with diverse grades and departments
        $supportJobs = [
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
                'title' => 'Maintenance Specialist',
                'grade' => '28',
                'job_code' => '0155',
                'department_code' => 'FACILITIES',
                'union_code' => 'SEIU',
                'filename' => '0155.pdf'
            ],
            [
                'title' => 'Security Officer',
                'grade' => '31',
                'job_code' => '0024',
                'department_code' => 'SECURITY',
                'union_code' => 'CCPOA',
                'filename' => '0024.pdf'
            ],
            [
                'title' => 'Technology Specialist',
                'grade' => '35',
                'job_code' => '0200',
                'department_code' => 'TECHNOLOGY',
                'union_code' => 'CCSD-S',
                'filename' => '0200.pdf'
            ]
        ];

        foreach ($adminJobs as $jobData) {
            $this->jobModel->createAdminJob($jobData);
        }

        foreach ($licensedJobs as $jobData) {
            $this->jobModel->createLicensedJob($jobData);
        }

        foreach ($supportJobs as $jobData) {
            $this->jobModel->createSupportJob($jobData);
        }
    }

    // ==================== FILTER OPTIONS TESTS ====================

    public function testGetFilterOptions(): void
    {
        $options = $this->jobModel->getFilterOptions();
        
        $this->assertIsArray($options);
        $this->assertArrayHasKey('grades', $options);
        $this->assertArrayHasKey('codes', $options);
        $this->assertArrayHasKey('divisions', $options);
        
        // Verify grades are populated
        $this->assertContains('25', $options['grades']);
        $this->assertContains('31', $options['grades']);
        $this->assertContains('40', $options['grades']);
        
        // Verify codes are populated (from all job types)
        $this->assertContains('A816', $options['codes']);
        $this->assertContains('1', $options['codes']);
        $this->assertContains('0021', $options['codes']);
        
        // Verify divisions are populated
        $this->assertContains('Education Services', $options['divisions']);
        $this->assertContains('Business and Finance', $options['divisions']);
    }

    // ==================== JOB TYPE FILTER TESTS ====================

    public function testFilterByJobTypeAdministration(): void
    {
        $allJobs = $this->jobModel->getAllJobs();
        $filters = ['type' => 'administration', 'grade' => '', 'code' => '', 'division' => ''];
        
        $filteredJobs = applyJobFilters($allJobs, $filters);
        
        $this->assertCount(5, $filteredJobs['administration']);
        $this->assertCount(0, $filteredJobs['licensed']);
        $this->assertCount(0, $filteredJobs['support']);
    }

    public function testFilterByJobTypeLicensed(): void
    {
        $allJobs = $this->jobModel->getAllJobs();
        $filters = ['type' => 'licensed', 'grade' => '', 'code' => '', 'division' => ''];
        
        $filteredJobs = applyJobFilters($allJobs, $filters);
        
        $this->assertCount(0, $filteredJobs['administration']);
        $this->assertCount(4, $filteredJobs['licensed']);
        $this->assertCount(0, $filteredJobs['support']);
    }

    public function testFilterByJobTypeSupport(): void
    {
        $allJobs = $this->jobModel->getAllJobs();
        $filters = ['type' => 'support', 'grade' => '', 'code' => '', 'division' => ''];
        
        $filteredJobs = applyJobFilters($allJobs, $filters);
        
        $this->assertCount(0, $filteredJobs['administration']);
        $this->assertCount(0, $filteredJobs['licensed']);
        $this->assertCount(5, $filteredJobs['support']);
    }

    public function testFilterByJobTypeAll(): void
    {
        $allJobs = $this->jobModel->getAllJobs();
        $filters = ['type' => 'all', 'grade' => '', 'code' => '', 'division' => ''];
        
        $filteredJobs = applyJobFilters($allJobs, $filters);
        
        $this->assertCount(5, $filteredJobs['administration']);
        $this->assertCount(4, $filteredJobs['licensed']);
        $this->assertCount(5, $filteredJobs['support']);
    }

    // ==================== GRADE FILTER TESTS ====================

    public function testFilterByGrade40(): void
    {
        $allJobs = $this->jobModel->getAllJobs();
        $filters = ['type' => 'all', 'grade' => '40', 'code' => '', 'division' => ''];
        
        $filteredJobs = applyJobFilters($allJobs, $filters);
        
        // Should find 2 administration jobs with grade 40
        $this->assertCount(2, $filteredJobs['administration']);
        $this->assertCount(0, $filteredJobs['licensed']); // Licensed jobs don't have grades
        $this->assertCount(0, $filteredJobs['support']); // No support jobs with grade 40
        
        foreach ($filteredJobs['administration'] as $job) {
            $this->assertEquals('40', $job['grade']);
        }
    }

    public function testFilterByGrade31(): void
    {
        $allJobs = $this->jobModel->getAllJobs();
        $filters = ['type' => 'all', 'grade' => '31', 'code' => '', 'division' => ''];
        
        $filteredJobs = applyJobFilters($allJobs, $filters);
        
        // Should find 2 support jobs with grade 31
        $this->assertCount(0, $filteredJobs['administration']);
        $this->assertCount(0, $filteredJobs['licensed']);
        $this->assertCount(2, $filteredJobs['support']);
        
        foreach ($filteredJobs['support'] as $job) {
            $this->assertEquals('31', $job['grade']);
        }
    }

    // ==================== CODE FILTER TESTS ====================

    public function testFilterByAdministrationCode(): void
    {
        $allJobs = $this->jobModel->getAllJobs();
        $filters = ['type' => 'all', 'grade' => '', 'code' => 'A816', 'division' => ''];
        
        $filteredJobs = applyJobFilters($allJobs, $filters);
        
        $this->assertCount(1, $filteredJobs['administration']);
        $this->assertCount(0, $filteredJobs['licensed']);
        $this->assertCount(0, $filteredJobs['support']);
        
        $this->assertEquals('A816', $filteredJobs['administration'][0]['ccode']);
    }

    public function testFilterByLicensedJobId(): void
    {
        $allJobs = $this->jobModel->getAllJobs();
        $filters = ['type' => 'all', 'grade' => '', 'code' => '15', 'division' => ''];
        
        $filteredJobs = applyJobFilters($allJobs, $filters);
        
        $this->assertCount(0, $filteredJobs['administration']);
        $this->assertCount(1, $filteredJobs['licensed']);
        $this->assertCount(0, $filteredJobs['support']);
        
        $this->assertEquals('15', $filteredJobs['licensed'][0]['job_id']);
    }

    public function testFilterBySupportJobCode(): void
    {
        $allJobs = $this->jobModel->getAllJobs();
        $filters = ['type' => 'all', 'grade' => '', 'code' => '0021', 'division' => ''];
        
        $filteredJobs = applyJobFilters($allJobs, $filters);
        
        $this->assertCount(0, $filteredJobs['administration']);
        $this->assertCount(0, $filteredJobs['licensed']);
        $this->assertCount(1, $filteredJobs['support']);
        
        $this->assertEquals('0021', $filteredJobs['support'][0]['job_code']);
    }

    // ==================== DIVISION FILTER TESTS ====================

    public function testFilterByEducationServicesDivision(): void
    {
        $allJobs = $this->jobModel->getAllJobs();
        $filters = ['type' => 'all', 'grade' => '', 'code' => '', 'division' => 'Education Services'];
        
        $filteredJobs = applyJobFilters($allJobs, $filters);
        
        // Should find 2 administration jobs in Education Services
        $this->assertCount(2, $filteredJobs['administration']);
        $this->assertCount(0, $filteredJobs['licensed']); // No licensed jobs in Education Services in our test data
        $this->assertCount(0, $filteredJobs['support']); // Support jobs don't have divisions
        
        foreach ($filteredJobs['administration'] as $job) {
            $this->assertEquals('Education Services', $job['division']);
        }
    }

    public function testFilterByCurriculumInstructionDivision(): void
    {
        $allJobs = $this->jobModel->getAllJobs();
        $filters = ['type' => 'all', 'grade' => '', 'code' => '', 'division' => 'Curriculum and Instruction'];
        
        $filteredJobs = applyJobFilters($allJobs, $filters);
        
        // Should find 2 licensed jobs in Curriculum and Instruction
        $this->assertCount(0, $filteredJobs['administration']);
        $this->assertCount(2, $filteredJobs['licensed']);
        $this->assertCount(0, $filteredJobs['support']);
        
        foreach ($filteredJobs['licensed'] as $job) {
            $this->assertEquals('Curriculum and Instruction', $job['division']);
        }
    }

    // ==================== COMBINED FILTER TESTS ====================

    public function testCombinedJobTypeAndGradeFilter(): void
    {
        $allJobs = $this->jobModel->getAllJobs();
        $filters = ['type' => 'administration', 'grade' => '40', 'code' => '', 'division' => ''];
        
        $filteredJobs = applyJobFilters($allJobs, $filters);
        
        $this->assertCount(2, $filteredJobs['administration']);
        $this->assertCount(0, $filteredJobs['licensed']);
        $this->assertCount(0, $filteredJobs['support']);
        
        foreach ($filteredJobs['administration'] as $job) {
            $this->assertEquals('40', $job['grade']);
        }
    }

    public function testCombinedGradeAndCodeFilter(): void
    {
        $allJobs = $this->jobModel->getAllJobs();
        $filters = ['type' => 'all', 'grade' => '31', 'code' => '0021', 'division' => ''];
        
        $filteredJobs = applyJobFilters($allJobs, $filters);
        
        $this->assertCount(0, $filteredJobs['administration']);
        $this->assertCount(0, $filteredJobs['licensed']);
        $this->assertCount(1, $filteredJobs['support']);
        
        $job = $filteredJobs['support'][0];
        $this->assertEquals('31', $job['grade']);
        $this->assertEquals('0021', $job['job_code']);
    }

    public function testCombinedJobTypeAndDivisionFilter(): void
    {
        $allJobs = $this->jobModel->getAllJobs();
        $filters = ['type' => 'licensed', 'grade' => '', 'code' => '', 'division' => 'Student Services'];
        
        $filteredJobs = applyJobFilters($allJobs, $filters);
        
        $this->assertCount(0, $filteredJobs['administration']);
        $this->assertCount(1, $filteredJobs['licensed']);
        $this->assertCount(0, $filteredJobs['support']);
        
        $job = $filteredJobs['licensed'][0];
        $this->assertEquals('Student Services', $job['division']);
    }

    public function testTripleFilterCombination(): void
    {
        $allJobs = $this->jobModel->getAllJobs();
        $filters = ['type' => 'administration', 'grade' => '40', 'code' => '', 'division' => 'Education Services'];
        
        $filteredJobs = applyJobFilters($allJobs, $filters);
        
        $this->assertCount(1, $filteredJobs['administration']);
        $this->assertCount(0, $filteredJobs['licensed']);
        $this->assertCount(0, $filteredJobs['support']);
        
        $job = $filteredJobs['administration'][0];
        $this->assertEquals('40', $job['grade']);
        $this->assertEquals('Education Services', $job['division']);
    }

    // ==================== EDGE CASE FILTER TESTS ====================

    public function testFilterWithNoMatches(): void
    {
        $allJobs = $this->jobModel->getAllJobs();
        $filters = ['type' => 'all', 'grade' => '99', 'code' => '', 'division' => ''];
        
        $filteredJobs = applyJobFilters($allJobs, $filters);
        
        $this->assertCount(0, $filteredJobs['administration']);
        $this->assertCount(0, $filteredJobs['licensed']);
        $this->assertCount(0, $filteredJobs['support']);
    }

    public function testFilterWithEmptyFilters(): void
    {
        $allJobs = $this->jobModel->getAllJobs();
        $filters = ['type' => 'all', 'grade' => '', 'code' => '', 'division' => ''];
        
        $filteredJobs = applyJobFilters($allJobs, $filters);
        
        // Should return all jobs when no filters applied
        $this->assertCount(5, $filteredJobs['administration']);
        $this->assertCount(4, $filteredJobs['licensed']);
        $this->assertCount(5, $filteredJobs['support']);
    }

    // ==================== HELPER FUNCTION TESTS ====================

    public function testCalculateCurrentCounts(): void
    {
        $allJobs = $this->jobModel->getAllJobs();
        $filters = ['type' => 'administration', 'grade' => '40', 'code' => '', 'division' => ''];
        $filteredJobs = applyJobFilters($allJobs, $filters);
        
        $counts = calculateCurrentCounts($filteredJobs);
        
        $this->assertIsArray($counts);
        $this->assertEquals(2, $counts['administration']);
        $this->assertEquals(0, $counts['licensed']);
        $this->assertEquals(0, $counts['support']);
    }

    public function testPrepareSearchStatus(): void
    {
        $params = [
            'search' => 'test search',
            'filter' => 'administration',
            'grade' => '40',
            'code' => 'A816',
            'division' => 'Education Services'
        ];
        
        $status = prepareSearchStatus($params);
        
        $this->assertIsArray($status);
        $this->assertEquals('test search', $status['search_term']);
        $this->assertEquals('administration', $status['filter_type']);
        $this->assertEquals('40', $status['filter_grade']);
        $this->assertEquals('A816', $status['filter_code']);
        $this->assertEquals('Education Services', $status['filter_division']);
    }
}