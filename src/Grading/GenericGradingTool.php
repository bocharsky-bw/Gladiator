<?php

namespace KnpU\Gladiator\Grading;

use KnpU\Gladiator\CodingChallenge\CodingExecutionResult;
use KnpU\Gladiator\CodingChallenge\Exception\GradingException;

/**
 * Generic input grading tool
 */
class GenericGradingTool
{
    /**
     * @var CodingExecutionResult
     */
    protected $result;

    public function __construct(CodingExecutionResult $result)
    {
        $this->result = $result;
    }

    public function assertInputContains($filename, $string, $gradingErrorMessage = null, $caseSensitive = false)
    {
        $contents = $this->result->getInputFileContents($filename);
        if (!$this->stringContains($contents, $string, $caseSensitive)) {
            if ($gradingErrorMessage === null) {
                $gradingErrorMessage = sprintf('I don\'t see `%s` used in `%s`', $string, $filename);
            }
            throw new GradingException($gradingErrorMessage);
        }
    }
    public function assertInputDoesNotContain($filename, $string, $gradingErrorMessage = null, $caseSensitive = false)
    {
        $contents = $this->result->getInputFileContents($filename);
        if ($this->stringContains($contents, $string, $caseSensitive)) {
            if ($gradingErrorMessage === null) {
                $gradingErrorMessage = sprintf('I see `%s` used in `%`, but it shouldn\'t be there!', $string, $filename);
            }
            throw new GradingException($gradingErrorMessage);
        }
    }

    /**
    * @param string $haystack
    * @param string $needle
    * @param bool|false $caseSensitive
    * @return bool
    */
   protected function stringContains($haystack, $needle, $caseSensitive = false)
   {
       $needle = (string) $needle;
       if ($caseSensitive) {
           $position = strpos($haystack, $needle);
       } else {
           $position = stripos($haystack, $needle);
       }
       return $position !== false;
   }
}
