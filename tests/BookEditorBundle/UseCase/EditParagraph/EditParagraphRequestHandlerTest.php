<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\EditParagraph;

use App\BookEditorBundle\Exception\BadRequestException;
use App\BookEditorBundle\Entity\Paragraph;
use App\BookEditorBundle\Entity\Verse;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\BookEditorBundle\UseCase\EditParagraph\EditParagraphRequestHandler
 */
class EditParagraphRequestHandlerTest extends TestCase
{
    private $requestHandler;

    public function setUp(): void
    {
        $this->requestHandler = new EditParagraphRequestHandler();
    }

    public function testGetParagraphEntityFromJsonStringReturnCorrectParagraphEntity()
    {
        $requestBodyJson = [
            'heading' => 'Der Baum der Vergessenheit',
            'verses' => [
                [
                    'id' => 64356,
                    'text' => 'Ein Mensch, der seine ausgeprägteste Eigenschaft verliert, ' .
                        'verliert auch seine Stärke und verfällt in sich zusammen.'
                ],
                [
                    'id' => 64357,
                    'text' => 'Regula Dorenus ist das perfekte Beispiel dafür, ' .
                        'denn dank eines einzigen Mannes hat sie ihr ganzes Leben verloren.'
                ],
                [
                    'id' => 64358,
                    'text' => 'Trotz allem war ihr noch genügend Zeit geblieben, ' .
                        'ihrer Nichte vieles mit auf den Weg zu geben, auch wenn diese ' .
                        'von all dem nichts erahnt.'
                ]
            ]
        ];
        $requestBodyJsonString = json_encode($requestBodyJson);

        $this->assertEquals(
            (new Paragraph())
                ->setHeading('Der Baum der Vergessenheit')
                ->setVerses([
                    (new Verse())
                        ->setId(64356)
                        ->setText(
                            'Ein Mensch, der seine ausgeprägteste Eigenschaft ' .
                            'verliert, verliert auch seine Stärke und verfällt in '.
                            'sich zusammen.'
                        ),
                    (new Verse())
                        ->setId(64357)
                        ->setText(
                            'Regula Dorenus ist das perfekte Beispiel dafür, ' .
                            'denn dank eines einzigen Mannes hat sie ihr '.
                            'ganzes Leben verloren.'
                        ),
                    (new Verse())
                        ->setId(64358)
                        ->setText(
                            'Trotz allem war ihr noch genügend Zeit geblieben, ' .
                            'ihrer Nichte vieles mit auf den Weg zu geben, ' .
                            'auch wenn diese von all dem nichts erahnt.'
                        )
                ]),
            $this->requestHandler->getParagraphEntityFromJsonString($requestBodyJsonString)
        );
    }

    public function testGetParagraphEntityFromJsonStringThrowsIfJsonIsInvalid()
    {
        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage('The given json invalid!');

        $this->requestHandler->getParagraphEntityFromJsonString('{broken json');
    }

    public function testGetParagraphEntityFromJsonStringDoesNotSetHeadingOrVersesIfNotGiven()
    {
        $this->assertEquals(
            new Paragraph(),
            $this->requestHandler->getParagraphEntityFromJsonString('{}')
        );
    }

    public function testGetParagraphEntityFromJsonStringThrowsIfInvalidHeadingIsGiven()
    {
        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage('The given heading is invalid!');

        $this->requestHandler->getParagraphEntityFromJsonString('{"heading":123}');
    }

    public function testGetParagraphEntityFromJsonStringThrowsIfInvalidVersesFieldIsGiven()
    {
        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage('The verses field has to be an array!');

        $this->requestHandler->getParagraphEntityFromJsonString('{"verses":123}');
    }

    public function testGetParagraphEntityFromJsonStringDoesNotSetVerseIdOrVerseTextIfNotGiven()
    {
        $this->assertEquals(
            (new Paragraph())
                ->setVerses([
                    new Verse()
                ]),
            $this->requestHandler->getParagraphEntityFromJsonString('{"verses":[{}]}')
        );
    }

    public function testGetParagraphEntityFromJsonStringThrowsIfInvalidVerseIdIsGiven()
    {
        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage('The given verse id is invalid!');

        $this->requestHandler->getParagraphEntityFromJsonString('{"verses":[{"id":"invalid"}]}');
    }

    public function testGetParagraphEntityFromJsonStringThrowsIfInvalidVerseTextIsGiven()
    {
        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage('The given verse text is invalid!');

        $this->requestHandler->getParagraphEntityFromJsonString('{"verses":[{"text":123}]}');
    }
}
