<?php

namespace S4mpp\AdminPanel\Tests\Unit\CustomActions;

use S4mpp\AdminPanel\Tests\TestCase;
use S4mpp\AdminPanel\CustomActions\View;

final class ViewTest extends TestCase
{
    public function test_create_view(): void
    {
        $view = new View('View Action', 'view');

        $this->assertSame('View Action', $view->getTitle());
    }

    public function test_get_view(): void
    {
        $slide = new View('View Action', 'view-name');

        $this->assertSame('view-name', $slide->getView());
    }
}
