<?php declare(strict_types=1);

namespace Magebit\Faq\Controller\Adminhtml\Question;

use Magebit\Faq\Model\Question;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\Action;
use Magento\Framework\Controller\ResultFactory;
use Magebit\Faq\Api\QuestionRepositoryInterface;

class Enable extends Action implements HttpGetActionInterface
{
    private $questionRepository;


    public function __construct(
        Context     $context,
        QuestionRepositoryInterface $questionRepository
    )
    {
        parent::__construct($context);
        $this->questionRepository = $questionRepository;
    }

    public function execute(): Redirect
    {
        $id = (int)$this->getRequest()->getParam('id');
        /** @var Question $question */
        $question = $this->questionRepository->getById($id);
        $question->setStatus(true);
        $this->questionRepository->save($question);

        /** @var Redirect $redirect */
        $redirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $redirect->setPath('*/*');

    }
}