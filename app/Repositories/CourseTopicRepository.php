<?php

namespace App\Repositories;

use App\Models\CourseTopic;
use App\Repositories\Interfaces\CourseTopicRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class CourseTopicRepository implements CourseTopicRepositoryInterface
{
    protected $model;

    public function __construct(CourseTopic $model)
    {
        $this->model = $model;
    }

    /**
     * Get all course topics with pagination
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getAllPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model->orderBy('created_at', 'desc')->paginate($perPage);
    }

    /**
     * Find course topic by ID
     *
     * @param int $id
     * @return CourseTopic|null
     */
    public function findById(int $id): ?CourseTopic
    {
        return $this->model->find($id);
    }

    /**
     * Create a new course topic
     *
     * @param array $data
     * @return CourseTopic
     */
    public function create(array $data): CourseTopic
    {
        return $this->model->create($data);
    }

    /**
     * Update course topic
     *
     * @param int $id
     * @param array $data
     * @return CourseTopic|null
     */
    public function update(int $id, array $data): ?CourseTopic
    {
        $courseTopic = $this->findById($id);

        if ($courseTopic) {
            $courseTopic->update($data);
            return $courseTopic->fresh();
        }

        return null;
    }

    /**
     * Delete course topic
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $courseTopic = $this->findById($id);

        if ($courseTopic) {
            return $courseTopic->delete();
        }

        return false;
    }

    /**
     * Get all course topics
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->model->orderBy('created_at', 'desc')->get();
    }
}
