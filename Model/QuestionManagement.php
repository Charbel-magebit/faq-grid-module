<?php

declare(strict_types=1);

namespace Magebit\Faq\Model;

use Magebit\Faq\Api\Data\QuestionInterface;
use Magebit\Faq\Api\QuestionManagementInterface;
use Magebit\Faq\Api\QuestionRepositoryInterface;

class QuestionManagement implements QuestionManagementInterface
{
    private $questionRepository;

    public function __construct(QuestionRepositoryInterface $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }

    public function enableQuestion(QuestionInterface $question): void
    {
        $question->setStatus(QuestionInterface::STATUS_ENABLED);
        $this->questionRepository->save($question);
    }

    public function disableQuestion(QuestionInterface $question): void
    {
        $question->setStatus(QuestionInterface::STATUS_DISABLED);
        $this->questionRepository->save($question);
    }
}