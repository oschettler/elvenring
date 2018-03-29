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
        $program = ltrim($program);

        if (preg_match('/^"([^"]*)"/', $program, $match)) {
            $expr = [
                'type' => "value",
                'value' => $match[1],
            ];
        }
        else if (preg_match('/^\d+\b/', $program, $match)) {
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

    private function parseApply($expr, $program)
    {
        $program = ltrim($program);
        if ($program == '' || $program[0] != "(") {
            return ['expr' => $expr, 'rest' => $program];
        }

        $program = ltrim(substr($program, 1));
        $expr = ['type' => "apply", 'operator' => $expr, 'args' => []];
        while ($program[0] != ")") {
            $arg = $this->parseExpression($program);
            array_push($expr['args'], $arg['expr']);
            $program = ltrim($arg['rest']);
            if ($program[0] == ",") {
                $program = ltrim(substr($program, 1));
            }
            else if ($program[0] != ")") {
                throw new SyntaxErrorException("Expected ',' or ')'");
            }
        }
        return $this->parseApply($expr, substr($program, 1));
    }

    function parse($program) {
        $result = $this->parseExpression($program);
        if (strlen(ltrim($result['rest'])) > 0) {
            throw new SyntaxErrorException("Unexpected text after program");
        }
        return $result['expr'];
    }
}