<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\EditVerse;

use App\BookEditorBundle\Exception\BadRequestException;
use App\BookEditorBundle\Entity\Verse;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\BookEditorBundle\UseCase\EditVerse\EditVerseRequestHandler
 */
class EditVerseRequestHandlerTest extends TestCase
{
    private $requestHandler;

    public function setUp(): void
    {
        $this->requestHandler = new EditVerseRequestHandler();
    }

    public function testGetVerseEntityFromJsonStringReturnCorrectVerseEntity()
    {
        $requestBodyJson = [
            'text' => 'Der Baum der Vergessenheit wird das Bewusstsein der Menschen erfassen.'
        ];
        $requestBodyJsonString = json_encode($requestBodyJson);

        $this->assertEquals(
            (new Verse())
                ->setText('Der Baum der Vergessenheit wird das Bewusstsein der Menschen erfassen.'),
            $this->requestHandler->getVerseEntityFromJsonString($requestBodyJsonString)
        );
    }

    public function testGetVerseEntityFromJsonStringThrowsIfJsonIsInvalid()
    {
        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage('The given json invalid!');

        $this->requestHandler->getVerseEntityFromJsonString('{broken json');
    }

    public function testGetVerseEntityFromJsonStringDoesNotSetTextIfNotGiven()
    {
        $this->assertEquals(
            new Verse(),
            $this->requestHandler->getVerseEntityFromJsonString('{}')
        );
    }

    public function testGetVerseEntityFromJsonStringThrowsIfInvalidTextIsGiven()
    {
        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage('The given text is invalid!');

        $this->requestHandler->getVerseEntityFromJsonString('{"text":123}');
    }
}
