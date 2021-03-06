<?php
/**
 * @copyright Copyright © 2014 Rollun LC (http://rollun.com/)
 * @license LICENSE.md New BSD License
 */

namespace rollun\test\old\DataStore;

class CsvIntIdTest extends CsvBaseTest
{
    protected $entity = 'testCsvIntId';

    public function testCheckIntegrity()
    {
        $this->_initObject();
        $this->assertTrue($this->object->checkIntegrityData());
    }

    public function testInsertLastRowAndCheckIntegrity()
    {
        $this->_initObject();
        $itemData = [
            'id' => 1000,
            'anotherId' => null,
            'fFloat' => 1000.01,
            'fString' => '',
        ];
        $this->object->create($itemData);
        $this->assertTrue($this->object->checkIntegrityData());
    }

    public function testInsertRowIntoMiddleListAndCheckIntegrity()
    {
        $this->_initObject();
        $itemData = [
            'id' => 1000,
            'anotherId' => null,
            'fFloat' => 1000.01,
            'fString' => '',
        ];
        $this->object->create($itemData);
        $itemData = [
            'id' => 100,
            'anotherId' => null,
            'fFloat' => 100.01,
            'fString' => '',
        ];
        $this->object->create($itemData);
        $this->assertTrue($this->object->checkIntegrityData());
    }

    public function testIntegrityNotSortedData()
    {
        $itemData = $this->_itemsArrayDelault;
        $itemData[] = [
            'id' => 1000,
            'anotherId' => null,
            'fFloat' => 1000.01,
            'fString' => '',
        ];
        $itemData[] = [
            'id' => 100,
            'anotherId' => null,
            'fFloat' => 100.01,
            'fString' => '',
        ];
        $this->_initObject($itemData);
        $this->expectException('\rollun\datastore\DataStore\DataStoreException');
        $this->object->checkIntegrityData();
    }

    public function testIntegrity_TryingToWriteNotIntegerPrimaryKey()
    {
        $this->_initObject();
        $itemData = [
            'id' => uniqid(),
            'anotherId' => null,
            'fFloat' => 1000.01,
            'fString' => '',
        ];
        $this->expectException('\rollun\datastore\DataStore\DataStoreException');
        $this->object->create($itemData);
    }
}