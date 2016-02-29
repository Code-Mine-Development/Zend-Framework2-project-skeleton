<?php
/**
 * Created by PhpStorm.
 * User: mariusz
 * Date: 24.02.2016
 * Time: 14:50
 */

namespace Language;


use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator;
use ValueObjects\StringLiteral\StringLiteral;

class Language
{
    private $languageCode;
    private $translations = array();


    /**
     * Language constructor.
     * @param StringLiteral $languageCode
     * @param array $translations
     */
    public function __construct(StringLiteral $languageCode, array $translations)
    {
        $this->languageCode = $languageCode;
        $this->translations = $translations;
    }

    /**
     * @param StringLiteral $word
     * @param StringLiteral $translation
     */
    public function addTranslation(StringLiteral $word, StringLiteral $translation)
    {
        $this->validateData($word->toNative(), $translation->toNative());
        array_push($this->translations, [$word->toNative() => $translation->toNative()]);
    }

    public function getLanguageCode()
    {
        return $this->languageCode;
    }

    /**
     * @param StringLiteral $word
     * @param StringLiteral $translation
     */
    public function editTranslation(StringLiteral $word, StringLiteral $translation)
    {
        $this->wordExist($word);
        $this->translations[$word->toNative()] = $translation->toNative();
    }

    /**
     * @param StringLiteral $word
     * @return mixed
     */
    public function getTranslation(StringLiteral $word) :string
    {
        $this->wordExist($word);
        return $this->translations[$word->toNative()];
    }

    /**
     * @return array
     */
    public function getTranslations() : array
    {
        return $this->translations;
    }

    /**
     * @param $word
     * @param $translation
     */
    private function validateData($word, $translation)
    {
        $wordScalar = $word;
        $translationScalar = $translation;
        $validator = Validator::stringType()
            ->notEmpty();

        try {
            $validator->assert($wordScalar);
            $validator->assert($translationScalar);
        } catch (NestedValidationException $exception) {
            throw new \InvalidArgumentException($exception->getFullMessage());
        }
    }

    /**
     * @param StringLiteral $word
     */
    public function wordExist(StringLiteral $word)
    {
        if (!isset($this->translations[$word->toNative()])) {
            throw new \InvalidArgumentException('Word does not exist in the database');
        }
    }
//    public function jsonSerialize()
//    {
//        return [
//            'languageCode' => $this->languageCode,
//            $this->translations,
//        ];
//    }
}
