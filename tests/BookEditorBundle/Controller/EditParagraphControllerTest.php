<?php declare(strict_types = 1);

namespace App\BookEditorBundle\Controller;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\BookEditorBundle\UseCase\EditParagraph\EditParagraphInteractorStub;
use Tests\BookEditorBundle\UseCase\EditParagraph\EditParagraphJsonPresenterStub;

/**
 * @covers \App\BookEditorBundle\Controller\EditParagraphController
 */
class EditParagraphControllerTest extends TestCase
{
    private Request $request;
    private EditParagraphInteractorStub $editParagraphInteractor;
    private EditParagraphJsonPresenterStub $editParagraphPresenter;
    private EditParagraphController $controller;

    public function setUp(): void
    {
        $this->request = new Request(['paragraphId' => 5], [], [], [], [], [], '{"heading":"The art of crafting"}');
        $this->editParagraphInteractor = new EditParagraphInteractorStub();
        $this->editParagraphPresenter = new EditParagraphJsonPresenterStub();

        $this->controller = new EditParagraphController($this->editParagraphInteractor, $this->editParagraphPresenter);
    }

    public function testEditParagraphExecutesTheInteractorCorrectly()
    {
        $this->controller->editParagraph($this->request);

        $this->assertEquals(
            [[5, '{"heading":"The art of crafting"}']],
            $this->editParagraphInteractor->getExecuteCalls()
        );
    }

    public function testEditParagraphCallsThePresenterCorrectly()
    {
        $this->controller->editParagraph($this->request);

        $this->assertEquals(
            [[false]],
            $this->editParagraphPresenter->getGetJsonStringCalls()
        );
    }

    public function testEditParagraphCallsThePresenterCorrectlyWithResultVersesInResponseParameter()
    {
        $this->request = new Request(
            [
                'paragraphId' => 5,
                'resultVersesInResponse' => '1'
            ],
            [],
            [],
            [],
            [],
            [],
            '{"heading":"The art of crafting"}'
        );
        $this->controller->editParagraph($this->request);

        $this->assertEquals(
            [[true]],
            $this->editParagraphPresenter->getGetJsonStringCalls()
        );
    }

    public function testEditParagraphReturnsTheCorrectResponse()
    {
        $this->editParagraphPresenter->setJsonString('{"success":{"message":"Die Änderungen wurden erfolgreich übernommen!"}}');

        $this->assertEquals(
            new Response(
                '{"success":{"message":"Die Änderungen wurden erfolgreich übernommen!"}}',
                Response::HTTP_OK,
                ['Content-type' => 'application/json']
            ),
            $this->controller->editParagraph($this->request)
        );
    }
}
