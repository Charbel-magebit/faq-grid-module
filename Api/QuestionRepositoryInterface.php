<?php

namespace Magebit\Faq\Api;

use Magebit\Faq\Api\Data\QuestionInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;

interface QuestionRepositoryInterface
{
    public function getById(int $id): QuestionInterface;

    public function save(QuestionInterface $question): void;

    public function getList(SearchCriteriaInterface $searchCriteria): SearchResultsInterface;

    public function delete(QuestionInterface $question): void;

    public function deleteById(int $id): void;
}