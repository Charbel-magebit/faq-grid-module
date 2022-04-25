<?php

namespace Magebit\Faq\Controller\Adminhtml\Question;

use Magento\Framework\App\Action\Action;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Ui\Component\MassAction\Filter;
use Magebit\Faq\Model\ResourceModel\Question\CollectionFactory as QuestionCollectionFactory;

class MassDelete extends Action
{

    private $questionCollectionFactory;

    public function __construct(
        Context $context,
        Filter $filter,
        QuestionCollectionFactory $questionCollectionFactory
    )
    {
        parent::__construct($context);
        $this->filter = $filter;
        $this->questionCollectionFactory = $questionCollectionFactory;
    }

    /**
     * @throws LocalizedException
     */
    public function execute()
    {
        $questionsToDelete = $this->filter->getCollection($this->questionCollectionFactory->create());

        foreach ($questionsToDelete as $questionToDelete) {
            $questionToDelete->delete();
        }
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}