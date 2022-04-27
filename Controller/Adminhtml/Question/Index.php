<?php declare(strict_types=1);

namespace Magebit\Faq\Controller\Adminhtml\Question;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\Action;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\Result\Page;

class Index extends Action implements HttpGetActionInterface
{
    public function execute(): Page
    {
        /** @var Page $page */
        $page = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $page->setActiveMenu('Magebit_Faq::faq');
        $page->getConfig()->getTitle()->prepend(__('Frequently Asked Questions'));

        return $page;
    }
}