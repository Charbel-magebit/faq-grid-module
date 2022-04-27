<?php

declare(strict_types=1);

namespace Magebit\Faq\Controller\Adminhtml\Question;

use Magebit\Faq\Controller\Adminhtml\BaseController;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\Page;

class Index extends BaseController implements HttpGetActionInterface
{
    public function execute(): Page
    {
        return $this->createPage('Magebit_Faq::faq', 'Frequently Asked Questions');
    }
}