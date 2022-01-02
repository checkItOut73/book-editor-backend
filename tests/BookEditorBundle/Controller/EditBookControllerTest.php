<?php declare(strict_types = 1);

namespace App\BookEditorBundle\Controller;

use App\BookEditorBundle\Entity\Chapter;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\BookEditorBundle\UseCase\EditBook\EditBookInteractorStub;
use Tests\BookEditorBundle\UseCase\EditBook\EditBookJsonPresenterStub;

/**
 * @covers \App\BookEditorBundle\Controller\EditBookController
 */
class EditBookControllerTest extends TestCase
{
    private Request $request;
    private EditBookInteractorStub $editBookInteractor;
    private EditBookJsonPresenterStub $editBookPresenter;
    private EditBookController $controller;

    public function setUp(): void
    {
        $this->request = new Request(['bookId' => 5], [], [], [], [], [], '{"title":"The art of crafting"}');
        $this->editBookInteractor = new EditBookInteractorStub();
        $this->editBookPresenter = new EditBookJsonPresenterStub();

        $this->controller = new EditBookController($this->editBookInteractor, $this->editBookPresenter);
    }

    public function testEditBookExecutesTheInteractorCorrectly()
    {
        $this->controller->editBook($this->request);

        $this->assertEquals(
            [[5, '{"title":"The art of crafting"}']],
            $this->editBookInteractor->getExecuteCalls()
        );
    }

    public function testEditBookCallsThePresenterCorrectly()
    {
        $this->controller->editBook($this->request);

        $this->assertEquals(
            [[false]],
            $this->editBookPresenter->getGetJsonStringCalls()
        );
    }

    public function testEditBookCallsThePresenterCorrectlyWithResultChaptersInResponseParameter()
    {
        $this->request = new Request(
            [
                'bookId' => 5,
                'resultChaptersInResponse' => '1'
            ],
            [],
            [],
            [],
            [],
            [],
            '{"title":"The art of crafting"}'
        );
        $this->controller->editBook($this->request);

        $this->assertEquals(
            [[true]],
            $this->editBookPresenter->getGetJsonStringCalls()
        );
    }

    public function testEditBookReturnsTheCorrectResponse()
    {
        $this->editBookPresenter->setJsonString('{"success":{"message":"Die Änderungen wurden erfolgreich übernommen!"}}');

        $this->assertEquals(
            new Response(
                '{"success":{"message":"Die Änderungen wurden erfolgreich übernommen!"}}',
                Response::HTTP_OK,
                ['Content-type' => 'application/json']
            ),
            $this->controller->editBook($this->request)
        );
    }
}
