<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\EditBook;

use App\BookEditorBundle\Exception\BadRequestException;
use App\BookEditorBundle\Entity\Book;
use App\BookEditorBundle\Entity\Chapter;
use App\BookEditorBundle\Entity\Paragraph;
use App\BookEditorBundle\Entity\Verse;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\BookEditorBundle\UseCase\EditBook\EditBookRequestHandler
 */
class EditBookRequestHandlerTest extends TestCase
{
    private $requestHandler;

    public function setUp(): void
    {
        $this->requestHandler = new EditBookRequestHandler();
    }

    public function testGetBookEntityFromJsonStringReturnCorrectBookEntity()
    {
        $requestBodyJson = [
            'title' => 'Viele Fragen ohne eine Antwort',
            'chapters' => [
                [
                    'id' => 5,
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
                ],
                [
                    'id' => 6,
                    'heading' => 'Der Baum der Erinnerung',
                    'paragraphs' => [
                        [
                            'id' => 61,
                            'heading' => 'Der Klassiker zum Thema "Abschied nehmen"',
                            'verses' => [
                                [
                                    'id' => 64362,
                                    'text' => 'Das Bilderbuch vermittelt einfühlsam Kindern ab 4 Jahren, ' .
                                        'aber auch Erwachsenen, dass der Tod eines geliebten Menschen ' .
                                        'keinen endgültigen Abschied bedeutet.'
                                ],
                                [
                                    'id' => 64363,
                                    'text' => 'Die zeitlose Botschaft wird durch die Perspektive von ' .
                                        'Waldtieren erzählt, deren Freund gestorben ist.'
                                ],
                                [
                                    'id' => 64364,
                                    'text' => 'Die ruhigen Illustrationen von Britta Teckentrup ' .
                                        'unterstreichen die poetische Geschichte.'
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];
        $requestBodyJsonString = json_encode($requestBodyJson);

        $this->assertEquals(
            (new Book())
                ->setTitle('Viele Fragen ohne eine Antwort')
                ->setChapters([
                    (new Chapter())
                        ->setId(5)
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
                    (new Chapter())
                        ->setId(6)
                        ->setHeading('Der Baum der Erinnerung')
                        ->setParagraphs([
                            (new Paragraph())
                                ->setId(61)
                                ->setHeading('Der Klassiker zum Thema "Abschied nehmen"')
                                ->setVerses([
                                    (new Verse())
                                        ->setId(64362)
                                        ->setText(
                                            'Das Bilderbuch vermittelt einfühlsam ' .
                                            'Kindern ab 4 Jahren, aber auch Erwachsenen, ' .
                                            'dass der Tod eines geliebten Menschen keinen ' .
                                            'endgültigen Abschied bedeutet.'
                                        ),
                                    (new Verse())
                                        ->setId(64363)
                                        ->setText(
                                            'Die zeitlose Botschaft wird durch ' .
                                            'die Perspektive von Waldtieren erzählt, ' .
                                            'deren Freund gestorben ist.'
                                        ),
                                    (new Verse())
                                        ->setId(64364)
                                        ->setText(
                                            'Die ruhigen Illustrationen von Britta ' .
                                            'Teckentrup unterstreichen die poetische Geschichte.'
                                        )
                                ])
                        ])
                ]),
            $this->requestHandler->getBookEntityFromJsonString($requestBodyJsonString)
        );
    }

    public function testGetBookEntityFromJsonStringThrowsIfJsonIsInvalid()
    {
        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage('The given json invalid!');

        $this->requestHandler->getBookEntityFromJsonString('{broken json');
    }

    public function testGetBookEntityFromJsonStringDoesNotSetTitleOrChaptersIfNotGiven()
    {
        $this->assertEquals(
            new Book(),
            $this->requestHandler->getBookEntityFromJsonString('{}')
        );
    }

    public function testGetBookEntityFromJsonStringThrowsIfInvalidTitleIsGiven()
    {
        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage('The given title is invalid!');

        $this->requestHandler->getBookEntityFromJsonString('{"title":123}');
    }

    public function testGetBookEntityFromJsonStringThrowsIfInvalidChaptersFieldIsGiven()
    {
        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage('The chapters field has to be an array!');

        $this->requestHandler->getBookEntityFromJsonString('{"chapters":123}');
    }

    public function testGetBookEntityFromJsonStringDoesNotSetChapterIdOrChapterHeadingOrChapterParagraphsIfNotGiven()
    {
        $this->assertEquals(
            (new Book())
                ->setChapters([
                    new Chapter()
                ]),
            $this->requestHandler->getBookEntityFromJsonString('{"chapters":[{}]}')
        );
    }

    public function testGetBookEntityFromJsonStringThrowsIfInvalidChapterIdIsGiven()
    {
        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage('The given chapter id is invalid!');

        $this->requestHandler->getBookEntityFromJsonString('{"chapters":[{"id":"invalid"}]}');
    }

    public function testGetBookEntityFromJsonStringThrowsIfInvalidChapterHeadingIsGiven()
    {
        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage('The given chapter heading is invalid!');

        $this->requestHandler->getBookEntityFromJsonString('{"chapters":[{"heading":123}]}');
    }

    public function testGetBookEntityFromJsonStringThrowsIfInvalidChapterParagraphsFieldIsGiven()
    {
        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage('The chapter paragraphs field has to be an array!');

        $this->requestHandler->getBookEntityFromJsonString('{"chapters":[{"paragraphs":123}]}');
    }

    public function testGetBookEntityFromJsonStringDoesNotSetParagraphIdOrParagraphHeadingOrParagraphVersesIfNotGiven()
    {
        $this->assertEquals(
            (new Book())
                ->setChapters([
                    (new Chapter())
                        ->setParagraphs([
                            new Paragraph()
                        ])
                ]),
            $this->requestHandler->getBookEntityFromJsonString(
                '{"chapters":[' .
                    '{"paragraphs":[{}]}' .
                ']}'
            )
        );
    }

    public function testGetBookEntityFromJsonStringThrowsIfInvalidParagraphIdIsGiven()
    {
        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage('The given paragraph id is invalid!');

        $this->requestHandler->getBookEntityFromJsonString(
            '{"chapters":[' .
                '{"paragraphs":[{"id":"invalid"}]}' .
            ']}'
        );
    }

    public function testGetBookEntityFromJsonStringThrowsIfInvalidParagraphHeadingIsGiven()
    {
        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage('The given paragraph heading is invalid!');

        $this->requestHandler->getBookEntityFromJsonString(
            '{"chapters":[' .
                '{"paragraphs":[{"heading":123}]}' .
            ']}'
        );
    }

    public function testGetBookEntityFromJsonStringThrowsIfInvalidParagraphVersesFieldIsGiven()
    {
        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage('The paragraph verses field has to be an array!');

        $this->requestHandler->getBookEntityFromJsonString(
            '{"chapters":[' .
                '{"paragraphs":[{"verses":123}]}' .
            ']}'
        );
    }

    public function testGetBookEntityFromJsonStringDoesNotSetVerseIdOrVerseTextIfNotGiven()
    {
        $this->assertEquals(
            (new Book())
                ->setChapters([
                    (new Chapter())
                        ->setParagraphs([
                            (new Paragraph())
                                ->setVerses([
                                    new Verse()
                                ])
                        ])
                ]),
            $this->requestHandler->getBookEntityFromJsonString(
                '{"chapters":[' .
                    '{"paragraphs":[' .
                        '{"verses":[{}]}' .
                    ']}' .
                ']}'
            )
        );
    }

    public function testGetBookEntityFromJsonStringThrowsIfInvalidVerseIdIsGiven()
    {
        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage('The given verse id is invalid!');

        $this->requestHandler->getBookEntityFromJsonString(
            '{"chapters":[' .
                '{"paragraphs":[' .
                    '{"verses":[' .
                        '{"id":"invalid"}' .
                    ']}' .
                ']}' .
            ']}'
        );
    }

    public function testGetBookEntityFromJsonStringThrowsIfInvalidVerseTextIsGiven()
    {
        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage('The given verse text is invalid!');

        $this->requestHandler->getBookEntityFromJsonString(
            '{"chapters":[' .
                '{"paragraphs":[' .
                    '{"verses":[' .
                        '{"text":123}' .
                    ']}' .
                ']}' .
            ']}'
        );
    }
}
