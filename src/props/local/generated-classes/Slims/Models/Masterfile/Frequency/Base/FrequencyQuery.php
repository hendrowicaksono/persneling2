<?php

namespace Slims\Models\Masterfile\Frequency\Base;

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
use Slims\Models\Masterfile\Frequency\Frequency as ChildFrequency;
use Slims\Models\Masterfile\Frequency\FrequencyQuery as ChildFrequencyQuery;
use Slims\Models\Masterfile\Frequency\Map\FrequencyTableMap;

/**
 * Base class that represents a query for the 'mst_frequency' table.
 *
 *
 *
 * @method     ChildFrequencyQuery orderByFrequencyId($order = Criteria::ASC) Order by the frequency_id column
 * @method     ChildFrequencyQuery orderByFrequency($order = Criteria::ASC) Order by the frequency column
 * @method     ChildFrequencyQuery orderByLanguage_prefix($order = Criteria::ASC) Order by the language_prefix column
 * @method     ChildFrequencyQuery orderByTime_increment($order = Criteria::ASC) Order by the time_increment column
 * @method     ChildFrequencyQuery orderByTime_unit($order = Criteria::ASC) Order by the time_unit column
 * @method     ChildFrequencyQuery orderByInput_date($order = Criteria::ASC) Order by the input_date column
 * @method     ChildFrequencyQuery orderByLast_update($order = Criteria::ASC) Order by the last_update column
 *
 * @method     ChildFrequencyQuery groupByFrequencyId() Group by the frequency_id column
 * @method     ChildFrequencyQuery groupByFrequency() Group by the frequency column
 * @method     ChildFrequencyQuery groupByLanguage_prefix() Group by the language_prefix column
 * @method     ChildFrequencyQuery groupByTime_increment() Group by the time_increment column
 * @method     ChildFrequencyQuery groupByTime_unit() Group by the time_unit column
 * @method     ChildFrequencyQuery groupByInput_date() Group by the input_date column
 * @method     ChildFrequencyQuery groupByLast_update() Group by the last_update column
 *
 * @method     ChildFrequencyQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildFrequencyQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildFrequencyQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildFrequencyQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildFrequencyQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildFrequencyQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildFrequencyQuery leftJoinBiblio($relationAlias = null) Adds a LEFT JOIN clause to the query using the Biblio relation
 * @method     ChildFrequencyQuery rightJoinBiblio($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Biblio relation
 * @method     ChildFrequencyQuery innerJoinBiblio($relationAlias = null) Adds a INNER JOIN clause to the query using the Biblio relation
 *
 * @method     ChildFrequencyQuery joinWithBiblio($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Biblio relation
 *
 * @method     ChildFrequencyQuery leftJoinWithBiblio() Adds a LEFT JOIN clause and with to the query using the Biblio relation
 * @method     ChildFrequencyQuery rightJoinWithBiblio() Adds a RIGHT JOIN clause and with to the query using the Biblio relation
 * @method     ChildFrequencyQuery innerJoinWithBiblio() Adds a INNER JOIN clause and with to the query using the Biblio relation
 *
 * @method     \Slims\Models\Bibliography\Biblio\BiblioQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildFrequency findOne(ConnectionInterface $con = null) Return the first ChildFrequency matching the query
 * @method     ChildFrequency findOneOrCreate(ConnectionInterface $con = null) Return the first ChildFrequency matching the query, or a new ChildFrequency object populated from the query conditions when no match is found
 *
 * @method     ChildFrequency findOneByFrequencyId(int $frequency_id) Return the first ChildFrequency filtered by the frequency_id column
 * @method     ChildFrequency findOneByFrequency(string $frequency) Return the first ChildFrequency filtered by the frequency column
 * @method     ChildFrequency findOneByLanguage_prefix(string $language_prefix) Return the first ChildFrequency filtered by the language_prefix column
 * @method     ChildFrequency findOneByTime_increment(int $time_increment) Return the first ChildFrequency filtered by the time_increment column
 * @method     ChildFrequency findOneByTime_unit(string $time_unit) Return the first ChildFrequency filtered by the time_unit column
 * @method     ChildFrequency findOneByInput_date(string $input_date) Return the first ChildFrequency filtered by the input_date column
 * @method     ChildFrequency findOneByLast_update(string $last_update) Return the first ChildFrequency filtered by the last_update column *

 * @method     ChildFrequency requirePk($key, ConnectionInterface $con = null) Return the ChildFrequency by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFrequency requireOne(ConnectionInterface $con = null) Return the first ChildFrequency matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildFrequency requireOneByFrequencyId(int $frequency_id) Return the first ChildFrequency filtered by the frequency_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFrequency requireOneByFrequency(string $frequency) Return the first ChildFrequency filtered by the frequency column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFrequency requireOneByLanguage_prefix(string $language_prefix) Return the first ChildFrequency filtered by the language_prefix column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFrequency requireOneByTime_increment(int $time_increment) Return the first ChildFrequency filtered by the time_increment column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFrequency requireOneByTime_unit(string $time_unit) Return the first ChildFrequency filtered by the time_unit column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFrequency requireOneByInput_date(string $input_date) Return the first ChildFrequency filtered by the input_date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFrequency requireOneByLast_update(string $last_update) Return the first ChildFrequency filtered by the last_update column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildFrequency[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildFrequency objects based on current ModelCriteria
 * @method     ChildFrequency[]|ObjectCollection findByFrequencyId(int $frequency_id) Return ChildFrequency objects filtered by the frequency_id column
 * @method     ChildFrequency[]|ObjectCollection findByFrequency(string $frequency) Return ChildFrequency objects filtered by the frequency column
 * @method     ChildFrequency[]|ObjectCollection findByLanguage_prefix(string $language_prefix) Return ChildFrequency objects filtered by the language_prefix column
 * @method     ChildFrequency[]|ObjectCollection findByTime_increment(int $time_increment) Return ChildFrequency objects filtered by the time_increment column
 * @method     ChildFrequency[]|ObjectCollection findByTime_unit(string $time_unit) Return ChildFrequency objects filtered by the time_unit column
 * @method     ChildFrequency[]|ObjectCollection findByInput_date(string $input_date) Return ChildFrequency objects filtered by the input_date column
 * @method     ChildFrequency[]|ObjectCollection findByLast_update(string $last_update) Return ChildFrequency objects filtered by the last_update column
 * @method     ChildFrequency[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class FrequencyQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Slims\Models\Masterfile\Frequency\Base\FrequencyQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'slims', $modelName = '\\Slims\\Models\\Masterfile\\Frequency\\Frequency', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildFrequencyQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildFrequencyQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildFrequencyQuery) {
            return $criteria;
        }
        $query = new ChildFrequencyQuery();
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
     * @return ChildFrequency|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(FrequencyTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = FrequencyTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildFrequency A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT frequency_id, frequency, language_prefix, time_increment, time_unit, input_date, last_update FROM mst_frequency WHERE frequency_id = :p0';
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
            /** @var ChildFrequency $obj */
            $obj = new ChildFrequency();
            $obj->hydrate($row);
            FrequencyTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildFrequency|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildFrequencyQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(FrequencyTableMap::COL_FREQUENCY_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildFrequencyQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(FrequencyTableMap::COL_FREQUENCY_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the frequency_id column
     *
     * Example usage:
     * <code>
     * $query->filterByFrequencyId(1234); // WHERE frequency_id = 1234
     * $query->filterByFrequencyId(array(12, 34)); // WHERE frequency_id IN (12, 34)
     * $query->filterByFrequencyId(array('min' => 12)); // WHERE frequency_id > 12
     * </code>
     *
     * @param     mixed $frequencyId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFrequencyQuery The current query, for fluid interface
     */
    public function filterByFrequencyId($frequencyId = null, $comparison = null)
    {
        if (is_array($frequencyId)) {
            $useMinMax = false;
            if (isset($frequencyId['min'])) {
                $this->addUsingAlias(FrequencyTableMap::COL_FREQUENCY_ID, $frequencyId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($frequencyId['max'])) {
                $this->addUsingAlias(FrequencyTableMap::COL_FREQUENCY_ID, $frequencyId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FrequencyTableMap::COL_FREQUENCY_ID, $frequencyId, $comparison);
    }

    /**
     * Filter the query on the frequency column
     *
     * Example usage:
     * <code>
     * $query->filterByFrequency('fooValue');   // WHERE frequency = 'fooValue'
     * $query->filterByFrequency('%fooValue%', Criteria::LIKE); // WHERE frequency LIKE '%fooValue%'
     * </code>
     *
     * @param     string $frequency The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFrequencyQuery The current query, for fluid interface
     */
    public function filterByFrequency($frequency = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($frequency)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FrequencyTableMap::COL_FREQUENCY, $frequency, $comparison);
    }

    /**
     * Filter the query on the language_prefix column
     *
     * Example usage:
     * <code>
     * $query->filterByLanguage_prefix('fooValue');   // WHERE language_prefix = 'fooValue'
     * $query->filterByLanguage_prefix('%fooValue%', Criteria::LIKE); // WHERE language_prefix LIKE '%fooValue%'
     * </code>
     *
     * @param     string $language_prefix The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFrequencyQuery The current query, for fluid interface
     */
    public function filterByLanguage_prefix($language_prefix = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($language_prefix)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FrequencyTableMap::COL_LANGUAGE_PREFIX, $language_prefix, $comparison);
    }

    /**
     * Filter the query on the time_increment column
     *
     * Example usage:
     * <code>
     * $query->filterByTime_increment(1234); // WHERE time_increment = 1234
     * $query->filterByTime_increment(array(12, 34)); // WHERE time_increment IN (12, 34)
     * $query->filterByTime_increment(array('min' => 12)); // WHERE time_increment > 12
     * </code>
     *
     * @param     mixed $time_increment The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFrequencyQuery The current query, for fluid interface
     */
    public function filterByTime_increment($time_increment = null, $comparison = null)
    {
        if (is_array($time_increment)) {
            $useMinMax = false;
            if (isset($time_increment['min'])) {
                $this->addUsingAlias(FrequencyTableMap::COL_TIME_INCREMENT, $time_increment['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($time_increment['max'])) {
                $this->addUsingAlias(FrequencyTableMap::COL_TIME_INCREMENT, $time_increment['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FrequencyTableMap::COL_TIME_INCREMENT, $time_increment, $comparison);
    }

    /**
     * Filter the query on the time_unit column
     *
     * Example usage:
     * <code>
     * $query->filterByTime_unit('fooValue');   // WHERE time_unit = 'fooValue'
     * $query->filterByTime_unit('%fooValue%', Criteria::LIKE); // WHERE time_unit LIKE '%fooValue%'
     * </code>
     *
     * @param     string $time_unit The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFrequencyQuery The current query, for fluid interface
     */
    public function filterByTime_unit($time_unit = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($time_unit)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FrequencyTableMap::COL_TIME_UNIT, $time_unit, $comparison);
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
     * @return $this|ChildFrequencyQuery The current query, for fluid interface
     */
    public function filterByInput_date($input_date = null, $comparison = null)
    {
        if (is_array($input_date)) {
            $useMinMax = false;
            if (isset($input_date['min'])) {
                $this->addUsingAlias(FrequencyTableMap::COL_INPUT_DATE, $input_date['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($input_date['max'])) {
                $this->addUsingAlias(FrequencyTableMap::COL_INPUT_DATE, $input_date['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FrequencyTableMap::COL_INPUT_DATE, $input_date, $comparison);
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
     * @return $this|ChildFrequencyQuery The current query, for fluid interface
     */
    public function filterByLast_update($last_update = null, $comparison = null)
    {
        if (is_array($last_update)) {
            $useMinMax = false;
            if (isset($last_update['min'])) {
                $this->addUsingAlias(FrequencyTableMap::COL_LAST_UPDATE, $last_update['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($last_update['max'])) {
                $this->addUsingAlias(FrequencyTableMap::COL_LAST_UPDATE, $last_update['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FrequencyTableMap::COL_LAST_UPDATE, $last_update, $comparison);
    }

    /**
     * Filter the query by a related \Slims\Models\Bibliography\Biblio\Biblio object
     *
     * @param \Slims\Models\Bibliography\Biblio\Biblio|ObjectCollection $biblio the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildFrequencyQuery The current query, for fluid interface
     */
    public function filterByBiblio($biblio, $comparison = null)
    {
        if ($biblio instanceof \Slims\Models\Bibliography\Biblio\Biblio) {
            return $this
                ->addUsingAlias(FrequencyTableMap::COL_FREQUENCY_ID, $biblio->getFrequencyId(), $comparison);
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
     * @return $this|ChildFrequencyQuery The current query, for fluid interface
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
     * @param   ChildFrequency $frequency Object to remove from the list of results
     *
     * @return $this|ChildFrequencyQuery The current query, for fluid interface
     */
    public function prune($frequency = null)
    {
        if ($frequency) {
            $this->addUsingAlias(FrequencyTableMap::COL_FREQUENCY_ID, $frequency->getFrequencyId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the mst_frequency table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(FrequencyTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            FrequencyTableMap::clearInstancePool();
            FrequencyTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(FrequencyTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(FrequencyTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            FrequencyTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            FrequencyTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // FrequencyQuery
