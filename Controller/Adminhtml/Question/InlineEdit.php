<?php

namespace Magebit\Faq\Controller\Adminhtml\Question;

use Exception;
use Magebit\Faq\Api\QuestionRepositoryInterface;
use Magebit\Faq\Model\Question;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\JsonFactory;

class InlineEdit extends Action implements HttpPostActionInterface
{

    private $resultJsonFactory;
    private $questionRepository;

    public function __construct(
        Context $context,
        JsonFactory $resultJsonFactory,
        QuestionRepositoryInterface $questionRepository
    )
    {
        parent::__construct($context);
        $this->resultJsonFactory = $resultJsonFactory;
        $this->questionRepository = $questionRepository;
    }

    public function execute(): Json
    {
        $resultJson = $this->resultJsonFactory->create();
        $error = false;
        $messages = '';

        $postItems = $this->getRequest()->getParam('items', []);

        if (!($this->getRequest()->getParam('isAjax') && count($postItems))) {
            return $resultJson->setData(
                [
                    'messages' => [__('Please correct the data sent.')],
                    'error' => true,
                ]
            );
        }

        try {
            foreach (array_keys($postItems) as $questionId) {
                $question = $this->questionRepository->getById($questionId);
                $questionData = $this->filterPost($postItems[$questionId]);
                $this->validatePost($questionData, $error, $messages);
                $extendedQuestionData = $question->getData();
                $this->setQuestionData($question, $extendedQuestionData, $questionData);
                $this->questionRepository->save($question);
            }
        } catch (Exception $e) {
            $messages = __('Something went wrong while saving the page.');
            $error = true;
        }

        return $resultJson->setData(
            [
                'messages' => $messages,
                'error' => $error
            ]
        );
    }

    protected function filterPost($postData = []): array
    {
        $questionData['question'] = $postData['question'] ?? null;
        $questionData['answer'] = $postData['answer'] ?? null;
        $questionData['status'] = (bool)$postData['status'] ?? false;
        $questionData['position'] = (int)$postData['position'] ?? null;
        return $questionData;
    }

    protected function validatePost(array $questionData, string &$error, string &$messages)
    {
        if ($questionData['question'] === null || $questionData['answer'] === null) {
            $error = true;
            $messages = __('Question and Answer fields should not be empty');
        }
    }

    public function setQuestionData(
        Question $question,
        array    $extendedQuestionData,
        array    $questionData
    ): self
    {
        $question->setData(array_merge($question->getData(), $extendedQuestionData, $questionData));
        return $this;
    }
}