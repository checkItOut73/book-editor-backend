<?php
namespace App\BookEditorBundle\Controller;

use App\BookEditorBundle\UseCase\EditVerse\EditVerseInteractor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class EditVerseController extends AbstractController
{
    private EditVerseInteractor $editVerseInteractor;

    public function __construct(EditVerseInteractor $editVerseInteractor)
    {
        $this->editVerseInteractor = $editVerseInteractor;
    }

    public function editVerse(Request $request): Response
    {
        $this->editVerseInteractor->execute($request->get('verseId'), $request->getContent());

        return new Response(
            '{"success":{"message":"Die Änderungen wurden erfolgreich übernommen!"}}',
            Response::HTTP_OK,
            ['Content-type' => 'application/json']
        );
    }
}
