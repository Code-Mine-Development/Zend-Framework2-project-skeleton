<?php
/**
 * Created by PhpStorm.
 * User: mariusz
 * Date: 24.02.2016
 * Time: 14:51
 */

namespace Language;


use Language\Language;
use ValueObjects\StringLiteral\StringLiteral;

class LanguageTest extends \PHPUnit_Framework_TestCase
{
    public function testLanguage()
    {
        $word = new StringLiteral('register');
        $translation = new StringLiteral('zarejestruj sie');
        $translations = array('send'=>'wyslij', 'new'=>'nowy');
        $slug = new StringLiteral('PL');
        $language = new Language($slug, $translations);
        $languages = array();
        //$language->getTranslations();
        $language->addTranslation($word, $translation);
        $word2 = new StringLiteral('register2');
        $translation2 = new StringLiteral('zarejestruj sie 2');
        $language->addTranslation($word2, $translation2);
        $edit1 = new StringLiteral('send');
        $editVal = new StringLiteral('WYSLIJ!!');
        $language->editTranslation($edit1, $editVal);
        array_push($languages, $translations);
        array_push($languages, [$word->toNative() => $translation->toNative()]);
//        $langJson=$language->jsonSerialize();
//        var_dump($langJson);
        $this->assertSame($languages, $language->getTranslations());
    }

}
