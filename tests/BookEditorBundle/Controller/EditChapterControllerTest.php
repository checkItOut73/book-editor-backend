<?php declare(strict_types = 1);

namespace App\BookEditorBundle\Controller;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\BookEditorBundle\UseCase\EditChapter\EditChapterInteractorStub;

/**
 * @covers \App\BookEditorBundle\Controller\EditChapterController
 */
class EditChapterControllerTest extends TestCase
{
    private Request $request;
    private EditChapterInteractorStub $editChapterInteractor;
    private EditChapterController $controller;

    public function setUp(): void
    {
        $this->request = new Request(['chapterId' => 5], [], [], [], [], [], '{"heading":"The art of crafting"}');
        $this->editChapterInteractor = new EditChapterInteractorStub();

        $this->controller = new EditChapterController($this->editChapterInteractor);
    }

    public function testEditChapterExecutesTheInteractorCorrectly()
    {
        $this->controller->editChapter($this->request);

        $this->assertEquals(
            [[5, '{"heading":"The art of crafting"}']],
            $this->editChapterInteractor->getExecuteCalls()
        );
    }

    public function testEditChapterReturnsTheCorrectResponse()
    {
        $this->assertEquals(
            new Response(
                '{"message":"Changes have been applied successfully!"}',
                Response::HTTP_OK,
                ['Content-type' => 'application/json']
            ),
            $this->controller->editChapter($this->request)
        );
    }
}
