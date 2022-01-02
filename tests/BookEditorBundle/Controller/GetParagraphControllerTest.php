<?php declare(strict_types = 1);

namespace App\BookEditorBundle\Controller;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\BookEditorBundle\UseCase\GetParagraph\GetParagraphInteractorStub;
use Tests\BookEditorBundle\UseCase\GetParagraph\GetParagraphJsonPresenterStub;

/**
 * @covers \App\BookEditorBundle\Controller\GetParagraphController
 */
class GetParagraphControllerTest extends TestCase
{
    private Request $request;
    private GetParagraphInteractorStub $getParagraphInteractor;
    private GetParagraphJsonPresenterStub $getParagraphPresenter;
    private GetParagraphController $controller;

    public function setUp(): void
    {
        $this->request = new Request(['paragraphId' => 5]);
        $this->getParagraphInteractor = new GetParagraphInteractorStub();
        $this->getParagraphPresenter = new GetParagraphJsonPresenterStub();

        $this->controller = new GetParagraphController($this->getParagraphInteractor, $this->getParagraphPresenter);
    }

    public function testGetParagraphExecutesTheInteractorCorrectly()
    {
        $this->controller->getParagraph($this->request);

        $this->assertEquals(
            [[5]],
            $this->getParagraphInteractor->getExecuteCalls()
        );
    }

    public function testGetParagraphReturnsTheCorrectResponse()
    {
        $this->getParagraphPresenter
            ->setJsonString('{"numberInChapter":1,"heading":"You have to read this!","verses":[]}');

        $this->assertEquals(
            new Response(
                '{"numberInChapter":1,"heading":"You have to read this!","verses":[]}',
                Response::HTTP_OK,
                ['Content-type' => 'application/json']
            ),
            $this->controller->getParagraph($this->request)
        );
    }
}
