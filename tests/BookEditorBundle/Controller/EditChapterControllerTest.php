<?php declare(strict_types = 1);

namespace App\BookEditorBundle\Controller;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\BookEditorBundle\UseCase\EditChapter\EditChapterInteractorStub;
use Tests\BookEditorBundle\UseCase\EditChapter\EditChapterJsonPresenterStub;

/**
 * @covers \App\BookEditorBundle\Controller\EditChapterController
 */
class EditChapterControllerTest extends TestCase
{
    private Request $request;
    private EditChapterInteractorStub $editChapterInteractor;
    private EditChapterJsonPresenterStub $editChapterPresenter;
    private EditChapterController $controller;

    public function setUp(): void
    {
        $this->request = new Request(['chapterId' => 5], [], [], [], [], [], '{"heading":"The art of crafting"}');
        $this->editChapterInteractor = new EditChapterInteractorStub();
        $this->editChapterPresenter = new EditChapterJsonPresenterStub();

        $this->controller = new EditChapterController($this->editChapterInteractor, $this->editChapterPresenter);
    }

    public function testEditChapterExecutesTheInteractorCorrectly()
    {
        $this->controller->editChapter($this->request);

        $this->assertEquals(
            [[5, '{"heading":"The art of crafting"}']],
            $this->editChapterInteractor->getExecuteCalls()
        );
    }

    public function testEditChapterCallsThePresenterCorrectly()
    {
        $this->controller->editChapter($this->request);

        $this->assertEquals(
            [[false]],
            $this->editChapterPresenter->getGetJsonStringCalls()
        );
    }

    public function testEditChapterCallsThePresenterCorrectlyWithResultParagraphsInResponseParameter()
    {
        $this->request = new Request(
            [
                'chapterId' => 5,
                'resultParagraphsInResponse' => '1'
            ],
            [],
            [],
            [],
            [],
            [],
            '{"heading":"The art of crafting"}'
        );
        $this->controller->editChapter($this->request);

        $this->assertEquals(
            [[true]],
            $this->editChapterPresenter->getGetJsonStringCalls()
        );
    }

    public function testEditChapterReturnsTheCorrectResponse()
    {
        $this->editChapterPresenter->setJsonString('{"success":{"message":"Die Änderungen wurden erfolgreich übernommen!"}}');

        $this->assertEquals(
            new Response(
                '{"success":{"message":"Die Änderungen wurden erfolgreich übernommen!"}}',
                Response::HTTP_OK,
                ['Content-type' => 'application/json']
            ),
            $this->controller->editChapter($this->request)
        );
    }
}
