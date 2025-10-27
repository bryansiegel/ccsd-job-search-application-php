<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../includes/db/model.php';
require_once __DIR__ . '/../Fixtures/TestData.php';

class JobModelTest extends TestCase
{
    private JobModel $jobModel;
    private PDO $pdo;

    protected function setUp(): void
    {
        $this->pdo = getTestDatabaseConnection();
        $this->jobModel = new JobModel($this->pdo);
        resetTestDatabase();
    }

    protected function tearDown(): void
    {
        resetTestDatabase();
    }

    // ==================== ADMINISTRATION JOBS TESTS ====================

    public function testCreateAdminJob(): void
    {
        $testData = TestData::getAdministrationJobData();
        
        $jobId = $this->jobModel->createAdminJob($testData);
        
        $this->assertIsInt($jobId);
        $this->assertGreaterThan(0, $jobId);
        
        // Verify job was created correctly
        $createdJob = $this->jobModel->getAdminJobById($jobId);
        $this->assertIsArray($createdJob);
        $this->assertEquals($testData['title'], $createdJob['title']);
        $this->assertEquals($testData['grade'], $createdJob['grade']);
        $this->assertEquals($testData['ccode'], $createdJob['ccode']);
        $this->assertEquals($testData['division'], $createdJob['division']);
        $this->assertEquals($testData['description'], $createdJob['description']);
        $this->assertEquals($testData['filename'], $createdJob['filename']);
    }

    public function testGetAdminJobById(): void
    {
        $testData = TestData::getAdministrationJobData();
        $jobId = $this->jobModel->createAdminJob($testData);
        
        $job = $this->jobModel->getAdminJobById($jobId);
        
        $this->assertIsArray($job);
        $this->assertEquals($jobId, $job['id']);
        $this->assertEquals($testData['title'], $job['title']);
    }

    public function testGetAdminJobByIdNotFound(): void
    {
        $job = $this->jobModel->getAdminJobById(99999);
        $this->assertFalse($job);
    }

    public function testUpdateAdminJob(): void
    {
        $testData = TestData::getAdministrationJobData();
        $jobId = $this->jobModel->createAdminJob($testData);
        
        $updateData = [
            'title' => 'Updated Administrator Position',
            'grade' => '45',
            'ccode' => 'UPDATED001',
            'division' => 'Updated Division',
            'description' => 'Updated description',
            'filename' => 'UPDATED001.pdf'
        ];
        
        $result = $this->jobModel->updateAdminJob($jobId, $updateData);
        $this->assertTrue($result);
        
        $updatedJob = $this->jobModel->getAdminJobById($jobId);
        $this->assertEquals($updateData['title'], $updatedJob['title']);
        $this->assertEquals($updateData['grade'], $updatedJob['grade']);
        $this->assertEquals($updateData['ccode'], $updatedJob['ccode']);
    }

    public function testDeleteAdminJob(): void
    {
        $testData = TestData::getAdministrationJobData();
        $jobId = $this->jobModel->createAdminJob($testData);
        
        $result = $this->jobModel->deleteAdminJob($jobId);
        $this->assertTrue($result);
        
        $deletedJob = $this->jobModel->getAdminJobById($jobId);
        $this->assertFalse($deletedJob);
    }

    public function testGetAdminJobs(): void
    {
        $jobs = TestData::getMultipleAdministrationJobs();
        foreach ($jobs as $jobData) {
            $this->jobModel->createAdminJob($jobData);
        }
        
        $allJobs = $this->jobModel->getAdminJobs();
        $this->assertIsArray($allJobs);
        $this->assertCount(3, $allJobs);
    }

    public function testGetAdminJobsByCriteria(): void
    {
        $jobs = TestData::getMultipleAdministrationJobs();
        foreach ($jobs as $jobData) {
            $this->jobModel->createAdminJob($jobData);
        }
        
        $criteriaJobs = $this->jobModel->getAdminJobsByCriteria(['grade' => '40']);
        $this->assertIsArray($criteriaJobs);
        $this->assertCount(1, $criteriaJobs);
        $this->assertEquals('40', $criteriaJobs[0]['grade']);
    }

    public function testGetAdminJobsCount(): void
    {
        $jobs = TestData::getMultipleAdministrationJobs();
        foreach ($jobs as $jobData) {
            $this->jobModel->createAdminJob($jobData);
        }
        
        $count = $this->jobModel->getAdminJobsCount();
        $this->assertEquals(3, $count);
    }

    // ==================== LICENSED JOBS TESTS ====================

    public function testCreateLicensedJob(): void
    {
        $testData = TestData::getLicensedJobData();
        
        $jobId = $this->jobModel->createLicensedJob($testData);
        
        $this->assertIsInt($jobId);
        $this->assertGreaterThan(0, $jobId);
        
        $createdJob = $this->jobModel->getLicensedJobById($jobId);
        $this->assertIsArray($createdJob);
        $this->assertEquals($testData['title'], $createdJob['title']);
        $this->assertEquals($testData['job_id'], $createdJob['job_id']);
        $this->assertEquals($testData['category'], $createdJob['category']);
        $this->assertEquals($testData['active'], $createdJob['active']);
    }

