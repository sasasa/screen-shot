<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class TagRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(private int $min = 1, private int $max = 10)
    {
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    // 最初が[
    // 最後が]
    // 途中に[]をふくまない
    // [..]の中の文字が1文字以上($this->max)
    public function passes($attribute, $value)
    {
        if(!isset($value))
        {
            return true;
        }
        return collect(preg_split("/[\s　]+/u", $value))->every(function ($val, $key) {
            return mb_substr($val, 0, 1) === '['
                && mb_substr($val, -1) === ']'
                && strpos(mb_substr($val, 1, -1),'[') === false
                && strpos(mb_substr($val, 1, -1),']') === false
                && mb_strlen(mb_substr($val, 1, -1)) >= $this->min
                && mb_strlen(mb_substr($val, 1, -1)) <= $this->max;
        });
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ':attribute は正しい形式で入力してください。';
    }
}