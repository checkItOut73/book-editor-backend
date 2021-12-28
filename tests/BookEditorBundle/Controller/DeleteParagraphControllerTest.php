<?php declare(strict_types = 1);

namespace App\BookEditorBundle\Controller;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\BookEditorBundle\UseCase\DeleteParagraph\DeleteParagraphInteractorStub;

/**
 * @covers \App\BookEditorBundle\Controller\DeleteParagraphController
 */
class DeleteParagraphControllerTest extends TestCase
{
    private Request $request;
    private DeleteParagraphInteractorStub $deleteParagraphInteractor;
    private DeleteParagraphController $controller;

    public function setUp(): void
    {
        $this->request = new Request(['paragraphId' => 5]);
        $this->deleteParagraphInteractor = new DeleteParagraphInteractorStub();

        $this->controller = new DeleteParagraphController($this->deleteParagraphInteractor);
    }

    public function testDeleteParagraphExecutesTheInteractorCorrectly()
    {
        $this->controller->deleteParagraph($this->request);

        $this->assertEquals(
            [[5]],
            $this->deleteParagraphInteractor->getExecuteCalls()
        );
    }

    public function testDeleteParagraphReturnsTheCorrectResponse()
    {
        $this->assertEquals(
            new Response(
                '{"success":{"message":"Der Paragraph wurde erfolgreich gelöscht!"}}',
                Response::HTTP_OK,
                ['Content-type' => 'application/json']
            ),
            $this->controller->deleteParagraph($this->request)
        );
    }
}
