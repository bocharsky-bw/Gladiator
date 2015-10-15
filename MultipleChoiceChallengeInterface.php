<?php

namespace KnpU\Gladiator;

use KnpU\Gladiator\MultipleChoice\AnswerBuilder;

interface MultipleChoiceChallengeInterface extends ChallengeInterface
{
    /**
     * @param AnswerBuilder $builder
     * @return void
     */
    public function configureAnswers(AnswerBuilder $builder);

    /**
     * @return string
     */
    public function getExplanation();
}
