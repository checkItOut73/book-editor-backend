<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\DeleteParagraph;

use App\BookEditorBundle\Entity\Paragraph;
use App\BookEditorBundle\UseCase\DeleteParagraph\Repository\DeleteParagraphRepository;

class DeleteParagraphInteractor
{
    private DeleteParagraphRepository $deleteParagraphRepository;

    public function __construct(DeleteParagraphRepository $deleteParagraphRepository) {
        $this->deleteParagraphRepository = $deleteParagraphRepository;
    }

    public function execute(int $paragraphId)
    {
        $this->deleteParagraphRepository->deleteParagraph($paragraphId);
    }
}
