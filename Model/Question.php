<?php declare(strict_types=1);

namespace Magebit\Faq\Model;

use Magebit\Faq\Api\Data\QuestionInterface;
use Magento\Framework\Model\AbstractModel;

class Question extends AbstractModel implements QuestionInterface
{

    protected function _construct()
    {
        $this->_init(\Magebit\Faq\Model\ResourceModel\Question::class);
    }


    public function getQuestion(): string
    {
        return $this->_getData(self::QUESTION);
    }

    public function setQuestion(string $question): self
    {
        $questionField = self::QUESTION;
        $this->$questionField = $question;
        return $this;
    }

    public function getAnswer(): string
    {
        return $this->_getData(self::ANSWER);
    }

    public function setAnswer(string $answer): self
    {
        $answerField = self::ANSWER;
        $this->$answerField = $answer;
        return $this;
    }

    public function getStatus(): bool
    {
        return $this->_getData(self::STATUS);
    }

    public function setStatus(bool $status): self
    {
        $statusField = self::STATUS;
        $this->$statusField = $status;
        return $this;
    }

    public function getPosition(): int
    {
        return $this->_getData(self::POSITION);
    }

    public function setPosition(int $position): self
    {
        $positionField = self::POSITION;
        $this->$positionField = $position;
        return $this;
    }

    public function getUpdatedAt(): string
    {
        return $this->_getData(self::UPDATED_AT);
    }
}