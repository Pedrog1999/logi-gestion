<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\DTO\Response\ErrorResponse;
use App\Exceptions\AppException;
use App\Exceptions\BadRequestException;
use App\Exceptions\ValidationException;
use Closure;
use CodeIgniter\HTTP\ResponseInterface;
use Throwable;

abstract class ApiController extends BaseController
{
    /** Ejecuta la acción y traduce excepciones a respuestas JSON. */
    protected function handle(Closure $action): ResponseInterface
    {
        try {
            return $action();
        } catch (AppException $e) {
            return $this->response
                ->setStatusCode($e->getStatusCode())
                ->setJSON(ErrorResponse::fromException($e)->toArray());
        } catch (Throwable $e) {
            log_message('critical', '{exception}', ['exception' => $e]);

            return $this->response
                ->setStatusCode(500)
                ->setJSON(ErrorResponse::internal()->toArray());
        }
    }

    protected function success($data, int $status = 200): ResponseInterface
    {
        return $this->response->setStatusCode($status)->setJSON(['data' => $data]);
    }

    protected function getPayload(): array
    {
        $body = trim((string) $this->request->getBody());

        if ($body === '') {
            return [];
        }

        $data = json_decode($body, true);

        if (! is_array($data)) {
            throw new BadRequestException('El cuerpo de la solicitud debe ser un JSON válido');
        }

        return $data;
    }

    protected function validatePayload(array $payload, array $rules): void
    {
        $validator = service('validation');
        $validator->setRules($rules);

        if (! $validator->run($payload)) {
            throw new ValidationException($validator->getErrors());
        }
    }
}