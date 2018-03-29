<?php

namespace Knowfox\Story\Services;

use Knowfox\Story\SyntaxErrorException;

class Story
{
    private $egg;

    public function __construct(Egg $egg)
    {
        $this->egg = $egg;
    }

    public function dump($scenes)
    {
        $result = '';
        $sep = '';
        foreach ($scenes as $scene) {
            $result .= $sep . $scene['title'] . "\n\n" . $scene['body'] . "\n";

            foreach ($scene['passages'] as $passage) {
                $result .= "\n[- " . $passage['title'] . ' -> ' . $passage['target'] . "]";
            }

            $sep = "\n\n---\n";
        }

        return $result;
    }

    private function passage($link, &$scene)
    {
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

            $passage['condition'] = $program['expr'];
            $link = ltrim(substr($link, 1));
        }

        preg_match('/^(.+)(\s*->\s*(.+))?$/U', $link, $matches);

        $passage = [
            'title' => trim($matches[1]),
        ];
        if (count($matches) > 2) {
            $passage['target'] = trim($matches[3]);
        }
        else {
            $passage['target'] = trim(ucfirst($matches[1]));
        }
        $scene['passages'][] = $passage;

        return $do_remove ? '' : '<u>' . $passage['title'] . '</u>';
    }

    private function parseScene($text)
    {
        $scene = ['passages' => [], 'vars' => [], 'expr' => []];

        list ($scene['title'], $body) = preg_split("/\n/", $text, 2);

        $scene['title'] = trim($scene['title']);

        $body = trim($body);

        while (preg_match("/^\.\.\.(\w+)(.*)\n\.\.\.$/", $body, $matches)) {
            $scene['vars'][$matches[1]] = trim($matches[2]);
            $body = ltrim(substr(strlen($matches[0])));
        }

        while (false !== ($pos = strpos($body, '{'))) {
            $expr = $this->egg->parseExpression(substr($body, $pos));

            $body = ltrim($expr['rest']);
            if (strpos($body, '}') !== 0) {
                throw new SyntaxErrorException("Unbalanced curly braces");
            }

            $scene['expr'][] = $expr['expr'];
            $body = '<expr' . count($scene['expr']) . '>' . substr($body, 1);
        }

        $scene['body'] = trim(preg_replace_callback('/\[([^\]]+)\]/', function ($matches) use (&$scene) {
            return $this->passage($matches[1], $scene);
        }, $body));

        return $scene;
    }

    public function parse($text)
    {
        $scenes = [];

        $body = '';

        foreach (preg_split("/\n/", $text) as $line) {

            if (preg_match('/^---/', $line)) {
                $scene = $this->parseScene($body);
                $scenes[$scene['title']] = $scene;
                $body = '';

                continue;
            }
            $body .= $line . "\n";
        }
        $scene = $this->parseScene($body);
        $scenes[$scene['title']] = $scene;

        return $scenes;
    }
}
