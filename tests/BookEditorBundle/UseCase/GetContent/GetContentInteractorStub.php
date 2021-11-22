<?php declare(strict_types = 1);

namespace Tests\BookEditorBundle\UseCase\GetContent;

use App\BookEditorBundle\UseCase\GetContent\GetContentInteractor;

class GetContentInteractorStub extends GetContentInteractor
{
    private $executeCalls = [];

    public function __construct()
    {
        // stub overrides constructor so that it can be instantiated without dependencies
    }

    public function execute(): GetContentInteractor
    {
        $this->executeCalls[] = [];

        return $this;
    }

    public function getExecuteCalls(): array
    {
        return $this->executeCalls;
    }
}
