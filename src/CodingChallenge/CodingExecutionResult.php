<?php

namespace KnpU\Gladiator\CodingChallenge;

use KnpU\Gladiator\Exception\GradingException;

/**
 * Used inside the eval'ed scripts themselves to summarize what happened
 *
 * This is passed to the grader
 */
class CodingExecutionResult
{
    private $inputFiles;

    private $output;

    private $declaredVariables = array();

    private $exception;

    /**
     * @var string Sometimes, we can detect language errors at runtime (e.g. Twig)
     */
    private $languageError;

    private $gradingError;

    public function __construct(array $inputFiles)
    {
        $this->inputFiles = $inputFiles;
    }

    /**
     * @param string $variableName
     * @return bool
     */
    public function isVariableDeclared($variableName)
    {
        return isset($this->declaredVariables[$variableName]);
    }

    /**
     * @param $variableName
     * @return mixed
     * @throws GradingException
     */
    public function getDeclaredVariableValue($variableName)
    {
        if (!$this->isVariableDeclared($variableName)) {
            throw new GradingException(sprintf('The variable "%s" is not defined', $variableName));
        }

        return $this->declaredVariables[$variableName];
    }

    public function getOutput()
    {
        return $this->output;
    }

    /**
     * @param string $filename
     * @return string
     */
    public function getInputFileContents($filename)
    {
        if (!isset($this->inputFiles[$filename])) {
            throw new \InvalidArgumentException(sprintf('Unknown file "%s"!', $filename));
        }

        return $this->inputFiles[$filename];
    }

    public function getException()
    {
        return $this->exception;
    }

    public function setException(\Exception $exception)
    {
        $this->exception = $exception;
    }

    public function getLanguageError()
    {
        return $this->languageError;
    }

    public function setLanguageError($languageError)
    {
        $this->languageError = $languageError;
    }

    public function getGradingError()
    {
        return $this->gradingError;
    }

    public function setGradingError($gradingError)
    {
        $this->gradingError = $gradingError;
    }

    public function setOutput($output)
    {
        $this->output = $output;
    }

    public function setDeclaredVariables($declaredVariables)
    {
        $this->declaredVariables = $declaredVariables;
    }
}
