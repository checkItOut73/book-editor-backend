<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\GetParagraph\Exception;

use App\BookEditorBundle\Exception\NotFoundException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\BookEditorBundle\UseCase\GetParagraph\Exception\ParagraphNotFoundException
 */
class ParagraphNotFoundExceptionTest extends TestCase
{
    public function testExceptionIsExtendedCorrectly()
    {
        $this->assertInstanceOf(NotFoundException::class, new ParagraphNotFoundException());
    }
}
