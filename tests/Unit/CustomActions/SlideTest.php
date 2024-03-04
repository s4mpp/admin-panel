<?php

namespace S4mpp\AdminPanel\Tests\Unit\CustomActions;

use Illuminate\View\View;
use S4mpp\AdminPanel\Tests\TestCase;
use S4mpp\AdminPanel\CustomActions\Slide;

final class SlideTest extends TestCase
{
    public function test_create_slide(): void
    {
        $slide = new Slide('Slide Action', 'view-name');

        $this->assertSame('Slide Action', $slide->getTitle());

        $this->assertSame('slideSlideAction', $slide->getNameSlide());
    }

    public function test_render_button(): void
    {
        $slide = new Slide('Slide Action', 'view-name');

        $this->assertInstanceOf(View::class, $slide->renderButton());
    }
    
    public function test_render_content(): void
    {
        $slide = new Slide('Slide Action', 'view-name');

        $this->assertInstanceOf(View::class, $slide->renderContent());
    }

    public function test_render_content_modal_confirmation(): void
    {
        $slide = new Slide('Slide Action', 'view-name');

        $this->assertInstanceOf(View::class, $slide->renderContentModalConfirmation());
    }

    public function test_get_view(): void
    {
        $slide = new Slide('Slide Action', 'view-name');

        $this->assertSame('view-name', $slide->getView());
    }
}
