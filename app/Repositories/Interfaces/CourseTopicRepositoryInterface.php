<?php

namespace App\Repositories\Interfaces;

use App\Models\CourseTopic;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface CourseTopicRepositoryInterface
{
    /**
     * Get all course topics with pagination
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getAllPaginated(int $perPage = 15): LengthAwarePaginator;

    /**
     * Find course topic by ID
     *
     * @param int $id
     * @return CourseTopic|null
     */
    public function findById(int $id): ?CourseTopic;

    /**
     * Create a new course topic
     *
     * @param array $data
     * @return CourseTopic
     */
    public function create(array $data): CourseTopic;

    /**
     * Update course topic
     *
     * @param int $id
     * @param array $data
     * @return CourseTopic|null
     */
    public function update(int $id, array $data): ?CourseTopic;

    /**
     * Delete course topic
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * Get all course topics
     *
     * @return Collection
     */
    public function getAll(): Collection;
}
