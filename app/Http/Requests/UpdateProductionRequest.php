<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'company_type' => 'required|integer|min:1|max:3',
            'name' => 'required|string|max:255',
            'kana' => 'required|string|max:255|regex:/^[ァ-ヾ]+$/u',
            'representative' => 'required|string|max:255',
            'inquiry_email' => 'required|string|email:strict,dns,spoof|max:255|unique:productions,inquiry_email,'. $this->production->id . ',id',
            'postal' => 'required|string|regex:/^\d{3}-\d{4}$/',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|regex:/^(0{1}\d{1,4}-{0,1}\d{1,4}-{0,1}\d{4})$/',
            'url' => 'required|string|max:255|url',
            'staff' => 'required|integer|min:1|max:7',
            'achievement' => 'required|string|max:5000',
            'introduction' => 'required|string|max:5000',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'postal.regex' => '郵便番号は正しい形式で入力してください',
            'kana.regex' => 'カタカナで入力してください',
            'phone.regex' => '電話番号は正しい形式で入力してください',
        ];
    }
}
