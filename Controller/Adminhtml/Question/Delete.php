<?php

declare(strict_types=1);

namespace Magebit\Faq\Controller\Adminhtml\Question;

use Exception;
use Magebit\Faq\Controller\Adminhtml\BaseController;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpGetActionInterface;

class Delete extends BaseController implements HttpGetActionInterface
{
    public function execute(): Redirect
    {
        try {
            $id = (int)$this->getRequest()
                ->getParam('id');
            $faq = $this->questionRepository->getById($id);
            if ($faq->getId()) {
                $this->questionRepository->delete($faq);
                $this->messageManager->addSuccessMessage(__('The question has been successfully deleted'));
            } else {
                $this->messageManager->addErrorMessage(__('The question does not exist'));
            }
        } catch (Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        return $this->redirect('*/*');
    }
}