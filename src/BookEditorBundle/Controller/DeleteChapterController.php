<?php
namespace App\BookEditorBundle\Controller;

use App\BookEditorBundle\UseCase\DeleteChapter\DeleteChapterInteractor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class DeleteChapterController extends AbstractController
{
    private DeleteChapterInteractor $deleteChapterInteractor;

    public function __construct(DeleteChapterInteractor $deleteChapterInteractor)
    {
        $this->deleteChapterInteractor = $deleteChapterInteractor;
    }

    public function deleteChapter(Request $request): Response
    {
        $this->deleteChapterInteractor->execute($request->get('chapterId'));

        return new Response(
            '{"success":{"message":"Das Kapitel wurde erfolgreich gelöscht!"}}',
            Response::HTTP_OK,
            ['Content-type' => 'application/json']
        );
    }
}
