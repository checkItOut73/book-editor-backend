<?php declare(strict_types = 1);

namespace App\BookEditorBundle\Controller;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\BookEditorBundle\UseCase\EditParagraph\EditParagraphInteractorStub;

/**
 * @covers \App\BookEditorBundle\Controller\EditParagraphController
 */
class EditParagraphControllerTest extends TestCase
{
    private Request $request;
    private EditParagraphInteractorStub $editParagraphInteractor;
    private EditParagraphController $controller;

    public function setUp(): void
    {
        $this->request = new Request(['paragraphId' => 5], [], [], [], [], [], '{"heading":"The art of crafting"}');
        $this->editParagraphInteractor = new EditParagraphInteractorStub();

        $this->controller = new EditParagraphController($this->editParagraphInteractor);
    }

    public function testEditParagraphExecutesTheInteractorCorrectly()
    {
        $this->controller->editParagraph($this->request);

        $this->assertEquals(
            [[5, '{"heading":"The art of crafting"}']],
            $this->editParagraphInteractor->getExecuteCalls()
        );
    }

    public function testEditParagraphReturnsTheCorrectResponse()
    {
        $this->assertEquals(
            new Response(
                '{"message":"Changes have been applied successfully!"}',
                Response::HTTP_OK,
                ['Content-type' => 'application/json']
            ),
            $this->controller->editParagraph($this->request)
        );
    }
}
