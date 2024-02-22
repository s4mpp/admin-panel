<?php

namespace S4mpp\AdminPanel\Tests\Unit\CustomActions;

use S4mpp\AdminPanel\Elements\Card;
use S4mpp\AdminPanel\Tests\TestCase;

final class CardTest extends TestCase
{
    public function test_create_card(): void
    {
        $card = new Card('Card title', []);

        $this->assertSame('Card title', $card->getTitle());
        $this->assertSame([], $card->getElements());
    }
}
