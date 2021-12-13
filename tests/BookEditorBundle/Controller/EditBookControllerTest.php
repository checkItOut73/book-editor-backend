<?php declare(strict_types = 1);

namespace App\BookEditorBundle\Controller;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\BookEditorBundle\UseCase\EditBook\EditBookInteractorStub;

/**
 * @covers \App\BookEditorBundle\Controller\EditBookController
 */
class EditBookControllerTest extends TestCase
{
    private Request $request;
    private EditBookInteractorStub $editBookInteractor;
    private EditBookController $controller;

    public function setUp(): void
    {
        $this->request = new Request(['bookId' => 5], [], [], [], [], [], '{"title":"The art of crafting"}');
        $this->editBookInteractor = new EditBookInteractorStub();

        $this->controller = new EditBookController($this->editBookInteractor);
    }

    public function testEditBookExecutesTheInteractorCorrectly()
    {
        $this->controller->editBook($this->request);

        $this->assertEquals(
            [[5, '{"title":"The art of crafting"}']],
            $this->editBookInteractor->getExecuteCalls()
        );
    }

    public function testEditBookReturnsTheCorrectResponse()
    {
        $this->assertEquals(
            new Response(
                '{"message":"Changes have been applied successfully!"}',
                Response::HTTP_OK,
                ['Content-type' => 'application/json']
            ),
            $this->controller->editBook($this->request)
        );
    }
}
