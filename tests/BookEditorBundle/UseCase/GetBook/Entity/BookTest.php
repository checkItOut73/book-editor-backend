<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\GetBook\Entity;

use PHPUnit\Framework\TestCase;

/**
 * @covers \App\BookEditorBundle\UseCase\GetBook\Entity\Book
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

    public function testGetTitle()
    {
        $this->assertSame('Ein Berg in einem See', $this->book->getTitle());
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
}
