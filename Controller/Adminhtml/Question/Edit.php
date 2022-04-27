<?php declare(strict_types=1);

namespace Magebit\Faq\Controller\Adminhtml\Question;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\Action;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Result\Page;

class Edit extends Action implements HttpGetActionInterface
{
    /**
     * @throws NoSuchEntityException
     */
    public function execute(): Page
    {
        /** @var Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->setActiveMenu('Magebit_Faq::faq');
        $resultPage->getConfig()->getTitle()->prepend(__('FAQ Question'));

        return $resultPage;
    }
}