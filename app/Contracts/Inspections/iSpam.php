<?php

namespace App\Contracts\Inspections;

interface iSpam
{
    /**
     * Detect spam.
     *
     * @param  string $body
     */
    public function detect($body);
}
