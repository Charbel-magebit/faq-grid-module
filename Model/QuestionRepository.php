<?php

declare(strict_types=1);

namespace Magebit\Faq\Model;

use Exception;
use Magebit\Faq\Api\Data\QuestionInterface;
use Magebit\Faq\Api\QuestionRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magebit\Faq\Model\ResourceModel\QuestionFactory as QuestionResourceModelFactory;
use Magebit\Faq\Model\QuestionFactory as QuestionModelFactory;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magebit\Faq\Model\ResourceModel\Question\CollectionFactory as QuestionCollectionFactory;
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
    ) {
        $this->questionResourceModelFactory = $questionResourceModelFactory;
        $this->questionModelFactory = $questionModelFactory;
        $this->questionCollectionFactory = $questionCollectionFactory;
        $this->searchResultFactory = $searchResultFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @throws NoSuchEntityException
     */
    public function getById(int $id): QuestionInterface
    {
        try {
            $questionResourceModel = $this->questionResourceModelFactory->create();
            $question = $this->questionModelFactory->create();
            $questionResourceModel->load($question, $id);

            return $question;
        } catch (Exception $e) {
            throw new NoSuchEntityException(__('The CMS page with the "%1" ID doesn\'t exist.', $id));
        }
    }

    /**
     * @throws CouldNotSaveException
     */
    public function save(QuestionInterface $question): void
    {
        try {
            $questionResourceModel = $this->questionResourceModelFactory->create();
            $questionResourceModel->save($question);
        } catch (Exception $e) {
            throw new CouldNotSaveException(__('Could not save question'));
        }
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
     * @throws CouldNotDeleteException
     */
    public function delete(QuestionInterface $question): void
    {
        try {
            $questionResourceModel = $this->questionResourceModelFactory->create();
            $questionResourceModel->delete($question);
        } catch (Exception $e) {
            throw new CouldNotDeleteException(
                __('Could not delete the page: %1', $e->getMessage())
            );
        }
    }

    /**
     * @throws CouldNotDeleteException
     */
    public function deleteById(int $id): void
    {
        try {
            $question = $this->getById($id);
            $this->delete($question);
        } catch (Exception $e) {
            throw new CouldNotDeleteException(
                __('Could not delete the page: %1', $e->getMessage())
            );
        }
    }
}