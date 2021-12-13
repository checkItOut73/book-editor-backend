<?php declare(strict_types = 1);

namespace App\BookEditorBundle\Entity;

use PHPUnit\Framework\TestCase;

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
        $this->assertSame(2, $this->paragraph->getId());
    }

    public function testGetNumberInChapter()
    {
        $this->assertSame(22, $this->paragraph->getNumberInChapter());
    }

    public function testGetHeading()
    {
        $this->assertSame('Der Stein der Weisen', $this->paragraph->getHeading());
    }

    public function testGetChapterId()
    {
        $this->assertSame(85, $this->paragraph->getChapterId());
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
}
