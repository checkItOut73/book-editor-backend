<?php declare(strict_types = 1);

namespace App\BookEditorBundle\Entity;

use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * @covers \App\BookEditorBundle\Entity\Paragraph
 */
class ParagraphTest extends TestCase
{
    private Paragraph $paragraph;

    public function setUp(): void
    {
        $this->paragraph = (new Paragraph())
            ->setId(2)
            ->setNumberInChapter(22)
            ->setHeading('Der Stein der Weisen')
            ->setChapterId(85)
            ->setBookId(3)
            ->setVerseNumberInChapterOffset(48932)
            ->setVerses([
                (new Verse())
                    ->setNumberInParagraph(1)
                    ->setNumberInChapter(23)
                    ->setText(
                        'Die Geschichte der Bildenden Kunst vollzieht sich durch die Veränderung ' .
                        'der gesellschaftlichen Funktion und Stellung der Kunst, der theoretischen ' .
                        'Auffassung über sie sowie durch die Entwicklung der Kunstformen und Stilrichtungen.'
                    )
                    ->setParagraphId(2),
                (new Verse())
                    ->setNumberInParagraph(2)
                    ->setNumberInChapter(24)
                    ->setText(
                        'Im Gegensatz zur Kunstkritik wählt sich die Kunstgeschichte in der Regel historische ' .
                        'Gegenstände oder versucht zumindest sich zeitgenössischen Themen mit ' .
                        'einer wissenschaftlich abgesicherten, methodisch definierten Herangehensweise zu nähern.'
                    )
                    ->setParagraphId(2)
            ]);
    }

    public function testGetId()
    {
        $this->assertNull((new Paragraph())->getId());
        $this->assertSame(2, $this->paragraph->getId());
    }

    public function testGetNumberInChapter()
    {
        $this->assertSame(22, $this->paragraph->getNumberInChapter());
    }

    public function testIsHeadingNullReturnsWhetherHeadingIsNull()
    {
        $this->assertFalse($this->paragraph->isHeadingNull());
        $this->assertTrue((new Paragraph())->isHeadingNull());
    }

    public function testGetHeading()
    {
        $this->assertNull((new Paragraph())->getHeading());
        $this->assertSame('Der Stein der Weisen', $this->paragraph->getHeading());
    }

    public function testGetChapterId()
    {
        $this->assertSame(85, $this->paragraph->getChapterId());
    }

    public function testGetBookId()
    {
        $this->assertSame(3, $this->paragraph->getBookId());
    }

    public function testGetVerseNumberInChapterOffset()
    {
        $this->assertSame(48932, $this->paragraph->getVerseNumberInChapterOffset());
    }

    public function testAreVersesNullReturnsWhetherVersesAreNull()
    {
        $this->assertFalse($this->paragraph->areVersesNull());
        $this->assertTrue((new Paragraph())->areVersesNull());
    }

    public function testGetVerses()
    {
        $this->assertEquals(
            [
                (new Verse())
                    ->setNumberInParagraph(1)
                    ->setNumberInChapter(23)
                    ->setText(
                        'Die Geschichte der Bildenden Kunst vollzieht sich durch die Veränderung ' .
                        'der gesellschaftlichen Funktion und Stellung der Kunst, der theoretischen ' .
                        'Auffassung über sie sowie durch die Entwicklung der Kunstformen und Stilrichtungen.'
                    )
                    ->setParagraphId(2),
                (new Verse())
                    ->setNumberInParagraph(2)
                    ->setNumberInChapter(24)
                    ->setText(
                        'Im Gegensatz zur Kunstkritik wählt sich die Kunstgeschichte in der Regel historische ' .
                        'Gegenstände oder versucht zumindest sich zeitgenössischen Themen mit ' .
                        'einer wissenschaftlich abgesicherten, methodisch definierten Herangehensweise zu nähern.'
                    )
                    ->setParagraphId(2)
            ],
            $this->paragraph->getVerses()
        );
    }

    public function testGetVersesThrowsIfVersesAreNotSet()
    {
        $this->expectException(TypeError::class);
        $this->expectExceptionMessage('Return value must be of type array, null returned');

        (new Paragraph())->getVerses();
    }
}
