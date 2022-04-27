<?php

namespace Magebit\Faq\Controller\Adminhtml\Question;

use Magebit\Faq\Model\Question;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\Action;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\Result\PageFactory;
use Magebit\Faq\Api\QuestionRepositoryInterface;

class Disable extends Action implements HttpGetActionInterface
{
    /** @var PageFactory $pageFactory */
    protected $pageFactory;
    private $questionRepository;


    public function __construct(
        Context     $context,
        PageFactory $pageFactory,
        QuestionRepositoryInterface $questionRepository
    )
    {
        parent::__construct($context);
        $this->pageFactory = $pageFactory;
        $this->questionRepository = $questionRepository;
    }

    public function execute(): Redirect
    {
        $id = $this->getRequest()->getParam('id');
        /** @var Question $question */
        $question = $this->questionRepository->getById((int)$id);
        $question->setStatus(false);
        $this->questionRepository->save($question);

        /** @var Redirect $redirect */
        $redirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $redirect->setPath('*/*');
    }
}