<?php declare(strict_types=1);

namespace Magebit\Faq\Controller\Adminhtml\Question;

use Magebit\Faq\Api\QuestionRepositoryInterface;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\View\Result\PageFactory;

use Magebit\Faq\Model\QuestionFactory;

class Save extends Action implements HttpPostActionInterface
{
    /** @var PageFactory $pageFactory */
    protected $pageFactory;

    private $questionFactory;
    private $questionRepository;

    public function __construct(
        Context     $context,
        PageFactory $pageFactory,
        QuestionFactory $questionFactory,
        QuestionRepositoryInterface $questionRepository
    )
    {
        parent::__construct($context);
        $this->pageFactory = $pageFactory;
        $this->questionFactory = $questionFactory;
        $this->questionRepository = $questionRepository;
    }

    public function execute(): Redirect
    {
        $params = $this->getRequest()->getPostValue();

        $back = $params['back'];
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        $filteredParams = $this->filterParams($params);

        $question = $this->questionFactory->create();

        if (isset($filteredParams['id'])) {
            $question = $this->questionRepository->getById($filteredParams['id']);
        }

        $question->setData($filteredParams);

        $this->questionRepository->save($question);
        $this->messageManager->addSuccessMessage(__('The question was successfully saved'));

        if ($back === 'continue') {
            return $resultRedirect->setPath('*/*/edit', ['id' => $question->getId(), '_current' => true]);
        }

        return $resultRedirect->setPath('*/*/');
    }

    private function filterParams($params): array
    {
        $filteredParam = [];
        if ($params['id']) {
            $filteredParam['id'] = (int)$params['id'];
        }
        $filteredParam['question'] = $params['question'];
        $filteredParam['answer'] = $params['answer'];
        $filteredParam['status'] = (int)$params['status'];

        return $filteredParam;
    }
}