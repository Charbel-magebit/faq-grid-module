<?php

namespace Magebit\Faq\Model;

use Exception;
use Magebit\Faq\Api\Data\QuestionInterface;
use Magebit\Faq\Api\QuestionRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magebit\Faq\Model\ResourceModel\QuestionFactory as QuestionResourceModelFactory;
use Magebit\Faq\Model\QuestionFactory as QuestionModelFactory;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magebit\Faq\Model\ResourceModel\Question\CollectionFactory as QuestionCollectionFactory;
use Magebit\Faq\Model\ResourceModel\Question\Collection as QuestionCollection;
use Magento\Framework\Api\SearchResultsInterfaceFactory as SearchResultFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessor;


class QuestionRepository implements QuestionRepositoryInterface
{

    private $questionResourceModelFactory;
    private $questionModelFactory;
    private $questionCollectionFactory;
    private $searchResultFactory;
    private $collectionProcessor;

    public function __construct(
        QuestionResourceModelFactory $questionResourceModelFactory,
        QuestionModelFactory $questionModelFactory,
        QuestionCollectionFactory $questionCollectionFactory,
        SearchResultFactory $searchResultFactory,
        CollectionProcessor $collectionProcessor
    )
    {
        $this->questionResourceModelFactory = $questionResourceModelFactory;
        $this->questionModelFactory = $questionModelFactory;
        $this->questionCollectionFactory = $questionCollectionFactory;
        $this->searchResultFactory = $searchResultFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @throws NoSuchEntityException
     */
    public function getById(int $id): Question
    {
        $questionResourceModel = $this->questionResourceModelFactory->create();
        $question = $this->questionModelFactory->create();
        $questionResourceModel->load($question, $id);
        if (!$question->getId()) {
            throw new NoSuchEntityException(__('The CMS page with the "%1" ID doesn\'t exist.', $id));
        }
        return $question;
    }

    /**
     * @throws AlreadyExistsException
     */
    public function save(QuestionInterface $question)
    {
        $questionResourceModel = $this->questionResourceModelFactory->create();
        $questionResourceModel->save($question);
    }

    public function getList(SearchCriteriaInterface $searchCriteria): SearchResultsInterface
    {
        $searchResult = $this->searchResultFactory->create();
        $collection = $this->questionCollectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResult->setItems($collection->getItems());
        $searchResult->setTotalCount($collection->getSize());

        return $searchResult;
    }

    /**
     * @throws Exception
     */
    public function delete(QuestionInterface $question): void
    {
        $questionResourceModel = $this->questionResourceModelFactory->create();
        $questionResourceModel->delete($question);
    }

    /**
     * @throws NoSuchEntityException
     * @throws Exception
     */
    public function deleteById(int $id): void
    {
        $question = $this->getById($id);
        $this->delete($question);
    }
}