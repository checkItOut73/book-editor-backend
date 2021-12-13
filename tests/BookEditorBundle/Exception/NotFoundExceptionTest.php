<?php declare(strict_types = 1);

namespace App\BookEditorBundle\Exception;

use Exception;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\BookEditorBundle\Exception\NotFoundException
 */
class NotFoundExceptionTest extends TestCase
{
    public function testExceptionIsExtendedCorrectly()
    {
        $this->assertInstanceOf(Exception::class, new NotFoundException());
    }
}
