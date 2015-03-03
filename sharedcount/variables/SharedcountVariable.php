<?php
namespace Craft;

class SharedcountVariable
{
    public function likes($options = array())
    {
        return craft()->sharedcount->likes($options);
    }

}