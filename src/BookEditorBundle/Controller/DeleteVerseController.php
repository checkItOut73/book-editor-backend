<?php
namespace App\BookEditorBundle\Controller;

use App\BookEditorBundle\UseCase\DeleteVerse\DeleteVerseInteractor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class DeleteVerseController extends AbstractController
{
    private DeleteVerseInteractor $deleteVerseInteractor;

    public function __construct(DeleteVerseInteractor $deleteVerseInteractor)
    {
        $this->deleteVerseInteractor = $deleteVerseInteractor;
    }

    public function deleteVerse(Request $request): Response
    {
        $this->deleteVerseInteractor->execute($request->get('verseId'));

        return new Response(
            '{"success":{"message":"Der Vers wurde erfolgreich gelöscht!"}}',
            Response::HTTP_OK,
            ['Content-type' => 'application/json']
        );
    }
}
