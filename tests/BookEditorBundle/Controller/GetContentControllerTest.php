<?php declare(strict_types = 1);

namespace App\BookEditorBundle\Controller;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Tests\BookEditorBundle\UseCase\GetContent\GetContentInteractorStub;
use Tests\BookEditorBundle\UseCase\GetContent\GetContentJsonPresenterStub;

/**
 * @covers \App\BookEditorBundle\Controller\GetContentController
 */
class GetContentControllerTest extends TestCase
{
    private GetContentInteractorStub $getContentInteractor;
    private GetContentJsonPresenterStub $getContentPresenter;
    private GetContentController $controller;

    public function setUp(): void
    {
        $this->getContentInteractor = new GetContentInteractorStub();
        $this->getContentPresenter = new GetContentJsonPresenterStub();

        $this->controller = new GetContentController($this->getContentInteractor, $this->getContentPresenter);
    }

    public function testGetContentExecutesTheInteractorCorrectly()
    {
        $this->controller->getContent();

        $this->assertEquals(
            [[]],
            $this->getContentInteractor->getExecuteCalls()
        );
    }

    public function testGetContentReturnsTheCorrectResponse()
    {
        $this->getContentPresenter->setJsonString('[{"number":1,"heading":"You have to read this!","paragraphs":[]}]');

        $this->assertEquals(
            new Response(
                '[{"number":1,"heading":"You have to read this!","paragraphs":[]}]',
                Response::HTTP_OK,
                ['Content-type' => 'application/json']
            ),
            $this->controller->getContent()
        );
    }
}
