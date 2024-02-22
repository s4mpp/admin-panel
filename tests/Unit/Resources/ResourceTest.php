<?php

namespace S4mpp\AdminPanel\Tests\Unit;

use S4mpp\AdminPanel\Reports\Report;
use S4mpp\AdminPanel\Tests\TestCase;
use Workbench\App\AdminPanel\EmptyResource;
use S4mpp\AdminPanel\Resources\UserResource;

final class ResourceTest extends TestCase
{
    public function test_create_instance(): void
    {
        $resource = new UserResource();

        // $this->assertEquals('User', $resource->getName());
        $this->assertEquals('users', $resource->getSlug());
        $this->assertEquals('Users', $resource->getTitle());

        $this->assertIsArray($resource->getReports());
        $this->assertIsArray($resource->getCustomActions());
        $this->assertIsArray($resource->getRepeaters());
        $this->assertIsArray($resource->getRead());
        $this->assertIsArray($resource->getForm());
        $this->assertIsArray($resource->getActions());
    }

    public function test_create_instance_empty_resource(): void
    {
        $resource = new EmptyResource();

        // $this->assertEquals('User', $resource->getName());
        // $this->assertEquals('users', $resource->getSlug());
        // $this->assertEquals('Users', $resource->getTitle());

        $this->assertIsArray($resource->getReports());
        $this->assertIsArray($resource->getCustomActions());
        $this->assertIsArray($resource->getRepeaters());
        $this->assertIsArray($resource->getRead());
        $this->assertIsArray($resource->getForm());
        $this->assertIsArray($resource->getActions());
    }

    public function test_get_reports(): void
    {
        $resource = new UserResource();

        $this->assertInstanceOf(Report::class, $resource->getReport('users-registered'));

        $this->assertNull($resource->getReport('inexistent-report'));
    }
}
