<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\GetBook\Exception;

use App\BookEditorBundle\Exception\NotFoundException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\BookEditorBundle\UseCase\GetBook\Exception\BookNotFoundException
 */
class BookNotFoundExceptionTest extends TestCase
{
    public function testExceptionIsExtendedCorrectly()
    {
        $this->assertInstanceOf(NotFoundException::class, new BookNotFoundException());
    }
}
