<?php

namespace App\Helpers;

use ArrayAccess;

class NullArray implements ArrayAccess
{
    public function offsetExists($offset)
    {
        return false;
    }

    public function offsetGet($offset)
    {
        return $this;
    }

    public function offsetSet($offset, $value)
    {
        // do nothing
    }

    public function offsetUnset($offset)
    {
        // do nothing
    }
}
