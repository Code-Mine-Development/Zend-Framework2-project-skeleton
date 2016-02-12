<?php
namespace Api\V1\Rpc\Health;

class HealthControllerFactory
{
    public function __invoke($controllers)
    {
        return new HealthController();
    }
}
