<?php declare(strict_types = 1);

namespace App\BookEditorBundle\Entity;

use PHPUnit\Framework\TestCase;

/**
 * @covers \App\BookEditorBundle\Entity\Verse
 */
class VerseTest extends TestCase
{
    private Verse $verse;

    public function setUp(): void
    {
        $this->verse = (new Verse())
            ->setId(5643)
            ->setNumberInParagraph(12)
            ->setNumberInChapter(44)
            ->setText('Keine Ahnung was noch kommt...')
            ->setParagraphId(5);
    }

    public function testGetId()
    {
        $this->assertSame(5643, $this->verse->getId());
    }

    public function testGetNumberInParagraph()
    {
        $this->assertSame(12, $this->verse->getNumberInParagraph());
    }

    public function testGetNumberInChapter()
    {
        $this->assertSame(44, $this->verse->getNumberInChapter());
    }

    public function testGetHeading()
    {
        $this->assertSame('Keine Ahnung was noch kommt...', $this->verse->getText());
    }

    public function testGetParagraphId()
    {
        $this->assertSame(5, $this->verse->getParagraphId());
    }
}
