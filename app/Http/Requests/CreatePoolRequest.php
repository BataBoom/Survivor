<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Pool;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
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

        if ($this->input('entry_cost') > 1 || $this->input('guaranteed_prize') > 1) {
            $hidden = true;
        } else {
            $hidden = false;
        }

        $this->merge([
            'status' => true,
            'creator_id' => Auth::user()->id,
            'hidden' => $hidden,
            'public' => filter_var($this->public, FILTER_VALIDATE_BOOLEAN),
        ]);

      // dd($this->all());
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            redirect()->back()->withErrors($validator)->withInput()
        );
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
            'type' => ['required', 'string', 'max:200'],
            'entry_cost' => ['nullable', 'integer', 'min:0'],
            'lives_per_person' => ['required', 'integer'],
            'prize_type' => ['required', 'string', 'max:200'],
            'public' => ['required', 'boolean'],
            'hidden' => ['required', 'boolean'],
            'guaranteed_prize' => ['required', 'numeric'],
            'status' => ['required', 'boolean'],
            'creator_id' => ['required', 'exists:users,id'],

        ];

    }
}
