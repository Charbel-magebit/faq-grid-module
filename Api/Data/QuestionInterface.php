<?php

namespace Magebit\Faq\Api\Data;

interface QuestionInterface
{
    const QUESTION = 'question';
    const ANSWER = 'answer';
    const STATUS = 'status';
    const POSITION = 'position';
    const UPDATED_AT = 'updated_at';

    const STATUS_VALUES = [
        0 => false,
        1 => true,
    ];
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    public function getQuestion(): string;

    public function setQuestion(string $question);

    public function getAnswer(): string;

    public function setAnswer(string $answer);

    public function getStatus(): bool;

    public function setStatus(int $status);

    public function getPosition(): int;

    public function setPosition(int $position);

    public function getUpdatedAt(): string;
}