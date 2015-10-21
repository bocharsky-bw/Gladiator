<?php

namespace KnpU\Gladiator\Grading;

use KnpU\Gladiator\CodingChallenge\CodingExecutionResult;
use KnpU\Gladiator\CodingChallenge\Exception\GradingException;

/**
 * Helper to grade PHP code
 */
class PhpGradingTool extends GenericGradingTool
{
    public function assertFunctionExists($functionName, $gradingErrorMessage = null)
    {
        if ($gradingErrorMessage === null) {
            $gradingErrorMessage = sprintf(
                'The `%s` function does not exist - do you create it?',
                $functionName
            );
        }

        // this works because grading happens in the same PHP thread as execution
        // so if the user created a function, it literally still exists
        if (!function_exists($functionName)) {
            throw new GradingException($gradingErrorMessage);
        }
    }

    /**
     * Assert that the user created this variable
     *
     * @param string $variableName
     * @param null $gradingErrorMessage
     * @throws GradingException
     */
    public function assertVariableExists($variableName, $gradingErrorMessage = null)
    {
        if ($gradingErrorMessage === null) {
            $gradingErrorMessage = sprintf('I don\'t see a variable called `%s` - did you set this variable?', $variableName);
        }

        if (!$this->result->isVariableDeclared($variableName)) {
            throw new GradingException($gradingErrorMessage);
        }
    }

    public function assertVariableEquals($variableName, $expectedValue, $gradingErrorMessage = null)
    {
        if ($gradingErrorMessage === null) {
            $gradingErrorMessage = sprintf(
                'The `$%s` variable exists, but is not set to %s',
                $variableName,
                var_export($expectedValue, true)
            );
        }

        if ($this->result->getDeclaredVariableValue($variableName) != $expectedValue) {
            throw new GradingException($gradingErrorMessage);
        }
    }
}
