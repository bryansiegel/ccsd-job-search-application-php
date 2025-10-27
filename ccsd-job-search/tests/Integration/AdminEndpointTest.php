<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../includes/db/model.php';
require_once __DIR__ . '/../../includes/functions/job-processing.php';
require_once __DIR__ . '/../Fixtures/TestData.php';

class AdminEndpointTest extends TestCase
{
    private JobModel $jobModel;
    private PDO $pdo;
    private array $originalPost;
    private array $originalGet;
    private array $originalFiles;
    private array $originalServer;

    protected function setUp(): void
    {
        $this->pdo = getTestDatabaseConnection();
        $this->jobModel = new JobModel($this->pdo);
        resetTestDatabase();
        
        // Store original superglobals
        $this->originalPost = $_POST;
        $this->originalGet = $_GET;
        $this->originalFiles = $_FILES;
        $this->originalServer = $_SERVER;
        
        // Reset superglobals
        $_POST = [];
        $_GET = [];
        $_FILES = [];
        $_SERVER['REQUEST_METHOD'] = 'GET';
    }

    protected function tearDown(): void
    {
        resetTestDatabase();
        
        // Restore original superglobals
        $_POST = $this->originalPost;
        $_GET = $this->originalGet;
        $_FILES = $this->originalFiles;
        $_SERVER = $this->originalServer;
    }

