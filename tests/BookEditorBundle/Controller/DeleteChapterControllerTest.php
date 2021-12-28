<?php declare(strict_types = 1);

namespace App\BookEditorBundle\Controller;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\BookEditorBundle\UseCase\DeleteChapter\DeleteChapterInteractorStub;

/**
 * @covers \App\BookEditorBundle\Controller\DeleteChapterController
 */
class DeleteChapterControllerTest extends TestCase
{
    private Request $request;
    private DeleteChapterInteractorStub $deleteChapterInteractor;
    private DeleteChapterController $controller;

    public function setUp(): void
    {
        $this->request = new Request(['chapterId' => 5]);
        $this->deleteChapterInteractor = new DeleteChapterInteractorStub();

        $this->controller = new DeleteChapterController($this->deleteChapterInteractor);
    }

    public function testDeleteChapterExecutesTheInteractorCorrectly()
    {
        $this->controller->deleteChapter($this->request);

        $this->assertEquals(
            [[5]],
            $this->deleteChapterInteractor->getExecuteCalls()
        );
    }

    public function testDeleteChapterReturnsTheCorrectResponse()
    {
        $this->assertEquals(
            new Response(
                '{"success":{"message":"Das Kapitel wurde erfolgreich gelöscht!"}}',
                Response::HTTP_OK,
                ['Content-type' => 'application/json']
            ),
            $this->controller->deleteChapter($this->request)
        );
    }
}
