<?php
/**
 * Created by PhpStorm.
 * User: mariusz
 * Date: 29.02.2016
 * Time: 11:07
 */

namespace Infrastructure\Dao;

use JsonSchema\Constraints\String;
use ValueObjects\StringLiteral\StringLiteral;
use Zend\Db\Adapter\Driver\Pdo\Statement;

class LanguageDao extends AbstractZendTableGatewayAwareDao implements LanguageDaoInterface
{

    /**
     * @return string
     */
    private $columns = ['language_code', 'label', 'translation'];


    public function tableName()
    {
        // TODO: Implement tableName() method.
        return 'language';
    }

    /**
     *
     */
    public function findByLanguageCode(StringLiteral $languageCode)
    {
        // TODO: Implement findByLanguageCode() method.

    }

    public function insert(StringLiteral $languageCode, array $translations)
    {
        // TODO: Implement insert() method.

        $updateData = [
            'language_code' => $languageCode->toNative(),
            'translations' => $translations
        ];

        $updateResult = $this->getGateway()->update(
            $updateData,
            [
                'language_code' => $languageCode->toNative(),
            ]
        );

        if (0 === $updateResult) {

            $insertData = $updateData;
            $insertData['language_code'] = $languageCode->toNative();

            $this->getGateway()->insert($insertData);
        }
    }

    private function checkIfUpdate(array $tmp1)
    {
        $tempColumn1 = $this->columns[0];
        $tempColumn2 = $this->columns[1];
        $tempTableName = $this->tableName();

        $statement = $tmp1->prepare('SELECT tempColumn1,tempColumn2 FROM tempTableNamee WHERE tempColumn1==');
    }

}