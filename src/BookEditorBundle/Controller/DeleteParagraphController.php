<?php
namespace App\BookEditorBundle\Controller;

use App\BookEditorBundle\UseCase\DeleteParagraph\DeleteParagraphInteractor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class DeleteParagraphController extends AbstractController
{
    private DeleteParagraphInteractor $deleteParagraphInteractor;

    public function __construct(DeleteParagraphInteractor $deleteParagraphInteractor)
    {
        $this->deleteParagraphInteractor = $deleteParagraphInteractor;
    }

    public function deleteParagraph(Request $request): Response
    {
        $this->deleteParagraphInteractor->execute($request->get('paragraphId'));

        return new Response(
            '{"success":{"message":"Der Paragraph wurde erfolgreich gelöscht!"}}',
            Response::HTTP_OK,
            ['Content-type' => 'application/json']
        );
    }
}
