<?php

declare(strict_types=1);

namespace Magebit\Faq\Controller\Adminhtml\Question;

use Exception;
use Magebit\Faq\Controller\Adminhtml\BaseController;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Exception\LocalizedException;
use Magento\Ui\Component\MassAction\Filter;
use Magebit\Faq\Model\ResourceModel\Question\CollectionFactory as QuestionCollectionFactory;
use Magebit\Faq\Api\QuestionRepositoryInterface;

class MassDelete extends BaseController
{

    /**
     * @var QuestionCollectionFactory
     */
    private $questionCollectionFactory;

    /**
     * @var Filter
     */
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

    public function execute(): Redirect
    {
        try {
            $questionsToDelete = $this->filter->getCollection($this->questionCollectionFactory->create());

            foreach ($questionsToDelete as $questionToDelete) {
                $this->questionRepository->delete($questionToDelete);
            }
        } catch (Exception $e) {
            $this->messageManager->addErrorMessage('Could not delete questions');
        }

        return $this->redirect('*/*/');
    }
}