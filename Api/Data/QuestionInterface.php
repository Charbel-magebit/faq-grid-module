<?php

namespace Magebit\Faq\Api\Data;

interface QuestionInterface
{
    const QUESTION = 'question';
    const ANSWER = 'answer';
    const STATUS = 'status';
    const POSITION = 'position';
    const UPDATED_AT = 'updated_at';

    public function getQuestion(): string;

    public function setQuestion(string $question);

    public function getAnswer(): string;

    public function setAnswer(string $answer);

    public function getStatus(): bool;

    public function setStatus(bool $status);

    public function getPosition(): int;

    public function setPosition(int $position);

    public function getUpdatedAt(): string;
}