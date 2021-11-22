<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\GetBook\Repository;

use App\BookEditorBundle\UseCase\GetBook\Entity\Verse;
use PHPUnit\Framework\TestCase;
use Tests\DataTransferBundle\DatabaseAdapterStub;

/**
 * @covers \App\BookEditorBundle\UseCase\GetBook\Repository\GetVersesRepository
 */
class GetVersesRepositoryTest extends TestCase
{
    private DatabaseAdapterStub $databaseAdapter;
    private GetVersesRepository $repository;

    public function setUp(): void
    {
        $this->databaseAdapter = new DatabaseAdapterStub();
        $this->repository = new GetVersesRepository($this->databaseAdapter);
    }

    public function testGetVersesPerformsTheCorrectQuery()
    {
        $this->repository->getVersesGroupedByParagraphId([1, 2, 3]);

        $this->assertEquals(
            ['EXEC getVerses @paragraphIds = \'1,2,3\''],
            $this->databaseAdapter->getGetRowsCalls()
        );
    }

    public function testGetVersesReturnsTheCorrectData()
    {
        $this->databaseAdapter->setRows([
            [
                'numberInParagraph' => '1',
                'text' => 'Die Leipziger Wasserkünste waren technische Einrichtungen, die ' .
                    'über drei Jahrhunderte die zentrale Wasserversorgung Leipzigs sicherten.',
                'paragraphId' => '1'
            ],
            [
                'numberInParagraph' => '2',
                'text' => 'Von einem Vorläufer abgesehen, waren es zwei Wasserförderanlagen am ' .
                    'Pleißemühlgraben mit den Namen Rote Wasserkunst und Schwarze Wasserkunst.',
                'paragraphId' => '1'
            ],
            [
                'numberInParagraph' => '1',
                'text' => 'Die „Rote“ hatte Tür- und Fenstereinfassungen aus rotem Rochlitzer ' .
                    'Porphyr, was der „Schwarzen“ fehlte.',
                'paragraphId' => '2'
            ],
            [
                'numberInParagraph' => '1',
                'text' => 'Die Rote Wasserkunst befand sich auf dem Gelände der Nonnenmühle östlich von ' .
                    'dieser. Das entspricht heute dem Kreuzungsbereich Karl-Tauchnitz-Straße/Martin-Luther-Ring (♁⊙).',
                'paragraphId' => '3'
            ],
            [
                'numberInParagraph' => '2',
                'text' => 'Die Schwarze Wasserkunst lag etwa 100 Meter südlich davon an der ' .
                    'Harkortstraße (bis 1876 An der Wasserkunst) gegenüber der Brücke zu ' .
                    'Schwägrichens Garten auf der dem Pleißemühlgraben abgewandten Straßenseite, ' .
                    'heute etwa mittig zwischen Martin-Luther-Ring und Dimitroffstraße (♁⊙).',
                'paragraphId' => '3'
            ]
        ]);

        $this->assertEquals(
            [
                1 => [
                    (new Verse())
                        ->setNumberInParagraph(1)
                        ->setText(
                            'Die Leipziger Wasserkünste waren technische Einrichtungen, die über ' .
                            'drei Jahrhunderte die zentrale Wasserversorgung Leipzigs sicherten.'
                        )
                        ->setParagraphId(1),
                    (new Verse())
                        ->setNumberInParagraph(2)
                        ->setText(
                            'Von einem Vorläufer abgesehen, waren es zwei Wasserförderanlagen am ' .
                            'Pleißemühlgraben mit den Namen Rote Wasserkunst und Schwarze Wasserkunst.'
                        )
                        ->setParagraphId(1)
                ],
                2 => [
                    (new Verse())
                        ->setNumberInParagraph(1)
                        ->setText(
                            'Die „Rote“ hatte Tür- und Fenstereinfassungen aus rotem Rochlitzer Porphyr, ' .
                            'was der „Schwarzen“ fehlte.'
                        )
                        ->setParagraphId(2)
                ],
                3 => [
                    (new Verse())
                        ->setNumberInParagraph(1)
                        ->setText(
                            'Die Rote Wasserkunst befand sich auf dem Gelände der Nonnenmühle östlich von dieser. ' .
                            'Das entspricht heute dem Kreuzungsbereich Karl-Tauchnitz-Straße/Martin-Luther-Ring (♁⊙).'
                        )
                        ->setParagraphId(3),
                    (new Verse())
                        ->setNumberInParagraph(2)
                        ->setText(
                            'Die Schwarze Wasserkunst lag etwa 100 Meter südlich davon an der Harkortstraße ' .
                            '(bis 1876 An der Wasserkunst) gegenüber der Brücke zu Schwägrichens Garten auf ' .
                            'der dem Pleißemühlgraben abgewandten Straßenseite, heute etwa mittig zwischen ' .
                            'Martin-Luther-Ring und Dimitroffstraße (♁⊙).'
                        )
                        ->setParagraphId(3)
                ],
                4 => []
            ],
            $this->repository->getVersesGroupedByParagraphId([1, 2, 3, 4])
        );
    }
}
