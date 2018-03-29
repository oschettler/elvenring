<?php

namespace Knowfox\Story\Tests;

use Knowfox\Story\Services\Egg;
use Tests\TestCase;

class EggTest extends TestCase
{
    protected $textual1 = '+(a, 10)';
    protected $prog1 = [
        'type' => 'apply',
        'operator' => [
            'type' => 'word',
            'name' => '+',
        ],
        'args' => [
            ['type' => 'word', 'name' => 'a'],
            ['type' => 'value', 'value' => 10],
        ],
    ];

    public function testEgg()
    {
        $service = app(Egg::class);
        $this->assertEquals($this->prog1, $service->parse($this->textual1));
    }
}