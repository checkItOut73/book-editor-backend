<?php
namespace App\BookEditorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\BookEditorBundle\UseCase\EditBook\EditBookInteractor;
use Symfony\Component\HttpFoundation\Request;

class EditBookController extends AbstractController
{
    private EditBookInteractor $editBookInteractor;

    public function __construct(EditBookInteractor $editBookInteractor)
    {
        $this->editBookInteractor = $editBookInteractor;
    }

    public function editBook(Request $request): Response
    {
        $this->editBookInteractor->execute($request->get('bookId'), $request->getContent());

        return new Response(
            '{"success":{"message":"Die Änderungen wurden erfolgreich übernommen!"}}',
            Response::HTTP_OK,
            ['Content-type' => 'application/json']
        );
    }
}
