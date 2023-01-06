<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Site;

class UrlWithoutQuery implements Rule
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
        $path = $parsed_url['path'];
        $url = 'https://'. $domain. $path;
        $site = Site::query()->where('url', $url)->first();
        return $site === null;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.url_without_query');
    }
}
