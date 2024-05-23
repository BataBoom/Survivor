<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Pool;
use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CreatePoolRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'status' => true,
            'creator_id' => Auth::user()->id,
            'public' => true,
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
            'name' => ['required', 'string', 'max:200'],
            //'type' => ['required', 'in', implode(',',Pool::TYPES)],
            'type' => ['required', 'string', 'max:200'],
            'entry_cost' => ['nullable', 'integer', 'min:0'],
            'lives_per_person' => ['required', 'integer'],
            'prize_type' => ['required', 'string', 'max:200'],
            //'prize_type' => ['required', 'in', implode(',',Pool::PRIZETYPES)],
            'public' => ['required', 'boolean'],
            'prize' => ['required', 'integer'],
            'status' => ['required', 'boolean'],


        ];
    }
}
