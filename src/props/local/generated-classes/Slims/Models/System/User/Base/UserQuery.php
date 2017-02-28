<?php

namespace Slims\Models\System\User\Base;

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
use Slims\Models\Bibliography\Item\Item;
use Slims\Models\System\User\User as ChildUser;
use Slims\Models\System\User\UserQuery as ChildUserQuery;
use Slims\Models\System\User\Map\UserTableMap;

/**
 * Base class that represents a query for the 'user' table.
 *
 *
 *
 * @method     ChildUserQuery orderByUserId($order = Criteria::ASC) Order by the user_id column
 * @method     ChildUserQuery orderByUsername($order = Criteria::ASC) Order by the username column
 * @method     ChildUserQuery orderByRealname($order = Criteria::ASC) Order by the realname column
 * @method     ChildUserQuery orderByPassword($order = Criteria::ASC) Order by the password column
 * @method     ChildUserQuery orderByEmail($order = Criteria::ASC) Order by the email column
 * @method     ChildUserQuery orderByUser_type($order = Criteria::ASC) Order by the user_type column
 * @method     ChildUserQuery orderByUser_image($order = Criteria::ASC) Order by the user_image column
 * @method     ChildUserQuery orderBySocial_media($order = Criteria::ASC) Order by the social_media column
 * @method     ChildUserQuery orderByLast_login($order = Criteria::ASC) Order by the last_login column
 * @method     ChildUserQuery orderByLast_login_ip($order = Criteria::ASC) Order by the last_login_ip column
 * @method     ChildUserQuery orderByGroups($order = Criteria::ASC) Order by the groups column
 * @method     ChildUserQuery orderByApi_key($order = Criteria::ASC) Order by the api_key column
 * @method     ChildUserQuery orderByInput_date($order = Criteria::ASC) Order by the input_date column
 * @method     ChildUserQuery orderByLast_update($order = Criteria::ASC) Order by the last_update column
 *
 * @method     ChildUserQuery groupByUserId() Group by the user_id column
 * @method     ChildUserQuery groupByUsername() Group by the username column
 * @method     ChildUserQuery groupByRealname() Group by the realname column
 * @method     ChildUserQuery groupByPassword() Group by the password column
 * @method     ChildUserQuery groupByEmail() Group by the email column
 * @method     ChildUserQuery groupByUser_type() Group by the user_type column
 * @method     ChildUserQuery groupByUser_image() Group by the user_image column
 * @method     ChildUserQuery groupBySocial_media() Group by the social_media column
 * @method     ChildUserQuery groupByLast_login() Group by the last_login column
 * @method     ChildUserQuery groupByLast_login_ip() Group by the last_login_ip column
 * @method     ChildUserQuery groupByGroups() Group by the groups column
 * @method     ChildUserQuery groupByApi_key() Group by the api_key column
 * @method     ChildUserQuery groupByInput_date() Group by the input_date column
 * @method     ChildUserQuery groupByLast_update() Group by the last_update column
 *
 * @method     ChildUserQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildUserQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildUserQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildUserQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildUserQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildUserQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildUserQuery leftJoinBiblio($relationAlias = null) Adds a LEFT JOIN clause to the query using the Biblio relation
 * @method     ChildUserQuery rightJoinBiblio($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Biblio relation
 * @method     ChildUserQuery innerJoinBiblio($relationAlias = null) Adds a INNER JOIN clause to the query using the Biblio relation
 *
 * @method     ChildUserQuery joinWithBiblio($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Biblio relation
 *
 * @method     ChildUserQuery leftJoinWithBiblio() Adds a LEFT JOIN clause and with to the query using the Biblio relation
 * @method     ChildUserQuery rightJoinWithBiblio() Adds a RIGHT JOIN clause and with to the query using the Biblio relation
 * @method     ChildUserQuery innerJoinWithBiblio() Adds a INNER JOIN clause and with to the query using the Biblio relation
 *
 * @method     ChildUserQuery leftJoinItem($relationAlias = null) Adds a LEFT JOIN clause to the query using the Item relation
 * @method     ChildUserQuery rightJoinItem($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Item relation
 * @method     ChildUserQuery innerJoinItem($relationAlias = null) Adds a INNER JOIN clause to the query using the Item relation
 *
 * @method     ChildUserQuery joinWithItem($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Item relation
 *
 * @method     ChildUserQuery leftJoinWithItem() Adds a LEFT JOIN clause and with to the query using the Item relation
 * @method     ChildUserQuery rightJoinWithItem() Adds a RIGHT JOIN clause and with to the query using the Item relation
 * @method     ChildUserQuery innerJoinWithItem() Adds a INNER JOIN clause and with to the query using the Item relation
 *
 * @method     \Slims\Models\Bibliography\Biblio\BiblioQuery|\Slims\Models\Bibliography\Item\ItemQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildUser findOne(ConnectionInterface $con = null) Return the first ChildUser matching the query
 * @method     ChildUser findOneOrCreate(ConnectionInterface $con = null) Return the first ChildUser matching the query, or a new ChildUser object populated from the query conditions when no match is found
 *
 * @method     ChildUser findOneByUserId(int $user_id) Return the first ChildUser filtered by the user_id column
 * @method     ChildUser findOneByUsername(string $username) Return the first ChildUser filtered by the username column
 * @method     ChildUser findOneByRealname(string $realname) Return the first ChildUser filtered by the realname column
 * @method     ChildUser findOneByPassword(string $password) Return the first ChildUser filtered by the password column
 * @method     ChildUser findOneByEmail(string $email) Return the first ChildUser filtered by the email column
 * @method     ChildUser findOneByUser_type(int $user_type) Return the first ChildUser filtered by the user_type column
 * @method     ChildUser findOneByUser_image(string $user_image) Return the first ChildUser filtered by the user_image column
 * @method     ChildUser findOneBySocial_media(string $social_media) Return the first ChildUser filtered by the social_media column
 * @method     ChildUser findOneByLast_login(string $last_login) Return the first ChildUser filtered by the last_login column
 * @method     ChildUser findOneByLast_login_ip(string $last_login_ip) Return the first ChildUser filtered by the last_login_ip column
 * @method     ChildUser findOneByGroups(string $groups) Return the first ChildUser filtered by the groups column
 * @method     ChildUser findOneByApi_key(string $api_key) Return the first ChildUser filtered by the api_key column
 * @method     ChildUser findOneByInput_date(string $input_date) Return the first ChildUser filtered by the input_date column
 * @method     ChildUser findOneByLast_update(string $last_update) Return the first ChildUser filtered by the last_update column *

 * @method     ChildUser requirePk($key, ConnectionInterface $con = null) Return the ChildUser by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOne(ConnectionInterface $con = null) Return the first ChildUser matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildUser requireOneByUserId(int $user_id) Return the first ChildUser filtered by the user_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByUsername(string $username) Return the first ChildUser filtered by the username column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByRealname(string $realname) Return the first ChildUser filtered by the realname column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByPassword(string $password) Return the first ChildUser filtered by the password column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByEmail(string $email) Return the first ChildUser filtered by the email column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByUser_type(int $user_type) Return the first ChildUser filtered by the user_type column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByUser_image(string $user_image) Return the first ChildUser filtered by the user_image column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneBySocial_media(string $social_media) Return the first ChildUser filtered by the social_media column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByLast_login(string $last_login) Return the first ChildUser filtered by the last_login column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByLast_login_ip(string $last_login_ip) Return the first ChildUser filtered by the last_login_ip column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByGroups(string $groups) Return the first ChildUser filtered by the groups column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByApi_key(string $api_key) Return the first ChildUser filtered by the api_key column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByInput_date(string $input_date) Return the first ChildUser filtered by the input_date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByLast_update(string $last_update) Return the first ChildUser filtered by the last_update column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildUser[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildUser objects based on current ModelCriteria
 * @method     ChildUser[]|ObjectCollection findByUserId(int $user_id) Return ChildUser objects filtered by the user_id column
 * @method     ChildUser[]|ObjectCollection findByUsername(string $username) Return ChildUser objects filtered by the username column
 * @method     ChildUser[]|ObjectCollection findByRealname(string $realname) Return ChildUser objects filtered by the realname column
 * @method     ChildUser[]|ObjectCollection findByPassword(string $password) Return ChildUser objects filtered by the password column
 * @method     ChildUser[]|ObjectCollection findByEmail(string $email) Return ChildUser objects filtered by the email column
 * @method     ChildUser[]|ObjectCollection findByUser_type(int $user_type) Return ChildUser objects filtered by the user_type column
 * @method     ChildUser[]|ObjectCollection findByUser_image(string $user_image) Return ChildUser objects filtered by the user_image column
 * @method     ChildUser[]|ObjectCollection findBySocial_media(string $social_media) Return ChildUser objects filtered by the social_media column
 * @method     ChildUser[]|ObjectCollection findByLast_login(string $last_login) Return ChildUser objects filtered by the last_login column
 * @method     ChildUser[]|ObjectCollection findByLast_login_ip(string $last_login_ip) Return ChildUser objects filtered by the last_login_ip column
 * @method     ChildUser[]|ObjectCollection findByGroups(string $groups) Return ChildUser objects filtered by the groups column
 * @method     ChildUser[]|ObjectCollection findByApi_key(string $api_key) Return ChildUser objects filtered by the api_key column
 * @method     ChildUser[]|ObjectCollection findByInput_date(string $input_date) Return ChildUser objects filtered by the input_date column
 * @method     ChildUser[]|ObjectCollection findByLast_update(string $last_update) Return ChildUser objects filtered by the last_update column
 * @method     ChildUser[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class UserQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Slims\Models\System\User\Base\UserQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'slims', $modelName = '\\Slims\\Models\\System\\User\\User', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildUserQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildUserQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildUserQuery) {
            return $criteria;
        }
        $query = new ChildUserQuery();
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
     * @return ChildUser|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(UserTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = UserTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildUser A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT user_id, username, realname, password, email, user_type, user_image, social_media, last_login, last_login_ip, groups, api_key, input_date, last_update FROM user WHERE user_id = :p0';
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
            /** @var ChildUser $obj */
            $obj = new ChildUser();
            $obj->hydrate($row);
            UserTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildUser|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(UserTableMap::COL_USER_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(UserTableMap::COL_USER_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the user_id column
     *
     * Example usage:
     * <code>
     * $query->filterByUserId(1234); // WHERE user_id = 1234
     * $query->filterByUserId(array(12, 34)); // WHERE user_id IN (12, 34)
     * $query->filterByUserId(array('min' => 12)); // WHERE user_id > 12
     * </code>
     *
     * @param     mixed $userId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByUserId($userId = null, $comparison = null)
    {
        if (is_array($userId)) {
            $useMinMax = false;
            if (isset($userId['min'])) {
                $this->addUsingAlias(UserTableMap::COL_USER_ID, $userId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userId['max'])) {
                $this->addUsingAlias(UserTableMap::COL_USER_ID, $userId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_USER_ID, $userId, $comparison);
    }

    /**
     * Filter the query on the username column
     *
     * Example usage:
     * <code>
     * $query->filterByUsername('fooValue');   // WHERE username = 'fooValue'
     * $query->filterByUsername('%fooValue%', Criteria::LIKE); // WHERE username LIKE '%fooValue%'
     * </code>
     *
     * @param     string $username The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByUsername($username = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($username)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_USERNAME, $username, $comparison);
    }

    /**
     * Filter the query on the realname column
     *
     * Example usage:
     * <code>
     * $query->filterByRealname('fooValue');   // WHERE realname = 'fooValue'
     * $query->filterByRealname('%fooValue%', Criteria::LIKE); // WHERE realname LIKE '%fooValue%'
     * </code>
     *
     * @param     string $realname The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByRealname($realname = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($realname)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_REALNAME, $realname, $comparison);
    }

    /**
     * Filter the query on the password column
     *
     * Example usage:
     * <code>
     * $query->filterByPassword('fooValue');   // WHERE password = 'fooValue'
     * $query->filterByPassword('%fooValue%', Criteria::LIKE); // WHERE password LIKE '%fooValue%'
     * </code>
     *
     * @param     string $password The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByPassword($password = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($password)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_PASSWORD, $password, $comparison);
    }

    /**
     * Filter the query on the email column
     *
     * Example usage:
     * <code>
     * $query->filterByEmail('fooValue');   // WHERE email = 'fooValue'
     * $query->filterByEmail('%fooValue%', Criteria::LIKE); // WHERE email LIKE '%fooValue%'
     * </code>
     *
     * @param     string $email The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByEmail($email = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($email)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_EMAIL, $email, $comparison);
    }

    /**
     * Filter the query on the user_type column
     *
     * Example usage:
     * <code>
     * $query->filterByUser_type(1234); // WHERE user_type = 1234
     * $query->filterByUser_type(array(12, 34)); // WHERE user_type IN (12, 34)
     * $query->filterByUser_type(array('min' => 12)); // WHERE user_type > 12
     * </code>
     *
     * @param     mixed $user_type The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByUser_type($user_type = null, $comparison = null)
    {
        if (is_array($user_type)) {
            $useMinMax = false;
            if (isset($user_type['min'])) {
                $this->addUsingAlias(UserTableMap::COL_USER_TYPE, $user_type['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($user_type['max'])) {
                $this->addUsingAlias(UserTableMap::COL_USER_TYPE, $user_type['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_USER_TYPE, $user_type, $comparison);
    }

    /**
     * Filter the query on the user_image column
     *
     * Example usage:
     * <code>
     * $query->filterByUser_image('fooValue');   // WHERE user_image = 'fooValue'
     * $query->filterByUser_image('%fooValue%', Criteria::LIKE); // WHERE user_image LIKE '%fooValue%'
     * </code>
     *
     * @param     string $user_image The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByUser_image($user_image = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($user_image)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_USER_IMAGE, $user_image, $comparison);
    }

    /**
     * Filter the query on the social_media column
     *
     * Example usage:
     * <code>
     * $query->filterBySocial_media('fooValue');   // WHERE social_media = 'fooValue'
     * $query->filterBySocial_media('%fooValue%', Criteria::LIKE); // WHERE social_media LIKE '%fooValue%'
     * </code>
     *
     * @param     string $social_media The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterBySocial_media($social_media = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($social_media)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_SOCIAL_MEDIA, $social_media, $comparison);
    }

    /**
     * Filter the query on the last_login column
     *
     * Example usage:
     * <code>
     * $query->filterByLast_login('2011-03-14'); // WHERE last_login = '2011-03-14'
     * $query->filterByLast_login('now'); // WHERE last_login = '2011-03-14'
     * $query->filterByLast_login(array('max' => 'yesterday')); // WHERE last_login > '2011-03-13'
     * </code>
     *
     * @param     mixed $last_login The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByLast_login($last_login = null, $comparison = null)
    {
        if (is_array($last_login)) {
            $useMinMax = false;
            if (isset($last_login['min'])) {
                $this->addUsingAlias(UserTableMap::COL_LAST_LOGIN, $last_login['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($last_login['max'])) {
                $this->addUsingAlias(UserTableMap::COL_LAST_LOGIN, $last_login['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_LAST_LOGIN, $last_login, $comparison);
    }

    /**
     * Filter the query on the last_login_ip column
     *
     * Example usage:
     * <code>
     * $query->filterByLast_login_ip('fooValue');   // WHERE last_login_ip = 'fooValue'
     * $query->filterByLast_login_ip('%fooValue%', Criteria::LIKE); // WHERE last_login_ip LIKE '%fooValue%'
     * </code>
     *
     * @param     string $last_login_ip The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByLast_login_ip($last_login_ip = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($last_login_ip)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_LAST_LOGIN_IP, $last_login_ip, $comparison);
    }

    /**
     * Filter the query on the groups column
     *
     * Example usage:
     * <code>
     * $query->filterByGroups('fooValue');   // WHERE groups = 'fooValue'
     * $query->filterByGroups('%fooValue%', Criteria::LIKE); // WHERE groups LIKE '%fooValue%'
     * </code>
     *
     * @param     string $groups The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByGroups($groups = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($groups)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_GROUPS, $groups, $comparison);
    }

    /**
     * Filter the query on the api_key column
     *
     * Example usage:
     * <code>
     * $query->filterByApi_key('fooValue');   // WHERE api_key = 'fooValue'
     * $query->filterByApi_key('%fooValue%', Criteria::LIKE); // WHERE api_key LIKE '%fooValue%'
     * </code>
     *
     * @param     string $api_key The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByApi_key($api_key = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($api_key)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_API_KEY, $api_key, $comparison);
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
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByInput_date($input_date = null, $comparison = null)
    {
        if (is_array($input_date)) {
            $useMinMax = false;
            if (isset($input_date['min'])) {
                $this->addUsingAlias(UserTableMap::COL_INPUT_DATE, $input_date['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($input_date['max'])) {
                $this->addUsingAlias(UserTableMap::COL_INPUT_DATE, $input_date['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_INPUT_DATE, $input_date, $comparison);
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
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByLast_update($last_update = null, $comparison = null)
    {
        if (is_array($last_update)) {
            $useMinMax = false;
            if (isset($last_update['min'])) {
                $this->addUsingAlias(UserTableMap::COL_LAST_UPDATE, $last_update['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($last_update['max'])) {
                $this->addUsingAlias(UserTableMap::COL_LAST_UPDATE, $last_update['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_LAST_UPDATE, $last_update, $comparison);
    }

    /**
     * Filter the query by a related \Slims\Models\Bibliography\Biblio\Biblio object
     *
     * @param \Slims\Models\Bibliography\Biblio\Biblio|ObjectCollection $biblio the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserQuery The current query, for fluid interface
     */
    public function filterByBiblio($biblio, $comparison = null)
    {
        if ($biblio instanceof \Slims\Models\Bibliography\Biblio\Biblio) {
            return $this
                ->addUsingAlias(UserTableMap::COL_USER_ID, $biblio->getUid(), $comparison);
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
     * @return $this|ChildUserQuery The current query, for fluid interface
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
     * Filter the query by a related \Slims\Models\Bibliography\Item\Item object
     *
     * @param \Slims\Models\Bibliography\Item\Item|ObjectCollection $item the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserQuery The current query, for fluid interface
     */
    public function filterByItem($item, $comparison = null)
    {
        if ($item instanceof \Slims\Models\Bibliography\Item\Item) {
            return $this
                ->addUsingAlias(UserTableMap::COL_USER_ID, $item->getUid(), $comparison);
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
     * @return $this|ChildUserQuery The current query, for fluid interface
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
     * @param   ChildUser $user Object to remove from the list of results
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function prune($user = null)
    {
        if ($user) {
            $this->addUsingAlias(UserTableMap::COL_USER_ID, $user->getUserId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the user table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(UserTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            UserTableMap::clearInstancePool();
            UserTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(UserTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(UserTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            UserTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            UserTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // UserQuery
