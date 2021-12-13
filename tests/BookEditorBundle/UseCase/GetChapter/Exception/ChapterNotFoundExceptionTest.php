<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\GetChapter\Exception;

use App\BookEditorBundle\Exception\NotFoundException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\BookEditorBundle\UseCase\GetChapter\Exception\ChapterNotFoundException
 */
class ChapterNotFoundExceptionTest extends TestCase
{
    public function testExceptionIsExtendedCorrectly()
    {
        $this->assertInstanceOf(NotFoundException::class, new ChapterNotFoundException());
    }
}
