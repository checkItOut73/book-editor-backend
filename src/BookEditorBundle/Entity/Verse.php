<?php declare(strict_types = 1);

namespace App\BookEditorBundle\Entity;

class Verse
{
    private ?int $id = null; // allow null for new verses
    private int $numberInParagraph;
    private int $numberInChapter;
    private ?string $text = null; // default must not be '' to keep text if field is not given
    private int $paragraphId;

    public function setId(int $id): Verse
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setNumberInParagraph(int $numberInParagraph): Verse
    {
        $this->numberInParagraph = $numberInParagraph;

        return $this;
    }

    public function getNumberInParagraph(): int
    {
        return $this->numberInParagraph;
    }

    public function setNumberInChapter(int $numberInChapter): Verse
    {
        $this->numberInChapter = $numberInChapter;

        return $this;
    }

    public function getNumberInChapter(): int
    {
        return $this->numberInChapter;
    }

    public function setText(string $text): Verse
    {
        $this->text = $text;

        return $this;
    }

    public function isTextNull(): bool
    {
        return is_null($this->text);
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setParagraphId(int $paragraphId): Verse
    {
        $this->paragraphId = $paragraphId;

        return $this;
    }

    public function getParagraphId(): int
    {
        return $this->paragraphId;
    }
}
