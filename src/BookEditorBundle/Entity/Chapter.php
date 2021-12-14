<?php declare(strict_types = 1);

namespace App\BookEditorBundle\Entity;

class Chapter
{
    private ?int $id = null; // allow null for new chapters
    private int $number;
    private ?string $heading = null; // default must not be '' to keep heading if field is not given
    private int $bookId;

    /** @var array<Paragraph> $paragraphs */
    private ?array $paragraphs = null; // default must not be [] to keep paragraphs if field is not given

    public function setId(int $id): Chapter
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): ?int
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

    public function isHeadingNull(): bool
    {
        return is_null($this->heading);
    }

    public function getHeading(): ?string
    {
        return $this->heading;
    }

    public function setBookId(int $bookId): Chapter
    {
        $this->bookId = $bookId;

        return $this;
    }

    public function getBookId(): int
    {
        return $this->bookId;
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

    public function areParagraphsNull(): bool
    {
        return is_null($this->paragraphs);
    }

    /**
     * @return array<Paragraph>
     */
    public function getParagraphs(): array
    {
        return $this->paragraphs;
    }
}
