<?php

namespace Slims\Models\Masterfile\Colltype\Base;

use \Exception;
use \PDO;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use Slims\Models\Bibliography\Item\Item;
use Slims\Models\Masterfile\Colltype\Colltype as ChildColltype;
use Slims\Models\Masterfile\Colltype\ColltypeQuery as ChildColltypeQuery;
use Slims\Models\Masterfile\Colltype\Map\ColltypeTableMap;

/**
 * Base class that represents a query for the 'mst_coll_type' table.
 *
 *
 *
 * @method     ChildColltypeQuery orderByCollTypeId($order = Criteria::ASC) Order by the coll_type_id column
 * @method     ChildColltypeQuery orderByColl_type_name($order = Criteria::ASC) Order by the coll_type_name column
 * @method     ChildColltypeQuery orderByInput_date($order = Criteria::ASC) Order by the input_date column
 * @method     ChildColltypeQuery orderByLast_update($order = Criteria::ASC) Order by the last_update column
 *
 * @method     ChildColltypeQuery groupByCollTypeId() Group by the coll_type_id column
 * @method     ChildColltypeQuery groupByColl_type_name() Group by the coll_type_name column
 * @method     ChildColltypeQuery groupByInput_date() Group by the input_date column
 * @method     ChildColltypeQuery groupByLast_update() Group by the last_update column
 *
 * @method     ChildColltypeQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildColltypeQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildColltypeQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildColltypeQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildColltypeQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildColltypeQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildColltypeQuery leftJoinItem($relationAlias = null) Adds a LEFT JOIN clause to the query using the Item relation
 * @method     ChildColltypeQuery rightJoinItem($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Item relation
 * @method     ChildColltypeQuery innerJoinItem($relationAlias = null) Adds a INNER JOIN clause to the query using the Item relation
 *
 * @method     ChildColltypeQuery joinWithItem($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Item relation
 *
 * @method     ChildColltypeQuery leftJoinWithItem() Adds a LEFT JOIN clause and with to the query using the Item relation
 * @method     ChildColltypeQuery rightJoinWithItem() Adds a RIGHT JOIN clause and with to the query using the Item relation
 * @method     ChildColltypeQuery innerJoinWithItem() Adds a INNER JOIN clause and with to the query using the Item relation
 *
 * @method     \Slims\Models\Bibliography\Item\ItemQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildColltype findOne(ConnectionInterface $con = null) Return the first ChildColltype matching the query
 * @method     ChildColltype findOneOrCreate(ConnectionInterface $con = null) Return the first ChildColltype matching the query, or a new ChildColltype object populated from the query conditions when no match is found
 *
 * @method     ChildColltype findOneByCollTypeId(int $coll_type_id) Return the first ChildColltype filtered by the coll_type_id column
 * @method     ChildColltype findOneByColl_type_name(string $coll_type_name) Return the first ChildColltype filtered by the coll_type_name column
 * @method     ChildColltype findOneByInput_date(string $input_date) Return the first ChildColltype filtered by the input_date column
 * @method     ChildColltype findOneByLast_update(string $last_update) Return the first ChildColltype filtered by the last_update column *

 * @method     ChildColltype requirePk($key, ConnectionInterface $con = null) Return the ChildColltype by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildColltype requireOne(ConnectionInterface $con = null) Return the first ChildColltype matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildColltype requireOneByCollTypeId(int $coll_type_id) Return the first ChildColltype filtered by the coll_type_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildColltype requireOneByColl_type_name(string $coll_type_name) Return the first ChildColltype filtered by the coll_type_name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildColltype requireOneByInput_date(string $input_date) Return the first ChildColltype filtered by the input_date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildColltype requireOneByLast_update(string $last_update) Return the first ChildColltype filtered by the last_update column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildColltype[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildColltype objects based on current ModelCriteria
 * @method     ChildColltype[]|ObjectCollection findByCollTypeId(int $coll_type_id) Return ChildColltype objects filtered by the coll_type_id column
 * @method     ChildColltype[]|ObjectCollection findByColl_type_name(string $coll_type_name) Return ChildColltype objects filtered by the coll_type_name column
 * @method     ChildColltype[]|ObjectCollection findByInput_date(string $input_date) Return ChildColltype objects filtered by the input_date column
 * @method     ChildColltype[]|ObjectCollection findByLast_update(string $last_update) Return ChildColltype objects filtered by the last_update column
 * @method     ChildColltype[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ColltypeQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Slims\Models\Masterfile\Colltype\Base\ColltypeQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'slims', $modelName = '\\Slims\\Models\\Masterfile\\Colltype\\Colltype', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildColltypeQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildColltypeQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildColltypeQuery) {
            return $criteria;
        }
        $query = new ChildColltypeQuery();
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
     * @return ChildColltype|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ColltypeTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = ColltypeTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildColltype A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT coll_type_id, coll_type_name, input_date, last_update FROM mst_coll_type WHERE coll_type_id = :p0';
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
            /** @var ChildColltype $obj */
            $obj = new ChildColltype();
            $obj->hydrate($row);
            ColltypeTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildColltype|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildColltypeQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ColltypeTableMap::COL_COLL_TYPE_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildColltypeQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ColltypeTableMap::COL_COLL_TYPE_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the coll_type_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCollTypeId(1234); // WHERE coll_type_id = 1234
     * $query->filterByCollTypeId(array(12, 34)); // WHERE coll_type_id IN (12, 34)
     * $query->filterByCollTypeId(array('min' => 12)); // WHERE coll_type_id > 12
     * </code>
     *
     * @param     mixed $collTypeId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildColltypeQuery The current query, for fluid interface
     */
    public function filterByCollTypeId($collTypeId = null, $comparison = null)
    {
        if (is_array($collTypeId)) {
            $useMinMax = false;
            if (isset($collTypeId['min'])) {
                $this->addUsingAlias(ColltypeTableMap::COL_COLL_TYPE_ID, $collTypeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($collTypeId['max'])) {
                $this->addUsingAlias(ColltypeTableMap::COL_COLL_TYPE_ID, $collTypeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ColltypeTableMap::COL_COLL_TYPE_ID, $collTypeId, $comparison);
    }

    /**
     * Filter the query on the coll_type_name column
     *
     * Example usage:
     * <code>
     * $query->filterByColl_type_name('fooValue');   // WHERE coll_type_name = 'fooValue'
     * $query->filterByColl_type_name('%fooValue%', Criteria::LIKE); // WHERE coll_type_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $coll_type_name The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildColltypeQuery The current query, for fluid interface
     */
    public function filterByColl_type_name($coll_type_name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($coll_type_name)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ColltypeTableMap::COL_COLL_TYPE_NAME, $coll_type_name, $comparison);
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
     * @return $this|ChildColltypeQuery The current query, for fluid interface
     */
    public function filterByInput_date($input_date = null, $comparison = null)
    {
        if (is_array($input_date)) {
            $useMinMax = false;
            if (isset($input_date['min'])) {
                $this->addUsingAlias(ColltypeTableMap::COL_INPUT_DATE, $input_date['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($input_date['max'])) {
                $this->addUsingAlias(ColltypeTableMap::COL_INPUT_DATE, $input_date['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ColltypeTableMap::COL_INPUT_DATE, $input_date, $comparison);
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
     * @return $this|ChildColltypeQuery The current query, for fluid interface
     */
    public function filterByLast_update($last_update = null, $comparison = null)
    {
        if (is_array($last_update)) {
            $useMinMax = false;
            if (isset($last_update['min'])) {
                $this->addUsingAlias(ColltypeTableMap::COL_LAST_UPDATE, $last_update['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($last_update['max'])) {
                $this->addUsingAlias(ColltypeTableMap::COL_LAST_UPDATE, $last_update['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ColltypeTableMap::COL_LAST_UPDATE, $last_update, $comparison);
    }

    /**
     * Filter the query by a related \Slims\Models\Bibliography\Item\Item object
     *
     * @param \Slims\Models\Bibliography\Item\Item|ObjectCollection $item the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildColltypeQuery The current query, for fluid interface
     */
    public function filterByItem($item, $comparison = null)
    {
        if ($item instanceof \Slims\Models\Bibliography\Item\Item) {
            return $this
                ->addUsingAlias(ColltypeTableMap::COL_COLL_TYPE_ID, $item->getColl_type_id(), $comparison);
        } elseif ($item instanceof ObjectCollection) {
            return $this
                ->useItemQuery()
                ->filterByPrimaryKeys($item->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByItem() only accepts arguments of type \Slims\Models\Bibliography\Item\Item or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Item relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildColltypeQuery The current query, for fluid interface
     */
    public function joinItem($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Item');

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
            $this->addJoinObject($join, 'Item');
        }

        return $this;
    }

    /**
     * Use the Item relation Item object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Slims\Models\Bibliography\Item\ItemQuery A secondary query class using the current class as primary query
     */
    public function useItemQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinItem($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Item', '\Slims\Models\Bibliography\Item\ItemQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildColltype $colltype Object to remove from the list of results
     *
     * @return $this|ChildColltypeQuery The current query, for fluid interface
     */
    public function prune($colltype = null)
    {
        if ($colltype) {
            $this->addUsingAlias(ColltypeTableMap::COL_COLL_TYPE_ID, $colltype->getCollTypeId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the mst_coll_type table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ColltypeTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ColltypeTableMap::clearInstancePool();
            ColltypeTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ColltypeTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ColltypeTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ColltypeTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ColltypeTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ColltypeQuery
