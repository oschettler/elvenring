<?php

namespace Knowfox\Story\Tests;

use Knowfox\Story\Services\Story;
use Tests\TestCase;

class StoryTest extends TestCase
{
    protected $scenes1 = [
        'Scene #1' => [
            'title' => 'Scene #1',
            'body' => "fdasdfsfgs asdfuizdf\nasdfuiz sadfiu",
            'passages' => [
                [
                    'title' => 'Passage 1',
                    'target' => 'Scene #1',
                ],
                [
                    'title' => 'Passage 2',
                    'target' => 'Scene #1',
                ],
            ],
            'vars' => [],
            'code' => [],
        ],
        'Scene #2' => [
            'title' => 'Scene #2',
            'body' => "asdfuizdf <code2> fdasdfsfgs\nasdfuiz sadfiu",
            'passages' => [],
            'vars' => [
                'text1' => "<code1> dies ist der\nerste Text",
                'text2' => "dies ist der\nzweite Text",
            ],
            'code' => [
                [
                    'type' => 'apply',
                    'operator' => [
                        'type' => 'word',
                        'name' => '*',
                    ],
                    'args' => [
                        ['type' => 'word', 'name' => 'a'],
                        ['type' => 'value', 'value' => 42],
                    ],
                ],
                [
                    'type' => 'apply',
                    'operator' => [
                        'type' => 'word',
                        'name' => '+',
                    ],
                    'args' => [
                        ['type' => 'word', 'name' => 'a'],
                        ['type' => 'value', 'value' => 10],
                    ],
                ],
            ],
        ],
    ];

    protected $scenes2 = [
        'Scene #3' => [
            'title' => 'Scene #3',
            'body' => "asdfuizdf  fdasdfsfgs\nasdfuiz <u>Passage 43</u> sadfiu\nasdfuiz <u>Passage 44</u> sadfiu",
            'passages' => [
                [
                    'title' => 'Passage 42',
                    'target' => 'Scene #2',
                ],
                [
                    'title' => 'Passage 43',
                    'target' => 'Scene #1',
                ],
                [
                    'title' => 'Passage 44',
                    'target' => 'Scene #3',
                ]
            ],
            'vars' => [],
            'code' => [],
        ]
    ];

    protected $textual1 = <<<EOS
Scene #1

fdasdfsfgs asdfuizdf
asdfuiz sadfiu

[- Passage 1 -> Scene #1]
[- Passage 2 -> Scene #1]

---
Scene #2

...text1 {*(a, 42)} dies ist der
erste Text
...
...text2 dies ist der
zweite Text
...
asdfuizdf {+(a, 10)} fdasdfsfgs
asdfuiz sadfiu

EOS;

    protected $textual1_dumped = <<<EOS
Scene #1

fdasdfsfgs asdfuizdf
asdfuiz sadfiu

[- Passage 1 -> Scene #1]
[- Passage 2 -> Scene #1]

---
Scene #2

asdfuizdf <code2> fdasdfsfgs
asdfuiz sadfiu

EOS;

    protected $textual2 = <<<EOS
Scene #3

asdfuizdf [- Passage 42 -> Scene #2] fdasdfsfgs
asdfuiz [Passage 43 -> Scene #1] sadfiu
asdfuiz [Passage 44 
    -> Scene #3] sadfiu

EOS;


    public function testParse1()
    {
        $service = app(Story::class);
        $this->assertEquals($this->scenes1, $service->parse($this->textual1));
    }

    public function testDump1()
    {
        $service = app(Story::class);
        $this->assertEquals($this->textual1_dumped, $service->dump($this->scenes1));
    }

    public function testParse2()
    {
        $service = app(Story::class);
        $this->assertEquals($this->scenes2, $service->parse($this->textual2));
    }
}
