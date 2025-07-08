<?php

namespace App\Http\Requests\CourseTopic;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCourseTopicRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $courseTopicId = $this->route('id');

        return [
            'name' => [
                'sometimes',
                'string',
                'max:255',
                Rule::unique('course_topics', 'name')->ignore($courseTopicId),
            ],
            'description' => 'sometimes|nullable|string|max:1000',
            'publication_date' => 'sometimes|date|after_or_equal:today',
            'is_mandatory' => 'sometimes|boolean',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.unique' => 'Ya existe un tema con este nombre.',
            'name.max' => 'El nombre del tema no puede superar los 255 caracteres.',
            'description.max' => 'La descripción no puede superar los 1000 caracteres.',
            'publication_date.date' => 'La fecha de publicación debe ser una fecha válida.',
            'publication_date.after_or_equal' => 'La fecha de publicación debe ser hoy o una fecha futura.',
            'is_mandatory.boolean' => 'El campo obligatorio debe ser verdadero o falso.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'name' => 'nombre del tema',
            'description' => 'descripción',
            'publication_date' => 'fecha de publicación',
            'is_mandatory' => 'estado obligatorio',
        ];
    }
}
