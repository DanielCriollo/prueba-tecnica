<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;

trait ApiResponse
{
    /**
     * Success response
     *
     * @param mixed $data
     * @param string $message
     * @param int $code
     * @return JsonResponse
     */
    protected function successResponse($data = null, string $message = 'Success', int $code = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    /**
     * Error response
     *
     * @param string $message
     * @param int $code
     * @param mixed $errors
     * @return JsonResponse
     */
    protected function errorResponse(string $message = 'Error', int $code = 500, $errors = null): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if ($errors !== null) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $code);
    }

    /**
     * Created response (201)
     *
     * @param mixed $data
     * @param string $message
     * @return JsonResponse
     */
    protected function createdResponse($data = null, string $message = 'Resource created successfully'): JsonResponse
    {
        return $this->successResponse($data, $message, 201);
    }

    /**
     * No content response (204)
     *
     * @param string $message
     * @return JsonResponse
     */
    protected function noContentResponse(string $message = 'No content'): JsonResponse
    {
        return $this->successResponse(null, $message, 204);
    }

    /**
     * Not found response (404)
     *
     * @param string $message
     * @return JsonResponse
     */
    protected function notFoundResponse(string $message = 'Resource not found'): JsonResponse
    {
        return $this->errorResponse($message, 404);
    }

    /**
     * Validation error response (422)
     *
     * @param string $message
     * @param mixed $errors
     * @return JsonResponse
     */
    protected function validationErrorResponse(string $message = 'Validation failed', $errors = null): JsonResponse
    {
        return $this->errorResponse($message, 422, $errors);
    }

    /**
     * Unauthorized response (401)
     *
     * @param string $message
     * @return JsonResponse
     */
    protected function unauthorizedResponse(string $message = 'Unauthorized'): JsonResponse
    {
        return $this->errorResponse($message, 401);
    }

    /**
     * Forbidden response (403)
     *
     * @param string $message
     * @return JsonResponse
     */
    protected function forbiddenResponse(string $message = 'Forbidden'): JsonResponse
    {
        return $this->errorResponse($message, 403);
    }

    /**
     * Server error response (500)
     *
     * @param string $message
     * @return JsonResponse
     */
    protected function serverErrorResponse(string $message = 'Internal server error'): JsonResponse
    {
        return $this->errorResponse($message, 500);
    }

    /**
     * Bad request response (400)
     *
     * @param string $message
     * @return JsonResponse
     */
    protected function badRequestResponse(string $message = 'Bad request'): JsonResponse
    {
        return $this->errorResponse($message, 400);
    }

    /**
     * Paginated response
     *
     * @param LengthAwarePaginator $paginator
     * @param string $message
     * @return JsonResponse
     */
    protected function paginatedResponse(LengthAwarePaginator $paginator, string $message = 'Data retrieved successfully'): JsonResponse
    {
        return $this->successResponse($paginator, $message);
    }

    /**
     * Collection response
     *
     * @param mixed $collection
     * @param string $message
     * @return JsonResponse
     */
    protected function collectionResponse($collection, string $message = 'Data retrieved successfully'): JsonResponse
    {
        return $this->successResponse($collection, $message);
    }

    /**
     * Single resource response
     *
     * @param mixed $resource
     * @param string $message
     * @return JsonResponse
     */
    protected function resourceResponse($resource, string $message = 'Resource retrieved successfully'): JsonResponse
    {
        return $this->successResponse($resource, $message);
    }

    /**
     * Deleted response
     *
     * @param string $message
     * @return JsonResponse
     */
    protected function deletedResponse(string $message = 'Resource deleted successfully'): JsonResponse
    {
        return $this->successResponse(null, $message);
    }

    /**
     * Updated response
     *
     * @param mixed $data
     * @param string $message
     * @return JsonResponse
     */
    protected function updatedResponse($data = null, string $message = 'Resource updated successfully'): JsonResponse
    {
        return $this->successResponse($data, $message);
    }
}
