<?php
/**
 * Created by PhpStorm.
 * User: mariusz
 * Date: 29.02.2016
 * Time: 13:24
 */

namespace Infrastructure\Dao;


use ValueObjects\StringLiteral\StringLiteral;

interface LanguageDaoInterface {
    public function insert(StringLiteral $languageCode, array $translations);

    public function findByLanguageCode(StringLiteral $languageCode);
}