<?php declare(strict_types=1);

namespace Magebit\Faq\Controller\Adminhtml\Question;

use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\Action;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\Result\PageFactory;

use Magebit\Faq\Model\QuestionFactory;
use Magebit\Faq\Model\ResourceModel\Question as QuestionResourceModel;

class Delete extends Action implements HttpGetActionInterface
{
    /** @var PageFactory $pageFactory */
    protected $pageFactory;

    private $questionResourceModel;
    private $questionFactory;

    public function __construct(
        Context     $context,
        PageFactory $pageFactory,
        QuestionResourceModel $questionResourceModel,
        QuestionFactory $questionFactory
    )
    {
        parent::__construct($context);
        $this->pageFactory = $pageFactory;
        $this->questionFactory = $questionFactory;
        $this->questionResourceModel = $questionResourceModel;
    }

    public function execute(): Redirect
    {
        try {
            $id = $this->getRequest()->getParam('id');
            $faq = $this->questionFactory->create();
            $this->questionResourceModel->load($faq, $id);
            if ($faq->getId()) {
                $this->questionResourceModel->delete($faq);
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