<?php

namespace Knowfox\Story\Services;

class Scene
{
    public $title;
    public $body;
    public $vars;
    public $passages;
    public $code;

    public function __construct(array $a = [])
    {
        $this->title = $a['title'] ?? '';
        $this->body = $a['body'] ?? '';
        $this->vars = $a['vars'] ?? [];
        $this->passages = $a['passages'] ?? [];
        $this->code = $a['code'] ?? [];
    }

    public function toArray()
    {
        return [
            'title' => $this->title,
            'body' => $this->body,
            'vars' => $this->vars,
            'passages' => $this->passages,
            'code' => $this->code,
        ];
    }
}