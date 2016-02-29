<?php
/**
 * Created by PhpStorm.
 * User: mariusz
 * Date: 29.02.2016
 * Time: 10:32
 */

namespace Infrastructure\Repository;

use Infrastructure\Dao\LanguageDaoInterface;
use Infrastructure\Repository\AbstractRepository;
use Language\Language;
use ValueObjects\StringLiteral\StringLiteral;
class LanguageRepository
{

    /**
     * @var LanguageDaoInterface
     */
    private $languageDao;

    /**
     * LanguageRepository constructor.
     */
    public function __construct(array $config)
    {
        // config[0] instanceof LagnugaeDaoInterrface

        $this->languageDao = $config[0];
    }

    public function findByLanguageCode(StringLiteral $lngCode)
    {
//      $statement =  $this->pdo->prepare('SELECT pole FROM tablica_o_ktorej_jeszcze_nic_nie_wiemy WHERE keyID=:lngCode');
//
//        $result = $statement->execute([
//            ':lngCode' => $lngCode->toNative()
//        ]);
//
//        return $result;

        $result = $this->languageDao->findByLanguageCode($lngCode);

        $language = new Language($result->languageCode, $result->translations);

        return $language;
    }

    public function save(Language $language)
    {
        $this->languageDao->insert($language->getLanguageCode(), $language->getTranslations());
    }
}