    public function testUpdateLicensedJob(): void
    {
        $testData = TestData::getLicensedJobData();
        $jobId = $this->jobModel->createLicensedJob($testData);
        
        $updateData = [
            'title' => 'Updated Licensed Teacher',
            'job_id' => 'LIC002',
            'category' => 'Secondary',
            'division' => 'Updated Services',
            'certification_type' => 'Updated License',
            'active' => 0,
            'salary_code' => 'TC-20',
            'filename' => 'LIC002.pdf'
        ];
        
        $result = $this->jobModel->updateLicensedJob($jobId, $updateData);
        $this->assertTrue($result);
        
        $updatedJob = $this->jobModel->getLicensedJobById($jobId);
        $this->assertEquals($updateData['title'], $updatedJob['title']);
        $this->assertEquals($updateData['active'], $updatedJob['active']);
    }

    public function testDeleteLicensedJob(): void
    {
        $testData = TestData::getLicensedJobData();
        $jobId = $this->jobModel->createLicensedJob($testData);
        
        $result = $this->jobModel->deleteLicensedJob($jobId);
        $this->assertTrue($result);
        
        $deletedJob = $this->jobModel->getLicensedJobById($jobId);
        $this->assertFalse($deletedJob);
    }

    // ==================== SUPPORT JOBS TESTS ====================

    public function testCreateSupportJob(): void
    {
        $testData = TestData::getSupportJobData();
        
        $jobId = $this->jobModel->createSupportJob($testData);
        
        $this->assertIsInt($jobId);
        $this->assertGreaterThan(0, $jobId);
        
        $createdJob = $this->jobModel->getSupportJobById($jobId);
        $this->assertIsArray($createdJob);
        $this->assertEquals($testData['title'], $createdJob['title']);
        $this->assertEquals($testData['grade'], $createdJob['grade']);
        $this->assertEquals($testData['job_code'], $createdJob['job_code']);
    }

    public function testUpdateSupportJob(): void
    {
        $testData = TestData::getSupportJobData();
        $jobId = $this->jobModel->createSupportJob($testData);
        
        $updateData = [
            'title' => 'Updated Support Staff',
            'grade' => '35',
            'job_code' => 'SUP002',
            'department_code' => 'DEPT002',
            'union_code' => 'UNION002',
            'filename' => 'SUP002.pdf'
        ];
        
        $result = $this->jobModel->updateSupportJob($jobId, $updateData);
        $this->assertTrue($result);
        
        $updatedJob = $this->jobModel->getSupportJobById($jobId);
        $this->assertEquals($updateData['title'], $updatedJob['title']);
        $this->assertEquals($updateData['grade'], $updatedJob['grade']);
    }

    public function testDeleteSupportJob(): void
    {
        $testData = TestData::getSupportJobData();
        $jobId = $this->jobModel->createSupportJob($testData);
        
        $result = $this->jobModel->deleteSupportJob($jobId);
        $this->assertTrue($result);
        
        $deletedJob = $this->jobModel->getSupportJobById($jobId);
        $this->assertFalse($deletedJob);
    }

    // ==================== AGGREGATE METHODS TESTS ====================

    public function testGetAllJobs(): void
    {
        // Create test jobs
        $this->jobModel->createAdminJob(TestData::getAdministrationJobData());
        $this->jobModel->createLicensedJob(TestData::getLicensedJobData());
        $this->jobModel->createSupportJob(TestData::getSupportJobData());
        
        $allJobs = $this->jobModel->getAllJobs();
        
        $this->assertIsArray($allJobs);
        $this->assertArrayHasKey('administration', $allJobs);
        $this->assertArrayHasKey('licensed', $allJobs);
        $this->assertArrayHasKey('support', $allJobs);
        
        $this->assertCount(1, $allJobs['administration']);
        $this->assertCount(1, $allJobs['licensed']);
        $this->assertCount(1, $allJobs['support']);
    }

    public function testGetAllJobsCounts(): void
    {
        // Create multiple test jobs
        $adminJobs = TestData::getMultipleAdministrationJobs();
        foreach ($adminJobs as $jobData) {
            $this->jobModel->createAdminJob($jobData);
        }
        
        $licensedJobs = TestData::getMultipleLicensedJobs();
        foreach ($licensedJobs as $jobData) {
            $this->jobModel->createLicensedJob($jobData);
        }
        
        $supportJobs = TestData::getMultipleSupportJobs();
        foreach ($supportJobs as $jobData) {
            $this->jobModel->createSupportJob($jobData);
        }
        
        $counts = $this->jobModel->getAllJobsCounts();
        
        $this->assertIsArray($counts);
        $this->assertEquals(3, $counts['administration']);
        $this->assertEquals(3, $counts['licensed']);
        $this->assertEquals(3, $counts['support']);
        $this->assertEquals(9, $counts['total']);
    }
}