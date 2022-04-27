<?php declare(strict_types=1);

namespace Magebit\Faq\Block;

use Magebit\Faq\Api\Data\QuestionInterface;
use Magebit\Faq\Model\Question;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magebit\Faq\Api\QuestionRepositoryInterface;

/**
 *
 */
class QuestionList extends Template
{
    /**
     * @var QuestionRepositoryInterface $questionRepository
     */
    private $questionRepository;

    /**
     * @var SearchCriteriaBuilder $searchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var SortOrderBuilder $sortOrderBuilder
     */
    private $sortOrderBuilder;

    /**
     */
    public function __construct(
        Context                     $context,
        QuestionRepositoryInterface $questionRepository,
        SearchCriteriaBuilder       $searchCriteriaBuilder,
        SortOrderBuilder            $sortOrderBuilder,
        array                       $data = []
    )
    {
        parent::__construct($context, $data);
        $this->questionRepository = $questionRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->sortOrderBuilder = $sortOrderBuilder;
    }

    /**
     */
    public function getQuestions(): array
    {
        $sortOrder = $this->sortOrderBuilder->setField(QuestionInterface::POSITION)->setDirection('DESC')->create();
        $searchCriteria = $this->searchCriteriaBuilder->setSortOrders([$sortOrder])->create();
        $searchResult = $this->questionRepository->getList($searchCriteria);

        $frontendQuestions = [];

        /** @var Question $question */
        foreach ($searchResult->getItems() as $question) {
            $frontendQuestions[] = [
                QuestionInterface::QUESTION => $question->getQuestion(),
                QuestionInterface::ANSWER => $question->getAnswer()
            ];
        }

        return $frontendQuestions;
    }
}