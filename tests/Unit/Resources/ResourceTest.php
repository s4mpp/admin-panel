<?php

namespace S4mpp\AdminPanel\Tests\Unit;

use S4mpp\AdminPanel\Reports\Report;
use S4mpp\AdminPanel\Tests\TestCase;
use Illuminate\Database\Eloquent\Model;
use Workbench\App\AdminPanel\EmptyResource;
use S4mpp\AdminPanel\Resources\UserResource;

final class ResourceTest extends TestCase
{
    public function test_create_instance(): void
    {
        $resource = new UserResource();

        $this->assertEquals('User', $resource->getName());
        $this->assertEquals('usuarios', $resource->getSlug());
        $this->assertEquals('Usuários', $resource->getTitle());

        $this->assertIsArray($resource->getReports());
        $this->assertIsArray($resource->getCustomActions());
        $this->assertIsArray($resource->getRepeaters());
        $this->assertIsArray($resource->getRead());
        $this->assertIsArray($resource->getForm());
        $this->assertIsArray($resource->getTable());
        $this->assertIsArray($resource->getFilters());
        $this->assertIsArray($resource->getActions());
        
        $this->assertIsString($resource->getNameModel());
        $this->assertInstanceOf(Model::class, $resource->getModel());
        
        $this->assertIsBool($resource->hasAction('create'));

        $this->assertSame('name', $resource->getOrdenationField());
        $this->assertSame('ASC', $resource->getOrdenationDirection());
    }
}
