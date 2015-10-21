<?php

namespace KnpU\Gladiator;

use KnpU\Gladiator\CodingChallenge\CodingExecutionResult;
use KnpU\Gladiator\CodingChallenge\CorrectAnswer;
use KnpU\Gladiator\CodingChallenge\Exception\GradingException;
use KnpU\Gladiator\CodingChallenge\ChallengeBuilder;
use KnpU\Gladiator\CodingChallenge\CodingContext;
use KnpU\Gladiator\Worker\WorkerLoaderInterface;

/**
 * All activities will implement this interface
 */
interface CodingChallengeInterface extends ChallengeInterface
{
    // helper constants for the most common
    const EXECUTION_PHP_NORMAL          = 'KnpU\Gladiator\BaseWorker\Worker\PhpWorker';
    const EXECUTION_MODE_TWIG_NORMAL    = 'KnpU\Gladiator\BaseWorker\Worker\TwigWorker';
    const EXECUTION_MODE_GHERKIN        = 'KnpU\Gladiator\BaseWorker\Worker\GherkinWorker';

    /**
     * Add files and set the entry point
     *
     * @return ChallengeBuilder
     */
    public function getChallengeBuilder();

    /**
     * A worker name that you've configured.
     *
     * @return string
     */
    public function getWorkerConfig(WorkerLoaderInterface $loader);

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
