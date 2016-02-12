<?php
/**
 * @author Radek Adamiec <radek@code-mine.com>.
 */

namespace Api\V1\Rest;


use League\Tactician\CommandBus;
use ValueObjects\StringLiteral\StringLiteral;

class UpdateDispatcher
{
    /**
     * @var array
     */
    private $actionCommandList;

    /**
     * @var \League\Tactician\CommandBus
     */
    private $commandBus;

    /**
     * UpdateDispatcher constructor.
     *
     * @param \League\Tactician\CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @param array      $data
     * @param array|NULL $additional
     */
    public function dispatch(array $data, array $additional = NULL)
    {
        foreach ($data['operations'] as $operation) {


            $data = (array)$operation['value'];

            $this->handleOperation(
                StringLiteral::fromNative($operation['op']),
                StringLiteral::fromNative($operation['path']),
                $data,
                $additional
            );
        }
    }

    private function handleOperation(StringLiteral $action, StringLiteral $path, array $data, array $additional = NULL)
    {

        if (NULL !== $additional) {

            foreach ($additional as $property => $extraData) {
                $data[$property] = $extraData;
            }

        }

        $pathsRaw = explode('/', trim($path->toNative(), '/'));

        $pathForAction = $this->actionCommandList;
        foreach ($pathsRaw as $pathRaw) {
            $pathForAction = $pathForAction[$pathRaw];
        }

        $commandClassName = $pathForAction[$action->toNative()];

        $command = new $commandClassName($data);

        $this->commandBus->handle($command);
    }

    /**
     * @param array $actionCommandList
     */
    public function setActionCommandList($actionCommandList)
    {
        $this->actionCommandList = $actionCommandList;
    }
}