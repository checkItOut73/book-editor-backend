<?php
namespace App\BookEditorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\BookEditorBundle\UseCase\GetParagraph\GetParagraphInteractor;
use App\BookEditorBundle\UseCase\GetParagraph\GetParagraphJsonPresenter;
use Symfony\Component\HttpFoundation\Request;

class GetParagraphController extends AbstractController
{
    private GetParagraphInteractor $getParagraphInteractor;
    private GetParagraphJsonPresenter $getParagraphPresenter;

    public function __construct(
        GetParagraphInteractor $getParagraphInteractor,
        GetParagraphJsonPresenter $getParagraphPresenter
    ) {
        $this->getParagraphInteractor = $getParagraphInteractor;
        $this->getParagraphPresenter = $getParagraphPresenter;
    }

    public function getParagraph(Request $request): Response
    {
        $this->getParagraphInteractor->execute($request->get('paragraphId'));

        return new Response(
            $this->getParagraphPresenter->getJsonString(),
            $this->getParagraphPresenter->getHttpStatusCode(),
            ['Content-type' => 'application/json']
        );
    }
}
