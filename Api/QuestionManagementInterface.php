<?php

namespace Magebit\Faq\Api;

use Magebit\Faq\Api\Data\QuestionInterface;

interface QuestionManagementInterface
{
    public function enableQuestion(QuestionInterface $question);
    public function disableQuestion(QuestionInterface $question);
}