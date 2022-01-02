<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\DeleteChapter;

use App\BookEditorBundle\UseCase\DeleteChapter\Repository\DeleteChapterRepository;

class DeleteChapterInteractor
{
    private DeleteChapterRepository $deleteChapterRepository;

    public function __construct(DeleteChapterRepository $deleteChapterRepository)
    {
        $this->deleteChapterRepository = $deleteChapterRepository;
    }

    public function execute(int $chapterId)
    {
        $this->deleteChapterRepository->deleteChapter($chapterId);
    }
}
