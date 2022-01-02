<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\EditBook;

use App\BookEditorBundle\Entity\Chapter;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\BookEditorBundle\UseCase\EditBook\EditBookJsonPresenter
 */
class EditBookJsonPresenterTest extends TestCase
{
    private $presenter;

    public function setUp(): void
    {
        $this->presenter = new EditBookJsonPresenter();
    }

    public function testGetJsonReturnsCorrectJson()
    {
        $this->presenter->setResultChapters([
            (new Chapter())
                ->setId(43894)
                ->setHeading('The unforgiven step'),
            (new Chapter())
                ->setId(43895)
        ]);

        $this->assertEquals(
            json_encode([
                'success' => [
                    'message' => 'Die Änderungen wurden erfolgreich übernommen!'
                ],
                'result' => [
                    'chapters' => [
                        [
                            'id' => 43894,
                            'heading' => 'The unforgiven step'
                        ],
                        [
                            'id' => 43895
                        ]
                    ]
                ]
            ]),
            $this->presenter->getJsonString(true)
        );
    }

    public function testGetJsonDoesNotContainResultChaptersIfCorrespondingParameterIsFalse()
    {
        $this->presenter->setResultChapters([
            (new Chapter())
                ->setId(43894)
                ->setHeading('The unforgiven step'),
            (new Chapter())
                ->setId(43895)
        ]);

        $this->assertEquals(
            json_encode([
                'success' => [
                    'message' => 'Die Änderungen wurden erfolgreich übernommen!'
                ]
            ]),
            $this->presenter->getJsonString(false)
        );
    }

    public function testGetJsonDoesNotContainResultChaptersIfNoneGiven()
    {
        $this->assertEquals(
            json_encode([
                'success' => [
                    'message' => 'Die Änderungen wurden erfolgreich übernommen!'
                ]
            ]),
            $this->presenter->getJsonString(true)
        );
    }
}
