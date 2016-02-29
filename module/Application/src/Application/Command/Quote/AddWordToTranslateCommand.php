<?php

namespace Application\Command\Quote;

use CodeMine\CommandQuery\CommandQueryInputFilterAwareInterface;
use ValueObjects\StringLiteral\StringLiteral;
use Zend\InputFilter\InputFilterInterface;

class AddWordToTranslateCommand implements CommandQueryInputFilterAwareInterface
{
    private $word;
    private $translation;
    private $data;
    private $languageCode;
    private $inputFilter;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

//    public function __construct(StringLiteral $word, StringLiteral $translation)
//    {
//        $this->word = $word;
//        $this->translation = $translation;
//    }
    public function word()
    {
        return $this->word;
    }

    public function translation()
    {
        return $this->translation;
    }

    public function languageCode()
    {
        return $this->languageCode;
    }

    public function validate()
    {
        $inputFilter = $this->getInputFilter();
        $inputFilter->setData($this->data);
        if (FALSE === $inputFilter->isValid()) {
            throw new \InvalidArgumentException('Please provide valid data');
        }
        $result = $inputFilter->getValues();
        $this->word = $result['word'];
        $this->translation = $result['translation'];
        $this->languageCode = $result['languageCode'];
    }

    public static function name()
    {
        return static::class;
    }

    public function jsonSerialize()
    {
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        $this->inputFilter = $inputFilter;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }


}

