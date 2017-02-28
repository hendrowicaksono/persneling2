<?php

namespace Slims\Models\Masterfile\Author\Base;

use \Exception;
use \PDO;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use Slims\Models\Masterfile\Author\Author as ChildAuthor;
use Slims\Models\Masterfile\Author\AuthorQuery as ChildAuthorQuery;
use Slims\Models\Masterfile\Author\Map\AuthorTableMap;
use Slims\Models\Masterfile\BiblioAuthor\BiblioAuthor;

/**
 * Base class that represents a query for the 'mst_author' table.
 *
 *
 *
 * @method     ChildAuthorQuery orderByAuthorId($order = Criteria::ASC) Order by the author_id column
 * @method     ChildAuthorQuery orderByAuthor_name($order = Criteria::ASC) Order by the author_name column
 *
 * @method     ChildAuthorQuery groupByAuthorId() Group by the author_id column
 * @method     ChildAuthorQuery groupByAuthor_name() Group by the author_name column
 *
 * @method     ChildAuthorQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildAuthorQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildAuthorQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildAuthorQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildAuthorQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildAuthorQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildAuthorQuery leftJoinBiblioAuthor($relationAlias = null) Adds a LEFT JOIN clause to the query using the BiblioAuthor relation
 * @method     ChildAuthorQuery rightJoinBiblioAuthor($relationAlias = null) Adds a RIGHT JOIN clause to the query using the BiblioAuthor relation
 * @method     ChildAuthorQuery innerJoinBiblioAuthor($relationAlias = null) Adds a INNER JOIN clause to the query using the BiblioAuthor relation
 *
 * @method     ChildAuthorQuery joinWithBiblioAuthor($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the BiblioAuthor relation
 *
 * @method     ChildAuthorQuery leftJoinWithBiblioAuthor() Adds a LEFT JOIN clause and with to the query using the BiblioAuthor relation
 * @method     ChildAuthorQuery rightJoinWithBiblioAuthor() Adds a RIGHT JOIN clause and with to the query using the BiblioAuthor relation
 * @method     ChildAuthorQuery innerJoinWithBiblioAuthor() Adds a INNER JOIN clause and with to the query using the BiblioAuthor relation
 *
 * @method     \Slims\Models\Masterfile\BiblioAuthor\BiblioAuthorQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildAuthor findOne(ConnectionInterface $con = null) Return the first ChildAuthor matching the query
 * @method     ChildAuthor findOneOrCreate(ConnectionInterface $con = null) Return the first ChildAuthor matching the query, or a new ChildAuthor object populated from the query conditions when no match is found
 *
 * @method     ChildAuthor findOneByAuthorId(int $author_id) Return the first ChildAuthor filtered by the author_id column
 * @method     ChildAuthor findOneByAuthor_name(string $author_name) Return the first ChildAuthor filtered by the author_name column *

 * @method     ChildAuthor requirePk($key, ConnectionInterface $con = null) Return the ChildAuthor by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAuthor requireOne(ConnectionInterface $con = null) Return the first ChildAuthor matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAuthor requireOneByAuthorId(int $author_id) Return the first ChildAuthor filtered by the author_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAuthor requireOneByAuthor_name(string $author_name) Return the first ChildAuthor filtered by the author_name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAuthor[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildAuthor objects based on current ModelCriteria
 * @method     ChildAuthor[]|ObjectCollection findByAuthorId(int $author_id) Return ChildAuthor objects filtered by the author_id column
 * @method     ChildAuthor[]|ObjectCollection findByAuthor_name(string $author_name) Return ChildAuthor objects filtered by the author_name column
 * @method     ChildAuthor[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class AuthorQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Slims\Models\Masterfile\Author\Base\AuthorQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'slims', $modelName = '\\Slims\\Models\\Masterfile\\Author\\Author', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildAuthorQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildAuthorQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildAuthorQuery) {
            return $criteria;
        }
        $query = new ChildAuthorQuery();
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
     * @return ChildAuthor|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(AuthorTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = AuthorTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildAuthor A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT author_id, author_name FROM mst_author WHERE author_id = :p0';
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
            /** @var ChildAuthor $obj */
            $obj = new ChildAuthor();
            $obj->hydrate($row);
            AuthorTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildAuthor|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildAuthorQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AuthorTableMap::COL_AUTHOR_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildAuthorQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AuthorTableMap::COL_AUTHOR_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the author_id column
     *
     * Example usage:
     * <code>
     * $query->filterByAuthorId(1234); // WHERE author_id = 1234
     * $query->filterByAuthorId(array(12, 34)); // WHERE author_id IN (12, 34)
     * $query->filterByAuthorId(array('min' => 12)); // WHERE author_id > 12
     * </code>
     *
     * @param     mixed $authorId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAuthorQuery The current query, for fluid interface
     */
    public function filterByAuthorId($authorId = null, $comparison = null)
    {
        if (is_array($authorId)) {
            $useMinMax = false;
            if (isset($authorId['min'])) {
                $this->addUsingAlias(AuthorTableMap::COL_AUTHOR_ID, $authorId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($authorId['max'])) {
                $this->addUsingAlias(AuthorTableMap::COL_AUTHOR_ID, $authorId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AuthorTableMap::COL_AUTHOR_ID, $authorId, $comparison);
    }

    /**
     * Filter the query on the author_name column
     *
     * Example usage:
     * <code>
     * $query->filterByAuthor_name('fooValue');   // WHERE author_name = 'fooValue'
     * $query->filterByAuthor_name('%fooValue%', Criteria::LIKE); // WHERE author_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $author_name The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAuthorQuery The current query, for fluid interface
     */
    public function filterByAuthor_name($author_name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($author_name)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AuthorTableMap::COL_AUTHOR_NAME, $author_name, $comparison);
    }

    /**
     * Filter the query by a related \Slims\Models\Masterfile\BiblioAuthor\BiblioAuthor object
     *
     * @param \Slims\Models\Masterfile\BiblioAuthor\BiblioAuthor|ObjectCollection $biblioAuthor the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAuthorQuery The current query, for fluid interface
     */
    public function filterByBiblioAuthor($biblioAuthor, $comparison = null)
    {
        if ($biblioAuthor instanceof \Slims\Models\Masterfile\BiblioAuthor\BiblioAuthor) {
            return $this
                ->addUsingAlias(AuthorTableMap::COL_AUTHOR_ID, $biblioAuthor->getAuthorId(), $comparison);
        } elseif ($biblioAuthor instanceof ObjectCollection) {
            return $this
                ->useBiblioAuthorQuery()
                ->filterByPrimaryKeys($biblioAuthor->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByBiblioAuthor() only accepts arguments of type \Slims\Models\Masterfile\BiblioAuthor\BiblioAuthor or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the BiblioAuthor relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildAuthorQuery The current query, for fluid interface
     */
    public function joinBiblioAuthor($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('BiblioAuthor');

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
            $this->addJoinObject($join, 'BiblioAuthor');
        }

        return $this;
    }

    /**
     * Use the BiblioAuthor relation BiblioAuthor object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Slims\Models\Masterfile\BiblioAuthor\BiblioAuthorQuery A secondary query class using the current class as primary query
     */
    public function useBiblioAuthorQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinBiblioAuthor($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'BiblioAuthor', '\Slims\Models\Masterfile\BiblioAuthor\BiblioAuthorQuery');
    }

    /**
     * Filter the query by a related Biblio object
     * using the biblio_author table as cross reference
     *
     * @param Biblio $biblio the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAuthorQuery The current query, for fluid interface
     */
    public function filterByBiblio($biblio, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useBiblioAuthorQuery()
            ->filterByBiblio($biblio, $comparison)
            ->endUse();
    }

    /**
     * Exclude object from result
     *
     * @param   ChildAuthor $author Object to remove from the list of results
     *
     * @return $this|ChildAuthorQuery The current query, for fluid interface
     */
    public function prune($author = null)
    {
        if ($author) {
            $this->addUsingAlias(AuthorTableMap::COL_AUTHOR_ID, $author->getAuthorId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the mst_author table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AuthorTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            AuthorTableMap::clearInstancePool();
            AuthorTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(AuthorTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(AuthorTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            AuthorTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            AuthorTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // AuthorQuery
