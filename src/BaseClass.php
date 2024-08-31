<?php

namespace sdk_moneygate;

use sdk_moneygate\Auth;
use sdk_moneygate\Request;

/**
 * BaseClass
 */
class BaseClass
{
    public Auth $auth;
    public Request $request;

    public function __construct(Auth $auth, bool $isTest = false)
    {
        $this->auth = $auth;
        $this->request = new Request(isTest: $isTest);
    }

    function getAuth()
    {
        return $this->auth;
    }

    function getRequest()
    {
        return $this->request;
    }

}
