<?php
namespace App\BookEditorBundle\Controller;

use App\BookEditorBundle\UseCase\EditParagraph\EditParagraphInteractor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class EditParagraphController extends AbstractController
{
    private EditParagraphInteractor $editParagraphInteractor;

    public function __construct(EditParagraphInteractor $editParagraphInteractor)
    {
        $this->editParagraphInteractor = $editParagraphInteractor;
    }

    public function editParagraph(Request $request): Response
    {
        $this->editParagraphInteractor->execute($request->get('paragraphId'), $request->getContent());

        return new Response(
            '{"success":{"message":"Die Änderungen wurden erfolgreich übernommen!"}}',
            Response::HTTP_OK,
            ['Content-type' => 'application/json']
        );
    }
}
