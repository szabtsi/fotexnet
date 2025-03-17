<?php

namespace App\Http\Requests;

use App\Models\Movie;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Container\Attributes\RouteParameter;
use Illuminate\Foundation\Http\FormRequest;

class UpdateMovieRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(
        #[CurrentUser()] User $user,
        #[RouteParameter()] Movie $movie
    ): bool {
        return $user->can('update', $movie);
    }

    protected function prepareForValidation()
    {
        if ($this->hasFile('image')) {
            $path = $this->file('image')->store('covers');
            $this->merge([
                'cover' => $path,
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'description' => 'required|string',
            'age_limit' => 'required|integer',
            'language' => 'required|string',
            'cover' => 'sometimes|nullable|string',
            'image' => 'sometimes|nullable|image',
        ];
    }
}
