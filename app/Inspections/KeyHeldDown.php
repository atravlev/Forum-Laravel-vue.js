<?php 

namespace App\Inspections;

use App\Contracts\Inspections\iSpam;
use Exception;

class KeyHeldDown implements iSpam
{
    /**
     * Detect spam.
     *
     * @param  string $body
     * @throws \Exception
     */
    public function detect($body)
    {
        if (preg_match('/(.)\\1{4,}/', $body)) {
            throw new Exception('Your reply contains spam');
        }
    }
}
