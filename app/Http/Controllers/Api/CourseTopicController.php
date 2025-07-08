<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CourseTopic\StoreCourseTopicRequest;
use App\Http\Requests\CourseTopic\UpdateCourseTopicRequest;
use App\Services\CourseTopicService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;

class CourseTopicController extends BaseApiController
{
    protected $courseTopicService;

    public function __construct(CourseTopicService $courseTopicService)
    {
        parent::__construct();
        $this->courseTopicService = $courseTopicService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $perPage = $request->get('per_page', 15);
            $courseTopics = $this->courseTopicService->getAllPaginated($perPage);

            return $this->paginatedResponse($courseTopics, 'Course topics retrieved successfully');
        } catch (Exception $e) {
            return $this->serverErrorResponse('Error retrieving course topics: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseTopicRequest $request): JsonResponse
    {
        try {
            $courseTopic = $this->courseTopicService->create($request->validated());

            return $this->createdResponse($courseTopic, 'Course topic created successfully');
        } catch (Exception $e) {
            return $this->validationErrorResponse('Error creating course topic: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): JsonResponse
    {
        try {
            $courseTopic = $this->courseTopicService->findById($id);

            return $this->resourceResponse($courseTopic, 'Course topic retrieved successfully');
        } catch (Exception $e) {
            $statusCode = $e->getCode() ?: 500;

            if ($statusCode === 404) {
                return $this->notFoundResponse($e->getMessage());
            }

            return $this->serverErrorResponse($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseTopicRequest $request, int $id): JsonResponse
    {
        try {
            $courseTopic = $this->courseTopicService->update($id, $request->validated());

            return $this->updatedResponse($courseTopic, 'Course topic updated successfully');
        } catch (Exception $e) {
            $statusCode = $e->getCode() ?: 500;

            if ($statusCode === 404) {
                return $this->notFoundResponse($e->getMessage());
            }

            return $this->validationErrorResponse($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->courseTopicService->delete($id);

            return $this->deletedResponse('Course topic deleted successfully');
        } catch (Exception $e) {
            $statusCode = $e->getCode() ?: 500;

            if ($statusCode === 404) {
                return $this->notFoundResponse($e->getMessage());
            }

            return $this->serverErrorResponse($e->getMessage());
        }
    }

    /**
     * Get all course topics without pagination
     */
    public function all(): JsonResponse
    {
        try {
            $courseTopics = $this->courseTopicService->getAll();

            return $this->collectionResponse($courseTopics, 'All course topics retrieved successfully');
        } catch (Exception $e) {
            return $this->serverErrorResponse('Error retrieving course topics: ' . $e->getMessage());
        }
    }
}
