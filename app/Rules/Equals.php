<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Equals implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    private $param2;

    public function __construct($param2)
    {
        $this->param2 = $param2;
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
        return $value == $this->param2;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Esta não é a porra do nif';
    }
}
