<?php

namespace Knowfox\Story\Services;

class Story
{
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

    private function parseScene($text)
    {
        $scene = ['passages' => []];

        list ($scene['title'], $body) = preg_split("/\n/", $text, 2);

        $scene['title'] = trim($scene['title']);

        $scene['body'] = trim(preg_replace_callback('/\[([^\]]+)\]/', function ($matches) use (&$scene) {
            $link = $matches[1];

            $do_remove = false;
            if (strpos($link, '-') === 0) {
                $link = preg_replace('/^-?\s*/', '', $link);
                $do_remove = true;
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
