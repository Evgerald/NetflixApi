<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

/**
 * ReviewCreate Request
 *
 * @version 1.0
 */
class ReviewCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'movie_id' => ['required', 'string', 'exists:movies,movie_id'],
            'user_id' => ['required', 'string', 'exists:users,user_id'],
            'rating' => ['required', 'integer', 'min:0', 'max:255'],
            'review_date' => ['required', 'date'],
            'device_type' => ['required', 'string', 'in:Mobile,Tablet,Laptop,Smart TV'],
            'is_verified_watch' => ['required', 'boolean'],
            'helpful_votes' => ['required', 'numeric'],
            'total_votes' => ['required', 'numeric'],
            'review_text' => ['required', 'string'],
            'sentiment' => ['required', 'string', 'in:neutral,positive,negative'],
            'sentiment_score' => ['required', 'between:0,9.999'],
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            '*.required' => 'Missing required field',
            '*.integer' => 'Check parameter type in documentation',
            '*.string' => 'Check parameter type in documentation',
            '*.boolean' => 'Check parameter type in documentation',
            '*.numeric' => 'Check parameter type in documentation',
            '*.date' => 'Check parameter type in documentation',

            '*.min' => 'Check parameter min value in documentation',
            '*.max' => 'Check parameter max value in documentation',
            '*.in' => 'Check available values in documentation',

            'user_id.exists' => 'Such user does not exist',
            'movie_id.exists' => 'Such movie does not exist',
        ];
    }
}