    private function simulatePostRequest(array $postData, array $files = []): void
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST = $postData;
        $_FILES = $files;
    }

    private function simulateGetRequest(array $getData): void
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_GET = $getData;
    }

    private function captureAdminPageOutput(string $action = '', array $postData = [], array $files = []): string
    {
        if (!empty($postData)) {
            $this->simulatePostRequest($postData, $files);
        }
        
        if (!empty($action)) {
            $_GET['action'] = $action;
        }
        
        ob_start();
        
        try {
            // Include the admin page logic without HTML output
            include __DIR__ . '/../../admin/index.php';
        } catch (Exception $e) {
            // Capture any exceptions for testing
            ob_end_clean();
            throw $e;
        }
        
        $output = ob_get_clean();
        return $output;
    }

    // ==================== ADMINISTRATION JOB ENDPOINT TESTS ====================

    public function testCreateAdministrationJobEndpoint(): void
    {
        $postData = [
            'action' => 'create',
            'job_type' => 'administration',
            'title' => 'Test Administrator Position',
            'grade' => '40',
            'ccode' => 'TEST001',
            'division' => 'Test Division',
            'description' => 'Test description for administrator position'
        ];
        
        $this->simulatePostRequest($postData);
        
        // Manually execute the creation logic from admin/index.php
        $data = sanitizeJobData($postData, 'administration');
        $result = $this->jobModel->createAdminJob($data);
        
        $this->assertIsInt($result);
        $this->assertGreaterThan(0, $result);
        
        // Verify job was created
        $createdJob = $this->jobModel->getAdminJobById($result);
        $this->assertEquals($postData['title'], $createdJob['title']);
        $this->assertEquals($postData['ccode'], $createdJob['ccode']);
    }

    public function testUpdateAdministrationJobEndpoint(): void
    {
        // First create a job
        $initialData = TestData::getAdministrationJobData();
        $jobId = $this->jobModel->createAdminJob($initialData);
        
        $postData = [
            'action' => 'update',
            'job_type' => 'administration',
            'job_id' => $jobId,
            'title' => 'Updated Administrator Position',
            'grade' => '45',
            'ccode' => 'UPDATED001',
            'division' => 'Updated Division',
            'description' => 'Updated description'
        ];
        
        $this->simulatePostRequest($postData);
        
        // Execute update logic
        $data = sanitizeJobData($postData, 'administration');
        $result = $this->jobModel->updateAdminJob($jobId, $data);
        
        $this->assertTrue($result);
        
        // Verify job was updated
        $updatedJob = $this->jobModel->getAdminJobById($jobId);
        $this->assertEquals($postData['title'], $updatedJob['title']);
        $this->assertEquals($postData['ccode'], $updatedJob['ccode']);
    }

    public function testDeleteAdministrationJobEndpoint(): void
    {
        // First create a job
        $testData = TestData::getAdministrationJobData();
        $jobId = $this->jobModel->createAdminJob($testData);
        
        $this->simulateGetRequest([
            'action' => 'delete',
            'type' => 'administration',
            'id' => $jobId
        ]);
        
        // Execute delete logic
        $result = $this->jobModel->deleteAdminJob($jobId);
        
        $this->assertTrue($result);
        
        // Verify job was deleted
        $deletedJob = $this->jobModel->getAdminJobById($jobId);
        $this->assertFalse($deletedJob);
    }

    // ==================== LICENSED JOB ENDPOINT TESTS ====================

    public function testCreateLicensedJobEndpoint(): void
    {
        $postData = [
            'action' => 'create',
            'job_type' => 'licensed',
            'title' => 'Test Licensed Teacher',
            'job_id' => 'LIC001',
            'category' => 'Elementary',
            'division' => 'Education Services',
            'certification_type' => 'Teaching License',
            'active' => 'Y',
            'salary_code' => 'TC-15'
        ];
        
        $this->simulatePostRequest($postData);
        
        // Execute creation logic
        $data = sanitizeJobData($postData, 'licensed');
        $result = $this->jobModel->createLicensedJob($data);
        
        $this->assertIsInt($result);
        $this->assertGreaterThan(0, $result);
        
        // Verify job was created
        $createdJob = $this->jobModel->getLicensedJobById($result);
        $this->assertEquals($postData['title'], $createdJob['title']);
        $this->assertEquals($postData['job_id'], $createdJob['job_id']);
        $this->assertEquals(1, $createdJob['active']); // Y converted to 1
    }

    public function testUpdateLicensedJobEndpoint(): void
    {
        // First create a job
        $initialData = TestData::getLicensedJobData();
        $jobId = $this->jobModel->createLicensedJob($initialData);
        
        $postData = [
            'action' => 'update',
            'job_type' => 'licensed',
            'job_id' => $jobId,
            'title' => 'Updated Licensed Teacher',
            'job_id' => 'LIC002',
            'category' => 'Secondary',
            'division' => 'Updated Services',
            'certification_type' => 'Updated License',
            'active' => 'N',
            'salary_code' => 'TC-20'
        ];
        
        $this->simulatePostRequest($postData);
        
        // Execute update logic
        $data = sanitizeJobData($postData, 'licensed');
        $result = $this->jobModel->updateLicensedJob($jobId, $data);
        
        $this->assertTrue($result);
        
        // Verify job was updated
        $updatedJob = $this->jobModel->getLicensedJobById($jobId);
        $this->assertEquals($postData['title'], $updatedJob['title']);
        $this->assertEquals(0, $updatedJob['active']); // N converted to 0
    }

    // ==================== SUPPORT JOB ENDPOINT TESTS ====================

    public function testCreateSupportJobEndpoint(): void
    {
        $postData = [
            'action' => 'create',
            'job_type' => 'support',
            'title' => 'Test Support Staff',
            'grade' => '31',
            'job_code' => 'SUP001',
            'department_code' => 'DEPT001',
            'union_code' => 'UNION001'
        ];
        
        $this->simulatePostRequest($postData);
        
        // Execute creation logic
        $data = sanitizeJobData($postData, 'support');
        $result = $this->jobModel->createSupportJob($data);
        
        $this->assertIsInt($result);
        $this->assertGreaterThan(0, $result);
        
        // Verify job was created
        $createdJob = $this->jobModel->getSupportJobById($result);
        $this->assertEquals($postData['title'], $createdJob['title']);
        $this->assertEquals($postData['job_code'], $createdJob['job_code']);
    }

    // ==================== SEARCH ENDPOINT TESTS ====================

    public function testSearchEndpoint(): void
    {
        // Create test data
        $this->jobModel->createAdminJob([
            'title' => 'Principal Elementary School',
            'grade' => '45',
            'ccode' => 'A816',
            'division' => 'Education Services',
            'description' => 'Elementary school principal',
            'filename' => 'A816.pdf'
        ]);
        
        $this->jobModel->createLicensedJob([
            'title' => 'Teacher Mathematics',
            'job_id' => '1',
            'category' => 'Elementary',
            'division' => 'Curriculum and Instruction',
            'certification_type' => 'Mathematics Education',
            'active' => 1,
            'salary_code' => 'TC-12',
            'filename' => 'teacher-math.pdf'
        ]);
        
        $this->simulateGetRequest(['search' => 'Principal']);
        
        // Execute search logic
        $searchResults = $this->jobModel->searchAllJobs('Principal');
        
        $this->assertIsArray($searchResults);
        $this->assertGreaterThan(0, count($searchResults['administration']));
        $this->assertEquals(0, count($searchResults['licensed']));
    }

    public function testFilterEndpoint(): void
    {
        // Create test data with different grades
        $this->jobModel->createAdminJob([
            'title' => 'Manager Grade 40',
            'grade' => '40',
            'ccode' => 'A100',
            'division' => 'Administration',
            'description' => 'Management position',
            'filename' => 'A100.pdf'
        ]);
        
        $this->jobModel->createAdminJob([
            'title' => 'Director Grade 45',
            'grade' => '45',
            'ccode' => 'A200',
            'division' => 'Administration',
            'description' => 'Director position',
            'filename' => 'A200.pdf'
        ]);
        
        $this->simulateGetRequest([
            'filter' => 'administration',
            'grade' => '40'
        ]);
        
        // Execute filter logic
        $allJobs = $this->jobModel->getAllJobs();
        $filters = [
            'type' => 'administration',
            'grade' => '40',
            'code' => '',
            'division' => ''
        ];
        $filteredJobs = applyJobFilters($allJobs, $filters);
        
        $this->assertCount(1, $filteredJobs['administration']);
        $this->assertEquals('40', $filteredJobs['administration'][0]['grade']);
    }

    // ==================== ERROR HANDLING TESTS ====================

    public function testCreateJobMissingRequiredFields(): void
    {
        $postData = [
            'action' => 'create',
            'job_type' => 'administration',
            // Missing required fields: title, grade, ccode, division, description
        ];
        
        $this->simulatePostRequest($postData);
        
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Job title is required");
        
        sanitizeJobData($postData, 'administration');
    }

    public function testCreateJobInvalidJobType(): void
    {
        $postData = [
            'action' => 'create',
            'job_type' => 'invalid_type',
            'title' => 'Test Job'
        ];
        
        $this->simulatePostRequest($postData);
        
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Invalid job type");
        
        sanitizeJobData($postData, 'invalid_type');
    }

    public function testUpdateNonExistentJob(): void
    {
        $postData = [
            'action' => 'update',
            'job_type' => 'administration',
            'job_id' => 99999, // Non-existent ID
            'title' => 'Updated Job'
        ];
        
        $this->simulatePostRequest($postData);
        
        $data = sanitizeJobData($postData, 'administration');
        $result = $this->jobModel->updateAdminJob(99999, $data);
        
        $this->assertFalse($result);
    }

    public function testDeleteNonExistentJob(): void
    {
        $result = $this->jobModel->deleteAdminJob(99999);
        $this->assertFalse($result);
    }

    // ==================== DATA SANITIZATION TESTS ====================

    public function testSanitizeJobDataAdministration(): void
    {
        $rawData = [
            'title' => '  Test Title  ',
            'grade' => '40',
            'ccode' => 'A225',
            'division' => 'Test Division',
            'description' => 'Test description with <script>alert("xss")</script>',
            'extra_field' => 'should_be_ignored'
        ];
        
        $sanitized = sanitizeJobData($rawData, 'administration');
        
        $this->assertEquals('Test Title', $sanitized['title']); // Trimmed
        $this->assertEquals('40', $sanitized['grade']);
        $this->assertEquals('A225', $sanitized['ccode']);
        $this->assertEquals('Test Division', $sanitized['division']);
        $this->assertStringNotContainsString('<script>', $sanitized['description']); // XSS filtered
        $this->assertArrayNotHasKey('extra_field', $sanitized); // Extra fields removed
    }

    public function testSanitizeJobDataLicensed(): void
    {
        $rawData = [
            'title' => 'Licensed Teacher',
            'job_id' => 'LIC001',
            'category' => 'Elementary',
            'division' => 'Education',
            'certification_type' => 'Teaching',
            'active' => 'Y',
            'salary_code' => 'TC-15'
        ];
        
        $sanitized = sanitizeJobData($rawData, 'licensed');
        
        $this->assertEquals('Licensed Teacher', $sanitized['title']);
        $this->assertEquals(1, $sanitized['active']); // Y converted to 1
    }

    public function testSanitizeJobDataSupport(): void
    {
        $rawData = [
            'title' => 'Support Staff',
            'grade' => '31',
            'job_code' => '0021',
            'department_code' => 'POLICE',
            'union_code' => 'CCPOA'
        ];
        
        $sanitized = sanitizeJobData($rawData, 'support');
        
        $this->assertEquals('Support Staff', $sanitized['title']);
        $this->assertEquals('31', $sanitized['grade']);
        $this->assertEquals('0021', $sanitized['job_code']);
    }

    // ==================== INTEGRATION WORKFLOW TESTS ====================

    public function testCompleteJobCreationWorkflow(): void
    {
        // Test complete workflow: create -> verify -> update -> verify -> delete -> verify
        
        // 1. Create
        $createData = [
            'action' => 'create',
            'job_type' => 'administration',
            'title' => 'Workflow Test Job',
            'grade' => '40',
            'ccode' => 'WF001',
            'division' => 'Test Division',
            'description' => 'Test workflow job'
        ];
        
        $this->simulatePostRequest($createData);
        $sanitizedData = sanitizeJobData($createData, 'administration');
        $jobId = $this->jobModel->createAdminJob($sanitizedData);
        
        $this->assertIsInt($jobId);
        
        // 2. Verify creation
        $createdJob = $this->jobModel->getAdminJobById($jobId);
        $this->assertEquals($createData['title'], $createdJob['title']);
        
        // 3. Update
        $updateData = [
            'action' => 'update',
            'job_type' => 'administration',
            'job_id' => $jobId,
            'title' => 'Updated Workflow Test Job',
            'grade' => '45',
            'ccode' => 'WF002',
            'division' => 'Updated Division',
            'description' => 'Updated test workflow job'
        ];
        
        $this->simulatePostRequest($updateData);
        $sanitizedUpdateData = sanitizeJobData($updateData, 'administration');
        $updateResult = $this->jobModel->updateAdminJob($jobId, $sanitizedUpdateData);
        
        $this->assertTrue($updateResult);
        
        // 4. Verify update
        $updatedJob = $this->jobModel->getAdminJobById($jobId);
        $this->assertEquals($updateData['title'], $updatedJob['title']);
        $this->assertEquals($updateData['grade'], $updatedJob['grade']);
        
        // 5. Delete
        $deleteResult = $this->jobModel->deleteAdminJob($jobId);
        $this->assertTrue($deleteResult);
        
        // 6. Verify deletion
        $deletedJob = $this->jobModel->getAdminJobById($jobId);
        $this->assertFalse($deletedJob);
    }
}