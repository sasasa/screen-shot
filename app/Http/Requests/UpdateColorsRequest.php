<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateColorsRequest extends FormRequest
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
        $validate_orders_sum = function($attribute, $value, $fail) {
            $orders = $this->collect('orders');
            // Confirm that the total is less than 100 when all are added together
            if($orders->sum() > 100) {
                $fail('色の割合の合計が100を超えています。全てを足して100以下になるようにしてください。');
            }
        };
        $validate_colors_num = function($attribute, $value, $fail) {
            $colors = $this->collect('colors');
            if($colors->count() > 3) {
                $fail('色が4つ以上選択されています。3つ以下にしてください。');
            }
        };
        $validate_color_order = function($attribute, $value, $fail) {
            $colors = $this->collect('colors');
            // 選択されたカラーのorderは0以上100以下
            $colors->each(function($color) use ($fail) {
                if($this->orders[$color] <= 0 || $this->orders[$color] > 100) {
                    $fail('選択中の色の割合は1以上100以下にしてください。');
                }
            });
        };
        return [
            'colors' => ['required', 'array', $validate_colors_num, ],
            'colors.*' => ['required', 'string', ] ,
            'orders' => ['required', 'array', $validate_orders_sum, $validate_color_order, ],
            'orders.*' => ['integer', 'min:0', 'max:100', ],
        ];
    }
}
