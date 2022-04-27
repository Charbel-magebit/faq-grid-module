<?php

declare(strict_types=1);

namespace Magebit\Faq\Controller\Adminhtml\Question;

use Magebit\Faq\Api\Data\QuestionInterface;
use Magebit\Faq\Controller\Adminhtml\BaseController;
use Magebit\Faq\Model\Question;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpGetActionInterface;

class Disable extends BaseController implements HttpGetActionInterface
{
    public function execute(): Redirect
    {
        $id = (int)$this->getRequest()
            ->getParam('id');

        /** @var Question $question */
        $question = $this->questionRepository->getById($id);
        $question->setStatus(QuestionInterface::STATUS_DISABLED);
        $this->questionRepository->save($question);

        return $this->redirect('*/*');
    }
}