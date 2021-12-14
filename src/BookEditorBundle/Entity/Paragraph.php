<?php declare(strict_types = 1);

namespace App\BookEditorBundle\Entity;

class Paragraph
{
    private ?int $id = null; // allow null for new paragraphs
    private int $numberInChapter;
    private ?string $heading = null; // default must not be '' to keep heading if field is not given
    private int $chapterId;
    private int $bookId;
    private int $verseNumberInChapterOffset;

    /** @var array<Verse> $verses */
    private ?array $verses = null; // default must not be [] to keep verses if field is not given

    public function setId(int $id): Paragraph
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): ?int
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

    public function isHeadingNull(): bool
    {
        return is_null($this->heading);
    }

    public function getHeading(): ?string
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

    public function setBookId(int $bookId): Paragraph
    {
        $this->bookId = $bookId;

        return $this;
    }

    public function getBookId(): int
    {
        return $this->bookId;
    }

    public function setVerseNumberInChapterOffset(int $verseNumberInChapterOffset): Paragraph
    {
        $this->verseNumberInChapterOffset = $verseNumberInChapterOffset;

        return $this;
    }

    public function getVerseNumberInChapterOffset(): int
    {
        return $this->verseNumberInChapterOffset;
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

    public function areVersesNull(): bool
    {
        return is_null($this->verses);
    }

    /**
     * @return array<Verse>
     */
    public function getVerses(): array
    {
        return $this->verses;
    }
}
