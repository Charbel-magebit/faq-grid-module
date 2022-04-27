<?php

declare(strict_types=1);

namespace Magebit\Faq\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Question extends AbstractDb
{

    public const MAIN_TABLE = 'magebit_faq_questions';
    public const ID_FIELD_NAME = 'id';

    protected function _construct()
    {
        $this->_init(
            self::MAIN_TABLE,
            self::ID_FIELD_NAME
        );
    }
}