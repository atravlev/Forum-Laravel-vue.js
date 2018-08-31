<?php 

namespace App\Inspactions;

use App\Contracts\Inspections\iSpam;
use App\Inspections\InvalidKeywords;
use App\Inspections\KeyHeldDown;

class Spam implements iSpam
{
    /**
     * All registered inspections.
     *
     * @var array
     */
    protected $inspections = [
        InvalidKeywords::class,
        KeyHeldDown::class
    ];

    /**
     * Detect spam.
     *
     * @param  string $body
     * @return bool
     */
    public function detect($body)
    {
        foreach ($this->inspections as $inspection) {
            app($inspection)->detect($body);
        }

        return false;
    }
}
