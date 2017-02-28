<?php

namespace Slims\Models\Bibliography\Biblio\Map;

use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;
use Slims\Models\Bibliography\Biblio\Biblio;
use Slims\Models\Bibliography\Biblio\BiblioQuery;


/**
 * This class defines the structure of the 'biblio' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class BiblioTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Slims.Models.Bibliography.Biblio.Map.BiblioTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'slims';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'biblio';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Slims\\Models\\Bibliography\\Biblio\\Biblio';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Slims.Models.Bibliography.Biblio.Biblio';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 25;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 25;

    /**
     * the column name for the biblio_id field
     */
    const COL_BIBLIO_ID = 'biblio.biblio_id';

    /**
     * the column name for the title field
     */
    const COL_TITLE = 'biblio.title';

    /**
     * the column name for the sor field
     */
    const COL_SOR = 'biblio.sor';

    /**
     * the column name for the edition field
     */
    const COL_EDITION = 'biblio.edition';

    /**
     * the column name for the isbn_issn field
     */
    const COL_ISBN_ISSN = 'biblio.isbn_issn';

    /**
     * the column name for the publisher_id field
     */
    const COL_PUBLISHER_ID = 'biblio.publisher_id';

    /**
     * the column name for the publish_year field
     */
    const COL_PUBLISH_YEAR = 'biblio.publish_year';

    /**
     * the column name for the collation field
     */
    const COL_COLLATION = 'biblio.collation';

    /**
     * the column name for the series_title field
     */
    const COL_SERIES_TITLE = 'biblio.series_title';

    /**
     * the column name for the call_number field
     */
    const COL_CALL_NUMBER = 'biblio.call_number';

    /**
     * the column name for the language_id field
     */
    const COL_LANGUAGE_ID = 'biblio.language_id';

    /**
     * the column name for the source field
     */
    const COL_SOURCE = 'biblio.source';

    /**
     * the column name for the publish_place_id field
     */
    const COL_PUBLISH_PLACE_ID = 'biblio.publish_place_id';

    /**
     * the column name for the classification field
     */
    const COL_CLASSIFICATION = 'biblio.classification';

    /**
     * the column name for the notes field
     */
    const COL_NOTES = 'biblio.notes';

    /**
     * the column name for the image field
     */
    const COL_IMAGE = 'biblio.image';

    /**
     * the column name for the file_att field
     */
    const COL_FILE_ATT = 'biblio.file_att';

    /**
     * the column name for the opac_hide field
     */
    const COL_OPAC_HIDE = 'biblio.opac_hide';

    /**
     * the column name for the promoted field
     */
    const COL_PROMOTED = 'biblio.promoted';

    /**
     * the column name for the labels field
     */
    const COL_LABELS = 'biblio.labels';

    /**
     * the column name for the frequency_id field
     */
    const COL_FREQUENCY_ID = 'biblio.frequency_id';

    /**
     * the column name for the spec_detail_info field
     */
    const COL_SPEC_DETAIL_INFO = 'biblio.spec_detail_info';

    /**
     * the column name for the input_date field
     */
    const COL_INPUT_DATE = 'biblio.input_date';

    /**
     * the column name for the last_update field
     */
    const COL_LAST_UPDATE = 'biblio.last_update';

    /**
     * the column name for the uid field
     */
    const COL_UID = 'biblio.uid';

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
        self::TYPE_PHPNAME       => array('BiblioId', 'Title', 'Sor', 'Edition', 'Isbn_issn', 'PublisherId', 'Publish_year', 'Collation', 'Series_title', 'Call_number', 'LanguageId', 'Source', 'PublishPlaceId', 'Classification', 'Notes', 'Image', 'File_att', 'Opac_hide', 'Promoted', 'Labels', 'FrequencyId', 'Spec_detail_info', 'Input_date', 'Last_update', 'Uid', ),
        self::TYPE_CAMELNAME     => array('biblioId', 'title', 'sor', 'edition', 'isbn_issn', 'publisherId', 'publish_year', 'collation', 'series_title', 'call_number', 'languageId', 'source', 'publishPlaceId', 'classification', 'notes', 'image', 'file_att', 'opac_hide', 'promoted', 'labels', 'frequencyId', 'spec_detail_info', 'input_date', 'last_update', 'uid', ),
        self::TYPE_COLNAME       => array(BiblioTableMap::COL_BIBLIO_ID, BiblioTableMap::COL_TITLE, BiblioTableMap::COL_SOR, BiblioTableMap::COL_EDITION, BiblioTableMap::COL_ISBN_ISSN, BiblioTableMap::COL_PUBLISHER_ID, BiblioTableMap::COL_PUBLISH_YEAR, BiblioTableMap::COL_COLLATION, BiblioTableMap::COL_SERIES_TITLE, BiblioTableMap::COL_CALL_NUMBER, BiblioTableMap::COL_LANGUAGE_ID, BiblioTableMap::COL_SOURCE, BiblioTableMap::COL_PUBLISH_PLACE_ID, BiblioTableMap::COL_CLASSIFICATION, BiblioTableMap::COL_NOTES, BiblioTableMap::COL_IMAGE, BiblioTableMap::COL_FILE_ATT, BiblioTableMap::COL_OPAC_HIDE, BiblioTableMap::COL_PROMOTED, BiblioTableMap::COL_LABELS, BiblioTableMap::COL_FREQUENCY_ID, BiblioTableMap::COL_SPEC_DETAIL_INFO, BiblioTableMap::COL_INPUT_DATE, BiblioTableMap::COL_LAST_UPDATE, BiblioTableMap::COL_UID, ),
        self::TYPE_FIELDNAME     => array('biblio_id', 'title', 'sor', 'edition', 'isbn_issn', 'publisher_id', 'publish_year', 'collation', 'series_title', 'call_number', 'language_id', 'source', 'publish_place_id', 'classification', 'notes', 'image', 'file_att', 'opac_hide', 'promoted', 'labels', 'frequency_id', 'spec_detail_info', 'input_date', 'last_update', 'uid', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('BiblioId' => 0, 'Title' => 1, 'Sor' => 2, 'Edition' => 3, 'Isbn_issn' => 4, 'PublisherId' => 5, 'Publish_year' => 6, 'Collation' => 7, 'Series_title' => 8, 'Call_number' => 9, 'LanguageId' => 10, 'Source' => 11, 'PublishPlaceId' => 12, 'Classification' => 13, 'Notes' => 14, 'Image' => 15, 'File_att' => 16, 'Opac_hide' => 17, 'Promoted' => 18, 'Labels' => 19, 'FrequencyId' => 20, 'Spec_detail_info' => 21, 'Input_date' => 22, 'Last_update' => 23, 'Uid' => 24, ),
        self::TYPE_CAMELNAME     => array('biblioId' => 0, 'title' => 1, 'sor' => 2, 'edition' => 3, 'isbn_issn' => 4, 'publisherId' => 5, 'publish_year' => 6, 'collation' => 7, 'series_title' => 8, 'call_number' => 9, 'languageId' => 10, 'source' => 11, 'publishPlaceId' => 12, 'classification' => 13, 'notes' => 14, 'image' => 15, 'file_att' => 16, 'opac_hide' => 17, 'promoted' => 18, 'labels' => 19, 'frequencyId' => 20, 'spec_detail_info' => 21, 'input_date' => 22, 'last_update' => 23, 'uid' => 24, ),
        self::TYPE_COLNAME       => array(BiblioTableMap::COL_BIBLIO_ID => 0, BiblioTableMap::COL_TITLE => 1, BiblioTableMap::COL_SOR => 2, BiblioTableMap::COL_EDITION => 3, BiblioTableMap::COL_ISBN_ISSN => 4, BiblioTableMap::COL_PUBLISHER_ID => 5, BiblioTableMap::COL_PUBLISH_YEAR => 6, BiblioTableMap::COL_COLLATION => 7, BiblioTableMap::COL_SERIES_TITLE => 8, BiblioTableMap::COL_CALL_NUMBER => 9, BiblioTableMap::COL_LANGUAGE_ID => 10, BiblioTableMap::COL_SOURCE => 11, BiblioTableMap::COL_PUBLISH_PLACE_ID => 12, BiblioTableMap::COL_CLASSIFICATION => 13, BiblioTableMap::COL_NOTES => 14, BiblioTableMap::COL_IMAGE => 15, BiblioTableMap::COL_FILE_ATT => 16, BiblioTableMap::COL_OPAC_HIDE => 17, BiblioTableMap::COL_PROMOTED => 18, BiblioTableMap::COL_LABELS => 19, BiblioTableMap::COL_FREQUENCY_ID => 20, BiblioTableMap::COL_SPEC_DETAIL_INFO => 21, BiblioTableMap::COL_INPUT_DATE => 22, BiblioTableMap::COL_LAST_UPDATE => 23, BiblioTableMap::COL_UID => 24, ),
        self::TYPE_FIELDNAME     => array('biblio_id' => 0, 'title' => 1, 'sor' => 2, 'edition' => 3, 'isbn_issn' => 4, 'publisher_id' => 5, 'publish_year' => 6, 'collation' => 7, 'series_title' => 8, 'call_number' => 9, 'language_id' => 10, 'source' => 11, 'publish_place_id' => 12, 'classification' => 13, 'notes' => 14, 'image' => 15, 'file_att' => 16, 'opac_hide' => 17, 'promoted' => 18, 'labels' => 19, 'frequency_id' => 20, 'spec_detail_info' => 21, 'input_date' => 22, 'last_update' => 23, 'uid' => 24, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, )
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
        $this->setName('biblio');
        $this->setPhpName('Biblio');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Slims\\Models\\Bibliography\\Biblio\\Biblio');
        $this->setPackage('Slims.Models.Bibliography.Biblio');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('biblio_id', 'BiblioId', 'INTEGER', true, null, null);
        $this->addColumn('title', 'Title', 'LONGVARCHAR', true, null, null);
        $this->addColumn('sor', 'Sor', 'VARCHAR', false, 200, null);
        $this->addColumn('edition', 'Edition', 'VARCHAR', false, 50, null);
        $this->addColumn('isbn_issn', 'Isbn_issn', 'VARCHAR', false, 20, null);
        $this->addForeignKey('publisher_id', 'PublisherId', 'INTEGER', 'mst_publisher', 'publisher_id', false, null, null);
        $this->addColumn('publish_year', 'Publish_year', 'VARCHAR', false, 20, null);
        $this->addColumn('collation', 'Collation', 'VARCHAR', false, 50, null);
        $this->addColumn('series_title', 'Series_title', 'VARCHAR', false, 200, null);
        $this->addColumn('call_number', 'Call_number', 'VARCHAR', false, 50, null);
        $this->addForeignKey('language_id', 'LanguageId', 'CHAR', 'mst_language', 'language_id', false, 5, null);
        $this->addColumn('source', 'Source', 'VARCHAR', false, 3, null);
        $this->addForeignKey('publish_place_id', 'PublishPlaceId', 'INTEGER', 'mst_place', 'place_id', false, null, null);
        $this->addColumn('classification', 'Classification', 'VARCHAR', false, 40, null);
        $this->addColumn('notes', 'Notes', 'LONGVARCHAR', false, null, null);
        $this->addColumn('image', 'Image', 'VARCHAR', false, 100, null);
        $this->addColumn('file_att', 'File_att', 'VARCHAR', false, 255, null);
        $this->addColumn('opac_hide', 'Opac_hide', 'SMALLINT', false, 3, null);
        $this->addColumn('promoted', 'Promoted', 'SMALLINT', false, 3, null);
        $this->addColumn('labels', 'Labels', 'LONGVARCHAR', false, null, null);
        $this->addForeignKey('frequency_id', 'FrequencyId', 'INTEGER', 'mst_frequency', 'frequency_id', false, null, null);
        $this->addColumn('spec_detail_info', 'Spec_detail_info', 'LONGVARCHAR', false, null, null);
        $this->addColumn('input_date', 'Input_date', 'TIMESTAMP', false, null, null);
        $this->addColumn('last_update', 'Last_update', 'TIMESTAMP', false, null, null);
        $this->addForeignKey('uid', 'Uid', 'INTEGER', 'user', 'user_id', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Publisher', '\\Slims\\Models\\Masterfile\\Publisher\\Publisher', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':publisher_id',
    1 => ':publisher_id',
  ),
), null, null, null, false);
        $this->addRelation('Language', '\\Slims\\Models\\Masterfile\\Language\\Language', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':language_id',
    1 => ':language_id',
  ),
), null, null, null, false);
        $this->addRelation('Place', '\\Slims\\Models\\Masterfile\\Place\\Place', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':publish_place_id',
    1 => ':place_id',
  ),
), null, null, null, false);
        $this->addRelation('Frequency', '\\Slims\\Models\\Masterfile\\Frequency\\Frequency', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':frequency_id',
    1 => ':frequency_id',
  ),
), null, null, null, false);
        $this->addRelation('User', '\\Slims\\Models\\System\\User\\User', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':uid',
    1 => ':user_id',
  ),
), null, null, null, false);
        $this->addRelation('BiblioAuthor', '\\Slims\\Models\\Masterfile\\BiblioAuthor\\BiblioAuthor', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':biblio_id',
    1 => ':biblio_id',
  ),
), null, null, 'BiblioAuthors', false);
        $this->addRelation('BiblioTopic', '\\Slims\\Models\\Masterfile\\BiblioTopic\\BiblioTopic', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':biblio_id',
    1 => ':biblio_id',
  ),
), null, null, 'BiblioTopics', false);
        $this->addRelation('Item', '\\Slims\\Models\\Bibliography\\Item\\Item', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':biblio_id',
    1 => ':biblio_id',
  ),
), null, null, 'Items', false);
        $this->addRelation('Author', '\\Slims\\Models\\Masterfile\\Author\\Author', RelationMap::MANY_TO_MANY, array(), null, null, 'Authors');
        $this->addRelation('Topic', '\\Slims\\Models\\Masterfile\\Topic\\Topic', RelationMap::MANY_TO_MANY, array(), null, null, 'Topics');
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('BiblioId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('BiblioId', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('BiblioId', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('BiblioId', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('BiblioId', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('BiblioId', TableMap::TYPE_PHPNAME, $indexType)];
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
                : self::translateFieldName('BiblioId', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? BiblioTableMap::CLASS_DEFAULT : BiblioTableMap::OM_CLASS;
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
     * @return array           (Biblio object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = BiblioTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = BiblioTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + BiblioTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = BiblioTableMap::OM_CLASS;
            /** @var Biblio $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            BiblioTableMap::addInstanceToPool($obj, $key);
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
            $key = BiblioTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = BiblioTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Biblio $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                BiblioTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(BiblioTableMap::COL_BIBLIO_ID);
            $criteria->addSelectColumn(BiblioTableMap::COL_TITLE);
            $criteria->addSelectColumn(BiblioTableMap::COL_SOR);
            $criteria->addSelectColumn(BiblioTableMap::COL_EDITION);
            $criteria->addSelectColumn(BiblioTableMap::COL_ISBN_ISSN);
            $criteria->addSelectColumn(BiblioTableMap::COL_PUBLISHER_ID);
            $criteria->addSelectColumn(BiblioTableMap::COL_PUBLISH_YEAR);
            $criteria->addSelectColumn(BiblioTableMap::COL_COLLATION);
            $criteria->addSelectColumn(BiblioTableMap::COL_SERIES_TITLE);
            $criteria->addSelectColumn(BiblioTableMap::COL_CALL_NUMBER);
            $criteria->addSelectColumn(BiblioTableMap::COL_LANGUAGE_ID);
            $criteria->addSelectColumn(BiblioTableMap::COL_SOURCE);
            $criteria->addSelectColumn(BiblioTableMap::COL_PUBLISH_PLACE_ID);
            $criteria->addSelectColumn(BiblioTableMap::COL_CLASSIFICATION);
            $criteria->addSelectColumn(BiblioTableMap::COL_NOTES);
            $criteria->addSelectColumn(BiblioTableMap::COL_IMAGE);
            $criteria->addSelectColumn(BiblioTableMap::COL_FILE_ATT);
            $criteria->addSelectColumn(BiblioTableMap::COL_OPAC_HIDE);
            $criteria->addSelectColumn(BiblioTableMap::COL_PROMOTED);
            $criteria->addSelectColumn(BiblioTableMap::COL_LABELS);
            $criteria->addSelectColumn(BiblioTableMap::COL_FREQUENCY_ID);
            $criteria->addSelectColumn(BiblioTableMap::COL_SPEC_DETAIL_INFO);
            $criteria->addSelectColumn(BiblioTableMap::COL_INPUT_DATE);
            $criteria->addSelectColumn(BiblioTableMap::COL_LAST_UPDATE);
            $criteria->addSelectColumn(BiblioTableMap::COL_UID);
        } else {
            $criteria->addSelectColumn($alias . '.biblio_id');
            $criteria->addSelectColumn($alias . '.title');
            $criteria->addSelectColumn($alias . '.sor');
            $criteria->addSelectColumn($alias . '.edition');
            $criteria->addSelectColumn($alias . '.isbn_issn');
            $criteria->addSelectColumn($alias . '.publisher_id');
            $criteria->addSelectColumn($alias . '.publish_year');
            $criteria->addSelectColumn($alias . '.collation');
            $criteria->addSelectColumn($alias . '.series_title');
            $criteria->addSelectColumn($alias . '.call_number');
            $criteria->addSelectColumn($alias . '.language_id');
            $criteria->addSelectColumn($alias . '.source');
            $criteria->addSelectColumn($alias . '.publish_place_id');
            $criteria->addSelectColumn($alias . '.classification');
            $criteria->addSelectColumn($alias . '.notes');
            $criteria->addSelectColumn($alias . '.image');
            $criteria->addSelectColumn($alias . '.file_att');
            $criteria->addSelectColumn($alias . '.opac_hide');
            $criteria->addSelectColumn($alias . '.promoted');
            $criteria->addSelectColumn($alias . '.labels');
            $criteria->addSelectColumn($alias . '.frequency_id');
            $criteria->addSelectColumn($alias . '.spec_detail_info');
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
        return Propel::getServiceContainer()->getDatabaseMap(BiblioTableMap::DATABASE_NAME)->getTable(BiblioTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(BiblioTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(BiblioTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new BiblioTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Biblio or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Biblio object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(BiblioTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Slims\Models\Bibliography\Biblio\Biblio) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(BiblioTableMap::DATABASE_NAME);
            $criteria->add(BiblioTableMap::COL_BIBLIO_ID, (array) $values, Criteria::IN);
        }

        $query = BiblioQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            BiblioTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                BiblioTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the biblio table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return BiblioQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Biblio or Criteria object.
     *
     * @param mixed               $criteria Criteria or Biblio object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(BiblioTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Biblio object
        }

        if ($criteria->containsKey(BiblioTableMap::COL_BIBLIO_ID) && $criteria->keyContainsValue(BiblioTableMap::COL_BIBLIO_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.BiblioTableMap::COL_BIBLIO_ID.')');
        }


        // Set the correct dbName
        $query = BiblioQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // BiblioTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BiblioTableMap::buildTableMap();
