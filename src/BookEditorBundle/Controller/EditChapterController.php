<?php
namespace App\BookEditorBundle\Controller;

use App\BookEditorBundle\UseCase\EditChapter\EditChapterInteractor;
use App\BookEditorBundle\UseCase\EditChapter\EditChapterJsonPresenter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class EditChapterController extends AbstractController
{
    private EditChapterInteractor $editChapterInteractor;
    private EditChapterJsonPresenter $editChapterPresenter;

    public function __construct(EditChapterInteractor $editChapterInteractor, EditChapterJsonPresenter $editChapterPresenter)
    {
        $this->editChapterInteractor = $editChapterInteractor;
        $this->editChapterPresenter = $editChapterPresenter;
    }

    public function editChapter(Request $request): Response
    {
        $this->editChapterInteractor->execute($request->get('chapterId'), $request->getContent());

        return new Response(
            $this->editChapterPresenter->getJsonString((bool)$request->get('resultParagraphsInResponse')),
            Response::HTTP_OK,
            ['Content-type' => 'application/json']
        );
    }
}
