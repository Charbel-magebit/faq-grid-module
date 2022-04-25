<?php declare(strict_types=1);

namespace Magebit\Faq\Block;

use Magebit\Faq\Model\Question;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Framework\View\Element\Template;
use Magebit\Faq\Model\ResourceModel\Question\Collection as QuestionCollection;
use Magento\Framework\View\Element\Template\Context;
use Magebit\Faq\Api\QuestionRepositoryInterface;

class QuestionList extends Template
{
    private $questionRepository;
    private $searchCriteriaBuilder;
    private $sortOrderBuilder;

    public function __construct(
        Context            $context,
        QuestionRepositoryInterface $questionRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        SortOrderBuilder $sortOrderBuilder,
        array              $data = []
    )
    {
        parent::__construct($context, $data);
        $this->questionRepository = $questionRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->sortOrderBuilder = $sortOrderBuilder;
    }

    public function getQuestions(): array
    {
        $sortOrder = $this->sortOrderBuilder->setField('position')->setDirection('DESC')->create();
        $searchCriteria = $this->searchCriteriaBuilder->setSortOrders([$sortOrder])->create();
        $searchResult = $this->questionRepository->getList($searchCriteria);

        $frontendQuestions = [];
        /**
         * @var Question $question
         */
        foreach ($searchResult->getItems() as $question) {
            $frontendQuestions[] = [
                'question' => $question->getQuestion(),
                'answer' => $question->getAnswer()
            ];
        }

        return $frontendQuestions;
    }
}