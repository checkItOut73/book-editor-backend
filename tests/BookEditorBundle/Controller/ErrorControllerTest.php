<?php declare(strict_types = 1);

namespace App\BookEditorBundle\Controller;

use App\BookEditorBundle\Exception\BadRequestException;
use App\BookEditorBundle\Exception\NotFoundException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Exception;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @covers \App\BookEditorBundle\Controller\ErrorController
 */
class ErrorControllerTest extends TestCase
{
    private ErrorController $controller;

    public function setUp(): void
    {
        $this->controller = new ErrorController();
    }

    public function testShowReturnsTheCorrectResponse()
    {
        $this->assertEquals(
            new Response(
                '{"error":{"message":"some \"bad\" error"}}',
                Response::HTTP_INTERNAL_SERVER_ERROR,
                ['Content-type' => 'application/json']
            ),
            $this->controller->show(new Exception('some "bad" error'))
        );
    }

    public function exceptionHttpStatusCodeProvider(): array
    {
        return [
            [
                'exception' => new BadRequestException(),
                'expectedHttpStatusCode' => Response::HTTP_BAD_REQUEST
            ],
            [
                'exception' => new NotFoundHttpException(),
                'expectedHttpStatusCode' => Response::HTTP_BAD_REQUEST
            ],
            [
                'exception' => new NotFoundException(),
                'expectedHttpStatusCode' => Response::HTTP_NOT_FOUND
            ],
            [
                'exception' => new Exception(),
                'expectedHttpStatusCode' => Response::HTTP_INTERNAL_SERVER_ERROR
            ]
        ];
    }

    /**
     * @dataProvider exceptionHttpStatusCodeProvider
     * @param Exception $exception
     * @param int $expectedHttpStatusCode
     */
    public function testShowReturnsCorrespondingHttpStatusCodeForException(
        Exception $exception,
        int $expectedHttpStatusCode
    ) {

        $this->assertEquals(
            $expectedHttpStatusCode,
            $this->controller
                ->show($exception)
                ->getStatusCode()
        );
    }
}
