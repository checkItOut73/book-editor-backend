<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\DeleteVerse;

use App\BookEditorBundle\UseCase\DeleteVerse\Repository\DeleteVerseRepository;

class DeleteVerseInteractor
{
    private DeleteVerseRepository $deleteVerseRepository;

    public function __construct(DeleteVerseRepository $deleteVerseRepository)
    {
        $this->deleteVerseRepository = $deleteVerseRepository;
    }

    public function execute(int $verseId)
    {
        $this->deleteVerseRepository->deleteVerse($verseId);
    }
}
