<?php
namespace App\BookEditorBundle\Controller;

use App\BookEditorBundle\UseCase\EditChapter\EditChapterInteractor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class EditChapterController extends AbstractController
{
    private EditChapterInteractor $editChapterInteractor;

    public function __construct(EditChapterInteractor $editChapterInteractor)
    {
        $this->editChapterInteractor = $editChapterInteractor;
    }

    public function editChapter(Request $request): Response
    {
        $this->editChapterInteractor->execute($request->get('chapterId'), $request->getContent());

        return new Response(
            '{"message":"Changes have been applied successfully!"}',
            Response::HTTP_OK,
            ['Content-type' => 'application/json']
        );
    }
}
