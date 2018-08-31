<?php 

namespace App\Inspections;

use App\Contracts\Inspections\iSpam;
use Exception;

class InvalidKeywords implements iSpam
{
    /**
     * All registered invalid keywords.
     *
     * @var array
     */
    protected $keywords = [
        'yahoo customer support'
    ];

    /**
     * Detect spam.
     *
     * @param  string $body
     * @throws \Exception
     */
    public function detect($body)
    {
        foreach ($this->keywords as $keyword) {
            if (stripos($body, $keyword) !== false) {
                throw new Exception('Your reply contains spam');
            }
        }
    }
}
