<?php
namespace App\BookEditorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\BookEditorBundle\UseCase\EditBook\EditBookInteractor;
use App\BookEditorBundle\UseCase\EditBook\EditBookJsonPresenter;
use Symfony\Component\HttpFoundation\Request;

class EditBookController extends AbstractController
{
    private EditBookInteractor $editBookInteractor;
    private EditBookJsonPresenter $editBookPresenter;

    public function __construct(EditBookInteractor $editBookInteractor, EditBookJsonPresenter $editBookPresenter)
    {
        $this->editBookInteractor = $editBookInteractor;
        $this->editBookPresenter = $editBookPresenter;
    }

    public function editBook(Request $request): Response
    {
        $this->editBookInteractor->execute($request->get('bookId'), $request->getContent());

        return new Response(
            $this->editBookPresenter->getJsonString((bool)$request->get('resultChaptersInResponse')),
            Response::HTTP_OK,
            ['Content-type' => 'application/json']
        );
    }
}
