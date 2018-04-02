<?php

declare(strict_types = 1);

namespace Knowfox\Story\Services;

use Knowfox\Story\SyntaxErrorException;

class EggParser
{
    public function __construct($scene, Egg $egg = null)
    {
        $this->scene = $scene;
        $this->egg = $egg ?? new Egg();
    }

    public function __invoke($text)
    {
        while (false !== ($pos = strpos($text, '{'))) {

            $code_pos = $pos + 1;
            $include_code = true;
            if (strpos($text, '-', $code_pos) === $code_pos) {
                $code_pos += 1;
                $include_code = false;
            }

            $expr = $this->egg->parseExpression(substr($text, $code_pos));

            $prefix = substr($text, 0, $pos);

            $text = ltrim($expr['rest']);
            if (strpos($text, '}') !== 0) {
                throw new SyntaxErrorException("Unbalanced curly braces");
            }

            $this->scene->code[] = $expr['expr'];

            if ($include_code) {
                $text = $prefix . '<code #' . count($this->scene->code) . '>' . substr($text, 1);
            }
            else {
                $text = $prefix . substr($text, 1);
            }
        }

        return $text;
    }
}
