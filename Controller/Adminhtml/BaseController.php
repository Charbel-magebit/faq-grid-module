<?php

declare(strict_types=1);

namespace Magebit\Faq\Controller\Adminhtml;

use Magebit\Faq\Api\QuestionRepositoryInterface;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\Action;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\Result\Page;

abstract class BaseController extends Action
{
    /** @var QuestionRepositoryInterface $questionRepository */
    protected $questionRepository;

    public function __construct(
        Context $context,
        QuestionRepositoryInterface $questionRepository
    ) {
        parent::__construct($context);
        $this->questionRepository = $questionRepository;
    }

    protected function redirect(string $path): Redirect
    {
        /** @var Redirect $redirect */
        $redirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        return $redirect->setPath($path);
    }

    protected function createPage(string $activeMenu, string $title): Page
    {
        /** @var Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->setActiveMenu(__($activeMenu));

        $resultPage->getConfig()
            ->getTitle()
            ->prepend(__($title));

        return $resultPage;
    }
}