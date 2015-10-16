<?php

namespace KnpU\Gladiator\Worker;

use KnpU\Gladiator\CodingChallenge\CodingContext;
use KnpU\Gladiator\CodingChallenge\CodingExecutionResult;

/**
 * @author Kristen Gilden <kristen.gilden@knplabs.com>
 */
interface WorkerInterface
{
    /**
     * Execute the code and modify the CodingExecutionResult
     *
     * @param string $rootDir Where all the files have been placed
     * @param string $entryPointFilename
     * @param CodingContext $context
     * @param CodingExecutionResult $result
     */
    public function executeCode($rootDir, $entryPointFilename, CodingContext $context, CodingExecutionResult $result);

    /**
     * Gets the name of the worker.
     *
     * @return string
     */
    public function getName();
}
