<?php

namespace Application;

use Zend\InputFilter\InputFilterAwareInterface;

/**
 * Interface CommandQueryInputFilterAwareInterface
 * @package   Application
 */
interface CommandQueryInputFilterAwareInterface extends CommandQueryInterface, InputFilterAwareInterface
{
    /**
     * @return bool
     */
    public function validate();
}