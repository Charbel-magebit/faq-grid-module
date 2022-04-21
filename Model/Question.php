<?php declare(strict_types=1);

namespace Magebit\Faq\Model;

use Magento\Framework\Model\AbstractModel;

class Question extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(\Magebit\Faq\Model\ResourceModel\Question::class);
    }
}