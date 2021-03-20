<?php

namespace Tests\Unit;

use App\Complaint;
use App\Services\ComplaintService;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ComplaintCRUDTest extends TestCase
{
    use RefreshDatabase;

    protected $compalintService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->compalintService = $this->app->make(ComplaintService::class);
    }

    /**
     * Test create income
     * 
     * @return void
     */
    public function test_income_create(): void
    {
        $user = factory(User::class)->create();

        $this->be($user);

        $complaint = $this->compalintService->saveComplaintData([
            'status' => 'pending',
            'title' => 'Test Title',
            'description' => 'Long test description',
            'urgent' => false
        ]);

        $this->assertNotEmpty($complaint->id);
        $this->assertEquals('pending', $complaint->status);
    }

    /**
     * Test retrieve income
     * 
     * @return void
     */
    public function test_complaint_retrieve(): void
    {
        factory(User::class)->create();

        $complaint = factory(Complaint::class)->create();

        $retrievedComplaint = $this->compalintService->getComplaintById($complaint->id);

        $this->assertEquals($complaint->id, $retrievedComplaint->id);
    }

    /**
     * Test update income
     * 
     * @return void
     */
    public function test_complaint_update(): void
    {
        $user = factory(User::class)->create();

        $this->be($user);

        $complaint = factory(Complaint::class)->create();

        $complaint = $this->compalintService->saveComplaintData([
            'status' => 'dismissed'
        ], $complaint->id);

        $this->assertEquals('dismissed', $complaint->status);
    }

    /**
     * Test delete income
     * 
     * @return void
     */
    public function test_complaint_delete()
    {
        $user = factory(User::class)->create();

        $this->be($user);

        $complaint = factory(Complaint::class)->create();

        $this->compalintService->deleteComplaintById($complaint->id);

        $this->assertNull(Complaint::find($complaint->id));
    }
}
