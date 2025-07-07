<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CourseTopic
 *
 * Represents a topic within a course. This model is associated with the `course_topics` table.
 * Each course topic includes a name, a description, a publication date, and a flag indicating whether it is mandatory.
 *
 * @package App\Models
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon $publication_date
 * @property bool $is_mandatory
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class CourseTopic extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'course_topics';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'description',
        'publication_date',
        'is_mandatory',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'publication_date' => 'date',
        'is_mandatory' => 'boolean',
    ];
}