<?php declare(strict_types=1);

namespace Magebit\Faq\Controller\Adminhtml\Question;

use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\Action;
use Magento\Framework\Controller\ResultFactory;
use Magebit\Faq\Api\QuestionRepositoryInterface;

class Delete extends Action implements HttpGetActionInterface
{
    private $questionRepository;

    /**
     */
    public function __construct(
        Context                     $context,
        QuestionRepositoryInterface $questionRepository
    )
    {
        parent::__construct($context);
        $this->questionRepository = $questionRepository;
    }

    public function execute(): Redirect
    {
        try {
            $id = (int)$this->getRequest()->getParam('id');
            $faq = $this->questionRepository->getById($id);
            if ($faq->getId()) {
                $this->questionRepository->delete($faq);
                $this->messageManager->addSuccessMessage(__('The question has been successfully deleted'));
            } else {
                $this->messageManager->addErrorMessage(__('The question does not exist'));
            }
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        /** @var Redirect $redirect */
        $redirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $redirect->setPath('*/*');

    }
}