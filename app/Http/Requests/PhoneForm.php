<?php

namespace App\Http\Requests;

use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Propaganistas\LaravelPhone\PhoneNumber;

class PhoneForm extends FormRequest
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
        return [
            'login' => 'required|exists:users,phone|phone:UA'
        ];
    }

    protected function prepareForValidation()
    {
        try {
            $this->merge([
                'login' => new PhoneNumber($this->phone, 'UA'),
            ]);
    
        } catch (Exception $e) {
            Log::warning('Помилка формування номера телефону: '.$e->getMessage());
        }
    }
}
