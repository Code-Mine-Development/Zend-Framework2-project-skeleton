<?php
/**
 * Created by IntelliJ IDEA.
 * Author: Tomasz Osadnik
 * Date: 2015-12-03
 * Time: 12:06
 */

namespace Application\Service;


use CodeMine\CommandQuery\CommandQueryInputFilterAwareInterface;
use CodeMine\CommandQuery\CommandQueryInterface;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterPluginManager;

class CommandService
{
    /**
     * @var \Zend\InputFilter\InputFilterPluginManager
     */
    private $inputFilterManager;

    /**
     * @var array
     */
    private $map;

    /**
     * @param \Zend\InputFilter\InputFilterPluginManager $manager
     */
    public function setInputFilterManager(InputFilterPluginManager $manager)
    {
        $this->inputFilterManager = $manager;
    }

    /**
     * @param array $map
     */
    public function setInputFilterMap(array $map = [])
    {
        $this->map = $map;
    }

    /**
     * @param string $commandClassName
     *
     * @return string|NULL
     */
    private function getInputFilterClassName($commandClassName)
    {
        return isset($this->map[$commandClassName]) ? $this->map[$commandClassName] : NULL;
    }

    /**
     * @param string $commandClassName
     * @param array  $arguments
     *
     * @return CommandQueryInterface
     */
    public function getCommand($commandClassName, array $arguments = [])
    {
        if (FALSE === class_exists($commandClassName)) {
            throw new \InvalidArgumentException('Invalid class name');
        }

        // create Command
        $reflector = new \ReflectionClass($commandClassName);
        $command   = $reflector->newInstanceArgs($arguments);

        // is Command?
        if (FALSE === $command instanceof CommandQueryInterface) {
            throw new \InvalidArgumentException('Invalid Command class');
        }

        // is InputFilterAware Interface?
        if (TRUE === $command instanceof CommandQueryInputFilterAwareInterface) {

            $name = $this->getInputFilterClassName($commandClassName);
            if (TRUE === $this->inputFilterManager->has($name)) {
                $inputFilter = $this->inputFilterManager->get($name);
                $command->setInputFilter($inputFilter);
            }
        }

        return $command;
    }
}