<?php

namespace Magebit\Faq\Controller\Adminhtml\Question;

use Magebit\Faq\Model\Question;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Ui\Component\MassAction\Filter;
use Magebit\Faq\Model\ResourceModel\Question\CollectionFactory as QuestionCollectionFactory;
use Magebit\Faq\Api\QuestionRepositoryInterface;


class MassDisable extends Action implements HttpPostActionInterface
{
    protected $filter;

    protected $questionCollectionFactory;

    protected $questionRepository;

    public function __construct(
        Context $context,
        Filter $filter,
        QuestionCollectionFactory $questionCollectionFactory,
        QuestionRepositoryInterface $questionRepository
    )
    {
        $this->filter = $filter;
        $this->questionCollectionFactory = $questionCollectionFactory;
        $this->questionRepository = $questionRepository;
        parent::__construct($context);
    }

    public function execute()
    {
        $questionCollection = $this->filter->getCollection($this->questionCollectionFactory->create());

        /** @var Question $question */
        foreach ($questionCollection as $question) {
            $question->setStatus(false);
            $this->questionRepository->save($question);
        }

        $this->messageManager->addSuccessMessage(
            __('A total of %1 question(s) have been enabled.', $questionCollection->getSize())
        );

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}