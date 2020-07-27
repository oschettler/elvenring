<?php

namespace Knowfox\Story\Services;

use Knowfox\Story\SyntaxErrorException;

/**
 * Parser for the scripting language "Egg"
 * Defined in the book "Eloquent JavaScript"
 * by Marijn Haverbeke
 * @see https://eloquentjavascript.net/12_language.html
 */
class Egg
{
    public function parseExpression($program)
    {
        $program = $this->skipSpace($program);

        if (preg_match('/^"([^"]*)"/', $program, $match)) {
            $expr = [
                'type' => "value",
                'value' => $match[1],
            ];
        }
        else if (preg_match('/^-?\d+\b/', $program, $match)) {
            $expr = [
                'type' => "value",
                'value' => intval($match[0]),
            ];
        }
        else if (preg_match('/^[^\s(),"]+/', $program, $match)) {
            $expr = [
                'type' => "word",
                'name' => $match[0],
            ];
        }
        else {
            throw new SyntaxErrorException("Unexpected syntax: " . $program);
        }

        return $this->parseApply($expr, substr($program, strlen($match[0])));
    }

    private function skipSpace($string) {
        return preg_replace("/^(\s|#.*\n)*/", '', $string);
    }

    private function parseApply($expr, $program)
    {
        $program = $this->skipSpace($program);
        if ($program == '' || $program[0] != "(") {
            return ['expr' => $expr, 'rest' => $program];
        }

        $program = $this->skipSpace(substr($program, 1));
        $expr = ['type' => "apply", 'operator' => $expr, 'args' => []];
        while ($program[0] != ")") {
            $arg = $this->parseExpression($program);
            array_push($expr['args'], $arg['expr']);
            $program = $this->skipSpace($arg['rest']);
            if ($program[0] == ",") {
                $program = $this->skipSpace(substr($program, 1));
            }
            else if ($program[0] != ")") {
                throw new SyntaxErrorException("Expected ',' or ')' in text '" . htmlentities($program) . "'");
            }
        }
        return $this->parseApply($expr, substr($program, 1));
    }

    function parse($program) {
        $result = $this->parseExpression($program);
        if (strlen($this->skipSpace($result['rest'])) > 0) {
            throw new SyntaxErrorException("Unexpected text after program");
        }
        return $result['expr'];
    }
}