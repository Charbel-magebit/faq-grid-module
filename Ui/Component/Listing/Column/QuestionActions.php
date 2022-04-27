<?php declare(strict_types=1);

namespace Magebit\Faq\Ui\Component\Listing\Column;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class QuestionActions extends Column
{

    public $urlBuilder;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = [])
    {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource): array
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $item[$this->getData('name')] = [
                    'enable' => [
                        'href' => $this->urlBuilder->getUrl('faq/question/enable', ['id' => $item['id']]),
                        'label' => __('Enable')
                    ],
                    'disable' => [
                        'href' => $this->urlBuilder->getUrl('faq/question/disable', ['id' => $item['id']]),
                        'label' => __('Disable')
                    ],
                    'delete' => [
                        'href' => $this->urlBuilder->getUrl('faq/question/delete', ['id' => $item['id']]),
                        'label' => __('Delete')
                    ],
                    'edit' => [
                        'href' => $this->urlBuilder->getUrl('faq/question/edit', ['id' => $item['id']]),
                        'label' => __('Edit')
                    ],
                ];
            }
        }

        return $dataSource;
    }
}