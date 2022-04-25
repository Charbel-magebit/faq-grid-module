<?php

namespace Magebit\Faq\Api;

use Magebit\Faq\Api\Data\QuestionInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface QuestionRepositoryInterface
{
    public function getById(int $id);
    public function save(QuestionInterface $question);
    public function getList(SearchCriteriaInterface $searchCriteria);
    public function delete(QuestionInterface $question);
    public function deleteById(int $id);
}