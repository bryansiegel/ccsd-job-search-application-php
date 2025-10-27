<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../includes/db/model.php';
require_once __DIR__ . '/../Fixtures/TestData.php';

class SearchFunctionalityTest extends TestCase
{
    private JobModel $jobModel;
    private PDO $pdo;

    protected function setUp(): void
    {
        $this->pdo = getTestDatabaseConnection();
        $this->jobModel = new JobModel($this->pdo);
        resetTestDatabase();
        
        // Set up test data for search
        $this->createSearchTestData();
    }

    protected function tearDown(): void
    {
        resetTestDatabase();
    }

    private function createSearchTestData(): void
    {
        // Administration jobs with search terms
        $adminJobs = [
            [
                'title' => 'Principal Elementary School',
                'grade' => '45',
                'ccode' => 'A816',
                'division' => 'Education Services',
                'description' => 'Elementary school principal leadership position',
                'filename' => 'A816.pdf'
            ],
            [
                'title' => 'Assistant Principal Secondary',
                'grade' => '40',
                'ccode' => 'A066',
                'division' => 'Education Services',
                'description' => 'Secondary assistant principal management role',
                'filename' => 'A066.pdf'
            ],
            [
                'title' => 'Coordinator Finance Budget',
                'grade' => '38',
                'ccode' => 'A225',
                'division' => 'Business and Finance',
                'description' => 'Financial coordination and budget management',
                'filename' => 'A225.pdf'
            ]
        ];

        // Licensed jobs with search terms
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
                'title' => 'School Psychologist',
                'job_id' => '25',
                'category' => 'Student Services',
                'division' => 'Student Services',
                'certification_type' => 'School Psychology',
                'active' => 1,
                'salary_code' => 'SP-20',
                'filename' => 'psychologist.pdf'
            ]
        ];

        // Support jobs with search terms
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
                'title' => 'Maintenance Specialist Technology',
                'grade' => '28',
                'job_code' => '0155',
                'department_code' => 'FACILITIES',
                'union_code' => 'SEIU',
                'filename' => '0155.pdf'
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

    // ==================== BASIC SEARCH TESTS ====================

    public function testSearchByTitle(): void
    {
        $results = $this->jobModel->searchAllJobs('Principal');
        
        $this->assertIsArray($results);
        $this->assertArrayHasKey('administration', $results);
        $this->assertArrayHasKey('licensed', $results);
        $this->assertArrayHasKey('support', $results);
        
        // Should find 2 administration jobs with "Principal" in title
        $this->assertCount(2, $results['administration']);
        $this->assertCount(0, $results['licensed']);
        $this->assertCount(0, $results['support']);
        
        // Verify the found jobs
        $adminTitles = array_column($results['administration'], 'title');
        $this->assertContains('Principal Elementary School', $adminTitles);
        $this->assertContains('Assistant Principal Secondary', $adminTitles);
    }

    public function testSearchByCategory(): void
    {
        $results = $this->jobModel->searchAllJobs('Elementary');
        
        // Should find 1 admin job and 1 licensed job with "Elementary"
        $this->assertGreaterThanOrEqual(1, count($results['administration']));
        $this->assertGreaterThanOrEqual(1, count($results['licensed']));
    }

    public function testSearchByDivision(): void
    {
        $results = $this->jobModel->searchAllJobs('Education Services');
        
        // Should find jobs in Education Services division
        $this->assertGreaterThan(0, count($results['administration']));
        
        foreach ($results['administration'] as $job) {
            $this->assertEquals('Education Services', $job['division']);
        }
    }

    public function testSearchByJobCode(): void
    {
        $results = $this->jobModel->searchAllJobs('A816');
        
        // Should find 1 administration job with code A816
        $this->assertCount(1, $results['administration']);
        $this->assertEquals('A816', $results['administration'][0]['ccode']);
    }

    public function testSearchByGrade(): void
    {
        $results = $this->jobModel->searchAllJobs('31');
        
        // Should find support job with grade 31
        $this->assertGreaterThan(0, count($results['support']));
        
        $foundGrade31 = false;
        foreach ($results['support'] as $job) {
            if ($job['grade'] === '31') {
                $foundGrade31 = true;
                break;
            }
        }
        $this->assertTrue($foundGrade31);
    }

    public function testSearchByDescription(): void
    {
        $results = $this->jobModel->searchAllJobs('leadership');
        
        // Should find administration job with "leadership" in description
        $this->assertGreaterThan(0, count($results['administration']));
        
        $foundLeadership = false;
        foreach ($results['administration'] as $job) {
            if (stripos($job['description'], 'leadership') !== false) {
                $foundLeadership = true;
                break;
            }
        }
        $this->assertTrue($foundLeadership);
    }

    public function testSearchByCertificationType(): void
    {
        $results = $this->jobModel->searchAllJobs('Mathematics');
        
        // Should find licensed job with Mathematics certification
        $this->assertGreaterThan(0, count($results['licensed']));
        
        $foundMath = false;
        foreach ($results['licensed'] as $job) {
            if (stripos($job['certification_type'], 'Mathematics') !== false) {
                $foundMath = true;
                break;
            }
        }
        $this->assertTrue($foundMath);
    }

    public function testSearchByDepartmentCode(): void
    {
        $results = $this->jobModel->searchAllJobs('POLICE');
        
        // Should find support job in POLICE department
        $this->assertGreaterThan(0, count($results['support']));
        
        $foundPolice = false;
        foreach ($results['support'] as $job) {
            if ($job['department_code'] === 'POLICE') {
                $foundPolice = true;
                break;
            }
        }
        $this->assertTrue($foundPolice);
    }

    // ==================== CASE INSENSITIVE SEARCH TESTS ====================

    public function testSearchCaseInsensitive(): void
    {
        $resultsLower = $this->jobModel->searchAllJobs('principal');
        $resultsUpper = $this->jobModel->searchAllJobs('PRINCIPAL');
        $resultsMixed = $this->jobModel->searchAllJobs('Principal');
        
        // All should return the same results
        $this->assertEquals(count($resultsLower['administration']), count($resultsUpper['administration']));
        $this->assertEquals(count($resultsLower['administration']), count($resultsMixed['administration']));
    }

    // ==================== PARTIAL MATCH TESTS ====================

    public function testSearchPartialMatch(): void
    {
        $results = $this->jobModel->searchAllJobs('Math');
        
        // Should find jobs with "Math" in various fields (Mathematics, etc.)
        $totalMatches = count($results['administration']) + count($results['licensed']) + count($results['support']);
        $this->assertGreaterThan(0, $totalMatches);
    }

    public function testSearchMultiWordTerm(): void
    {
        $results = $this->jobModel->searchAllJobs('School Police');
        
        // Should find the School Police Officer position
        $this->assertGreaterThan(0, count($results['support']));
        
        $foundSchoolPolice = false;
        foreach ($results['support'] as $job) {
            if (stripos($job['title'], 'School Police') !== false) {
                $foundSchoolPolice = true;
                break;
            }
        }
        $this->assertTrue($foundSchoolPolice);
    }

    // ==================== EMPTY AND SPECIAL CASES ====================

    public function testSearchEmptyTerm(): void
    {
        $results = $this->jobModel->searchAllJobs('');
        
        // Empty search should return empty results
        $this->assertCount(0, $results['administration']);
        $this->assertCount(0, $results['licensed']);
        $this->assertCount(0, $results['support']);
    }

    public function testSearchNoResults(): void
    {
        $results = $this->jobModel->searchAllJobs('NonexistentTerm12345');
        
        // Should return empty arrays for all job types
        $this->assertCount(0, $results['administration']);
        $this->assertCount(0, $results['licensed']);
        $this->assertCount(0, $results['support']);
    }

    public function testSearchSpecialCharacters(): void
    {
        $results = $this->jobModel->searchAllJobs('0021');
        
        // Should find support job with code 0021
        $this->assertGreaterThan(0, count($results['support']));
        
        $foundCode = false;
        foreach ($results['support'] as $job) {
            if ($job['job_code'] === '0021') {
                $foundCode = true;
                break;
            }
        }
        $this->assertTrue($foundCode);
    }

    // ==================== CROSS-TABLE SEARCH TESTS ====================

    public function testSearchAcrossAllTables(): void
    {
        $results = $this->jobModel->searchAllJobs('Teacher');
        
        // Should find licensed jobs with "Teacher" in title
        $this->assertGreaterThan(0, count($results['licensed']));
        
        foreach ($results['licensed'] as $job) {
            $this->assertStringContainsStringIgnoringCase('Teacher', $job['title']);
        }
    }

    public function testSearchWithNumbers(): void
    {
        $results = $this->jobModel->searchAllJobs('25');
        
        // Should find jobs with grade 25 or job_id 25
        $totalMatches = count($results['administration']) + count($results['licensed']) + count($results['support']);
        $this->assertGreaterThan(0, $totalMatches);
    }

    // ==================== SEARCH RESULT STRUCTURE TESTS ====================

    public function testSearchResultStructure(): void
    {
        $results = $this->jobModel->searchAllJobs('Principal');
        
        // Verify result structure
        $this->assertIsArray($results);
        $this->assertArrayHasKey('administration', $results);
        $this->assertArrayHasKey('licensed', $results);
        $this->assertArrayHasKey('support', $results);
        
        // Verify each result has correct fields
        if (!empty($results['administration'])) {
            $job = $results['administration'][0];
            $this->assertArrayHasKey('id', $job);
            $this->assertArrayHasKey('title', $job);
            $this->assertArrayHasKey('job_type', $job);
            $this->assertEquals('administration', $job['job_type']);
        }
    }
}