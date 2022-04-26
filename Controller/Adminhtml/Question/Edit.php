<?php declare(strict_types=1);

namespace Magebit\Faq\Controller\Adminhtml\Question;

use Magebit\Faq\Api\QuestionRepositoryInterface;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\Action;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
use Magebit\Faq\Model\QuestionFactory as QuestionModelFactory;

class Edit extends Action implements HttpGetActionInterface
{
    public $resultPageFactory;
    public $questionRepository;
    public $questionModelFactory;

    public function __construct(
        Context                     $context,
        PageFactory                 $resultPageFactory,
        QuestionRepositoryInterface $questionRepository,
        QuestionModelFactory        $questionModelFactory
    )
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->questionRepository = $questionRepository;
        $this->questionModelFactory = $questionModelFactory;
    }

    /**
     * @throws NoSuchEntityException
     */
    public function execute(): Page
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Magebit_Faq::faq');
        $resultPage->getConfig()->getTitle()->prepend(__('FAQ Question'));

        return $resultPage;
    }
}