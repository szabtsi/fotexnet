<?php

namespace App\Http\Requests;

use App\Models\Screening;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Foundation\Http\FormRequest;

class StoreScreeningRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(
        #[CurrentUser()] User $user
    ): bool {
        return $user->can('create', Screening::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'starts_at' => 'required|date',
            'available_seats' => 'required|integer',
            'movie_id' => 'required|exists:movies,id',
        ];
    }
}
