<?php declare(strict_types = 1);

namespace App\BookEditorBundle\Entity;

class Paragraph
{
    private int $id;
    private int $numberInChapter;
    private string $heading;
    private int $chapterId;

    /** @var array<Verse> $verses */
    private array $verses;

    public function setId(int $id): Paragraph
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setNumberInChapter(int $numberInChapter): Paragraph
    {
        $this->numberInChapter = $numberInChapter;

        return $this;
    }

    public function getNumberInChapter(): int
    {
        return $this->numberInChapter;
    }

    public function setHeading(string $heading): Paragraph
    {
        $this->heading = $heading;

        return $this;
    }

    public function getHeading(): string
    {
        return $this->heading;
    }

    public function setChapterId(int $chapterId): Paragraph
    {
        $this->chapterId = $chapterId;

        return $this;
    }

    public function getChapterId(): int
    {
        return $this->chapterId;
    }

    /**
     * @param array<Verse> $verses
     * @return Paragraph
     */
    public function setVerses(array $verses): Paragraph
    {
        $this->verses = $verses;

        return $this;
    }

    /**
     * @return array<Verse>
     */
    public function getVerses(): array
    {
        return $this->verses;
    }
}
