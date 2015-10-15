<?php

namespace KnpU\Gladiator;

use KnpU\Gladiator\CodingChallenge\CodingExecutionResult;
use KnpU\Gladiator\CodingChallenge\CorrectAnswer;
use KnpU\Gladiator\Exception\GradingException;
use KnpU\Gladiator\CodingChallenge\FileBuilder;
use KnpU\Gladiator\CodingChallenge\CodingContext;

/**
 * All activities will implement this interface
 */
interface CodingChallengeInterface extends ChallengeInterface
{
    const EXECUTION_MODE_PHP_NORMAL     = 'php_normal';
    const EXECUTION_MODE_TWIG_NORMAL    = 'twig_normal';
    const EXECUTION_MODE_GHERKIN        = 'gherkin';

    /**
     * Add files and set the entry point
     *
     * @return FileBuilder
     */
    public function getFileBuilder();

    /**
     * Choose an EXECUTION_MODE_* constant
     *
     * This is how the code will be executed
     *
     * @return string
     */
    public function getExecutionMode();

    /**
     * Returns the path to a directory with a docker-compose.yml file
     *
     * @return string
     */
    public function getDockerComposeDirectory();

    /**
     * Configure the context for the code
     *
     * @param CodingContext $context
     * @return void
     */
    public function setupContext(CodingContext $context);

    /**
     * @param CodingExecutionResult $result
     * @return void
     * @throws GradingException If there are any grading problems
     */
    public function grade(CodingExecutionResult $result);

    /**
     * @param CorrectAnswer $correctAnswer A correct answer already filled in
     *                                     with the starting files from getFileBuilder()
     * @return void
     */
    public function configureCorrectAnswer(CorrectAnswer $correctAnswer);
}
