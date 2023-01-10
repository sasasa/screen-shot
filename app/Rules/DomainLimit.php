<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Site;

class DomainLimit implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $parsed_url = parse_url($value);
        $domain = $parsed_url['host'];
        return Site::where("url", "LIKE", "%".$domain."%")->count() <= 3;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.domain_limit');
    }
}
