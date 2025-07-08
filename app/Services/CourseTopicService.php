<?php

namespace App\Services;

use App\Models\CourseTopic;
use App\Repositories\Interfaces\CourseTopicRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Exception;

class CourseTopicService
{
    protected $courseTopicRepository;

    public function __construct(CourseTopicRepositoryInterface $courseTopicRepository)
    {
        $this->courseTopicRepository = $courseTopicRepository;
    }

    /**
     * Get all course topics with pagination
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getAllPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return $this->courseTopicRepository->getAllPaginated($perPage);
    }

    /**
     * Find course topic by ID
     *
     * @param int $id
     * @return CourseTopic|null
     * @throws Exception
     */
    public function findById(int $id): ?CourseTopic
    {
        $courseTopic = $this->courseTopicRepository->findById($id);

        if (!$courseTopic) {
            throw new Exception('Course topic not found', 404);
        }

        return $courseTopic;
    }

    /**
     * Create a new course topic
     *
     * @param array $data
     * @return CourseTopic
     */
    public function create(array $data): CourseTopic
    {
        // Validate publication date is not in the past
        if (isset($data['publication_date']) && strtotime($data['publication_date']) < time()) {
            throw new Exception('Publication date cannot be in the past', 422);
        }

        return $this->courseTopicRepository->create($data);
    }

    /**
     * Update course topic
     *
     * @param int $id
     * @param array $data
     * @return CourseTopic
     * @throws Exception
     */
    public function update(int $id, array $data): CourseTopic
    {
        // Validate publication date is not in the past
        if (isset($data['publication_date']) && strtotime($data['publication_date']) < time()) {
            throw new Exception('Publication date cannot be in the past', 422);
        }

        $courseTopic = $this->courseTopicRepository->update($id, $data);

        if (!$courseTopic) {
            throw new Exception('Course topic not found', 404);
        }

        return $courseTopic;
    }

    /**
     * Delete course topic
     *
     * @param int $id
     * @return bool
     * @throws Exception
     */
    public function delete(int $id): bool
    {
        $deleted = $this->courseTopicRepository->delete($id);

        if (!$deleted) {
            throw new Exception('Course topic not found', 404);
        }

        return true;
    }

    /**
     * Get all course topics
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->courseTopicRepository->getAll();
    }
}
