<?php

declare(strict_types=1);

namespace Magebit\Faq\Controller\Adminhtml\Question;

use Magebit\Faq\Api\Data\QuestionInterface;
use Magebit\Faq\Api\QuestionManagementInterface;
use Magebit\Faq\Model\Question;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Ui\Component\MassAction\Filter;
use Magebit\Faq\Model\ResourceModel\Question\CollectionFactory as QuestionCollectionFactory;
use Magebit\Faq\Api\QuestionRepositoryInterface;


class MassEnable extends Action implements HttpPostActionInterface
{
    /**
     * @var Filter $filter
     */
    protected $filter;

    protected $questionCollectionFactory;

    protected $questionRepository;
    protected $questionManagement;

    public function __construct(
        Context $context,
        Filter $filter,
        QuestionCollectionFactory $questionCollectionFactory,
        QuestionRepositoryInterface $questionRepository,
        QuestionManagementInterface $questionManagement
    ) {
        $this->filter = $filter;
        $this->questionCollectionFactory = $questionCollectionFactory;
        $this->questionRepository = $questionRepository;
        $this->questionManagement = $questionManagement;
        parent::__construct($context);
    }

    /**
     * @throws LocalizedException
     */
    public function execute(): Redirect
    {
        $questionCollection = $this->filter->getCollection($this->questionCollectionFactory->create());

        /** @var Question $question */
        foreach ($questionCollection as $question) {
            $this->questionManagement->enableQuestion($question);
        }

        $this->messageManager->addSuccessMessage(
            __('A total of %1 question(s) have been enabled.', $questionCollection->getSize())
        );

        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        return $resultRedirect->setPath('*/*/');
    }
}