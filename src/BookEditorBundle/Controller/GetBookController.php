<?php
namespace App\BookEditorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\BookEditorBundle\UseCase\GetBook\GetBookInteractor;
use App\BookEditorBundle\UseCase\GetBook\GetBookJsonPresenter;
use Symfony\Component\HttpFoundation\Request;

class GetBookController extends AbstractController
{
    private GetBookInteractor $getBookInteractor;
    private GetBookJsonPresenter $getBookPresenter;

    public function __construct(
        GetBookInteractor $getBookInteractor,
        GetBookJsonPresenter $getBookPresenter
    ) {
        $this->getBookInteractor = $getBookInteractor;
        $this->getBookPresenter = $getBookPresenter;
    }

    public function getBook(Request $request): Response
    {
        $this->getBookInteractor->execute($request->get('bookId'));

        return new Response(
            $this->getBookPresenter->getJsonString(),
            $this->getBookPresenter->getHttpStatusCode(),
            ['Content-type' => 'application/json']
        );
    }
}
