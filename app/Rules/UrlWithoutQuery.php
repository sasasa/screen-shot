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
        $url1 = 'https://'. $domain. $path;
        $site1 = Site::query()->where('url', $url1)->first();
        $url2 = 'http://'. $domain. $path;
        $site2 = Site::query()->where('url', $url2)->first();
        return $site1 === null && $site2 === null;
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
