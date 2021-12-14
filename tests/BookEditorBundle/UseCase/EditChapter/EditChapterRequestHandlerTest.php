<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\EditChapter;

use App\BookEditorBundle\Exception\BadRequestException;
use App\BookEditorBundle\Entity\Chapter;
use App\BookEditorBundle\Entity\Paragraph;
use App\BookEditorBundle\Entity\Verse;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\BookEditorBundle\UseCase\EditChapter\EditChapterRequestHandler
 */
class EditChapterRequestHandlerTest extends TestCase
{
    private $requestHandler;

    public function setUp(): void
    {
        $this->requestHandler = new EditChapterRequestHandler();
    }

    public function testGetChapterEntityFromJsonStringReturnCorrectChapterEntity()
    {
        $requestBodyJson = [
            'heading' => 'Der Baum der Vergessenheit',
            'paragraphs' => [
                [
                    'id' => 59,
                    'heading' => '',
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
                ],
                [
                    'id' => 60,
                    'heading' => 'Wieso es geschehen musste',
                    'verses' => [
                        [
                            'id' => 64359,
                            'text' => 'Die Welt von Tria Dorenus wurde ihres Glanzes ' .
                                'beraubt und verwest nun vor sich hin - immer tiefer in den Abgrund.'
                        ],
                        [
                            'id' => 64360,
                            'text' => 'Die Bewohner des Königreichs Qehndroz haben keine ' .
                            'andere Wahl und müssen dabei zu sehen, wie ihre Heimat immer '.
                            'mehr von der Bildfläche verschwindet.'
                        ],
                        [
                            'id' => 64361,
                            'text' => 'Die größte Tragödie ist dabei, dass die Qehndrianer nicht ' .
                                'einmal den wahren Grund für ihre jahrelange Trauer kennen.'
                        ]
                    ]
                ]
            ]
        ];
        $requestBodyJsonString = json_encode($requestBodyJson);

        $this->assertEquals(
            (new Chapter())
                ->setHeading('Der Baum der Vergessenheit')
                ->setParagraphs([
                    (new Paragraph())
                        ->setId(59)
                        ->setHeading('')
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
                    (new Paragraph())
                        ->setId(60)
                        ->setHeading('Wieso es geschehen musste')
                        ->setVerses([
                            (new Verse())
                                ->setId(64359)
                                ->setText(
                                    'Die Welt von Tria Dorenus wurde ihres ' .
                                    'Glanzes beraubt und verwest nun vor sich hin ' .
                                    '- immer tiefer in den Abgrund.'
                                ),
                            (new Verse())
                                ->setId(64360)
                                ->setText(
                                    'Die Bewohner des Königreichs Qehndroz ' .
                                    'haben keine andere Wahl und müssen dabei ' .
                                    'zu sehen, wie ihre Heimat immer mehr ' .
                                    'von der Bildfläche verschwindet.'
                                ),
                            (new Verse())
                                ->setId(64361)
                                ->setText(
                                    'Die größte Tragödie ist dabei, ' .
                                    'dass die Qehndrianer nicht einmal ' .
                                    'den wahren Grund für ihre jahrelange Trauer kennen.'
                                )
                        ])
                ]),
            $this->requestHandler->getChapterEntityFromJsonString($requestBodyJsonString)
        );
    }

    public function testGetChapterEntityFromJsonStringThrowsIfJsonIsInvalid()
    {
        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage('The given json invalid!');

        $this->requestHandler->getChapterEntityFromJsonString('{broken json');
    }

    public function testGetChapterEntityFromJsonStringDoesNotSetHeadingOrParagraphsIfNotGiven()
    {
        $this->assertEquals(
            new Chapter(),
            $this->requestHandler->getChapterEntityFromJsonString('{}')
        );
    }

    public function testGetChapterEntityFromJsonStringThrowsIfInvalidHeadingIsGiven()
    {
        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage('The given heading is invalid!');

        $this->requestHandler->getChapterEntityFromJsonString('{"heading":123}');
    }

    public function testGetChapterEntityFromJsonStringThrowsIfInvalidParagraphsFieldIsGiven()
    {
        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage('The paragraphs field has to be an array!');

        $this->requestHandler->getChapterEntityFromJsonString('{"paragraphs":123}');
    }

    public function testGetChapterEntityFromJsonStringDoesNotSetParagraphIdOrHeadingOrVersesIfNotGiven()
    {
        $this->assertEquals(
            (new Chapter())
                ->setParagraphs([
                    new Paragraph()
                ]),
            $this->requestHandler->getChapterEntityFromJsonString('{"paragraphs":[{}]}')
        );
    }

    public function testGetChapterEntityFromJsonStringThrowsIfInvalidParagraphIdIsGiven()
    {
        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage('The given paragraph id is invalid!');

        $this->requestHandler->getChapterEntityFromJsonString('{"paragraphs":[{"id":"invalid"}]}');
    }

    public function testGetChapterEntityFromJsonStringThrowsIfInvalidParagraphHeadingIsGiven()
    {
        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage('The given paragraph heading is invalid!');

        $this->requestHandler->getChapterEntityFromJsonString('{"paragraphs":[{"heading":123}]}');
    }

    public function testGetChapterEntityFromJsonStringThrowsIfInvalidParagraphVersesFieldIsGiven()
    {
        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage('The paragraph verses field has to be an array!');

        $this->requestHandler->getChapterEntityFromJsonString('{"paragraphs":[{"verses":123}]}');
    }

    public function testGetChapterEntityFromJsonStringDoesNotSetVerseIdOrVerseTextIfNotGiven()
    {
        $this->assertEquals(
            (new Chapter())
                ->setParagraphs([
                    (new Paragraph())
                        ->setVerses([
                            new Verse()
                        ])
                ]),
            $this->requestHandler->getChapterEntityFromJsonString(
                '{"paragraphs":[' .
                    '{"verses":[{}]}' .
                ']}'
            )
        );
    }

    public function testGetChapterEntityFromJsonStringThrowsIfInvalidVerseIdIsGiven()
    {
        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage('The given verse id is invalid!');

        $this->requestHandler->getChapterEntityFromJsonString(
            '{"paragraphs":[' .
                '{"verses":[' .
                    '{"id":"invalid"}' .
                ']}' .
            ']}'
        );
    }

    public function testGetChapterEntityFromJsonStringThrowsIfInvalidVerseTextIsGiven()
    {
        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage('The given verse text is invalid!');

        $this->requestHandler->getChapterEntityFromJsonString(
            '{"paragraphs":[' .
                '{"verses":[' .
                    '{"text":123}' .
                ']}' .
            ']}'
        );
    }
}
