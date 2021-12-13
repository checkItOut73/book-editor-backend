<?php declare(strict_types = 1);

namespace App\BookEditorBundle\Entity;

class Book
{
    private int $id;
    private ?string $title = null; // default must not be '' to keep title if field is not given

    /** @var array<Chapter> $chapters */
    private ?array $chapters = null; // default must not be [] to keep chapters if field is not given

    public function setId(int $id): Book
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setTitle(string $title): Book
    {
        $this->title = $title;

        return $this;
    }

    public function isTitleNull(): bool
    {
        return is_null($this->title);
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param array<Chapter> $chapters
     * @return Book
     */
    public function setChapters(array $chapters): Book
    {
        $this->chapters = $chapters;

        return $this;
    }

    public function areChaptersNull(): bool
    {
        return is_null($this->chapters);
    }

    /**
     * @return array<Chapter>
     */
    public function getChapters(): array
    {
        return $this->chapters;
    }
}
