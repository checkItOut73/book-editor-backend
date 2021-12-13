<?php declare(strict_types = 1);

namespace App\BookEditorBundle\Entity;

use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * @covers \App\BookEditorBundle\Entity\Chapter
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
        $this->assertNull((new Chapter())->getId());
        $this->assertSame(5, $this->chapter->getId());
    }

    public function testGetNumber()
    {
        $this->assertSame(2, $this->chapter->getNumber());
    }

    public function testIsHeadingNullReturnsWhetherHeadingIsNull()
    {
        $this->assertFalse($this->chapter->isHeadingNull());
        $this->assertTrue((new Chapter())->isHeadingNull());
    }

    public function testGetHeading()
    {
        $this->assertNull((new Chapter())->getHeading());
        $this->assertSame('Die Wanderung durch das Tal', $this->chapter->getHeading());
    }

    public function testAreParagraphsNullReturnsWhetherParagraphsAreNull()
    {
        $this->assertFalse($this->chapter->areParagraphsNull());
        $this->assertTrue((new Chapter())->areParagraphsNull());
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

    public function testGetParagraphsThrowsIfParagraphsAreNotSet()
    {
        $this->expectException(TypeError::class);
        $this->expectExceptionMessage('Return value must be of type array, null returned');

        (new Chapter())->getParagraphs();
    }
}
