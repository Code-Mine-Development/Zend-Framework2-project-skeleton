<?php
/**
 * @author Radek Adamiec <radek@code-mine.com>.
 */

namespace Infrastructure\Repository;

use ValueObjects\StringLiteral\StringLiteral;

/**
 * Class AbstractRepository
 * @package Infrastructure\Repository
 */
abstract class AbstractRepository
{
    /**
     * @var array
     */
    private static $repo;

    /**
     * @param array                                     $data
     * @param \ValueObjects\StringLiteral\StringLiteral $entityClass
     *
     * @return mixed
     */
    final protected function getInstance(array $data, StringLiteral $entityClass)
    {
        return $this->_createInstance($data, $entityClass);
    }


    /**
     *
     * Creates instance of an Entity class and fills it
     * with provided data. New instance is created without
     * calling constructor.
     *
     * @param array                                     $data
     * @param \ValueObjects\StringLiteral\StringLiteral $entityClassName
     *
     * @return mixed
     */
    private function _createInstance(array $data, StringLiteral $entityClassName)
    {
        $entityClass = new \ReflectionClass($entityClassName->toNative());

        if (FALSE === $entityClass->isInstantiable()) {
            throw new \InvalidArgumentException(sprintf('%s is not instantiable', $entityClassName->toNative()));
        }

        $entity       = $entityClass->newInstanceWithoutConstructor();
        $properties   = $this->_getProperties($entityClass);
        $filteredData = $this->_validateAndFilterDataKeys($data, $properties);
        unset($entityClass);

        return $this->_fillEntity($entity, $properties, $filteredData);
    }

    /**
     *
     * Get all properties from current class and also from parent classes
     *
     * @param \ReflectionClass $entityClass
     *
     * @return array|\ReflectionProperty[]
     */
    private function _getProperties(\ReflectionClass $entityClass)
    {
        $properties = $entityClass->getProperties();
        while (TRUE) {

            if (FALSE === $entityClass->getParentClass()) {
                break;
            }

            $newEntityClass = new \ReflectionClass($entityClass->getParentClass()->name);
            $properties     = array_merge($properties, $newEntityClass->getProperties());
            $entityClass    = $newEntityClass;
        }

        return $properties;
    }


    /**
     * Check if data provided for the Entity is
     * correct. Data keys are checked against
     * properties of the Entity.
     *
     * @param array $data
     * @param array $properties
     *
     * @return array
     */
    private function _validateAndFilterDataKeys(array $data, array $properties)
    {
        $dataKeys     = array_keys($data);
        $filteredData = [];
        $propertyKeys = $this->_extractPropertyKeys($properties);
        foreach ($dataKeys as $field) {
            $fieldInProperties = $field;
            /**
             * Quick check if given filed from data exist in entity
             */
            if (FALSE === isset($propertyKeys[$fieldInProperties])) {
                $fieldInProperties = "_{$fieldInProperties}";
                if (FALSE === isset($propertyKeys[$fieldInProperties])) {
                    throw new \InvalidArgumentException('Invalid data for entity');
                }
            }
            $filteredData[$fieldInProperties] = $data[$field];
        }

        return $filteredData;
    }

    /**
     * @param array $properties
     *
     * @return array
     */
    private function _extractPropertyKeys(array $properties)
    {
        $keys = [];
        foreach ($properties as $property) {
            $keys[$property->getName()] = $property->getName();
        }

        return $keys;
    }


    /**
     * @param       $entity
     * @param array $properties
     * @param array $data
     *
     * @return mixed
     */
    private function _fillEntity($entity, array $properties, array $data)
    {
        foreach ($properties as $property) {
            $property->setAccessible(TRUE);
            $property->setValue($entity, isset($data[$property->getName()]) ? $data[$property->getName()] : NULL);
        }

        return $entity;
    }

    /**
     * @param array|NULL $config
     *
     * @return mixed
     */
    final public static function getRepository(array $config = NULL)
    {
        $calledClassName = get_called_class();
        if (FALSE === isset(self::$repo[$calledClassName]) || NULL === self::$repo[$calledClassName]) {
            self::$repo[$calledClassName] = new $calledClassName($config);
        }

        return self::$repo[$calledClassName];
    }


    /**
     * AbstractRepository constructor.
     *
     * @param array|NULL $config
     */
    abstract protected function __construct(array $config = NULL);


    /**
     * This is just for making sure that singleton pattern is preserved
     */
    private function __clone()
    {
    }

    private function __wakeup()
    {
    }
}