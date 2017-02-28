<?php

namespace Slims\Models\Masterfile\Place\Base;

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
use Slims\Models\Masterfile\Place\Place as ChildPlace;
use Slims\Models\Masterfile\Place\PlaceQuery as ChildPlaceQuery;
use Slims\Models\Masterfile\Place\Map\PlaceTableMap;

/**
 * Base class that represents a query for the 'mst_place' table.
 *
 *
 *
 * @method     ChildPlaceQuery orderByPlaceId($order = Criteria::ASC) Order by the place_id column
 * @method     ChildPlaceQuery orderByPlace_name($order = Criteria::ASC) Order by the place_name column
 *
 * @method     ChildPlaceQuery groupByPlaceId() Group by the place_id column
 * @method     ChildPlaceQuery groupByPlace_name() Group by the place_name column
 *
 * @method     ChildPlaceQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPlaceQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPlaceQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPlaceQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildPlaceQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildPlaceQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildPlaceQuery leftJoinBiblio($relationAlias = null) Adds a LEFT JOIN clause to the query using the Biblio relation
 * @method     ChildPlaceQuery rightJoinBiblio($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Biblio relation
 * @method     ChildPlaceQuery innerJoinBiblio($relationAlias = null) Adds a INNER JOIN clause to the query using the Biblio relation
 *
 * @method     ChildPlaceQuery joinWithBiblio($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Biblio relation
 *
 * @method     ChildPlaceQuery leftJoinWithBiblio() Adds a LEFT JOIN clause and with to the query using the Biblio relation
 * @method     ChildPlaceQuery rightJoinWithBiblio() Adds a RIGHT JOIN clause and with to the query using the Biblio relation
 * @method     ChildPlaceQuery innerJoinWithBiblio() Adds a INNER JOIN clause and with to the query using the Biblio relation
 *
 * @method     \Slims\Models\Bibliography\Biblio\BiblioQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildPlace findOne(ConnectionInterface $con = null) Return the first ChildPlace matching the query
 * @method     ChildPlace findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPlace matching the query, or a new ChildPlace object populated from the query conditions when no match is found
 *
 * @method     ChildPlace findOneByPlaceId(int $place_id) Return the first ChildPlace filtered by the place_id column
 * @method     ChildPlace findOneByPlace_name(string $place_name) Return the first ChildPlace filtered by the place_name column *

 * @method     ChildPlace requirePk($key, ConnectionInterface $con = null) Return the ChildPlace by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPlace requireOne(ConnectionInterface $con = null) Return the first ChildPlace matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPlace requireOneByPlaceId(int $place_id) Return the first ChildPlace filtered by the place_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPlace requireOneByPlace_name(string $place_name) Return the first ChildPlace filtered by the place_name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPlace[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPlace objects based on current ModelCriteria
 * @method     ChildPlace[]|ObjectCollection findByPlaceId(int $place_id) Return ChildPlace objects filtered by the place_id column
 * @method     ChildPlace[]|ObjectCollection findByPlace_name(string $place_name) Return ChildPlace objects filtered by the place_name column
 * @method     ChildPlace[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PlaceQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Slims\Models\Masterfile\Place\Base\PlaceQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'slims', $modelName = '\\Slims\\Models\\Masterfile\\Place\\Place', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPlaceQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPlaceQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPlaceQuery) {
            return $criteria;
        }
        $query = new ChildPlaceQuery();
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
     * @return ChildPlace|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PlaceTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = PlaceTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildPlace A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT place_id, place_name FROM mst_place WHERE place_id = :p0';
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
            /** @var ChildPlace $obj */
            $obj = new ChildPlace();
            $obj->hydrate($row);
            PlaceTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildPlace|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildPlaceQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PlaceTableMap::COL_PLACE_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPlaceQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PlaceTableMap::COL_PLACE_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the place_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPlaceId(1234); // WHERE place_id = 1234
     * $query->filterByPlaceId(array(12, 34)); // WHERE place_id IN (12, 34)
     * $query->filterByPlaceId(array('min' => 12)); // WHERE place_id > 12
     * </code>
     *
     * @param     mixed $placeId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPlaceQuery The current query, for fluid interface
     */
    public function filterByPlaceId($placeId = null, $comparison = null)
    {
        if (is_array($placeId)) {
            $useMinMax = false;
            if (isset($placeId['min'])) {
                $this->addUsingAlias(PlaceTableMap::COL_PLACE_ID, $placeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($placeId['max'])) {
                $this->addUsingAlias(PlaceTableMap::COL_PLACE_ID, $placeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PlaceTableMap::COL_PLACE_ID, $placeId, $comparison);
    }

    /**
     * Filter the query on the place_name column
     *
     * Example usage:
     * <code>
     * $query->filterByPlace_name('fooValue');   // WHERE place_name = 'fooValue'
     * $query->filterByPlace_name('%fooValue%', Criteria::LIKE); // WHERE place_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $place_name The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPlaceQuery The current query, for fluid interface
     */
    public function filterByPlace_name($place_name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($place_name)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PlaceTableMap::COL_PLACE_NAME, $place_name, $comparison);
    }

    /**
     * Filter the query by a related \Slims\Models\Bibliography\Biblio\Biblio object
     *
     * @param \Slims\Models\Bibliography\Biblio\Biblio|ObjectCollection $biblio the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPlaceQuery The current query, for fluid interface
     */
    public function filterByBiblio($biblio, $comparison = null)
    {
        if ($biblio instanceof \Slims\Models\Bibliography\Biblio\Biblio) {
            return $this
                ->addUsingAlias(PlaceTableMap::COL_PLACE_ID, $biblio->getPublishPlaceId(), $comparison);
        } elseif ($biblio instanceof ObjectCollection) {
            return $this
                ->useBiblioQuery()
                ->filterByPrimaryKeys($biblio->getPrimaryKeys())
                ->endUse();
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
     * @return $this|ChildPlaceQuery The current query, for fluid interface
     */
    public function joinBiblio($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
    public function useBiblioQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinBiblio($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Biblio', '\Slims\Models\Bibliography\Biblio\BiblioQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildPlace $place Object to remove from the list of results
     *
     * @return $this|ChildPlaceQuery The current query, for fluid interface
     */
    public function prune($place = null)
    {
        if ($place) {
            $this->addUsingAlias(PlaceTableMap::COL_PLACE_ID, $place->getPlaceId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the mst_place table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PlaceTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PlaceTableMap::clearInstancePool();
            PlaceTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PlaceTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PlaceTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PlaceTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PlaceTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // PlaceQuery
