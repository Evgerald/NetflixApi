<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

/**
 * ReviewUpdate Request
 *
 * @version 1.0
 */
class ReviewUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'rating' => ['integer', 'min:0', 'max:255'],
            'device_type' => ['string', 'in:Mobile,Tablet,Laptop,Smart TV'],
            'is_verified_watch' => ['boolean'],
            'helpful_votes' => ['numeric'],
            'total_votes' => ['numeric'],
            'sentiment' => ['string', 'in:neutral,positive,negative'],
            'sentiment_score' => ['between:0,9.999'],
            'review_date' => ['date'],
            'movie_id' => ['string', 'exists:movies,movie_id'],
            'user_id' => ['string', 'exists:users,user_id'],
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
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
