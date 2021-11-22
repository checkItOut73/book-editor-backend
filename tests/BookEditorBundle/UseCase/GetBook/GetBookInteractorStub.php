<?php declare(strict_types = 1);

namespace Tests\BookEditorBundle\UseCase\GetBook;

use App\BookEditorBundle\UseCase\GetBook\GetBookInteractor;

class GetBookInteractorStub extends GetBookInteractor
{
    private $executeCalls = [];

    public function __construct()
    {
        // stub overrides constructor so that it can be instantiated without dependencies
    }

    public function execute(int $bookId): GetBookInteractor
    {
        $this->executeCalls[] = [$bookId];

        return $this;
    }

    public function getExecuteCalls(): array
    {
        return $this->executeCalls;
    }
}
