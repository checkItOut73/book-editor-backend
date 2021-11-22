<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\GetBook\Entity;

class Chapter
{
    private int $id;
    private int $number;
    private string $heading;

    /** @var array<Paragraph> $paragraphs */
    private array $paragraphs;

    public function setId(int $id): Chapter
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setNumber(int $number): Chapter
    {
        $this->number = $number;

        return $this;
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function setHeading(string $heading): Chapter
    {
        $this->heading = $heading;

        return $this;
    }

    public function getHeading(): string
    {
        return $this->heading;
    }

    /**
     * @param array<Paragraph> $paragraphs
     * @return Chapter
     */
    public function setParagraphs(array $paragraphs): Chapter
    {
        $this->paragraphs = $paragraphs;

        return $this;
    }

    /**
     * @return array<Paragraph>
     */
    public function getParagraphs(): array
    {
        return $this->paragraphs;
    }
}
