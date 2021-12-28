<?php declare(strict_types = 1);

namespace App\BookEditorBundle\Controller;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\BookEditorBundle\UseCase\DeleteVerse\DeleteVerseInteractorStub;

/**
 * @covers \App\BookEditorBundle\Controller\DeleteVerseController
 */
class DeleteVerseControllerTest extends TestCase
{
    private Request $request;
    private DeleteVerseInteractorStub $deleteVerseInteractor;
    private DeleteVerseController $controller;

    public function setUp(): void
    {
        $this->request = new Request(['verseId' => 5]);
        $this->deleteVerseInteractor = new DeleteVerseInteractorStub();

        $this->controller = new DeleteVerseController($this->deleteVerseInteractor);
    }

    public function testDeleteVerseExecutesTheInteractorCorrectly()
    {
        $this->controller->deleteVerse($this->request);

        $this->assertEquals(
            [[5]],
            $this->deleteVerseInteractor->getExecuteCalls()
        );
    }

    public function testDeleteVerseReturnsTheCorrectResponse()
    {
        $this->assertEquals(
            new Response(
                '{"success":{"message":"Der Vers wurde erfolgreich gelöscht!"}}',
                Response::HTTP_OK,
                ['Content-type' => 'application/json']
            ),
            $this->controller->deleteVerse($this->request)
        );
    }
}
