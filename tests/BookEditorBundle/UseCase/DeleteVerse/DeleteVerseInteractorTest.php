<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\DeleteVerse;

use App\BookEditorBundle\Entity\Verse;
use PHPUnit\Framework\TestCase;
use Tests\BookEditorBundle\UseCase\DeleteVerse\Repository\DeleteVerseRepositoryStub;

/**
 * @covers \App\BookEditorBundle\UseCase\DeleteVerse\DeleteVerseInteractor
 */
class DeleteVerseInteractorTest extends TestCase
{
    private DeleteVerseRepositoryStub $deleteVerseRepository;
    private DeleteVerseInteractor $interactor;

    public function setUp(): void
    {
        $this->deleteVerseRepository = new DeleteVerseRepositoryStub();

        $this->interactor = new DeleteVerseInteractor($this->deleteVerseRepository);
    }

    public function testExecuteCallsTheDeleteVerseRepositoryCorrectly()
    {
        $this->interactor->execute(5);

        $this->assertEquals(
            [
                [5]
            ],
            $this->deleteVerseRepository->getDeleteVerseCalls()
        );
    }
}
