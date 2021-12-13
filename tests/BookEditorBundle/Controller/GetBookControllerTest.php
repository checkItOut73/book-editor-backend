<?php declare(strict_types = 1);

namespace App\BookEditorBundle\Controller;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\BookEditorBundle\UseCase\GetBook\GetBookInteractorStub;
use Tests\BookEditorBundle\UseCase\GetBook\GetBookJsonPresenterStub;

/**
 * @covers \App\BookEditorBundle\Controller\GetBookController
 */
class GetBookControllerTest extends TestCase
{
    private Request $request;
    private GetBookInteractorStub $getBookInteractor;
    private GetBookJsonPresenterStub $getBookPresenter;
    private GetBookController $controller;

    public function setUp(): void
    {
        $this->request = new Request(['bookId' => 5]);
        $this->getBookInteractor = new GetBookInteractorStub();
        $this->getBookPresenter = new GetBookJsonPresenterStub();

        $this->controller = new GetBookController($this->getBookInteractor, $this->getBookPresenter);
    }

    public function testGetBookExecutesTheInteractorCorrectly()
    {
        $this->controller->getBook($this->request);

        $this->assertEquals(
            [[5]],
            $this->getBookInteractor->getExecuteCalls()
        );
    }

    public function testGetBookReturnsTheCorrectResponse()
    {
        $this->getBookPresenter
            ->setJsonString(
                '{' .
                    '"title":"Book title",' .
                    '"chapters":[{"number":1,"heading":"You have to read this!","paragraphs":[]}]' .
                '}'
            )
            ->setHttpStatusCode(Response::HTTP_OK);

        $this->assertEquals(
            new Response(
                '{"title":"Book title","chapters":[{"number":1,"heading":"You have to read this!","paragraphs":[]}]}',
                Response::HTTP_OK,
                ['Content-type' => 'application/json']
            ),
            $this->controller->getBook($this->request)
        );
    }
}
