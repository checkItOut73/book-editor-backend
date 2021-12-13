<?php declare(strict_types = 1);

namespace Tests\BookEditorBundle\UseCase\EditBook;

use App\BookEditorBundle\UseCase\EditBook\EditBookInteractor;

class EditBookInteractorStub extends EditBookInteractor
{
    private $executeCalls = [];

    public function __construct()
    {
        // stub overrides constructor so that it can be instantiated without dependencies
    }

    public function execute(int $bookId, string $requestContent): EditBookInteractor
    {
        $this->executeCalls[] = [$bookId, $requestContent];

        return $this;
    }

    public function getExecuteCalls(): array
    {
        return $this->executeCalls;
    }
}
