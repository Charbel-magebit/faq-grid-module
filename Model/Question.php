<?php

declare(strict_types=1);

namespace Magebit\Faq\Model;

use Magebit\Faq\Api\Data\QuestionInterface;
use Magento\Framework\Model\AbstractModel;

class Question extends AbstractModel implements QuestionInterface
{

    protected function _construct()
    {
        $this->_init(ResourceModel\Question::class);
    }


    public function getQuestion(): string
    {
        return $this->_getData(self::QUESTION);
    }

    public function setQuestion(string $question): self
    {
        $this->setData(self::QUESTION, $question);

        return $this;
    }

    public function getAnswer(): string
    {
        return $this->_getData(self::ANSWER);
    }

    public function setAnswer(string $answer): self
    {
        $this->setData(self::ANSWER, $answer);

        return $this;
    }

    public function getStatus(): bool
    {
        return $this->_getData(self::STATUS);
    }

    public function setStatus(int $status): self
    {
        $this->setData(self::STATUS, QuestionInterface::STATUS_VALUES[$status]);

        return $this;
    }

    public function getPosition(): int
    {
        return $this->_getData(self::POSITION);
    }

    public function setPosition(int $position): self
    {
        $this->setData(self::POSITION, $position);

        return $this;
    }

    public function getUpdatedAt(): string
    {
        return $this->_getData(self::UPDATED_AT);
    }
}