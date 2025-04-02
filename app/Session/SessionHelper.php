<?php

namespace App\Session;

use SlimSession\Helper;

class SessionHelper extends Helper
{
    /**
     * Get all session data
     *
     * @return array
     */
    public function all()
    {
        return $_SESSION;
    }
}