<?php

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

    public function enableQuestion(QuestionInterface $question)
    {
        $question->setStatus(true);
        $this->questionRepository->save($question);
    }

    public function disableQuestion(QuestionInterface $question)
    {
        $question->setStatus(false);
        $this->questionRepository->save($question);
    }
}