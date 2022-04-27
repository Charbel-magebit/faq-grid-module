<?php

namespace Magebit\Faq\Api;

use Magebit\Faq\Api\Data\QuestionInterface;

interface QuestionManagementInterface
{
    public function enableQuestion(QuestionInterface $question): void;

    public function disableQuestion(QuestionInterface $question): void;
}