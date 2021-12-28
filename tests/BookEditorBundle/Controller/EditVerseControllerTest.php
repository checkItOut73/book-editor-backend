<?php declare(strict_types = 1);

namespace App\BookEditorBundle\Controller;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\BookEditorBundle\UseCase\EditVerse\EditVerseInteractorStub;

/**
 * @covers \App\BookEditorBundle\Controller\EditVerseController
 */
class EditVerseControllerTest extends TestCase
{
    private Request $request;
    private EditVerseInteractorStub $editVerseInteractor;
    private EditVerseController $controller;

    public function setUp(): void
    {
        $this->request = new Request(['verseId' => 5], [], [], [], [], [], '{"text":"The art of crafting is awesome!"}');
        $this->editVerseInteractor = new EditVerseInteractorStub();

        $this->controller = new EditVerseController($this->editVerseInteractor);
    }

    public function testEditVerseExecutesTheInteractorCorrectly()
    {
        $this->controller->editVerse($this->request);

        $this->assertEquals(
            [[5, '{"text":"The art of crafting is awesome!"}']],
            $this->editVerseInteractor->getExecuteCalls()
        );
    }

    public function testEditVerseReturnsTheCorrectResponse()
    {
        $this->assertEquals(
            new Response(
                '{"success":{"message":"Die Änderungen wurden erfolgreich übernommen!"}}',
                Response::HTTP_OK,
                ['Content-type' => 'application/json']
            ),
            $this->controller->editVerse($this->request)
        );
    }
}
