<?php
namespace App\BookEditorBundle\Controller;

use App\BookEditorBundle\Exception\BadRequestException;
use App\BookEditorBundle\Exception\NotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class ErrorController extends AbstractController
{
    public function show(Throwable $exception): Response
    {
        // TODO no detailed error information for production use
        return new Response(
            '{"error":{"message":"' . addslashes($exception->getMessage()) . '"}}',
            $this->getHttpStatusCode($exception),
            ['Content-type' => 'application/json']
        );
    }

    private function getHttpStatusCode(Throwable $exception): int
    {
        if ($exception instanceof BadRequestException || $exception instanceof NotFoundHttpException) {
            return Response::HTTP_BAD_REQUEST;
        }

        if ($exception instanceof NotFoundException) {
            return Response::HTTP_NOT_FOUND;
        }

        return Response::HTTP_INTERNAL_SERVER_ERROR;
    }
}
