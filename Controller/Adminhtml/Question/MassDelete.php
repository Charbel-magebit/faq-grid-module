<?php

declare(strict_types=1);

namespace Magebit\Faq\Controller\Adminhtml\Question;

use Magebit\Faq\Controller\Adminhtml\BaseController;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Exception\LocalizedException;
use Magento\Ui\Component\MassAction\Filter;
use Magebit\Faq\Model\ResourceModel\Question\CollectionFactory as QuestionCollectionFactory;
use Magebit\Faq\Api\QuestionRepositoryInterface;

class MassDelete extends BaseController
{

    private $questionCollectionFactory;
    private $filter;

    public function __construct(
        Context $context,
        Filter $filter,
        QuestionCollectionFactory $questionCollectionFactory,
        QuestionRepositoryInterface $questionRepository
    ) {
        parent::__construct($context, $questionRepository);
        $this->filter = $filter;
        $this->questionCollectionFactory = $questionCollectionFactory;
        $this->questionRepository = $questionRepository;
    }

    /**
     * @throws LocalizedException
     */
    public function execute()
    {
        $questionsToDelete = $this->filter->getCollection($this->questionCollectionFactory->create());

        foreach ($questionsToDelete as $questionToDelete) {
            $this->questionRepository->delete($questionToDelete);
        }

        return $this->redirect('*/*/');
    }
}