<?php
namespace App\BookEditorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\BookEditorBundle\UseCase\GetContent\GetContentInteractor;
use App\BookEditorBundle\UseCase\GetContent\GetContentJsonPresenter;

class GetContentController extends AbstractController
{
    private GetContentInteractor $getContentInteractor;
    private GetContentJsonPresenter $getContentPresenter;

    public function __construct(
        GetContentInteractor $getContentInteractor,
        GetContentJsonPresenter $getContentPresenter
    ) {
        $this->getContentInteractor = $getContentInteractor;
        $this->getContentPresenter = $getContentPresenter;
    }

    public function getContent(): Response
    {
        $this->getContentInteractor->execute();

        return new Response(
            $this->getContentPresenter->getJsonString(),
            Response::HTTP_OK,
            ['Content-type' => 'application/json']
        );
    }
}
