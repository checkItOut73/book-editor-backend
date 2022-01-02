<?php declare(strict_types = 1);

namespace App\BookEditorBundle\Controller;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\BookEditorBundle\UseCase\GetChapter\GetChapterInteractorStub;
use Tests\BookEditorBundle\UseCase\GetChapter\GetChapterJsonPresenterStub;

/**
 * @covers \App\BookEditorBundle\Controller\GetChapterController
 */
class GetChapterControllerTest extends TestCase
{
    private Request $request;
    private GetChapterInteractorStub $getChapterInteractor;
    private GetChapterJsonPresenterStub $getChapterPresenter;
    private GetChapterController $controller;

    public function setUp(): void
    {
        $this->request = new Request(['chapterId' => 5]);
        $this->getChapterInteractor = new GetChapterInteractorStub();
        $this->getChapterPresenter = new GetChapterJsonPresenterStub();

        $this->controller = new GetChapterController($this->getChapterInteractor, $this->getChapterPresenter);
    }

    public function testGetChapterExecutesTheInteractorCorrectly()
    {
        $this->controller->getChapter($this->request);

        $this->assertEquals(
            [[5]],
            $this->getChapterInteractor->getExecuteCalls()
        );
    }

    public function testGetChapterReturnsTheCorrectResponse()
    {
        $this->getChapterPresenter
            ->setJsonString('{"number":1,"heading":"You have to read this!","paragraphs":[]}');

        $this->assertEquals(
            new Response(
                '{"number":1,"heading":"You have to read this!","paragraphs":[]}',
                Response::HTTP_OK,
                ['Content-type' => 'application/json']
            ),
            $this->controller->getChapter($this->request)
        );
    }
}
