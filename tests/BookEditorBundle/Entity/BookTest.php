<?php declare(strict_types = 1);

namespace App\BookEditorBundle\Entity;

use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * @covers \App\BookEditorBundle\Entity\Book
 */
class BookTest extends TestCase
{
    private Book $book;

    public function setUp(): void
    {
        $this->book = (new Book())
            ->setId(2)
            ->setTitle('Ein Berg in einem See')
            ->setChapters([
                (new Chapter())
                    ->setId(1)
                    ->setHeading('Ein großer Stein'),
                (new Chapter())
                    ->setId(2)
                    ->setHeading('Der Braunbär stammt vom Känguru ab')
            ]);
    }

    public function testGetId()
    {
        $this->assertSame(2, $this->book->getId());
    }

    public function testIsTitleNullReturnsWhetherTitleIsNull()
    {
        $this->assertFalse($this->book->isTitleNull());
        $this->assertTrue((new Book())->isTitleNull());
    }

    public function testGetTitle()
    {
        $this->assertSame('Ein Berg in einem See', $this->book->getTitle());
    }

    public function testAreChaptersNullReturnsWhetherChaptersAreNull()
    {
        $this->assertFalse($this->book->areChaptersNull());
        $this->assertTrue((new Book())->areChaptersNull());
    }

    public function testGetChapters()
    {
        $this->assertEquals(
            [
                (new Chapter())
                    ->setId(1)
                    ->setHeading('Ein großer Stein'),
                (new Chapter())
                    ->setId(2)
                    ->setHeading('Der Braunbär stammt vom Känguru ab')
            ],
            $this->book->getChapters()
        );
    }

    public function testGetChaptersThrowsIfChaptersAreNotSet()
    {
        $this->expectException(TypeError::class);
        $this->expectExceptionMessage('Return value must be of type array, null returned');

        (new Book())->getChapters();
    }
}
