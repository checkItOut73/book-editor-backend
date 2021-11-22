<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\GetBook\Entity;

use PHPUnit\Framework\TestCase;

/**
 * @covers \App\BookEditorBundle\UseCase\GetBook\Entity\Chapter
 */
class ChapterTest extends TestCase
{
    private Chapter $chapter;

    public function setUp(): void
    {
        $this->chapter = (new Chapter())
            ->setId(5)
            ->setNumber(2)
            ->setHeading('Die Wanderung durch das Tal')
            ->setParagraphs([
                (new Paragraph())
                    ->setId(23)
                    ->setNumberInChapter(1)
                    ->setHeading('')
                    ->setChapterId(5),
                (new Paragraph())
                    ->setId(34)
                    ->setNumberInChapter(2)
                    ->setHeading('And then...')
                    ->setChapterId(5)
            ]);
    }

    public function testGetId()
    {
        $this->assertSame(5, $this->chapter->getId());
    }

    public function testGetNumber()
    {
        $this->assertSame(2, $this->chapter->getNumber());
    }

    public function testGetHeading()
    {
        $this->assertSame('Die Wanderung durch das Tal', $this->chapter->getHeading());
    }

    public function testGetParagraphs()
    {
        $this->assertEquals(
            [
                (new Paragraph())
                    ->setId(23)
                    ->setNumberInChapter(1)
                    ->setHeading('')
                    ->setChapterId(5),
                (new Paragraph())
                    ->setId(34)
                    ->setNumberInChapter(2)
                    ->setHeading('And then...')
                    ->setChapterId(5)
            ],
            $this->chapter->getParagraphs()
        );
    }
}
