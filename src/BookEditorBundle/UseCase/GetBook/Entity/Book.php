<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\GetBook\Entity;

class Book
{
    private int $id;
    private string $title;

    /** @var array<Chapter> $chapters */
    private array $chapters;

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

    /**
     * @return array<Chapter>
     */
    public function getChapters(): array
    {
        return $this->chapters;
    }
}
