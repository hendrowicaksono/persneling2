<?php

namespace Slims\Models\Bibliography\Item\Map;

use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;
use Slims\Models\Bibliography\Item\Item;
use Slims\Models\Bibliography\Item\ItemQuery;


/**
 * This class defines the structure of the 'item' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class ItemTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Slims.Models.Bibliography.Item.Map.ItemTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'slims';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'item';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Slims\\Models\\Bibliography\\Item\\Item';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Slims.Models.Bibliography.Item.Item';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 21;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 21;

    /**
     * the column name for the item_id field
     */
    const COL_ITEM_ID = 'item.item_id';

    /**
     * the column name for the item_code field
     */
    const COL_ITEM_CODE = 'item.item_code';

    /**
     * the column name for the biblio_id field
     */
    const COL_BIBLIO_ID = 'item.biblio_id';

    /**
     * the column name for the call_number field
     */
    const COL_CALL_NUMBER = 'item.call_number';

    /**
     * the column name for the coll_type_id field
     */
    const COL_COLL_TYPE_ID = 'item.coll_type_id';

    /**
     * the column name for the inventory_code field
     */
    const COL_INVENTORY_CODE = 'item.inventory_code';

    /**
     * the column name for the received_date field
     */
    const COL_RECEIVED_DATE = 'item.received_date';

    /**
     * the column name for the supplier_id field
     */
    const COL_SUPPLIER_ID = 'item.supplier_id';

    /**
     * the column name for the order_no field
     */
    const COL_ORDER_NO = 'item.order_no';

    /**
     * the column name for the location_id field
     */
    const COL_LOCATION_ID = 'item.location_id';

    /**
     * the column name for the order_date field
     */
    const COL_ORDER_DATE = 'item.order_date';

    /**
     * the column name for the item_status_id field
     */
    const COL_ITEM_STATUS_ID = 'item.item_status_id';

    /**
     * the column name for the site field
     */
    const COL_SITE = 'item.site';

    /**
     * the column name for the source field
     */
    const COL_SOURCE = 'item.source';

    /**
     * the column name for the invoice field
     */
    const COL_INVOICE = 'item.invoice';

    /**
     * the column name for the price field
     */
    const COL_PRICE = 'item.price';

    /**
     * the column name for the price_currency field
     */
    const COL_PRICE_CURRENCY = 'item.price_currency';

    /**
     * the column name for the invoice_date field
     */
    const COL_INVOICE_DATE = 'item.invoice_date';

    /**
     * the column name for the input_date field
     */
    const COL_INPUT_DATE = 'item.input_date';

    /**
     * the column name for the last_update field
     */
    const COL_LAST_UPDATE = 'item.last_update';

    /**
     * the column name for the uid field
     */
    const COL_UID = 'item.uid';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('ItemId', 'Item_code', 'BiblioId', 'Call_number', 'Coll_type_id', 'Inventory_code', 'Received_date', 'SupplierId', 'Order_no', 'LocationId', 'Order_date', 'ItemStatusId', 'Site', 'Source', 'Invoice', 'Price', 'Price_currency', 'Invoice_date', 'Input_date', 'Last_update', 'Uid', ),
        self::TYPE_CAMELNAME     => array('itemId', 'item_code', 'biblioId', 'call_number', 'coll_type_id', 'inventory_code', 'received_date', 'supplierId', 'order_no', 'locationId', 'order_date', 'itemStatusId', 'site', 'source', 'invoice', 'price', 'price_currency', 'invoice_date', 'input_date', 'last_update', 'uid', ),
        self::TYPE_COLNAME       => array(ItemTableMap::COL_ITEM_ID, ItemTableMap::COL_ITEM_CODE, ItemTableMap::COL_BIBLIO_ID, ItemTableMap::COL_CALL_NUMBER, ItemTableMap::COL_COLL_TYPE_ID, ItemTableMap::COL_INVENTORY_CODE, ItemTableMap::COL_RECEIVED_DATE, ItemTableMap::COL_SUPPLIER_ID, ItemTableMap::COL_ORDER_NO, ItemTableMap::COL_LOCATION_ID, ItemTableMap::COL_ORDER_DATE, ItemTableMap::COL_ITEM_STATUS_ID, ItemTableMap::COL_SITE, ItemTableMap::COL_SOURCE, ItemTableMap::COL_INVOICE, ItemTableMap::COL_PRICE, ItemTableMap::COL_PRICE_CURRENCY, ItemTableMap::COL_INVOICE_DATE, ItemTableMap::COL_INPUT_DATE, ItemTableMap::COL_LAST_UPDATE, ItemTableMap::COL_UID, ),
        self::TYPE_FIELDNAME     => array('item_id', 'item_code', 'biblio_id', 'call_number', 'coll_type_id', 'inventory_code', 'received_date', 'supplier_id', 'order_no', 'location_id', 'order_date', 'item_status_id', 'site', 'source', 'invoice', 'price', 'price_currency', 'invoice_date', 'input_date', 'last_update', 'uid', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('ItemId' => 0, 'Item_code' => 1, 'BiblioId' => 2, 'Call_number' => 3, 'Coll_type_id' => 4, 'Inventory_code' => 5, 'Received_date' => 6, 'SupplierId' => 7, 'Order_no' => 8, 'LocationId' => 9, 'Order_date' => 10, 'ItemStatusId' => 11, 'Site' => 12, 'Source' => 13, 'Invoice' => 14, 'Price' => 15, 'Price_currency' => 16, 'Invoice_date' => 17, 'Input_date' => 18, 'Last_update' => 19, 'Uid' => 20, ),
        self::TYPE_CAMELNAME     => array('itemId' => 0, 'item_code' => 1, 'biblioId' => 2, 'call_number' => 3, 'coll_type_id' => 4, 'inventory_code' => 5, 'received_date' => 6, 'supplierId' => 7, 'order_no' => 8, 'locationId' => 9, 'order_date' => 10, 'itemStatusId' => 11, 'site' => 12, 'source' => 13, 'invoice' => 14, 'price' => 15, 'price_currency' => 16, 'invoice_date' => 17, 'input_date' => 18, 'last_update' => 19, 'uid' => 20, ),
        self::TYPE_COLNAME       => array(ItemTableMap::COL_ITEM_ID => 0, ItemTableMap::COL_ITEM_CODE => 1, ItemTableMap::COL_BIBLIO_ID => 2, ItemTableMap::COL_CALL_NUMBER => 3, ItemTableMap::COL_COLL_TYPE_ID => 4, ItemTableMap::COL_INVENTORY_CODE => 5, ItemTableMap::COL_RECEIVED_DATE => 6, ItemTableMap::COL_SUPPLIER_ID => 7, ItemTableMap::COL_ORDER_NO => 8, ItemTableMap::COL_LOCATION_ID => 9, ItemTableMap::COL_ORDER_DATE => 10, ItemTableMap::COL_ITEM_STATUS_ID => 11, ItemTableMap::COL_SITE => 12, ItemTableMap::COL_SOURCE => 13, ItemTableMap::COL_INVOICE => 14, ItemTableMap::COL_PRICE => 15, ItemTableMap::COL_PRICE_CURRENCY => 16, ItemTableMap::COL_INVOICE_DATE => 17, ItemTableMap::COL_INPUT_DATE => 18, ItemTableMap::COL_LAST_UPDATE => 19, ItemTableMap::COL_UID => 20, ),
        self::TYPE_FIELDNAME     => array('item_id' => 0, 'item_code' => 1, 'biblio_id' => 2, 'call_number' => 3, 'coll_type_id' => 4, 'inventory_code' => 5, 'received_date' => 6, 'supplier_id' => 7, 'order_no' => 8, 'location_id' => 9, 'order_date' => 10, 'item_status_id' => 11, 'site' => 12, 'source' => 13, 'invoice' => 14, 'price' => 15, 'price_currency' => 16, 'invoice_date' => 17, 'input_date' => 18, 'last_update' => 19, 'uid' => 20, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('item');
        $this->setPhpName('Item');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Slims\\Models\\Bibliography\\Item\\Item');
        $this->setPackage('Slims.Models.Bibliography.Item');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('item_id', 'ItemId', 'INTEGER', true, null, null);
        $this->addColumn('item_code', 'Item_code', 'VARCHAR', true, 20, null);
        $this->addForeignKey('biblio_id', 'BiblioId', 'INTEGER', 'biblio', 'biblio_id', true, null, null);
        $this->addColumn('call_number', 'Call_number', 'VARCHAR', false, 50, null);
        $this->addForeignKey('coll_type_id', 'Coll_type_id', 'INTEGER', 'mst_coll_type', 'coll_type_id', false, 3, null);
        $this->addColumn('inventory_code', 'Inventory_code', 'VARCHAR', false, 200, null);
        $this->addColumn('received_date', 'Received_date', 'DATE', false, null, null);
        $this->addColumn('supplier_id', 'SupplierId', 'INTEGER', false, null, null);
        $this->addColumn('order_no', 'Order_no', 'VARCHAR', false, 20, null);
        $this->addColumn('location_id', 'LocationId', 'VARCHAR', false, 3, null);
        $this->addColumn('order_date', 'Order_date', 'DATE', false, null, null);
        $this->addColumn('item_status_id', 'ItemStatusId', 'CHAR', false, 3, null);
        $this->addColumn('site', 'Site', 'VARCHAR', false, 50, null);
        $this->addColumn('source', 'Source', 'INTEGER', false, 1, null);
        $this->addColumn('invoice', 'Invoice', 'VARCHAR', false, 20, null);
        $this->addColumn('price', 'Price', 'INTEGER', false, null, null);
        $this->addColumn('price_currency', 'Price_currency', 'VARCHAR', false, 10, null);
        $this->addColumn('invoice_date', 'Invoice_date', 'DATE', false, null, null);
        $this->addColumn('input_date', 'Input_date', 'TIMESTAMP', false, null, null);
        $this->addColumn('last_update', 'Last_update', 'TIMESTAMP', false, null, null);
        $this->addForeignKey('uid', 'Uid', 'INTEGER', 'user', 'user_id', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Biblio', '\\Slims\\Models\\Bibliography\\Biblio\\Biblio', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':biblio_id',
    1 => ':biblio_id',
  ),
), null, null, null, false);
        $this->addRelation('User', '\\Slims\\Models\\System\\User\\User', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':uid',
    1 => ':user_id',
  ),
), null, null, null, false);
        $this->addRelation('Colltype', '\\Slims\\Models\\Masterfile\\Colltype\\Colltype', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':coll_type_id',
    1 => ':coll_type_id',
  ),
), null, null, null, false);
    } // buildRelations()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('ItemId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('ItemId', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('ItemId', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('ItemId', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('ItemId', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('ItemId', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('ItemId', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? ItemTableMap::CLASS_DEFAULT : ItemTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (Item object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = ItemTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = ItemTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + ItemTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = ItemTableMap::OM_CLASS;
            /** @var Item $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            ItemTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = ItemTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = ItemTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Item $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                ItemTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(ItemTableMap::COL_ITEM_ID);
            $criteria->addSelectColumn(ItemTableMap::COL_ITEM_CODE);
            $criteria->addSelectColumn(ItemTableMap::COL_BIBLIO_ID);
            $criteria->addSelectColumn(ItemTableMap::COL_CALL_NUMBER);
            $criteria->addSelectColumn(ItemTableMap::COL_COLL_TYPE_ID);
            $criteria->addSelectColumn(ItemTableMap::COL_INVENTORY_CODE);
            $criteria->addSelectColumn(ItemTableMap::COL_RECEIVED_DATE);
            $criteria->addSelectColumn(ItemTableMap::COL_SUPPLIER_ID);
            $criteria->addSelectColumn(ItemTableMap::COL_ORDER_NO);
            $criteria->addSelectColumn(ItemTableMap::COL_LOCATION_ID);
            $criteria->addSelectColumn(ItemTableMap::COL_ORDER_DATE);
            $criteria->addSelectColumn(ItemTableMap::COL_ITEM_STATUS_ID);
            $criteria->addSelectColumn(ItemTableMap::COL_SITE);
            $criteria->addSelectColumn(ItemTableMap::COL_SOURCE);
            $criteria->addSelectColumn(ItemTableMap::COL_INVOICE);
            $criteria->addSelectColumn(ItemTableMap::COL_PRICE);
            $criteria->addSelectColumn(ItemTableMap::COL_PRICE_CURRENCY);
            $criteria->addSelectColumn(ItemTableMap::COL_INVOICE_DATE);
            $criteria->addSelectColumn(ItemTableMap::COL_INPUT_DATE);
            $criteria->addSelectColumn(ItemTableMap::COL_LAST_UPDATE);
            $criteria->addSelectColumn(ItemTableMap::COL_UID);
        } else {
            $criteria->addSelectColumn($alias . '.item_id');
            $criteria->addSelectColumn($alias . '.item_code');
            $criteria->addSelectColumn($alias . '.biblio_id');
            $criteria->addSelectColumn($alias . '.call_number');
            $criteria->addSelectColumn($alias . '.coll_type_id');
            $criteria->addSelectColumn($alias . '.inventory_code');
            $criteria->addSelectColumn($alias . '.received_date');
            $criteria->addSelectColumn($alias . '.supplier_id');
            $criteria->addSelectColumn($alias . '.order_no');
            $criteria->addSelectColumn($alias . '.location_id');
            $criteria->addSelectColumn($alias . '.order_date');
            $criteria->addSelectColumn($alias . '.item_status_id');
            $criteria->addSelectColumn($alias . '.site');
            $criteria->addSelectColumn($alias . '.source');
            $criteria->addSelectColumn($alias . '.invoice');
            $criteria->addSelectColumn($alias . '.price');
            $criteria->addSelectColumn($alias . '.price_currency');
            $criteria->addSelectColumn($alias . '.invoice_date');
            $criteria->addSelectColumn($alias . '.input_date');
            $criteria->addSelectColumn($alias . '.last_update');
            $criteria->addSelectColumn($alias . '.uid');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(ItemTableMap::DATABASE_NAME)->getTable(ItemTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(ItemTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(ItemTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new ItemTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Item or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Item object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ItemTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Slims\Models\Bibliography\Item\Item) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(ItemTableMap::DATABASE_NAME);
            $criteria->add(ItemTableMap::COL_ITEM_ID, (array) $values, Criteria::IN);
        }

        $query = ItemQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            ItemTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                ItemTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the item table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return ItemQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Item or Criteria object.
     *
     * @param mixed               $criteria Criteria or Item object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ItemTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Item object
        }

        if ($criteria->containsKey(ItemTableMap::COL_ITEM_ID) && $criteria->keyContainsValue(ItemTableMap::COL_ITEM_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.ItemTableMap::COL_ITEM_ID.')');
        }


        // Set the correct dbName
        $query = ItemQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // ItemTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
ItemTableMap::buildTableMap();
