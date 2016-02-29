<?php
/**
 * Created by PhpStorm.
 * User: mariusz
 * Date: 29.02.2016
 * Time: 10:32
 */

namespace Infrastructure\Repository;

use Infrastructure\Repository\AbstractRepository;
use ValueObjects\StringLiteral\StringLiteral;

class LanguageRepository
{

    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * LanguageRepository constructor.
     */
    public function __construct(array $config)
    {
        $this->pdo = NULL;
    }

    public function findByLanguageCode(StringLiteral $lngCode)
    {
       $statement =  $this->pdo->prepare('SELECT pole FROM tablica_o_ktorej_jeszcze_nic_nie_wiemy WHERE keyID=:lngCode');

        $result = $statement->execute([
            ':lngCode' => $lngCode->toNative()
        ]);

        return $result;
    }

    public function save()
    {

    }
}