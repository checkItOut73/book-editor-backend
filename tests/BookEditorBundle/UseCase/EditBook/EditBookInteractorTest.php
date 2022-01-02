<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\EditBook;

use App\BookEditorBundle\Entity\Book;
use App\BookEditorBundle\Entity\Chapter;
use PHPUnit\Framework\TestCase;
use Tests\BookEditorBundle\UseCase\EditBook\EditBookJsonPresenterStub;
use Tests\BookEditorBundle\UseCase\EditBook\EditBookRequestHandlerStub;
use Tests\BookEditorBundle\UseCase\EditBook\Repository\SetBookTitleRepositoryStub;
use Tests\BookEditorBundle\UseCase\EditBook\Repository\SetChaptersRepositoryStub;

/**
 * @covers \App\BookEditorBundle\UseCase\EditBook\EditBookInteractor
 */
class EditBookInteractorTest extends TestCase
{
    private EditBookRequestHandlerStub $requestHandler;
    private SetBookTitleRepositoryStub $setBookTitleRepository;
    private SetChaptersRepositoryStub $setChaptersRepository;
    private EditBookJsonPresenterStub $editBookPresenter;

    private EditBookInteractor $interactor;

    public function setUp(): void
    {
        $this->requestHandler = (new EditBookRequestHandlerStub())
            ->setBookEntity(new Book());
        $this->setBookTitleRepository = new SetBookTitleRepositoryStub();
        $this->setChaptersRepository = new SetChaptersRepositoryStub();
        $this->editBookPresenter = new EditBookJsonPresenterStub();

        $this->interactor = new EditBookInteractor(
            $this->requestHandler,
            $this->setBookTitleRepository,
            $this->setChaptersRepository,
            $this->editBookPresenter
        );
    }

    public function testExecuteCallsTheRequestHandlerCorrectly()
    {
        $this->interactor->execute(5, '{"title":"The art of crafting"}');

        $this->assertEquals(
            [
                ['{"title":"The art of crafting"}']
            ],
            $this->requestHandler->getGetBookEntityCalls()
        );
    }

    public function testExecuteCallsTheSetBookTitleRepositoryCorrectly()
    {
        $this->requestHandler->setBookEntity(
            (new Book())->setTitle('The rise of the sun')
        );
        $this->interactor->execute(5, '{}');

        $this->assertEquals(
            [
                [5, 'The rise of the sun']
            ],
            $this->setBookTitleRepository->getSetBookTitleCalls()
        );
    }

    public function testExecuteDoesNotCallTheSetBookTitleRepositoryIfTheTitleIsNull()
    {
        $this->requestHandler->setBookEntity(new Book());
        $this->interactor->execute(5, '{}');

        $this->assertEmpty($this->setBookTitleRepository->getSetBookTitleCalls());
    }

    public function testExecuteCallsTheSetChaptersRepositoryCorrectly()
    {
        $chapters = [
            (new Chapter())
                ->setId(432),
            (new Chapter())
                ->setId(5934)
                ->setHeading('Trust yourself'),
            (new Chapter())
                ->setHeading('Don\'t hesitate')
        ];

        $this->requestHandler->setBookEntity(
            (new Book())->setChapters($chapters)
        );
        $this->interactor->execute(5, '{}');

        $this->assertEquals(
            [
                [5, $chapters]
            ],
            $this->setChaptersRepository->getSetChaptersCalls()
        );
    }

    public function testExecuteDoesNotCallTheSetChaptersRepositoryIfChaptersAreNull()
    {
        $this->requestHandler->setBookEntity(new Book());
        $this->interactor->execute(5, '{}');

        $this->assertEmpty($this->setChaptersRepository->getSetChaptersCalls());
    }

    public function testExecutePutsTheResultChaptersCorrectlyIntoThePresenter()
    {
        $this->requestHandler->setBookEntity(
            (new Book())->setChapters([
                (new Chapter())
                    ->setHeading('Der 1000-jährige Baum'),
                (new Chapter())
                    ->setId(29392)
            ])
        );

        $this->setChaptersRepository->setResultChapters([
            (new Chapter())
                ->setId(43932)
                ->setHeading('Der 1000-jährige Baum'),
            (new Chapter())
                ->setId(29392)
        ]);

        $this->interactor->execute(5, '{}');

        $this->assertEquals(
            [
                (new Chapter())
                    ->setId(43932)
                    ->setHeading('Der 1000-jährige Baum'),
                (new Chapter())
                    ->setId(29392)
            ],
            $this->editBookPresenter->getResultChapters()
        );
    }
}
