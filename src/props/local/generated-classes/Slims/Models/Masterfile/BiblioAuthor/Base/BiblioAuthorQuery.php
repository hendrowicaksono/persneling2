<?php

namespace Slims\Models\Masterfile\BiblioAuthor\Base;

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
use Slims\Models\Masterfile\Author\Author;
use Slims\Models\Masterfile\BiblioAuthor\BiblioAuthor as ChildBiblioAuthor;
use Slims\Models\Masterfile\BiblioAuthor\BiblioAuthorQuery as ChildBiblioAuthorQuery;
use Slims\Models\Masterfile\BiblioAuthor\Map\BiblioAuthorTableMap;

/**
 * Base class that represents a query for the 'biblio_author' table.
 *
 *
 *
 * @method     ChildBiblioAuthorQuery orderByBiblioId($order = Criteria::ASC) Order by the biblio_id column
 * @method     ChildBiblioAuthorQuery orderByAuthorId($order = Criteria::ASC) Order by the author_id column
 *
 * @method     ChildBiblioAuthorQuery groupByBiblioId() Group by the biblio_id column
 * @method     ChildBiblioAuthorQuery groupByAuthorId() Group by the author_id column
 *
 * @method     ChildBiblioAuthorQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildBiblioAuthorQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildBiblioAuthorQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildBiblioAuthorQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildBiblioAuthorQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildBiblioAuthorQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildBiblioAuthorQuery leftJoinBiblio($relationAlias = null) Adds a LEFT JOIN clause to the query using the Biblio relation
 * @method     ChildBiblioAuthorQuery rightJoinBiblio($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Biblio relation
 * @method     ChildBiblioAuthorQuery innerJoinBiblio($relationAlias = null) Adds a INNER JOIN clause to the query using the Biblio relation
 *
 * @method     ChildBiblioAuthorQuery joinWithBiblio($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Biblio relation
 *
 * @method     ChildBiblioAuthorQuery leftJoinWithBiblio() Adds a LEFT JOIN clause and with to the query using the Biblio relation
 * @method     ChildBiblioAuthorQuery rightJoinWithBiblio() Adds a RIGHT JOIN clause and with to the query using the Biblio relation
 * @method     ChildBiblioAuthorQuery innerJoinWithBiblio() Adds a INNER JOIN clause and with to the query using the Biblio relation
 *
 * @method     ChildBiblioAuthorQuery leftJoinAuthor($relationAlias = null) Adds a LEFT JOIN clause to the query using the Author relation
 * @method     ChildBiblioAuthorQuery rightJoinAuthor($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Author relation
 * @method     ChildBiblioAuthorQuery innerJoinAuthor($relationAlias = null) Adds a INNER JOIN clause to the query using the Author relation
 *
 * @method     ChildBiblioAuthorQuery joinWithAuthor($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Author relation
 *
 * @method     ChildBiblioAuthorQuery leftJoinWithAuthor() Adds a LEFT JOIN clause and with to the query using the Author relation
 * @method     ChildBiblioAuthorQuery rightJoinWithAuthor() Adds a RIGHT JOIN clause and with to the query using the Author relation
 * @method     ChildBiblioAuthorQuery innerJoinWithAuthor() Adds a INNER JOIN clause and with to the query using the Author relation
 *
 * @method     \Slims\Models\Bibliography\Biblio\BiblioQuery|\Slims\Models\Masterfile\Author\AuthorQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildBiblioAuthor findOne(ConnectionInterface $con = null) Return the first ChildBiblioAuthor matching the query
 * @method     ChildBiblioAuthor findOneOrCreate(ConnectionInterface $con = null) Return the first ChildBiblioAuthor matching the query, or a new ChildBiblioAuthor object populated from the query conditions when no match is found
 *
 * @method     ChildBiblioAuthor findOneByBiblioId(int $biblio_id) Return the first ChildBiblioAuthor filtered by the biblio_id column
 * @method     ChildBiblioAuthor findOneByAuthorId(int $author_id) Return the first ChildBiblioAuthor filtered by the author_id column *

 * @method     ChildBiblioAuthor requirePk($key, ConnectionInterface $con = null) Return the ChildBiblioAuthor by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBiblioAuthor requireOne(ConnectionInterface $con = null) Return the first ChildBiblioAuthor matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildBiblioAuthor requireOneByBiblioId(int $biblio_id) Return the first ChildBiblioAuthor filtered by the biblio_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBiblioAuthor requireOneByAuthorId(int $author_id) Return the first ChildBiblioAuthor filtered by the author_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildBiblioAuthor[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildBiblioAuthor objects based on current ModelCriteria
 * @method     ChildBiblioAuthor[]|ObjectCollection findByBiblioId(int $biblio_id) Return ChildBiblioAuthor objects filtered by the biblio_id column
 * @method     ChildBiblioAuthor[]|ObjectCollection findByAuthorId(int $author_id) Return ChildBiblioAuthor objects filtered by the author_id column
 * @method     ChildBiblioAuthor[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class BiblioAuthorQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Slims\Models\Masterfile\BiblioAuthor\Base\BiblioAuthorQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'slims', $modelName = '\\Slims\\Models\\Masterfile\\BiblioAuthor\\BiblioAuthor', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildBiblioAuthorQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildBiblioAuthorQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildBiblioAuthorQuery) {
            return $criteria;
        }
        $query = new ChildBiblioAuthorQuery();
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
     * $obj = $c->findPk(array(12, 34), $con);
     * </code>
     *
     * @param array[$biblio_id, $author_id] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildBiblioAuthor|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(BiblioAuthorTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = BiblioAuthorTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]))))) {
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
     * @return ChildBiblioAuthor A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT biblio_id, author_id FROM biblio_author WHERE biblio_id = :p0 AND author_id = :p1';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildBiblioAuthor $obj */
            $obj = new ChildBiblioAuthor();
            $obj->hydrate($row);
            BiblioAuthorTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]));
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
     * @return ChildBiblioAuthor|array|mixed the result, formatted by the current formatter
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
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
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
     * @return $this|ChildBiblioAuthorQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(BiblioAuthorTableMap::COL_BIBLIO_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(BiblioAuthorTableMap::COL_AUTHOR_ID, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildBiblioAuthorQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(BiblioAuthorTableMap::COL_BIBLIO_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(BiblioAuthorTableMap::COL_AUTHOR_ID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
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
     * @return $this|ChildBiblioAuthorQuery The current query, for fluid interface
     */
    public function filterByBiblioId($biblioId = null, $comparison = null)
    {
        if (is_array($biblioId)) {
            $useMinMax = false;
            if (isset($biblioId['min'])) {
                $this->addUsingAlias(BiblioAuthorTableMap::COL_BIBLIO_ID, $biblioId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($biblioId['max'])) {
                $this->addUsingAlias(BiblioAuthorTableMap::COL_BIBLIO_ID, $biblioId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BiblioAuthorTableMap::COL_BIBLIO_ID, $biblioId, $comparison);
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
     * @see       filterByAuthor()
     *
     * @param     mixed $authorId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBiblioAuthorQuery The current query, for fluid interface
     */
    public function filterByAuthorId($authorId = null, $comparison = null)
    {
        if (is_array($authorId)) {
            $useMinMax = false;
            if (isset($authorId['min'])) {
                $this->addUsingAlias(BiblioAuthorTableMap::COL_AUTHOR_ID, $authorId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($authorId['max'])) {
                $this->addUsingAlias(BiblioAuthorTableMap::COL_AUTHOR_ID, $authorId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BiblioAuthorTableMap::COL_AUTHOR_ID, $authorId, $comparison);
    }

    /**
     * Filter the query by a related \Slims\Models\Bibliography\Biblio\Biblio object
     *
     * @param \Slims\Models\Bibliography\Biblio\Biblio|ObjectCollection $biblio The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildBiblioAuthorQuery The current query, for fluid interface
     */
    public function filterByBiblio($biblio, $comparison = null)
    {
        if ($biblio instanceof \Slims\Models\Bibliography\Biblio\Biblio) {
            return $this
                ->addUsingAlias(BiblioAuthorTableMap::COL_BIBLIO_ID, $biblio->getBiblioId(), $comparison);
        } elseif ($biblio instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(BiblioAuthorTableMap::COL_BIBLIO_ID, $biblio->toKeyValue('PrimaryKey', 'BiblioId'), $comparison);
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
     * @return $this|ChildBiblioAuthorQuery The current query, for fluid interface
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
     * Filter the query by a related \Slims\Models\Masterfile\Author\Author object
     *
     * @param \Slims\Models\Masterfile\Author\Author|ObjectCollection $author The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildBiblioAuthorQuery The current query, for fluid interface
     */
    public function filterByAuthor($author, $comparison = null)
    {
        if ($author instanceof \Slims\Models\Masterfile\Author\Author) {
            return $this
                ->addUsingAlias(BiblioAuthorTableMap::COL_AUTHOR_ID, $author->getAuthorId(), $comparison);
        } elseif ($author instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(BiblioAuthorTableMap::COL_AUTHOR_ID, $author->toKeyValue('PrimaryKey', 'AuthorId'), $comparison);
        } else {
            throw new PropelException('filterByAuthor() only accepts arguments of type \Slims\Models\Masterfile\Author\Author or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Author relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildBiblioAuthorQuery The current query, for fluid interface
     */
    public function joinAuthor($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Author');

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
            $this->addJoinObject($join, 'Author');
        }

        return $this;
    }

    /**
     * Use the Author relation Author object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Slims\Models\Masterfile\Author\AuthorQuery A secondary query class using the current class as primary query
     */
    public function useAuthorQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAuthor($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Author', '\Slims\Models\Masterfile\Author\AuthorQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildBiblioAuthor $biblioAuthor Object to remove from the list of results
     *
     * @return $this|ChildBiblioAuthorQuery The current query, for fluid interface
     */
    public function prune($biblioAuthor = null)
    {
        if ($biblioAuthor) {
            $this->addCond('pruneCond0', $this->getAliasedColName(BiblioAuthorTableMap::COL_BIBLIO_ID), $biblioAuthor->getBiblioId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(BiblioAuthorTableMap::COL_AUTHOR_ID), $biblioAuthor->getAuthorId(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the biblio_author table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(BiblioAuthorTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            BiblioAuthorTableMap::clearInstancePool();
            BiblioAuthorTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(BiblioAuthorTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(BiblioAuthorTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            BiblioAuthorTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            BiblioAuthorTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // BiblioAuthorQuery
