<?php

declare(strict_types = 1);

namespace Knowfox\Story\Services;

use Knowfox\Story\SyntaxErrorException;

class PassageParser
{
    public function __construct($scene, Egg $egg = null)
    {
        $this->scene = $scene;
        $this->egg = $egg ?? new Egg();
    }

    private function passage($link)
    {
        $passage = [];

        $do_remove = false;
        if (strpos($link, '-') === 0) {
            $link = preg_replace('/^-?\s*/', '', $link);
            $do_remove = true;
        }

        if (strpos($link, '{') === 0) {
            $condition = $this->egg->parseExpression(substr($link, 1));

            $link = ltrim($condition['rest']);
            if (strpos($link, '}') !== 0) {
                throw new SyntaxErrorException("Unbalanced curly braces");
            }

            $passage['condition'] = $condition['expr'];
            $link = ltrim(substr($link, 1));
        }

        preg_match('/^(.+)(\s*->\s*(.+))?$/U', $link, $matches);

        $passage['title'] = trim($matches[1]);

        if (count($matches) > 2) {
            $passage['target'] = trim($matches[3]);
        }
        else {
            $passage['target'] = trim(ucfirst($matches[1]));
        }
        $this->scene->passages[] = $passage;

        return $do_remove ? '' : '<u>' . $passage['title'] . '</u>';
    }

    public function __invoke($text)
    {
        $text = trim(preg_replace_callback('/\[([^\]]+)\]/', function ($matches) {
            return $this->passage($matches[1]);
        }, $text));

        return $text;
    }
}
