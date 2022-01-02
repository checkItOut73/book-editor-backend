<?php
namespace App\BookEditorBundle\Controller;

use App\BookEditorBundle\UseCase\EditParagraph\EditParagraphInteractor;
use App\BookEditorBundle\UseCase\EditParagraph\EditParagraphJsonPresenter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class EditParagraphController extends AbstractController
{
    private EditParagraphInteractor $editParagraphInteractor;
    private EditParagraphJsonPresenter $editParagraphPresenter;

    public function __construct(EditParagraphInteractor $editParagraphInteractor, EditParagraphJsonPresenter $editParagraphPresenter)
    {
        $this->editParagraphInteractor = $editParagraphInteractor;
        $this->editParagraphPresenter = $editParagraphPresenter;
    }

    public function editParagraph(Request $request): Response
    {
        $this->editParagraphInteractor->execute($request->get('paragraphId'), $request->getContent());

        return new Response(
            $this->editParagraphPresenter->getJsonString((bool)$request->get('resultVersesInResponse')),
            Response::HTTP_OK,
            ['Content-type' => 'application/json']
        );
    }
}
