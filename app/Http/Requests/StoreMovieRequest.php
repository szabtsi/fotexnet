<?php

namespace App\Http\Requests;

use App\Models\Movie;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Foundation\Http\FormRequest;

class StoreMovieRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(
        #[CurrentUser()] User $user
    ): bool {
        return $user->can('create', Movie::class);
    }

    protected function prepareForValidation()
    {
        $path = $this->file('image')->store('covers');
        $this->merge([
            'cover' => $path,
        ]);
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
            'cover' => 'required|string',
            'image' => 'required|image',
        ];
    }
}
