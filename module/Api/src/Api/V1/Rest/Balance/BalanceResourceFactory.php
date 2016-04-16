<?php
namespace Api\V1\Rest\Balance;

class BalanceResourceFactory
{
    public function __invoke($services)
    {
        return new BalanceResource();
    }
}
