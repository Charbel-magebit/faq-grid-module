<?php

namespace Magebit\Faq\Model\ResourceModel\Question;

use Magebit\Faq\Model\Question;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magebit\Faq\Model\ResourceModel\Question as QuestionResourceModel;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'id';

    protected function _construct()
    {
        $this->_init(
            Question::class,
            QuestionResourceModel::class
        );
    }
}