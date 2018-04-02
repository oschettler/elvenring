<?php

namespace Knowfox\Story\Services;

use hkod\frontmatter\BlockParser;
use hkod\frontmatter\Parser;
use hkod\frontmatter\ParserBuilder;
use hkod\frontmatter\VoidParser;
use hkod\frontmatter\YamlParser;
use Knowfox\Story\SyntaxErrorException;

class Story
{
    const SEP = "\n...";
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
            $result .= $sep . $scene->title . "\n\n" . $scene->body . "\n";

            foreach ($scene->passages as $passage) {
                $result .= "\n[- " . $passage['title'] . ' -> ' . $passage['target'] . "]";
            }

            $sep = "\n\n---\n";
        }

        return $result;
    }

    private function parseScene($text)
    {
        $scene = new Scene();

        list ($scene->title, $body) = preg_split("/\n/", $text, 2);

        $scene->title = trim($scene->title);

        $body = trim($body);

        $parser = (new ParserBuilder())
            ->addFrontmatterPass(new EggParser($scene))
            ->addFrontmatterPass(new YamlParser())
            ->addBodyPass(new PassageParser($scene))
            ->addBodyPass(new EggParser($scene))
            ->setBlockParser(new BlockParser('...', '...'))
            ->buildParser();

        $result = $parser->parse($body);

        $scene->vars = $result->getFrontmatter() ?? [];
        $scene->body = $result->getBody();

        return $scene;
    }

    public function parse($text)
    {
        $scenes = [];

        $body = '';

        foreach (preg_split("/\n/", $text) as $line) {

            if (preg_match('/^---/', $line)) {
                $scene = $this->parseScene($body);
                $scenes[$scene->title] = $scene;
                $body = '';

                continue;
            }
            $body .= $line . "\n";
        }
        $scene = $this->parseScene($body);
        $scenes[$scene->title] = $scene;

        return $scenes;
    }
}
