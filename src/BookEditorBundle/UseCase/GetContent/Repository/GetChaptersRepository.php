<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\GetContent\Repository;

use App\DataTransferBundle\DatabaseAdapter;
use App\BookEditorBundle\UseCase\GetContent\Entity\Chapter;

class GetChaptersRepository
{
    private DatabaseAdapter $databaseAdapter;
    
    public function __construct(DatabaseAdapter $databaseAdapter)
    {
        $this->databaseAdapter = $databaseAdapter;
    }

    /**
     * @return array<Chapter>
     */
    public function getChapters(): array
    {
        return array_map(
            function ($row) {
                return (new Chapter())
                    ->setId((int)$row['id'])
                    ->setNumber((int)$row['number'])
                    ->setHeading($row['heading']);
            },
            $this->databaseAdapter->getRows('EXEC getChapters')
        );
    }
}
