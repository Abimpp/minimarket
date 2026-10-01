<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\Uppercase;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('name') && !$this->has('nama')) {
            $this->merge(['nama' => $this->input('name')]);
        }
    }

    public function rules(): array
    {
        return [
            'nama' => ['required', new Uppercase],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:6'],
            'password_confirmation' => ['required', 'same:password'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama tidak boleh kosong!',
            'email.required' => 'Email tidak boleh kosong!',
            'email.email' => 'Format email tidak valid!',
            'password.required' => 'Password tidak boleh kosong!',
            'password.min' => 'Password minimal 6 karakter!',
            'password_confirmation.required' => 'Konfirmasi Password tidak boleh kosong!',
            'password_confirmation.same' => 'Konfirmasi Password tidak sesuai!',
        ];
    }

    public function attributes(): array
    {
        return [
            'nama' => 'Nama',
            'email' => 'Email',
            'password' => 'Password',
            'password_confirmation' => 'Konfirmasi Password',
        ];
    }
}

