<?php declare(strict_types=1);

namespace Magebit\Faq\Setup\Patch\Data;

use Magebit\Faq\Model\ResourceModel\Question;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class DefaultQuestions implements DataPatchInterface
{
    /** @var ResourceConnection $resource */
    private $resource;

    public function __construct(
        ResourceConnection $resource
    )
    {
        $this->resource = $resource;
    }

    public static function getDependencies(): array
    {
        return [];
    }

    public function getAliases(): array
    {
        return [];
    }

    public function apply(): self
    {
        $connection = $this->resource->getConnection();

        $data = [
            [
                'question' => 'How can I change my shipping Address',
                'answer' => 'By default, the last used shipping address will be saved into your sample store account...',
                'status' => 1,
                'position' => 10,
            ],
            [
                'question' => 'How do I activate my account',
                'answer' => 'Just do the following...',
                'status' => 1,
                'position' => 20,
            ]
        ];

        // usually should not use insertMultiple but here as proof of concept
        $connection->insertMultiple(Question::MAIN_TABLE, $data);

        return $this;
    }
}