<?php

namespace Slims\Models\Bibliography\Item\Base;

use \Exception;
use \PDO;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use Slims\Models\Bibliography\Biblio\Biblio;
use Slims\Models\Bibliography\Item\Item as ChildItem;
use Slims\Models\Bibliography\Item\ItemQuery as ChildItemQuery;
use Slims\Models\Bibliography\Item\Map\ItemTableMap;
use Slims\Models\Masterfile\Colltype\Colltype;
use Slims\Models\System\User\User;

/**
 * Base class that represents a query for the 'item' table.
 *
 *
 *
 * @method     ChildItemQuery orderByItemId($order = Criteria::ASC) Order by the item_id column
 * @method     ChildItemQuery orderByItem_code($order = Criteria::ASC) Order by the item_code column
 * @method     ChildItemQuery orderByBiblioId($order = Criteria::ASC) Order by the biblio_id column
 * @method     ChildItemQuery orderByCall_number($order = Criteria::ASC) Order by the call_number column
 * @method     ChildItemQuery orderByColl_type_id($order = Criteria::ASC) Order by the coll_type_id column
 * @method     ChildItemQuery orderByInventory_code($order = Criteria::ASC) Order by the inventory_code column
 * @method     ChildItemQuery orderByReceived_date($order = Criteria::ASC) Order by the received_date column
 * @method     ChildItemQuery orderBySupplierId($order = Criteria::ASC) Order by the supplier_id column
 * @method     ChildItemQuery orderByOrder_no($order = Criteria::ASC) Order by the order_no column
 * @method     ChildItemQuery orderByLocationId($order = Criteria::ASC) Order by the location_id column
 * @method     ChildItemQuery orderByOrder_date($order = Criteria::ASC) Order by the order_date column
 * @method     ChildItemQuery orderByItemStatusId($order = Criteria::ASC) Order by the item_status_id column
 * @method     ChildItemQuery orderBySite($order = Criteria::ASC) Order by the site column
 * @method     ChildItemQuery orderBySource($order = Criteria::ASC) Order by the source column
 * @method     ChildItemQuery orderByInvoice($order = Criteria::ASC) Order by the invoice column
 * @method     ChildItemQuery orderByPrice($order = Criteria::ASC) Order by the price column
 * @method     ChildItemQuery orderByPrice_currency($order = Criteria::ASC) Order by the price_currency column
 * @method     ChildItemQuery orderByInvoice_date($order = Criteria::ASC) Order by the invoice_date column
 * @method     ChildItemQuery orderByInput_date($order = Criteria::ASC) Order by the input_date column
 * @method     ChildItemQuery orderByLast_update($order = Criteria::ASC) Order by the last_update column
 * @method     ChildItemQuery orderByUid($order = Criteria::ASC) Order by the uid column
 *
 * @method     ChildItemQuery groupByItemId() Group by the item_id column
 * @method     ChildItemQuery groupByItem_code() Group by the item_code column
 * @method     ChildItemQuery groupByBiblioId() Group by the biblio_id column
 * @method     ChildItemQuery groupByCall_number() Group by the call_number column
 * @method     ChildItemQuery groupByColl_type_id() Group by the coll_type_id column
 * @method     ChildItemQuery groupByInventory_code() Group by the inventory_code column
 * @method     ChildItemQuery groupByReceived_date() Group by the received_date column
 * @method     ChildItemQuery groupBySupplierId() Group by the supplier_id column
 * @method     ChildItemQuery groupByOrder_no() Group by the order_no column
 * @method     ChildItemQuery groupByLocationId() Group by the location_id column
 * @method     ChildItemQuery groupByOrder_date() Group by the order_date column
 * @method     ChildItemQuery groupByItemStatusId() Group by the item_status_id column
 * @method     ChildItemQuery groupBySite() Group by the site column
 * @method     ChildItemQuery groupBySource() Group by the source column
 * @method     ChildItemQuery groupByInvoice() Group by the invoice column
 * @method     ChildItemQuery groupByPrice() Group by the price column
 * @method     ChildItemQuery groupByPrice_currency() Group by the price_currency column
 * @method     ChildItemQuery groupByInvoice_date() Group by the invoice_date column
 * @method     ChildItemQuery groupByInput_date() Group by the input_date column
 * @method     ChildItemQuery groupByLast_update() Group by the last_update column
 * @method     ChildItemQuery groupByUid() Group by the uid column
 *
 * @method     ChildItemQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildItemQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildItemQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildItemQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildItemQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildItemQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildItemQuery leftJoinBiblio($relationAlias = null) Adds a LEFT JOIN clause to the query using the Biblio relation
 * @method     ChildItemQuery rightJoinBiblio($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Biblio relation
 * @method     ChildItemQuery innerJoinBiblio($relationAlias = null) Adds a INNER JOIN clause to the query using the Biblio relation
 *
 * @method     ChildItemQuery joinWithBiblio($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Biblio relation
 *
 * @method     ChildItemQuery leftJoinWithBiblio() Adds a LEFT JOIN clause and with to the query using the Biblio relation
 * @method     ChildItemQuery rightJoinWithBiblio() Adds a RIGHT JOIN clause and with to the query using the Biblio relation
 * @method     ChildItemQuery innerJoinWithBiblio() Adds a INNER JOIN clause and with to the query using the Biblio relation
 *
 * @method     ChildItemQuery leftJoinUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the User relation
 * @method     ChildItemQuery rightJoinUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the User relation
 * @method     ChildItemQuery innerJoinUser($relationAlias = null) Adds a INNER JOIN clause to the query using the User relation
 *
 * @method     ChildItemQuery joinWithUser($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the User relation
 *
 * @method     ChildItemQuery leftJoinWithUser() Adds a LEFT JOIN clause and with to the query using the User relation
 * @method     ChildItemQuery rightJoinWithUser() Adds a RIGHT JOIN clause and with to the query using the User relation
 * @method     ChildItemQuery innerJoinWithUser() Adds a INNER JOIN clause and with to the query using the User relation
 *
 * @method     ChildItemQuery leftJoinColltype($relationAlias = null) Adds a LEFT JOIN clause to the query using the Colltype relation
 * @method     ChildItemQuery rightJoinColltype($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Colltype relation
 * @method     ChildItemQuery innerJoinColltype($relationAlias = null) Adds a INNER JOIN clause to the query using the Colltype relation
 *
 * @method     ChildItemQuery joinWithColltype($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Colltype relation
 *
 * @method     ChildItemQuery leftJoinWithColltype() Adds a LEFT JOIN clause and with to the query using the Colltype relation
 * @method     ChildItemQuery rightJoinWithColltype() Adds a RIGHT JOIN clause and with to the query using the Colltype relation
 * @method     ChildItemQuery innerJoinWithColltype() Adds a INNER JOIN clause and with to the query using the Colltype relation
 *
 * @method     \Slims\Models\Bibliography\Biblio\BiblioQuery|\Slims\Models\System\User\UserQuery|\Slims\Models\Masterfile\Colltype\ColltypeQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildItem findOne(ConnectionInterface $con = null) Return the first ChildItem matching the query
 * @method     ChildItem findOneOrCreate(ConnectionInterface $con = null) Return the first ChildItem matching the query, or a new ChildItem object populated from the query conditions when no match is found
 *
 * @method     ChildItem findOneByItemId(int $item_id) Return the first ChildItem filtered by the item_id column
 * @method     ChildItem findOneByItem_code(string $item_code) Return the first ChildItem filtered by the item_code column
 * @method     ChildItem findOneByBiblioId(int $biblio_id) Return the first ChildItem filtered by the biblio_id column
 * @method     ChildItem findOneByCall_number(string $call_number) Return the first ChildItem filtered by the call_number column
 * @method     ChildItem findOneByColl_type_id(int $coll_type_id) Return the first ChildItem filtered by the coll_type_id column
 * @method     ChildItem findOneByInventory_code(string $inventory_code) Return the first ChildItem filtered by the inventory_code column
 * @method     ChildItem findOneByReceived_date(string $received_date) Return the first ChildItem filtered by the received_date column
 * @method     ChildItem findOneBySupplierId(int $supplier_id) Return the first ChildItem filtered by the supplier_id column
 * @method     ChildItem findOneByOrder_no(string $order_no) Return the first ChildItem filtered by the order_no column
 * @method     ChildItem findOneByLocationId(string $location_id) Return the first ChildItem filtered by the location_id column
 * @method     ChildItem findOneByOrder_date(string $order_date) Return the first ChildItem filtered by the order_date column
 * @method     ChildItem findOneByItemStatusId(string $item_status_id) Return the first ChildItem filtered by the item_status_id column
 * @method     ChildItem findOneBySite(string $site) Return the first ChildItem filtered by the site column
 * @method     ChildItem findOneBySource(int $source) Return the first ChildItem filtered by the source column
 * @method     ChildItem findOneByInvoice(string $invoice) Return the first ChildItem filtered by the invoice column
 * @method     ChildItem findOneByPrice(int $price) Return the first ChildItem filtered by the price column
 * @method     ChildItem findOneByPrice_currency(string $price_currency) Return the first ChildItem filtered by the price_currency column
 * @method     ChildItem findOneByInvoice_date(string $invoice_date) Return the first ChildItem filtered by the invoice_date column
 * @method     ChildItem findOneByInput_date(string $input_date) Return the first ChildItem filtered by the input_date column
 * @method     ChildItem findOneByLast_update(string $last_update) Return the first ChildItem filtered by the last_update column
 * @method     ChildItem findOneByUid(int $uid) Return the first ChildItem filtered by the uid column *

 * @method     ChildItem requirePk($key, ConnectionInterface $con = null) Return the ChildItem by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItem requireOne(ConnectionInterface $con = null) Return the first ChildItem matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildItem requireOneByItemId(int $item_id) Return the first ChildItem filtered by the item_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItem requireOneByItem_code(string $item_code) Return the first ChildItem filtered by the item_code column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItem requireOneByBiblioId(int $biblio_id) Return the first ChildItem filtered by the biblio_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItem requireOneByCall_number(string $call_number) Return the first ChildItem filtered by the call_number column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItem requireOneByColl_type_id(int $coll_type_id) Return the first ChildItem filtered by the coll_type_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItem requireOneByInventory_code(string $inventory_code) Return the first ChildItem filtered by the inventory_code column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItem requireOneByReceived_date(string $received_date) Return the first ChildItem filtered by the received_date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItem requireOneBySupplierId(int $supplier_id) Return the first ChildItem filtered by the supplier_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItem requireOneByOrder_no(string $order_no) Return the first ChildItem filtered by the order_no column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItem requireOneByLocationId(string $location_id) Return the first ChildItem filtered by the location_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItem requireOneByOrder_date(string $order_date) Return the first ChildItem filtered by the order_date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItem requireOneByItemStatusId(string $item_status_id) Return the first ChildItem filtered by the item_status_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItem requireOneBySite(string $site) Return the first ChildItem filtered by the site column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItem requireOneBySource(int $source) Return the first ChildItem filtered by the source column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItem requireOneByInvoice(string $invoice) Return the first ChildItem filtered by the invoice column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItem requireOneByPrice(int $price) Return the first ChildItem filtered by the price column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItem requireOneByPrice_currency(string $price_currency) Return the first ChildItem filtered by the price_currency column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItem requireOneByInvoice_date(string $invoice_date) Return the first ChildItem filtered by the invoice_date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItem requireOneByInput_date(string $input_date) Return the first ChildItem filtered by the input_date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItem requireOneByLast_update(string $last_update) Return the first ChildItem filtered by the last_update column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItem requireOneByUid(int $uid) Return the first ChildItem filtered by the uid column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildItem[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildItem objects based on current ModelCriteria
 * @method     ChildItem[]|ObjectCollection findByItemId(int $item_id) Return ChildItem objects filtered by the item_id column
 * @method     ChildItem[]|ObjectCollection findByItem_code(string $item_code) Return ChildItem objects filtered by the item_code column
 * @method     ChildItem[]|ObjectCollection findByBiblioId(int $biblio_id) Return ChildItem objects filtered by the biblio_id column
 * @method     ChildItem[]|ObjectCollection findByCall_number(string $call_number) Return ChildItem objects filtered by the call_number column
 * @method     ChildItem[]|ObjectCollection findByColl_type_id(int $coll_type_id) Return ChildItem objects filtered by the coll_type_id column
 * @method     ChildItem[]|ObjectCollection findByInventory_code(string $inventory_code) Return ChildItem objects filtered by the inventory_code column
 * @method     ChildItem[]|ObjectCollection findByReceived_date(string $received_date) Return ChildItem objects filtered by the received_date column
 * @method     ChildItem[]|ObjectCollection findBySupplierId(int $supplier_id) Return ChildItem objects filtered by the supplier_id column
 * @method     ChildItem[]|ObjectCollection findByOrder_no(string $order_no) Return ChildItem objects filtered by the order_no column
 * @method     ChildItem[]|ObjectCollection findByLocationId(string $location_id) Return ChildItem objects filtered by the location_id column
 * @method     ChildItem[]|ObjectCollection findByOrder_date(string $order_date) Return ChildItem objects filtered by the order_date column
 * @method     ChildItem[]|ObjectCollection findByItemStatusId(string $item_status_id) Return ChildItem objects filtered by the item_status_id column
 * @method     ChildItem[]|ObjectCollection findBySite(string $site) Return ChildItem objects filtered by the site column
 * @method     ChildItem[]|ObjectCollection findBySource(int $source) Return ChildItem objects filtered by the source column
 * @method     ChildItem[]|ObjectCollection findByInvoice(string $invoice) Return ChildItem objects filtered by the invoice column
 * @method     ChildItem[]|ObjectCollection findByPrice(int $price) Return ChildItem objects filtered by the price column
 * @method     ChildItem[]|ObjectCollection findByPrice_currency(string $price_currency) Return ChildItem objects filtered by the price_currency column
 * @method     ChildItem[]|ObjectCollection findByInvoice_date(string $invoice_date) Return ChildItem objects filtered by the invoice_date column
 * @method     ChildItem[]|ObjectCollection findByInput_date(string $input_date) Return ChildItem objects filtered by the input_date column
 * @method     ChildItem[]|ObjectCollection findByLast_update(string $last_update) Return ChildItem objects filtered by the last_update column
 * @method     ChildItem[]|ObjectCollection findByUid(int $uid) Return ChildItem objects filtered by the uid column
 * @method     ChildItem[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ItemQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Slims\Models\Bibliography\Item\Base\ItemQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'slims', $modelName = '\\Slims\\Models\\Bibliography\\Item\\Item', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildItemQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildItemQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildItemQuery) {
            return $criteria;
        }
        $query = new ChildItemQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildItem|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ItemTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = ItemTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
            // the object is already in the instance pool
            return $obj;
        }

        return $this->findPkSimple($key, $con);
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildItem A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT item_id, item_code, biblio_id, call_number, coll_type_id, inventory_code, received_date, supplier_id, order_no, location_id, order_date, item_status_id, site, source, invoice, price, price_currency, invoice_date, input_date, last_update, uid FROM item WHERE item_id = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildItem $obj */
            $obj = new ChildItem();
            $obj->hydrate($row);
            ItemTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildItem|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ItemTableMap::COL_ITEM_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ItemTableMap::COL_ITEM_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the item_id column
     *
     * Example usage:
     * <code>
     * $query->filterByItemId(1234); // WHERE item_id = 1234
     * $query->filterByItemId(array(12, 34)); // WHERE item_id IN (12, 34)
     * $query->filterByItemId(array('min' => 12)); // WHERE item_id > 12
     * </code>
     *
     * @param     mixed $itemId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterByItemId($itemId = null, $comparison = null)
    {
        if (is_array($itemId)) {
            $useMinMax = false;
            if (isset($itemId['min'])) {
                $this->addUsingAlias(ItemTableMap::COL_ITEM_ID, $itemId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($itemId['max'])) {
                $this->addUsingAlias(ItemTableMap::COL_ITEM_ID, $itemId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemTableMap::COL_ITEM_ID, $itemId, $comparison);
    }

    /**
     * Filter the query on the item_code column
     *
     * Example usage:
     * <code>
     * $query->filterByItem_code('fooValue');   // WHERE item_code = 'fooValue'
     * $query->filterByItem_code('%fooValue%', Criteria::LIKE); // WHERE item_code LIKE '%fooValue%'
     * </code>
     *
     * @param     string $item_code The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterByItem_code($item_code = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($item_code)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemTableMap::COL_ITEM_CODE, $item_code, $comparison);
    }

    /**
     * Filter the query on the biblio_id column
     *
     * Example usage:
     * <code>
     * $query->filterByBiblioId(1234); // WHERE biblio_id = 1234
     * $query->filterByBiblioId(array(12, 34)); // WHERE biblio_id IN (12, 34)
     * $query->filterByBiblioId(array('min' => 12)); // WHERE biblio_id > 12
     * </code>
     *
     * @see       filterByBiblio()
     *
     * @param     mixed $biblioId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterByBiblioId($biblioId = null, $comparison = null)
    {
        if (is_array($biblioId)) {
            $useMinMax = false;
            if (isset($biblioId['min'])) {
                $this->addUsingAlias(ItemTableMap::COL_BIBLIO_ID, $biblioId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($biblioId['max'])) {
                $this->addUsingAlias(ItemTableMap::COL_BIBLIO_ID, $biblioId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemTableMap::COL_BIBLIO_ID, $biblioId, $comparison);
    }

    /**
     * Filter the query on the call_number column
     *
     * Example usage:
     * <code>
     * $query->filterByCall_number('fooValue');   // WHERE call_number = 'fooValue'
     * $query->filterByCall_number('%fooValue%', Criteria::LIKE); // WHERE call_number LIKE '%fooValue%'
     * </code>
     *
     * @param     string $call_number The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterByCall_number($call_number = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($call_number)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemTableMap::COL_CALL_NUMBER, $call_number, $comparison);
    }

    /**
     * Filter the query on the coll_type_id column
     *
     * Example usage:
     * <code>
     * $query->filterByColl_type_id(1234); // WHERE coll_type_id = 1234
     * $query->filterByColl_type_id(array(12, 34)); // WHERE coll_type_id IN (12, 34)
     * $query->filterByColl_type_id(array('min' => 12)); // WHERE coll_type_id > 12
     * </code>
     *
     * @see       filterByColltype()
     *
     * @param     mixed $coll_type_id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterByColl_type_id($coll_type_id = null, $comparison = null)
    {
        if (is_array($coll_type_id)) {
            $useMinMax = false;
            if (isset($coll_type_id['min'])) {
                $this->addUsingAlias(ItemTableMap::COL_COLL_TYPE_ID, $coll_type_id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($coll_type_id['max'])) {
                $this->addUsingAlias(ItemTableMap::COL_COLL_TYPE_ID, $coll_type_id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemTableMap::COL_COLL_TYPE_ID, $coll_type_id, $comparison);
    }

    /**
     * Filter the query on the inventory_code column
     *
     * Example usage:
     * <code>
     * $query->filterByInventory_code('fooValue');   // WHERE inventory_code = 'fooValue'
     * $query->filterByInventory_code('%fooValue%', Criteria::LIKE); // WHERE inventory_code LIKE '%fooValue%'
     * </code>
     *
     * @param     string $inventory_code The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterByInventory_code($inventory_code = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($inventory_code)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemTableMap::COL_INVENTORY_CODE, $inventory_code, $comparison);
    }

    /**
     * Filter the query on the received_date column
     *
     * Example usage:
     * <code>
     * $query->filterByReceived_date('2011-03-14'); // WHERE received_date = '2011-03-14'
     * $query->filterByReceived_date('now'); // WHERE received_date = '2011-03-14'
     * $query->filterByReceived_date(array('max' => 'yesterday')); // WHERE received_date > '2011-03-13'
     * </code>
     *
     * @param     mixed $received_date The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterByReceived_date($received_date = null, $comparison = null)
    {
        if (is_array($received_date)) {
            $useMinMax = false;
            if (isset($received_date['min'])) {
                $this->addUsingAlias(ItemTableMap::COL_RECEIVED_DATE, $received_date['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($received_date['max'])) {
                $this->addUsingAlias(ItemTableMap::COL_RECEIVED_DATE, $received_date['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemTableMap::COL_RECEIVED_DATE, $received_date, $comparison);
    }

    /**
     * Filter the query on the supplier_id column
     *
     * Example usage:
     * <code>
     * $query->filterBySupplierId(1234); // WHERE supplier_id = 1234
     * $query->filterBySupplierId(array(12, 34)); // WHERE supplier_id IN (12, 34)
     * $query->filterBySupplierId(array('min' => 12)); // WHERE supplier_id > 12
     * </code>
     *
     * @param     mixed $supplierId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterBySupplierId($supplierId = null, $comparison = null)
    {
        if (is_array($supplierId)) {
            $useMinMax = false;
            if (isset($supplierId['min'])) {
                $this->addUsingAlias(ItemTableMap::COL_SUPPLIER_ID, $supplierId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($supplierId['max'])) {
                $this->addUsingAlias(ItemTableMap::COL_SUPPLIER_ID, $supplierId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemTableMap::COL_SUPPLIER_ID, $supplierId, $comparison);
    }

    /**
     * Filter the query on the order_no column
     *
     * Example usage:
     * <code>
     * $query->filterByOrder_no('fooValue');   // WHERE order_no = 'fooValue'
     * $query->filterByOrder_no('%fooValue%', Criteria::LIKE); // WHERE order_no LIKE '%fooValue%'
     * </code>
     *
     * @param     string $order_no The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterByOrder_no($order_no = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($order_no)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemTableMap::COL_ORDER_NO, $order_no, $comparison);
    }

    /**
     * Filter the query on the location_id column
     *
     * Example usage:
     * <code>
     * $query->filterByLocationId('fooValue');   // WHERE location_id = 'fooValue'
     * $query->filterByLocationId('%fooValue%', Criteria::LIKE); // WHERE location_id LIKE '%fooValue%'
     * </code>
     *
     * @param     string $locationId The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterByLocationId($locationId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($locationId)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemTableMap::COL_LOCATION_ID, $locationId, $comparison);
    }

    /**
     * Filter the query on the order_date column
     *
     * Example usage:
     * <code>
     * $query->filterByOrder_date('2011-03-14'); // WHERE order_date = '2011-03-14'
     * $query->filterByOrder_date('now'); // WHERE order_date = '2011-03-14'
     * $query->filterByOrder_date(array('max' => 'yesterday')); // WHERE order_date > '2011-03-13'
     * </code>
     *
     * @param     mixed $order_date The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterByOrder_date($order_date = null, $comparison = null)
    {
        if (is_array($order_date)) {
            $useMinMax = false;
            if (isset($order_date['min'])) {
                $this->addUsingAlias(ItemTableMap::COL_ORDER_DATE, $order_date['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($order_date['max'])) {
                $this->addUsingAlias(ItemTableMap::COL_ORDER_DATE, $order_date['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemTableMap::COL_ORDER_DATE, $order_date, $comparison);
    }

    /**
     * Filter the query on the item_status_id column
     *
     * Example usage:
     * <code>
     * $query->filterByItemStatusId('fooValue');   // WHERE item_status_id = 'fooValue'
     * $query->filterByItemStatusId('%fooValue%', Criteria::LIKE); // WHERE item_status_id LIKE '%fooValue%'
     * </code>
     *
     * @param     string $itemStatusId The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterByItemStatusId($itemStatusId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($itemStatusId)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemTableMap::COL_ITEM_STATUS_ID, $itemStatusId, $comparison);
    }

    /**
     * Filter the query on the site column
     *
     * Example usage:
     * <code>
     * $query->filterBySite('fooValue');   // WHERE site = 'fooValue'
     * $query->filterBySite('%fooValue%', Criteria::LIKE); // WHERE site LIKE '%fooValue%'
     * </code>
     *
     * @param     string $site The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterBySite($site = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($site)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemTableMap::COL_SITE, $site, $comparison);
    }

    /**
     * Filter the query on the source column
     *
     * Example usage:
     * <code>
     * $query->filterBySource(1234); // WHERE source = 1234
     * $query->filterBySource(array(12, 34)); // WHERE source IN (12, 34)
     * $query->filterBySource(array('min' => 12)); // WHERE source > 12
     * </code>
     *
     * @param     mixed $source The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterBySource($source = null, $comparison = null)
    {
        if (is_array($source)) {
            $useMinMax = false;
            if (isset($source['min'])) {
                $this->addUsingAlias(ItemTableMap::COL_SOURCE, $source['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($source['max'])) {
                $this->addUsingAlias(ItemTableMap::COL_SOURCE, $source['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemTableMap::COL_SOURCE, $source, $comparison);
    }

    /**
     * Filter the query on the invoice column
     *
     * Example usage:
     * <code>
     * $query->filterByInvoice('fooValue');   // WHERE invoice = 'fooValue'
     * $query->filterByInvoice('%fooValue%', Criteria::LIKE); // WHERE invoice LIKE '%fooValue%'
     * </code>
     *
     * @param     string $invoice The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterByInvoice($invoice = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($invoice)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemTableMap::COL_INVOICE, $invoice, $comparison);
    }

    /**
     * Filter the query on the price column
     *
     * Example usage:
     * <code>
     * $query->filterByPrice(1234); // WHERE price = 1234
     * $query->filterByPrice(array(12, 34)); // WHERE price IN (12, 34)
     * $query->filterByPrice(array('min' => 12)); // WHERE price > 12
     * </code>
     *
     * @param     mixed $price The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterByPrice($price = null, $comparison = null)
    {
        if (is_array($price)) {
            $useMinMax = false;
            if (isset($price['min'])) {
                $this->addUsingAlias(ItemTableMap::COL_PRICE, $price['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($price['max'])) {
                $this->addUsingAlias(ItemTableMap::COL_PRICE, $price['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemTableMap::COL_PRICE, $price, $comparison);
    }

    /**
     * Filter the query on the price_currency column
     *
     * Example usage:
     * <code>
     * $query->filterByPrice_currency('fooValue');   // WHERE price_currency = 'fooValue'
     * $query->filterByPrice_currency('%fooValue%', Criteria::LIKE); // WHERE price_currency LIKE '%fooValue%'
     * </code>
     *
     * @param     string $price_currency The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterByPrice_currency($price_currency = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($price_currency)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemTableMap::COL_PRICE_CURRENCY, $price_currency, $comparison);
    }

    /**
     * Filter the query on the invoice_date column
     *
     * Example usage:
     * <code>
     * $query->filterByInvoice_date('2011-03-14'); // WHERE invoice_date = '2011-03-14'
     * $query->filterByInvoice_date('now'); // WHERE invoice_date = '2011-03-14'
     * $query->filterByInvoice_date(array('max' => 'yesterday')); // WHERE invoice_date > '2011-03-13'
     * </code>
     *
     * @param     mixed $invoice_date The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterByInvoice_date($invoice_date = null, $comparison = null)
    {
        if (is_array($invoice_date)) {
            $useMinMax = false;
            if (isset($invoice_date['min'])) {
                $this->addUsingAlias(ItemTableMap::COL_INVOICE_DATE, $invoice_date['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($invoice_date['max'])) {
                $this->addUsingAlias(ItemTableMap::COL_INVOICE_DATE, $invoice_date['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemTableMap::COL_INVOICE_DATE, $invoice_date, $comparison);
    }

    /**
     * Filter the query on the input_date column
     *
     * Example usage:
     * <code>
     * $query->filterByInput_date('2011-03-14'); // WHERE input_date = '2011-03-14'
     * $query->filterByInput_date('now'); // WHERE input_date = '2011-03-14'
     * $query->filterByInput_date(array('max' => 'yesterday')); // WHERE input_date > '2011-03-13'
     * </code>
     *
     * @param     mixed $input_date The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterByInput_date($input_date = null, $comparison = null)
    {
        if (is_array($input_date)) {
            $useMinMax = false;
            if (isset($input_date['min'])) {
                $this->addUsingAlias(ItemTableMap::COL_INPUT_DATE, $input_date['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($input_date['max'])) {
                $this->addUsingAlias(ItemTableMap::COL_INPUT_DATE, $input_date['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemTableMap::COL_INPUT_DATE, $input_date, $comparison);
    }

    /**
     * Filter the query on the last_update column
     *
     * Example usage:
     * <code>
     * $query->filterByLast_update('2011-03-14'); // WHERE last_update = '2011-03-14'
     * $query->filterByLast_update('now'); // WHERE last_update = '2011-03-14'
     * $query->filterByLast_update(array('max' => 'yesterday')); // WHERE last_update > '2011-03-13'
     * </code>
     *
     * @param     mixed $last_update The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterByLast_update($last_update = null, $comparison = null)
    {
        if (is_array($last_update)) {
            $useMinMax = false;
            if (isset($last_update['min'])) {
                $this->addUsingAlias(ItemTableMap::COL_LAST_UPDATE, $last_update['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($last_update['max'])) {
                $this->addUsingAlias(ItemTableMap::COL_LAST_UPDATE, $last_update['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemTableMap::COL_LAST_UPDATE, $last_update, $comparison);
    }

    /**
     * Filter the query on the uid column
     *
     * Example usage:
     * <code>
     * $query->filterByUid(1234); // WHERE uid = 1234
     * $query->filterByUid(array(12, 34)); // WHERE uid IN (12, 34)
     * $query->filterByUid(array('min' => 12)); // WHERE uid > 12
     * </code>
     *
     * @see       filterByUser()
     *
     * @param     mixed $uid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterByUid($uid = null, $comparison = null)
    {
        if (is_array($uid)) {
            $useMinMax = false;
            if (isset($uid['min'])) {
                $this->addUsingAlias(ItemTableMap::COL_UID, $uid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($uid['max'])) {
                $this->addUsingAlias(ItemTableMap::COL_UID, $uid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemTableMap::COL_UID, $uid, $comparison);
    }

    /**
     * Filter the query by a related \Slims\Models\Bibliography\Biblio\Biblio object
     *
     * @param \Slims\Models\Bibliography\Biblio\Biblio|ObjectCollection $biblio The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildItemQuery The current query, for fluid interface
     */
    public function filterByBiblio($biblio, $comparison = null)
    {
        if ($biblio instanceof \Slims\Models\Bibliography\Biblio\Biblio) {
            return $this
                ->addUsingAlias(ItemTableMap::COL_BIBLIO_ID, $biblio->getBiblioId(), $comparison);
        } elseif ($biblio instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ItemTableMap::COL_BIBLIO_ID, $biblio->toKeyValue('PrimaryKey', 'BiblioId'), $comparison);
        } else {
            throw new PropelException('filterByBiblio() only accepts arguments of type \Slims\Models\Bibliography\Biblio\Biblio or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Biblio relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function joinBiblio($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Biblio');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Biblio');
        }

        return $this;
    }

    /**
     * Use the Biblio relation Biblio object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Slims\Models\Bibliography\Biblio\BiblioQuery A secondary query class using the current class as primary query
     */
    public function useBiblioQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinBiblio($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Biblio', '\Slims\Models\Bibliography\Biblio\BiblioQuery');
    }

    /**
     * Filter the query by a related \Slims\Models\System\User\User object
     *
     * @param \Slims\Models\System\User\User|ObjectCollection $user The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildItemQuery The current query, for fluid interface
     */
    public function filterByUser($user, $comparison = null)
    {
        if ($user instanceof \Slims\Models\System\User\User) {
            return $this
                ->addUsingAlias(ItemTableMap::COL_UID, $user->getUserId(), $comparison);
        } elseif ($user instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ItemTableMap::COL_UID, $user->toKeyValue('PrimaryKey', 'UserId'), $comparison);
        } else {
            throw new PropelException('filterByUser() only accepts arguments of type \Slims\Models\System\User\User or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the User relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function joinUser($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('User');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'User');
        }

        return $this;
    }

    /**
     * Use the User relation User object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Slims\Models\System\User\UserQuery A secondary query class using the current class as primary query
     */
    public function useUserQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinUser($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'User', '\Slims\Models\System\User\UserQuery');
    }

    /**
     * Filter the query by a related \Slims\Models\Masterfile\Colltype\Colltype object
     *
     * @param \Slims\Models\Masterfile\Colltype\Colltype|ObjectCollection $colltype The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildItemQuery The current query, for fluid interface
     */
    public function filterByColltype($colltype, $comparison = null)
    {
        if ($colltype instanceof \Slims\Models\Masterfile\Colltype\Colltype) {
            return $this
                ->addUsingAlias(ItemTableMap::COL_COLL_TYPE_ID, $colltype->getCollTypeId(), $comparison);
        } elseif ($colltype instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ItemTableMap::COL_COLL_TYPE_ID, $colltype->toKeyValue('PrimaryKey', 'CollTypeId'), $comparison);
        } else {
            throw new PropelException('filterByColltype() only accepts arguments of type \Slims\Models\Masterfile\Colltype\Colltype or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Colltype relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function joinColltype($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Colltype');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Colltype');
        }

        return $this;
    }

    /**
     * Use the Colltype relation Colltype object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Slims\Models\Masterfile\Colltype\ColltypeQuery A secondary query class using the current class as primary query
     */
    public function useColltypeQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinColltype($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Colltype', '\Slims\Models\Masterfile\Colltype\ColltypeQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildItem $item Object to remove from the list of results
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function prune($item = null)
    {
        if ($item) {
            $this->addUsingAlias(ItemTableMap::COL_ITEM_ID, $item->getItemId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the item table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ItemTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ItemTableMap::clearInstancePool();
            ItemTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ItemTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ItemTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ItemTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ItemTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ItemQuery
