<?php
namespace App\BookEditorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\BookEditorBundle\UseCase\GetChapter\GetChapterInteractor;
use App\BookEditorBundle\UseCase\GetChapter\GetChapterJsonPresenter;
use Symfony\Component\HttpFoundation\Request;

class GetChapterController extends AbstractController
{
    private GetChapterInteractor $getChapterInteractor;
    private GetChapterJsonPresenter $getChapterPresenter;

    public function __construct(
        GetChapterInteractor $getChapterInteractor,
        GetChapterJsonPresenter $getChapterPresenter
    ) {
        $this->getChapterInteractor = $getChapterInteractor;
        $this->getChapterPresenter = $getChapterPresenter;
    }

    public function getChapter(Request $request): Response
    {
        $this->getChapterInteractor->execute($request->get('chapterId'));

        return new Response(
            $this->getChapterPresenter->getJsonString(),
            Response::HTTP_OK,
            ['Content-type' => 'application/json']
        );
    }
}
