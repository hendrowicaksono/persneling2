<?php

namespace Slims\Models\Bibliography\Biblio\Base;

use \Exception;
use \PDO;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use Slims\Models\Bibliography\Biblio\Biblio as ChildBiblio;
use Slims\Models\Bibliography\Biblio\BiblioQuery as ChildBiblioQuery;
use Slims\Models\Bibliography\Biblio\Map\BiblioTableMap;
use Slims\Models\Bibliography\Item\Item;
use Slims\Models\Masterfile\BiblioAuthor\BiblioAuthor;
use Slims\Models\Masterfile\BiblioTopic\BiblioTopic;
use Slims\Models\Masterfile\Frequency\Frequency;
use Slims\Models\Masterfile\Language\Language;
use Slims\Models\Masterfile\Place\Place;
use Slims\Models\Masterfile\Publisher\Publisher;
use Slims\Models\System\User\User;

/**
 * Base class that represents a query for the 'biblio' table.
 *
 *
 *
 * @method     ChildBiblioQuery orderByBiblioId($order = Criteria::ASC) Order by the biblio_id column
 * @method     ChildBiblioQuery orderByTitle($order = Criteria::ASC) Order by the title column
 * @method     ChildBiblioQuery orderBySor($order = Criteria::ASC) Order by the sor column
 * @method     ChildBiblioQuery orderByEdition($order = Criteria::ASC) Order by the edition column
 * @method     ChildBiblioQuery orderByIsbn_issn($order = Criteria::ASC) Order by the isbn_issn column
 * @method     ChildBiblioQuery orderByPublisherId($order = Criteria::ASC) Order by the publisher_id column
 * @method     ChildBiblioQuery orderByPublish_year($order = Criteria::ASC) Order by the publish_year column
 * @method     ChildBiblioQuery orderByCollation($order = Criteria::ASC) Order by the collation column
 * @method     ChildBiblioQuery orderBySeries_title($order = Criteria::ASC) Order by the series_title column
 * @method     ChildBiblioQuery orderByCall_number($order = Criteria::ASC) Order by the call_number column
 * @method     ChildBiblioQuery orderByLanguageId($order = Criteria::ASC) Order by the language_id column
 * @method     ChildBiblioQuery orderBySource($order = Criteria::ASC) Order by the source column
 * @method     ChildBiblioQuery orderByPublishPlaceId($order = Criteria::ASC) Order by the publish_place_id column
 * @method     ChildBiblioQuery orderByClassification($order = Criteria::ASC) Order by the classification column
 * @method     ChildBiblioQuery orderByNotes($order = Criteria::ASC) Order by the notes column
 * @method     ChildBiblioQuery orderByImage($order = Criteria::ASC) Order by the image column
 * @method     ChildBiblioQuery orderByFile_att($order = Criteria::ASC) Order by the file_att column
 * @method     ChildBiblioQuery orderByOpac_hide($order = Criteria::ASC) Order by the opac_hide column
 * @method     ChildBiblioQuery orderByPromoted($order = Criteria::ASC) Order by the promoted column
 * @method     ChildBiblioQuery orderByLabels($order = Criteria::ASC) Order by the labels column
 * @method     ChildBiblioQuery orderByFrequencyId($order = Criteria::ASC) Order by the frequency_id column
 * @method     ChildBiblioQuery orderBySpec_detail_info($order = Criteria::ASC) Order by the spec_detail_info column
 * @method     ChildBiblioQuery orderByInput_date($order = Criteria::ASC) Order by the input_date column
 * @method     ChildBiblioQuery orderByLast_update($order = Criteria::ASC) Order by the last_update column
 * @method     ChildBiblioQuery orderByUid($order = Criteria::ASC) Order by the uid column
 *
 * @method     ChildBiblioQuery groupByBiblioId() Group by the biblio_id column
 * @method     ChildBiblioQuery groupByTitle() Group by the title column
 * @method     ChildBiblioQuery groupBySor() Group by the sor column
 * @method     ChildBiblioQuery groupByEdition() Group by the edition column
 * @method     ChildBiblioQuery groupByIsbn_issn() Group by the isbn_issn column
 * @method     ChildBiblioQuery groupByPublisherId() Group by the publisher_id column
 * @method     ChildBiblioQuery groupByPublish_year() Group by the publish_year column
 * @method     ChildBiblioQuery groupByCollation() Group by the collation column
 * @method     ChildBiblioQuery groupBySeries_title() Group by the series_title column
 * @method     ChildBiblioQuery groupByCall_number() Group by the call_number column
 * @method     ChildBiblioQuery groupByLanguageId() Group by the language_id column
 * @method     ChildBiblioQuery groupBySource() Group by the source column
 * @method     ChildBiblioQuery groupByPublishPlaceId() Group by the publish_place_id column
 * @method     ChildBiblioQuery groupByClassification() Group by the classification column
 * @method     ChildBiblioQuery groupByNotes() Group by the notes column
 * @method     ChildBiblioQuery groupByImage() Group by the image column
 * @method     ChildBiblioQuery groupByFile_att() Group by the file_att column
 * @method     ChildBiblioQuery groupByOpac_hide() Group by the opac_hide column
 * @method     ChildBiblioQuery groupByPromoted() Group by the promoted column
 * @method     ChildBiblioQuery groupByLabels() Group by the labels column
 * @method     ChildBiblioQuery groupByFrequencyId() Group by the frequency_id column
 * @method     ChildBiblioQuery groupBySpec_detail_info() Group by the spec_detail_info column
 * @method     ChildBiblioQuery groupByInput_date() Group by the input_date column
 * @method     ChildBiblioQuery groupByLast_update() Group by the last_update column
 * @method     ChildBiblioQuery groupByUid() Group by the uid column
 *
 * @method     ChildBiblioQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildBiblioQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildBiblioQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildBiblioQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildBiblioQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildBiblioQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildBiblioQuery leftJoinPublisher($relationAlias = null) Adds a LEFT JOIN clause to the query using the Publisher relation
 * @method     ChildBiblioQuery rightJoinPublisher($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Publisher relation
 * @method     ChildBiblioQuery innerJoinPublisher($relationAlias = null) Adds a INNER JOIN clause to the query using the Publisher relation
 *
 * @method     ChildBiblioQuery joinWithPublisher($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Publisher relation
 *
 * @method     ChildBiblioQuery leftJoinWithPublisher() Adds a LEFT JOIN clause and with to the query using the Publisher relation
 * @method     ChildBiblioQuery rightJoinWithPublisher() Adds a RIGHT JOIN clause and with to the query using the Publisher relation
 * @method     ChildBiblioQuery innerJoinWithPublisher() Adds a INNER JOIN clause and with to the query using the Publisher relation
 *
 * @method     ChildBiblioQuery leftJoinLanguage($relationAlias = null) Adds a LEFT JOIN clause to the query using the Language relation
 * @method     ChildBiblioQuery rightJoinLanguage($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Language relation
 * @method     ChildBiblioQuery innerJoinLanguage($relationAlias = null) Adds a INNER JOIN clause to the query using the Language relation
 *
 * @method     ChildBiblioQuery joinWithLanguage($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Language relation
 *
 * @method     ChildBiblioQuery leftJoinWithLanguage() Adds a LEFT JOIN clause and with to the query using the Language relation
 * @method     ChildBiblioQuery rightJoinWithLanguage() Adds a RIGHT JOIN clause and with to the query using the Language relation
 * @method     ChildBiblioQuery innerJoinWithLanguage() Adds a INNER JOIN clause and with to the query using the Language relation
 *
 * @method     ChildBiblioQuery leftJoinPlace($relationAlias = null) Adds a LEFT JOIN clause to the query using the Place relation
 * @method     ChildBiblioQuery rightJoinPlace($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Place relation
 * @method     ChildBiblioQuery innerJoinPlace($relationAlias = null) Adds a INNER JOIN clause to the query using the Place relation
 *
 * @method     ChildBiblioQuery joinWithPlace($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Place relation
 *
 * @method     ChildBiblioQuery leftJoinWithPlace() Adds a LEFT JOIN clause and with to the query using the Place relation
 * @method     ChildBiblioQuery rightJoinWithPlace() Adds a RIGHT JOIN clause and with to the query using the Place relation
 * @method     ChildBiblioQuery innerJoinWithPlace() Adds a INNER JOIN clause and with to the query using the Place relation
 *
 * @method     ChildBiblioQuery leftJoinFrequency($relationAlias = null) Adds a LEFT JOIN clause to the query using the Frequency relation
 * @method     ChildBiblioQuery rightJoinFrequency($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Frequency relation
 * @method     ChildBiblioQuery innerJoinFrequency($relationAlias = null) Adds a INNER JOIN clause to the query using the Frequency relation
 *
 * @method     ChildBiblioQuery joinWithFrequency($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Frequency relation
 *
 * @method     ChildBiblioQuery leftJoinWithFrequency() Adds a LEFT JOIN clause and with to the query using the Frequency relation
 * @method     ChildBiblioQuery rightJoinWithFrequency() Adds a RIGHT JOIN clause and with to the query using the Frequency relation
 * @method     ChildBiblioQuery innerJoinWithFrequency() Adds a INNER JOIN clause and with to the query using the Frequency relation
 *
 * @method     ChildBiblioQuery leftJoinUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the User relation
 * @method     ChildBiblioQuery rightJoinUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the User relation
 * @method     ChildBiblioQuery innerJoinUser($relationAlias = null) Adds a INNER JOIN clause to the query using the User relation
 *
 * @method     ChildBiblioQuery joinWithUser($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the User relation
 *
 * @method     ChildBiblioQuery leftJoinWithUser() Adds a LEFT JOIN clause and with to the query using the User relation
 * @method     ChildBiblioQuery rightJoinWithUser() Adds a RIGHT JOIN clause and with to the query using the User relation
 * @method     ChildBiblioQuery innerJoinWithUser() Adds a INNER JOIN clause and with to the query using the User relation
 *
 * @method     ChildBiblioQuery leftJoinBiblioAuthor($relationAlias = null) Adds a LEFT JOIN clause to the query using the BiblioAuthor relation
 * @method     ChildBiblioQuery rightJoinBiblioAuthor($relationAlias = null) Adds a RIGHT JOIN clause to the query using the BiblioAuthor relation
 * @method     ChildBiblioQuery innerJoinBiblioAuthor($relationAlias = null) Adds a INNER JOIN clause to the query using the BiblioAuthor relation
 *
 * @method     ChildBiblioQuery joinWithBiblioAuthor($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the BiblioAuthor relation
 *
 * @method     ChildBiblioQuery leftJoinWithBiblioAuthor() Adds a LEFT JOIN clause and with to the query using the BiblioAuthor relation
 * @method     ChildBiblioQuery rightJoinWithBiblioAuthor() Adds a RIGHT JOIN clause and with to the query using the BiblioAuthor relation
 * @method     ChildBiblioQuery innerJoinWithBiblioAuthor() Adds a INNER JOIN clause and with to the query using the BiblioAuthor relation
 *
 * @method     ChildBiblioQuery leftJoinBiblioTopic($relationAlias = null) Adds a LEFT JOIN clause to the query using the BiblioTopic relation
 * @method     ChildBiblioQuery rightJoinBiblioTopic($relationAlias = null) Adds a RIGHT JOIN clause to the query using the BiblioTopic relation
 * @method     ChildBiblioQuery innerJoinBiblioTopic($relationAlias = null) Adds a INNER JOIN clause to the query using the BiblioTopic relation
 *
 * @method     ChildBiblioQuery joinWithBiblioTopic($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the BiblioTopic relation
 *
 * @method     ChildBiblioQuery leftJoinWithBiblioTopic() Adds a LEFT JOIN clause and with to the query using the BiblioTopic relation
 * @method     ChildBiblioQuery rightJoinWithBiblioTopic() Adds a RIGHT JOIN clause and with to the query using the BiblioTopic relation
 * @method     ChildBiblioQuery innerJoinWithBiblioTopic() Adds a INNER JOIN clause and with to the query using the BiblioTopic relation
 *
 * @method     ChildBiblioQuery leftJoinItem($relationAlias = null) Adds a LEFT JOIN clause to the query using the Item relation
 * @method     ChildBiblioQuery rightJoinItem($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Item relation
 * @method     ChildBiblioQuery innerJoinItem($relationAlias = null) Adds a INNER JOIN clause to the query using the Item relation
 *
 * @method     ChildBiblioQuery joinWithItem($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Item relation
 *
 * @method     ChildBiblioQuery leftJoinWithItem() Adds a LEFT JOIN clause and with to the query using the Item relation
 * @method     ChildBiblioQuery rightJoinWithItem() Adds a RIGHT JOIN clause and with to the query using the Item relation
 * @method     ChildBiblioQuery innerJoinWithItem() Adds a INNER JOIN clause and with to the query using the Item relation
 *
 * @method     \Slims\Models\Masterfile\Publisher\PublisherQuery|\Slims\Models\Masterfile\Language\LanguageQuery|\Slims\Models\Masterfile\Place\PlaceQuery|\Slims\Models\Masterfile\Frequency\FrequencyQuery|\Slims\Models\System\User\UserQuery|\Slims\Models\Masterfile\BiblioAuthor\BiblioAuthorQuery|\Slims\Models\Masterfile\BiblioTopic\BiblioTopicQuery|\Slims\Models\Bibliography\Item\ItemQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildBiblio findOne(ConnectionInterface $con = null) Return the first ChildBiblio matching the query
 * @method     ChildBiblio findOneOrCreate(ConnectionInterface $con = null) Return the first ChildBiblio matching the query, or a new ChildBiblio object populated from the query conditions when no match is found
 *
 * @method     ChildBiblio findOneByBiblioId(int $biblio_id) Return the first ChildBiblio filtered by the biblio_id column
 * @method     ChildBiblio findOneByTitle(string $title) Return the first ChildBiblio filtered by the title column
 * @method     ChildBiblio findOneBySor(string $sor) Return the first ChildBiblio filtered by the sor column
 * @method     ChildBiblio findOneByEdition(string $edition) Return the first ChildBiblio filtered by the edition column
 * @method     ChildBiblio findOneByIsbn_issn(string $isbn_issn) Return the first ChildBiblio filtered by the isbn_issn column
 * @method     ChildBiblio findOneByPublisherId(int $publisher_id) Return the first ChildBiblio filtered by the publisher_id column
 * @method     ChildBiblio findOneByPublish_year(string $publish_year) Return the first ChildBiblio filtered by the publish_year column
 * @method     ChildBiblio findOneByCollation(string $collation) Return the first ChildBiblio filtered by the collation column
 * @method     ChildBiblio findOneBySeries_title(string $series_title) Return the first ChildBiblio filtered by the series_title column
 * @method     ChildBiblio findOneByCall_number(string $call_number) Return the first ChildBiblio filtered by the call_number column
 * @method     ChildBiblio findOneByLanguageId(string $language_id) Return the first ChildBiblio filtered by the language_id column
 * @method     ChildBiblio findOneBySource(string $source) Return the first ChildBiblio filtered by the source column
 * @method     ChildBiblio findOneByPublishPlaceId(int $publish_place_id) Return the first ChildBiblio filtered by the publish_place_id column
 * @method     ChildBiblio findOneByClassification(string $classification) Return the first ChildBiblio filtered by the classification column
 * @method     ChildBiblio findOneByNotes(string $notes) Return the first ChildBiblio filtered by the notes column
 * @method     ChildBiblio findOneByImage(string $image) Return the first ChildBiblio filtered by the image column
 * @method     ChildBiblio findOneByFile_att(string $file_att) Return the first ChildBiblio filtered by the file_att column
 * @method     ChildBiblio findOneByOpac_hide(int $opac_hide) Return the first ChildBiblio filtered by the opac_hide column
 * @method     ChildBiblio findOneByPromoted(int $promoted) Return the first ChildBiblio filtered by the promoted column
 * @method     ChildBiblio findOneByLabels(string $labels) Return the first ChildBiblio filtered by the labels column
 * @method     ChildBiblio findOneByFrequencyId(int $frequency_id) Return the first ChildBiblio filtered by the frequency_id column
 * @method     ChildBiblio findOneBySpec_detail_info(string $spec_detail_info) Return the first ChildBiblio filtered by the spec_detail_info column
 * @method     ChildBiblio findOneByInput_date(string $input_date) Return the first ChildBiblio filtered by the input_date column
 * @method     ChildBiblio findOneByLast_update(string $last_update) Return the first ChildBiblio filtered by the last_update column
 * @method     ChildBiblio findOneByUid(int $uid) Return the first ChildBiblio filtered by the uid column *

 * @method     ChildBiblio requirePk($key, ConnectionInterface $con = null) Return the ChildBiblio by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBiblio requireOne(ConnectionInterface $con = null) Return the first ChildBiblio matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildBiblio requireOneByBiblioId(int $biblio_id) Return the first ChildBiblio filtered by the biblio_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBiblio requireOneByTitle(string $title) Return the first ChildBiblio filtered by the title column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBiblio requireOneBySor(string $sor) Return the first ChildBiblio filtered by the sor column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBiblio requireOneByEdition(string $edition) Return the first ChildBiblio filtered by the edition column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBiblio requireOneByIsbn_issn(string $isbn_issn) Return the first ChildBiblio filtered by the isbn_issn column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBiblio requireOneByPublisherId(int $publisher_id) Return the first ChildBiblio filtered by the publisher_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBiblio requireOneByPublish_year(string $publish_year) Return the first ChildBiblio filtered by the publish_year column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBiblio requireOneByCollation(string $collation) Return the first ChildBiblio filtered by the collation column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBiblio requireOneBySeries_title(string $series_title) Return the first ChildBiblio filtered by the series_title column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBiblio requireOneByCall_number(string $call_number) Return the first ChildBiblio filtered by the call_number column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBiblio requireOneByLanguageId(string $language_id) Return the first ChildBiblio filtered by the language_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBiblio requireOneBySource(string $source) Return the first ChildBiblio filtered by the source column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBiblio requireOneByPublishPlaceId(int $publish_place_id) Return the first ChildBiblio filtered by the publish_place_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBiblio requireOneByClassification(string $classification) Return the first ChildBiblio filtered by the classification column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBiblio requireOneByNotes(string $notes) Return the first ChildBiblio filtered by the notes column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBiblio requireOneByImage(string $image) Return the first ChildBiblio filtered by the image column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBiblio requireOneByFile_att(string $file_att) Return the first ChildBiblio filtered by the file_att column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBiblio requireOneByOpac_hide(int $opac_hide) Return the first ChildBiblio filtered by the opac_hide column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBiblio requireOneByPromoted(int $promoted) Return the first ChildBiblio filtered by the promoted column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBiblio requireOneByLabels(string $labels) Return the first ChildBiblio filtered by the labels column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBiblio requireOneByFrequencyId(int $frequency_id) Return the first ChildBiblio filtered by the frequency_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBiblio requireOneBySpec_detail_info(string $spec_detail_info) Return the first ChildBiblio filtered by the spec_detail_info column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBiblio requireOneByInput_date(string $input_date) Return the first ChildBiblio filtered by the input_date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBiblio requireOneByLast_update(string $last_update) Return the first ChildBiblio filtered by the last_update column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBiblio requireOneByUid(int $uid) Return the first ChildBiblio filtered by the uid column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildBiblio[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildBiblio objects based on current ModelCriteria
 * @method     ChildBiblio[]|ObjectCollection findByBiblioId(int $biblio_id) Return ChildBiblio objects filtered by the biblio_id column
 * @method     ChildBiblio[]|ObjectCollection findByTitle(string $title) Return ChildBiblio objects filtered by the title column
 * @method     ChildBiblio[]|ObjectCollection findBySor(string $sor) Return ChildBiblio objects filtered by the sor column
 * @method     ChildBiblio[]|ObjectCollection findByEdition(string $edition) Return ChildBiblio objects filtered by the edition column
 * @method     ChildBiblio[]|ObjectCollection findByIsbn_issn(string $isbn_issn) Return ChildBiblio objects filtered by the isbn_issn column
 * @method     ChildBiblio[]|ObjectCollection findByPublisherId(int $publisher_id) Return ChildBiblio objects filtered by the publisher_id column
 * @method     ChildBiblio[]|ObjectCollection findByPublish_year(string $publish_year) Return ChildBiblio objects filtered by the publish_year column
 * @method     ChildBiblio[]|ObjectCollection findByCollation(string $collation) Return ChildBiblio objects filtered by the collation column
 * @method     ChildBiblio[]|ObjectCollection findBySeries_title(string $series_title) Return ChildBiblio objects filtered by the series_title column
 * @method     ChildBiblio[]|ObjectCollection findByCall_number(string $call_number) Return ChildBiblio objects filtered by the call_number column
 * @method     ChildBiblio[]|ObjectCollection findByLanguageId(string $language_id) Return ChildBiblio objects filtered by the language_id column
 * @method     ChildBiblio[]|ObjectCollection findBySource(string $source) Return ChildBiblio objects filtered by the source column
 * @method     ChildBiblio[]|ObjectCollection findByPublishPlaceId(int $publish_place_id) Return ChildBiblio objects filtered by the publish_place_id column
 * @method     ChildBiblio[]|ObjectCollection findByClassification(string $classification) Return ChildBiblio objects filtered by the classification column
 * @method     ChildBiblio[]|ObjectCollection findByNotes(string $notes) Return ChildBiblio objects filtered by the notes column
 * @method     ChildBiblio[]|ObjectCollection findByImage(string $image) Return ChildBiblio objects filtered by the image column
 * @method     ChildBiblio[]|ObjectCollection findByFile_att(string $file_att) Return ChildBiblio objects filtered by the file_att column
 * @method     ChildBiblio[]|ObjectCollection findByOpac_hide(int $opac_hide) Return ChildBiblio objects filtered by the opac_hide column
 * @method     ChildBiblio[]|ObjectCollection findByPromoted(int $promoted) Return ChildBiblio objects filtered by the promoted column
 * @method     ChildBiblio[]|ObjectCollection findByLabels(string $labels) Return ChildBiblio objects filtered by the labels column
 * @method     ChildBiblio[]|ObjectCollection findByFrequencyId(int $frequency_id) Return ChildBiblio objects filtered by the frequency_id column
 * @method     ChildBiblio[]|ObjectCollection findBySpec_detail_info(string $spec_detail_info) Return ChildBiblio objects filtered by the spec_detail_info column
 * @method     ChildBiblio[]|ObjectCollection findByInput_date(string $input_date) Return ChildBiblio objects filtered by the input_date column
 * @method     ChildBiblio[]|ObjectCollection findByLast_update(string $last_update) Return ChildBiblio objects filtered by the last_update column
 * @method     ChildBiblio[]|ObjectCollection findByUid(int $uid) Return ChildBiblio objects filtered by the uid column
 * @method     ChildBiblio[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class BiblioQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Slims\Models\Bibliography\Biblio\Base\BiblioQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'slims', $modelName = '\\Slims\\Models\\Bibliography\\Biblio\\Biblio', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildBiblioQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildBiblioQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildBiblioQuery) {
            return $criteria;
        }
        $query = new ChildBiblioQuery();
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
     * @return ChildBiblio|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(BiblioTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = BiblioTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildBiblio A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT biblio_id, title, sor, edition, isbn_issn, publisher_id, publish_year, collation, series_title, call_number, language_id, source, publish_place_id, classification, notes, image, file_att, opac_hide, promoted, labels, frequency_id, spec_detail_info, input_date, last_update, uid FROM biblio WHERE biblio_id = :p0';
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
            /** @var ChildBiblio $obj */
            $obj = new ChildBiblio();
            $obj->hydrate($row);
            BiblioTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildBiblio|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildBiblioQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(BiblioTableMap::COL_BIBLIO_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildBiblioQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(BiblioTableMap::COL_BIBLIO_ID, $keys, Criteria::IN);
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
     * @param     mixed $biblioId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBiblioQuery The current query, for fluid interface
     */
    public function filterByBiblioId($biblioId = null, $comparison = null)
    {
        if (is_array($biblioId)) {
            $useMinMax = false;
            if (isset($biblioId['min'])) {
                $this->addUsingAlias(BiblioTableMap::COL_BIBLIO_ID, $biblioId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($biblioId['max'])) {
                $this->addUsingAlias(BiblioTableMap::COL_BIBLIO_ID, $biblioId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BiblioTableMap::COL_BIBLIO_ID, $biblioId, $comparison);
    }

    /**
     * Filter the query on the title column
     *
     * Example usage:
     * <code>
     * $query->filterByTitle('fooValue');   // WHERE title = 'fooValue'
     * $query->filterByTitle('%fooValue%', Criteria::LIKE); // WHERE title LIKE '%fooValue%'
     * </code>
     *
     * @param     string $title The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBiblioQuery The current query, for fluid interface
     */
    public function filterByTitle($title = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($title)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BiblioTableMap::COL_TITLE, $title, $comparison);
    }

    /**
     * Filter the query on the sor column
     *
     * Example usage:
     * <code>
     * $query->filterBySor('fooValue');   // WHERE sor = 'fooValue'
     * $query->filterBySor('%fooValue%', Criteria::LIKE); // WHERE sor LIKE '%fooValue%'
     * </code>
     *
     * @param     string $sor The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBiblioQuery The current query, for fluid interface
     */
    public function filterBySor($sor = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($sor)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BiblioTableMap::COL_SOR, $sor, $comparison);
    }

    /**
     * Filter the query on the edition column
     *
     * Example usage:
     * <code>
     * $query->filterByEdition('fooValue');   // WHERE edition = 'fooValue'
     * $query->filterByEdition('%fooValue%', Criteria::LIKE); // WHERE edition LIKE '%fooValue%'
     * </code>
     *
     * @param     string $edition The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBiblioQuery The current query, for fluid interface
     */
    public function filterByEdition($edition = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($edition)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BiblioTableMap::COL_EDITION, $edition, $comparison);
    }

    /**
     * Filter the query on the isbn_issn column
     *
     * Example usage:
     * <code>
     * $query->filterByIsbn_issn('fooValue');   // WHERE isbn_issn = 'fooValue'
     * $query->filterByIsbn_issn('%fooValue%', Criteria::LIKE); // WHERE isbn_issn LIKE '%fooValue%'
     * </code>
     *
     * @param     string $isbn_issn The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBiblioQuery The current query, for fluid interface
     */
    public function filterByIsbn_issn($isbn_issn = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($isbn_issn)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BiblioTableMap::COL_ISBN_ISSN, $isbn_issn, $comparison);
    }

    /**
     * Filter the query on the publisher_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPublisherId(1234); // WHERE publisher_id = 1234
     * $query->filterByPublisherId(array(12, 34)); // WHERE publisher_id IN (12, 34)
     * $query->filterByPublisherId(array('min' => 12)); // WHERE publisher_id > 12
     * </code>
     *
     * @see       filterByPublisher()
     *
     * @param     mixed $publisherId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBiblioQuery The current query, for fluid interface
     */
    public function filterByPublisherId($publisherId = null, $comparison = null)
    {
        if (is_array($publisherId)) {
            $useMinMax = false;
            if (isset($publisherId['min'])) {
                $this->addUsingAlias(BiblioTableMap::COL_PUBLISHER_ID, $publisherId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($publisherId['max'])) {
                $this->addUsingAlias(BiblioTableMap::COL_PUBLISHER_ID, $publisherId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BiblioTableMap::COL_PUBLISHER_ID, $publisherId, $comparison);
    }

    /**
     * Filter the query on the publish_year column
     *
     * Example usage:
     * <code>
     * $query->filterByPublish_year('fooValue');   // WHERE publish_year = 'fooValue'
     * $query->filterByPublish_year('%fooValue%', Criteria::LIKE); // WHERE publish_year LIKE '%fooValue%'
     * </code>
     *
     * @param     string $publish_year The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBiblioQuery The current query, for fluid interface
     */
    public function filterByPublish_year($publish_year = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($publish_year)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BiblioTableMap::COL_PUBLISH_YEAR, $publish_year, $comparison);
    }

    /**
     * Filter the query on the collation column
     *
     * Example usage:
     * <code>
     * $query->filterByCollation('fooValue');   // WHERE collation = 'fooValue'
     * $query->filterByCollation('%fooValue%', Criteria::LIKE); // WHERE collation LIKE '%fooValue%'
     * </code>
     *
     * @param     string $collation The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBiblioQuery The current query, for fluid interface
     */
    public function filterByCollation($collation = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($collation)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BiblioTableMap::COL_COLLATION, $collation, $comparison);
    }

    /**
     * Filter the query on the series_title column
     *
     * Example usage:
     * <code>
     * $query->filterBySeries_title('fooValue');   // WHERE series_title = 'fooValue'
     * $query->filterBySeries_title('%fooValue%', Criteria::LIKE); // WHERE series_title LIKE '%fooValue%'
     * </code>
     *
     * @param     string $series_title The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBiblioQuery The current query, for fluid interface
     */
    public function filterBySeries_title($series_title = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($series_title)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BiblioTableMap::COL_SERIES_TITLE, $series_title, $comparison);
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
     * @return $this|ChildBiblioQuery The current query, for fluid interface
     */
    public function filterByCall_number($call_number = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($call_number)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BiblioTableMap::COL_CALL_NUMBER, $call_number, $comparison);
    }

    /**
     * Filter the query on the language_id column
     *
     * Example usage:
     * <code>
     * $query->filterByLanguageId('fooValue');   // WHERE language_id = 'fooValue'
     * $query->filterByLanguageId('%fooValue%', Criteria::LIKE); // WHERE language_id LIKE '%fooValue%'
     * </code>
     *
     * @param     string $languageId The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBiblioQuery The current query, for fluid interface
     */
    public function filterByLanguageId($languageId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($languageId)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BiblioTableMap::COL_LANGUAGE_ID, $languageId, $comparison);
    }

    /**
     * Filter the query on the source column
     *
     * Example usage:
     * <code>
     * $query->filterBySource('fooValue');   // WHERE source = 'fooValue'
     * $query->filterBySource('%fooValue%', Criteria::LIKE); // WHERE source LIKE '%fooValue%'
     * </code>
     *
     * @param     string $source The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBiblioQuery The current query, for fluid interface
     */
    public function filterBySource($source = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($source)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BiblioTableMap::COL_SOURCE, $source, $comparison);
    }

    /**
     * Filter the query on the publish_place_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPublishPlaceId(1234); // WHERE publish_place_id = 1234
     * $query->filterByPublishPlaceId(array(12, 34)); // WHERE publish_place_id IN (12, 34)
     * $query->filterByPublishPlaceId(array('min' => 12)); // WHERE publish_place_id > 12
     * </code>
     *
     * @see       filterByPlace()
     *
     * @param     mixed $publishPlaceId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBiblioQuery The current query, for fluid interface
     */
    public function filterByPublishPlaceId($publishPlaceId = null, $comparison = null)
    {
        if (is_array($publishPlaceId)) {
            $useMinMax = false;
            if (isset($publishPlaceId['min'])) {
                $this->addUsingAlias(BiblioTableMap::COL_PUBLISH_PLACE_ID, $publishPlaceId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($publishPlaceId['max'])) {
                $this->addUsingAlias(BiblioTableMap::COL_PUBLISH_PLACE_ID, $publishPlaceId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BiblioTableMap::COL_PUBLISH_PLACE_ID, $publishPlaceId, $comparison);
    }

    /**
     * Filter the query on the classification column
     *
     * Example usage:
     * <code>
     * $query->filterByClassification('fooValue');   // WHERE classification = 'fooValue'
     * $query->filterByClassification('%fooValue%', Criteria::LIKE); // WHERE classification LIKE '%fooValue%'
     * </code>
     *
     * @param     string $classification The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBiblioQuery The current query, for fluid interface
     */
    public function filterByClassification($classification = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($classification)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BiblioTableMap::COL_CLASSIFICATION, $classification, $comparison);
    }

    /**
     * Filter the query on the notes column
     *
     * Example usage:
     * <code>
     * $query->filterByNotes('fooValue');   // WHERE notes = 'fooValue'
     * $query->filterByNotes('%fooValue%', Criteria::LIKE); // WHERE notes LIKE '%fooValue%'
     * </code>
     *
     * @param     string $notes The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBiblioQuery The current query, for fluid interface
     */
    public function filterByNotes($notes = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($notes)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BiblioTableMap::COL_NOTES, $notes, $comparison);
    }

    /**
     * Filter the query on the image column
     *
     * Example usage:
     * <code>
     * $query->filterByImage('fooValue');   // WHERE image = 'fooValue'
     * $query->filterByImage('%fooValue%', Criteria::LIKE); // WHERE image LIKE '%fooValue%'
     * </code>
     *
     * @param     string $image The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBiblioQuery The current query, for fluid interface
     */
    public function filterByImage($image = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($image)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BiblioTableMap::COL_IMAGE, $image, $comparison);
    }

    /**
     * Filter the query on the file_att column
     *
     * Example usage:
     * <code>
     * $query->filterByFile_att('fooValue');   // WHERE file_att = 'fooValue'
     * $query->filterByFile_att('%fooValue%', Criteria::LIKE); // WHERE file_att LIKE '%fooValue%'
     * </code>
     *
     * @param     string $file_att The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBiblioQuery The current query, for fluid interface
     */
    public function filterByFile_att($file_att = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($file_att)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BiblioTableMap::COL_FILE_ATT, $file_att, $comparison);
    }

    /**
     * Filter the query on the opac_hide column
     *
     * Example usage:
     * <code>
     * $query->filterByOpac_hide(1234); // WHERE opac_hide = 1234
     * $query->filterByOpac_hide(array(12, 34)); // WHERE opac_hide IN (12, 34)
     * $query->filterByOpac_hide(array('min' => 12)); // WHERE opac_hide > 12
     * </code>
     *
     * @param     mixed $opac_hide The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBiblioQuery The current query, for fluid interface
     */
    public function filterByOpac_hide($opac_hide = null, $comparison = null)
    {
        if (is_array($opac_hide)) {
            $useMinMax = false;
            if (isset($opac_hide['min'])) {
                $this->addUsingAlias(BiblioTableMap::COL_OPAC_HIDE, $opac_hide['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($opac_hide['max'])) {
                $this->addUsingAlias(BiblioTableMap::COL_OPAC_HIDE, $opac_hide['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BiblioTableMap::COL_OPAC_HIDE, $opac_hide, $comparison);
    }

    /**
     * Filter the query on the promoted column
     *
     * Example usage:
     * <code>
     * $query->filterByPromoted(1234); // WHERE promoted = 1234
     * $query->filterByPromoted(array(12, 34)); // WHERE promoted IN (12, 34)
     * $query->filterByPromoted(array('min' => 12)); // WHERE promoted > 12
     * </code>
     *
     * @param     mixed $promoted The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBiblioQuery The current query, for fluid interface
     */
    public function filterByPromoted($promoted = null, $comparison = null)
    {
        if (is_array($promoted)) {
            $useMinMax = false;
            if (isset($promoted['min'])) {
                $this->addUsingAlias(BiblioTableMap::COL_PROMOTED, $promoted['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($promoted['max'])) {
                $this->addUsingAlias(BiblioTableMap::COL_PROMOTED, $promoted['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BiblioTableMap::COL_PROMOTED, $promoted, $comparison);
    }

    /**
     * Filter the query on the labels column
     *
     * Example usage:
     * <code>
     * $query->filterByLabels('fooValue');   // WHERE labels = 'fooValue'
     * $query->filterByLabels('%fooValue%', Criteria::LIKE); // WHERE labels LIKE '%fooValue%'
     * </code>
     *
     * @param     string $labels The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBiblioQuery The current query, for fluid interface
     */
    public function filterByLabels($labels = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($labels)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BiblioTableMap::COL_LABELS, $labels, $comparison);
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
     * @see       filterByFrequency()
     *
     * @param     mixed $frequencyId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBiblioQuery The current query, for fluid interface
     */
    public function filterByFrequencyId($frequencyId = null, $comparison = null)
    {
        if (is_array($frequencyId)) {
            $useMinMax = false;
            if (isset($frequencyId['min'])) {
                $this->addUsingAlias(BiblioTableMap::COL_FREQUENCY_ID, $frequencyId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($frequencyId['max'])) {
                $this->addUsingAlias(BiblioTableMap::COL_FREQUENCY_ID, $frequencyId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BiblioTableMap::COL_FREQUENCY_ID, $frequencyId, $comparison);
    }

    /**
     * Filter the query on the spec_detail_info column
     *
     * Example usage:
     * <code>
     * $query->filterBySpec_detail_info('fooValue');   // WHERE spec_detail_info = 'fooValue'
     * $query->filterBySpec_detail_info('%fooValue%', Criteria::LIKE); // WHERE spec_detail_info LIKE '%fooValue%'
     * </code>
     *
     * @param     string $spec_detail_info The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBiblioQuery The current query, for fluid interface
     */
    public function filterBySpec_detail_info($spec_detail_info = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($spec_detail_info)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BiblioTableMap::COL_SPEC_DETAIL_INFO, $spec_detail_info, $comparison);
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
     * @return $this|ChildBiblioQuery The current query, for fluid interface
     */
    public function filterByInput_date($input_date = null, $comparison = null)
    {
        if (is_array($input_date)) {
            $useMinMax = false;
            if (isset($input_date['min'])) {
                $this->addUsingAlias(BiblioTableMap::COL_INPUT_DATE, $input_date['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($input_date['max'])) {
                $this->addUsingAlias(BiblioTableMap::COL_INPUT_DATE, $input_date['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BiblioTableMap::COL_INPUT_DATE, $input_date, $comparison);
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
     * @return $this|ChildBiblioQuery The current query, for fluid interface
     */
    public function filterByLast_update($last_update = null, $comparison = null)
    {
        if (is_array($last_update)) {
            $useMinMax = false;
            if (isset($last_update['min'])) {
                $this->addUsingAlias(BiblioTableMap::COL_LAST_UPDATE, $last_update['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($last_update['max'])) {
                $this->addUsingAlias(BiblioTableMap::COL_LAST_UPDATE, $last_update['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BiblioTableMap::COL_LAST_UPDATE, $last_update, $comparison);
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
     * @return $this|ChildBiblioQuery The current query, for fluid interface
     */
    public function filterByUid($uid = null, $comparison = null)
    {
        if (is_array($uid)) {
            $useMinMax = false;
            if (isset($uid['min'])) {
                $this->addUsingAlias(BiblioTableMap::COL_UID, $uid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($uid['max'])) {
                $this->addUsingAlias(BiblioTableMap::COL_UID, $uid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BiblioTableMap::COL_UID, $uid, $comparison);
    }

    /**
     * Filter the query by a related \Slims\Models\Masterfile\Publisher\Publisher object
     *
     * @param \Slims\Models\Masterfile\Publisher\Publisher|ObjectCollection $publisher The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildBiblioQuery The current query, for fluid interface
     */
    public function filterByPublisher($publisher, $comparison = null)
    {
        if ($publisher instanceof \Slims\Models\Masterfile\Publisher\Publisher) {
            return $this
                ->addUsingAlias(BiblioTableMap::COL_PUBLISHER_ID, $publisher->getPublisherId(), $comparison);
        } elseif ($publisher instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(BiblioTableMap::COL_PUBLISHER_ID, $publisher->toKeyValue('PrimaryKey', 'PublisherId'), $comparison);
        } else {
            throw new PropelException('filterByPublisher() only accepts arguments of type \Slims\Models\Masterfile\Publisher\Publisher or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Publisher relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildBiblioQuery The current query, for fluid interface
     */
    public function joinPublisher($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Publisher');

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
            $this->addJoinObject($join, 'Publisher');
        }

        return $this;
    }

    /**
     * Use the Publisher relation Publisher object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Slims\Models\Masterfile\Publisher\PublisherQuery A secondary query class using the current class as primary query
     */
    public function usePublisherQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinPublisher($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Publisher', '\Slims\Models\Masterfile\Publisher\PublisherQuery');
    }

    /**
     * Filter the query by a related \Slims\Models\Masterfile\Language\Language object
     *
     * @param \Slims\Models\Masterfile\Language\Language|ObjectCollection $language The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildBiblioQuery The current query, for fluid interface
     */
    public function filterByLanguage($language, $comparison = null)
    {
        if ($language instanceof \Slims\Models\Masterfile\Language\Language) {
            return $this
                ->addUsingAlias(BiblioTableMap::COL_LANGUAGE_ID, $language->getLanguageId(), $comparison);
        } elseif ($language instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(BiblioTableMap::COL_LANGUAGE_ID, $language->toKeyValue('PrimaryKey', 'LanguageId'), $comparison);
        } else {
            throw new PropelException('filterByLanguage() only accepts arguments of type \Slims\Models\Masterfile\Language\Language or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Language relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildBiblioQuery The current query, for fluid interface
     */
    public function joinLanguage($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Language');

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
            $this->addJoinObject($join, 'Language');
        }

        return $this;
    }

    /**
     * Use the Language relation Language object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Slims\Models\Masterfile\Language\LanguageQuery A secondary query class using the current class as primary query
     */
    public function useLanguageQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinLanguage($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Language', '\Slims\Models\Masterfile\Language\LanguageQuery');
    }

    /**
     * Filter the query by a related \Slims\Models\Masterfile\Place\Place object
     *
     * @param \Slims\Models\Masterfile\Place\Place|ObjectCollection $place The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildBiblioQuery The current query, for fluid interface
     */
    public function filterByPlace($place, $comparison = null)
    {
        if ($place instanceof \Slims\Models\Masterfile\Place\Place) {
            return $this
                ->addUsingAlias(BiblioTableMap::COL_PUBLISH_PLACE_ID, $place->getPlaceId(), $comparison);
        } elseif ($place instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(BiblioTableMap::COL_PUBLISH_PLACE_ID, $place->toKeyValue('PrimaryKey', 'PlaceId'), $comparison);
        } else {
            throw new PropelException('filterByPlace() only accepts arguments of type \Slims\Models\Masterfile\Place\Place or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Place relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildBiblioQuery The current query, for fluid interface
     */
    public function joinPlace($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Place');

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
            $this->addJoinObject($join, 'Place');
        }

        return $this;
    }

    /**
     * Use the Place relation Place object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Slims\Models\Masterfile\Place\PlaceQuery A secondary query class using the current class as primary query
     */
    public function usePlaceQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinPlace($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Place', '\Slims\Models\Masterfile\Place\PlaceQuery');
    }

    /**
     * Filter the query by a related \Slims\Models\Masterfile\Frequency\Frequency object
     *
     * @param \Slims\Models\Masterfile\Frequency\Frequency|ObjectCollection $frequency The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildBiblioQuery The current query, for fluid interface
     */
    public function filterByFrequency($frequency, $comparison = null)
    {
        if ($frequency instanceof \Slims\Models\Masterfile\Frequency\Frequency) {
            return $this
                ->addUsingAlias(BiblioTableMap::COL_FREQUENCY_ID, $frequency->getFrequencyId(), $comparison);
        } elseif ($frequency instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(BiblioTableMap::COL_FREQUENCY_ID, $frequency->toKeyValue('PrimaryKey', 'FrequencyId'), $comparison);
        } else {
            throw new PropelException('filterByFrequency() only accepts arguments of type \Slims\Models\Masterfile\Frequency\Frequency or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Frequency relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildBiblioQuery The current query, for fluid interface
     */
    public function joinFrequency($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Frequency');

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
            $this->addJoinObject($join, 'Frequency');
        }

        return $this;
    }

    /**
     * Use the Frequency relation Frequency object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Slims\Models\Masterfile\Frequency\FrequencyQuery A secondary query class using the current class as primary query
     */
    public function useFrequencyQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinFrequency($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Frequency', '\Slims\Models\Masterfile\Frequency\FrequencyQuery');
    }

    /**
     * Filter the query by a related \Slims\Models\System\User\User object
     *
     * @param \Slims\Models\System\User\User|ObjectCollection $user The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildBiblioQuery The current query, for fluid interface
     */
    public function filterByUser($user, $comparison = null)
    {
        if ($user instanceof \Slims\Models\System\User\User) {
            return $this
                ->addUsingAlias(BiblioTableMap::COL_UID, $user->getUserId(), $comparison);
        } elseif ($user instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(BiblioTableMap::COL_UID, $user->toKeyValue('PrimaryKey', 'UserId'), $comparison);
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
     * @return $this|ChildBiblioQuery The current query, for fluid interface
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
     * Filter the query by a related \Slims\Models\Masterfile\BiblioAuthor\BiblioAuthor object
     *
     * @param \Slims\Models\Masterfile\BiblioAuthor\BiblioAuthor|ObjectCollection $biblioAuthor the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildBiblioQuery The current query, for fluid interface
     */
    public function filterByBiblioAuthor($biblioAuthor, $comparison = null)
    {
        if ($biblioAuthor instanceof \Slims\Models\Masterfile\BiblioAuthor\BiblioAuthor) {
            return $this
                ->addUsingAlias(BiblioTableMap::COL_BIBLIO_ID, $biblioAuthor->getBiblioId(), $comparison);
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
     * @return $this|ChildBiblioQuery The current query, for fluid interface
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
     * Filter the query by a related \Slims\Models\Masterfile\BiblioTopic\BiblioTopic object
     *
     * @param \Slims\Models\Masterfile\BiblioTopic\BiblioTopic|ObjectCollection $biblioTopic the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildBiblioQuery The current query, for fluid interface
     */
    public function filterByBiblioTopic($biblioTopic, $comparison = null)
    {
        if ($biblioTopic instanceof \Slims\Models\Masterfile\BiblioTopic\BiblioTopic) {
            return $this
                ->addUsingAlias(BiblioTableMap::COL_BIBLIO_ID, $biblioTopic->getBiblioId(), $comparison);
        } elseif ($biblioTopic instanceof ObjectCollection) {
            return $this
                ->useBiblioTopicQuery()
                ->filterByPrimaryKeys($biblioTopic->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByBiblioTopic() only accepts arguments of type \Slims\Models\Masterfile\BiblioTopic\BiblioTopic or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the BiblioTopic relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildBiblioQuery The current query, for fluid interface
     */
    public function joinBiblioTopic($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('BiblioTopic');

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
            $this->addJoinObject($join, 'BiblioTopic');
        }

        return $this;
    }

    /**
     * Use the BiblioTopic relation BiblioTopic object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Slims\Models\Masterfile\BiblioTopic\BiblioTopicQuery A secondary query class using the current class as primary query
     */
    public function useBiblioTopicQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinBiblioTopic($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'BiblioTopic', '\Slims\Models\Masterfile\BiblioTopic\BiblioTopicQuery');
    }

    /**
     * Filter the query by a related \Slims\Models\Bibliography\Item\Item object
     *
     * @param \Slims\Models\Bibliography\Item\Item|ObjectCollection $item the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildBiblioQuery The current query, for fluid interface
     */
    public function filterByItem($item, $comparison = null)
    {
        if ($item instanceof \Slims\Models\Bibliography\Item\Item) {
            return $this
                ->addUsingAlias(BiblioTableMap::COL_BIBLIO_ID, $item->getBiblioId(), $comparison);
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
     * @return $this|ChildBiblioQuery The current query, for fluid interface
     */
    public function joinItem($relationAlias = null, $joinType = Criteria::INNER_JOIN)
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
    public function useItemQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinItem($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Item', '\Slims\Models\Bibliography\Item\ItemQuery');
    }

    /**
     * Filter the query by a related Author object
     * using the biblio_author table as cross reference
     *
     * @param Author $author the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildBiblioQuery The current query, for fluid interface
     */
    public function filterByAuthor($author, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useBiblioAuthorQuery()
            ->filterByAuthor($author, $comparison)
            ->endUse();
    }

    /**
     * Filter the query by a related Topic object
     * using the biblio_topic table as cross reference
     *
     * @param Topic $topic the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildBiblioQuery The current query, for fluid interface
     */
    public function filterByTopic($topic, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useBiblioTopicQuery()
            ->filterByTopic($topic, $comparison)
            ->endUse();
    }

    /**
     * Exclude object from result
     *
     * @param   ChildBiblio $biblio Object to remove from the list of results
     *
     * @return $this|ChildBiblioQuery The current query, for fluid interface
     */
    public function prune($biblio = null)
    {
        if ($biblio) {
            $this->addUsingAlias(BiblioTableMap::COL_BIBLIO_ID, $biblio->getBiblioId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the biblio table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(BiblioTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            BiblioTableMap::clearInstancePool();
            BiblioTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(BiblioTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(BiblioTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            BiblioTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            BiblioTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // BiblioQuery
