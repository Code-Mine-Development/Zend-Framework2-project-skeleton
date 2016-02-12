<?php
/**
 * Created by IntelliJ IDEA.
 * Author: Tomasz Osadnik
 * Date: 2015-12-05
 * Time: 12:14
 */

namespace Application\Validator;


use Rhumsaa\Uuid\Uuid;
use Zend\Validator\AbstractValidator;

class UuidValidator extends AbstractValidator
{
    const UUID = 'uuid';

    /**
     * @var array
     */
    protected $messageTemplates = [
        self::UUID => "'%value%' is not a uuid value",
    ];

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isValid($value)
    {
        $this->setValue($value);

        if (FALSE == Uuid::isValid($value)) {
            $this->error(self::UUID);

            return FALSE;
        }

        return TRUE;
    }
}