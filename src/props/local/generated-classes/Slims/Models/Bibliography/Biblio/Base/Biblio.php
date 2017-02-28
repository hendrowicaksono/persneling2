<?php

namespace Slims\Models\Bibliography\Biblio\Base;

use \DateTime;
use \Exception;
use \PDO;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;
use Slims\Models\Bibliography\Biblio\Biblio as ChildBiblio;
use Slims\Models\Bibliography\Biblio\BiblioQuery as ChildBiblioQuery;
use Slims\Models\Bibliography\Biblio\Map\BiblioTableMap;
use Slims\Models\Bibliography\Item\Item;
use Slims\Models\Bibliography\Item\ItemQuery;
use Slims\Models\Bibliography\Item\Base\Item as BaseItem;
use Slims\Models\Bibliography\Item\Map\ItemTableMap;
use Slims\Models\Masterfile\Author\Author;
use Slims\Models\Masterfile\Author\AuthorQuery;
use Slims\Models\Masterfile\BiblioAuthor\BiblioAuthor;
use Slims\Models\Masterfile\BiblioAuthor\BiblioAuthorQuery;
use Slims\Models\Masterfile\BiblioAuthor\Base\BiblioAuthor as BaseBiblioAuthor;
use Slims\Models\Masterfile\BiblioAuthor\Map\BiblioAuthorTableMap;
use Slims\Models\Masterfile\BiblioTopic\BiblioTopic;
use Slims\Models\Masterfile\BiblioTopic\BiblioTopicQuery;
use Slims\Models\Masterfile\BiblioTopic\Base\BiblioTopic as BaseBiblioTopic;
use Slims\Models\Masterfile\BiblioTopic\Map\BiblioTopicTableMap;
use Slims\Models\Masterfile\Frequency\Frequency;
use Slims\Models\Masterfile\Frequency\FrequencyQuery;
use Slims\Models\Masterfile\Language\Language;
use Slims\Models\Masterfile\Language\LanguageQuery;
use Slims\Models\Masterfile\Place\Place;
use Slims\Models\Masterfile\Place\PlaceQuery;
use Slims\Models\Masterfile\Publisher\Publisher;
use Slims\Models\Masterfile\Publisher\PublisherQuery;
use Slims\Models\Masterfile\Topic\Topic;
use Slims\Models\Masterfile\Topic\TopicQuery;
use Slims\Models\System\User\User;
use Slims\Models\System\User\UserQuery;

/**
 * Base class that represents a row from the 'biblio' table.
 *
 *
 *
 * @package    propel.generator.Slims.Models.Bibliography.Biblio.Base
 */
abstract class Biblio implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Slims\\Models\\Bibliography\\Biblio\\Map\\BiblioTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the biblio_id field.
     *
     * @var        int
     */
    protected $biblio_id;

    /**
     * The value for the title field.
     *
     * @var        string
     */
    protected $title;

    /**
     * The value for the sor field.
     *
     * @var        string
     */
    protected $sor;

    /**
     * The value for the edition field.
     *
     * @var        string
     */
    protected $edition;

    /**
     * The value for the isbn_issn field.
     *
     * @var        string
     */
    protected $isbn_issn;

    /**
     * The value for the publisher_id field.
     *
     * @var        int
     */
    protected $publisher_id;

    /**
     * The value for the publish_year field.
     *
     * @var        string
     */
    protected $publish_year;

    /**
     * The value for the collation field.
     *
     * @var        string
     */
    protected $collation;

    /**
     * The value for the series_title field.
     *
     * @var        string
     */
    protected $series_title;

    /**
     * The value for the call_number field.
     *
     * @var        string
     */
    protected $call_number;

    /**
     * The value for the language_id field.
     *
     * @var        string
     */
    protected $language_id;

    /**
     * The value for the source field.
     *
     * @var        string
     */
    protected $source;

    /**
     * The value for the publish_place_id field.
     *
     * @var        int
     */
    protected $publish_place_id;

    /**
     * The value for the classification field.
     *
     * @var        string
     */
    protected $classification;

    /**
     * The value for the notes field.
     *
     * @var        string
     */
    protected $notes;

    /**
     * The value for the image field.
     *
     * @var        string
     */
    protected $image;

    /**
     * The value for the file_att field.
     *
     * @var        string
     */
    protected $file_att;

    /**
     * The value for the opac_hide field.
     *
     * @var        int
     */
    protected $opac_hide;

    /**
     * The value for the promoted field.
     *
     * @var        int
     */
    protected $promoted;

    /**
     * The value for the labels field.
     *
     * @var        string
     */
    protected $labels;

    /**
     * The value for the frequency_id field.
     *
     * @var        int
     */
    protected $frequency_id;

    /**
     * The value for the spec_detail_info field.
     *
     * @var        string
     */
    protected $spec_detail_info;

    /**
     * The value for the input_date field.
     *
     * @var        DateTime
     */
    protected $input_date;

    /**
     * The value for the last_update field.
     *
     * @var        DateTime
     */
    protected $last_update;

    /**
     * The value for the uid field.
     *
     * @var        int
     */
    protected $uid;

    /**
     * @var        Publisher
     */
    protected $aPublisher;

    /**
     * @var        Language
     */
    protected $aLanguage;

    /**
     * @var        Place
     */
    protected $aPlace;

    /**
     * @var        Frequency
     */
    protected $aFrequency;

    /**
     * @var        User
     */
    protected $aUser;

    /**
     * @var        ObjectCollection|BiblioAuthor[] Collection to store aggregation of BiblioAuthor objects.
     */
    protected $collBiblioAuthors;
    protected $collBiblioAuthorsPartial;

    /**
     * @var        ObjectCollection|BiblioTopic[] Collection to store aggregation of BiblioTopic objects.
     */
    protected $collBiblioTopics;
    protected $collBiblioTopicsPartial;

    /**
     * @var        ObjectCollection|Item[] Collection to store aggregation of Item objects.
     */
    protected $collItems;
    protected $collItemsPartial;

    /**
     * @var        ObjectCollection|Author[] Cross Collection to store aggregation of Author objects.
     */
    protected $collAuthors;

    /**
     * @var bool
     */
    protected $collAuthorsPartial;

    /**
     * @var        ObjectCollection|Topic[] Cross Collection to store aggregation of Topic objects.
     */
    protected $collTopics;

    /**
     * @var bool
     */
    protected $collTopicsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|Author[]
     */
    protected $authorsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|Topic[]
     */
    protected $topicsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|BiblioAuthor[]
     */
    protected $biblioAuthorsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|BiblioTopic[]
     */
    protected $biblioTopicsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|Item[]
     */
    protected $itemsScheduledForDeletion = null;

    /**
     * Initializes internal state of Slims\Models\Bibliography\Biblio\Base\Biblio object.
     */
    public function __construct()
    {
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>Biblio</code> instance.  If
     * <code>obj</code> is an instance of <code>Biblio</code>, delegates to
     * <code>equals(Biblio)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|Biblio The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        $cls = new \ReflectionClass($this);
        $propertyNames = [];
        $serializableProperties = array_diff($cls->getProperties(), $cls->getProperties(\ReflectionProperty::IS_STATIC));

        foreach($serializableProperties as $property) {
            $propertyNames[] = $property->getName();
        }

        return $propertyNames;
    }

    /**
     * Get the [biblio_id] column value.
     *
     * @return int
     */
    public function getBiblioId()
    {
        return $this->biblio_id;
    }

    /**
     * Get the [title] column value.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get the [sor] column value.
     *
     * @return string
     */
    public function getSor()
    {
        return $this->sor;
    }

    /**
     * Get the [edition] column value.
     *
     * @return string
     */
    public function getEdition()
    {
        return $this->edition;
    }

    /**
     * Get the [isbn_issn] column value.
     *
     * @return string
     */
    public function getIsbn_issn()
    {
        return $this->isbn_issn;
    }

    /**
     * Get the [publisher_id] column value.
     *
     * @return int
     */
    public function getPublisherId()
    {
        return $this->publisher_id;
    }

    /**
     * Get the [publish_year] column value.
     *
     * @return string
     */
    public function getPublish_year()
    {
        return $this->publish_year;
    }

    /**
     * Get the [collation] column value.
     *
     * @return string
     */
    public function getCollation()
    {
        return $this->collation;
    }

    /**
     * Get the [series_title] column value.
     *
     * @return string
     */
    public function getSeries_title()
    {
        return $this->series_title;
    }

    /**
     * Get the [call_number] column value.
     *
     * @return string
     */
    public function getCall_number()
    {
        return $this->call_number;
    }

    /**
     * Get the [language_id] column value.
     *
     * @return string
     */
    public function getLanguageId()
    {
        return $this->language_id;
    }

    /**
     * Get the [source] column value.
     *
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Get the [publish_place_id] column value.
     *
     * @return int
     */
    public function getPublishPlaceId()
    {
        return $this->publish_place_id;
    }

    /**
     * Get the [classification] column value.
     *
     * @return string
     */
    public function getClassification()
    {
        return $this->classification;
    }

    /**
     * Get the [notes] column value.
     *
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Get the [image] column value.
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Get the [file_att] column value.
     *
     * @return string
     */
    public function getFile_att()
    {
        return $this->file_att;
    }

    /**
     * Get the [opac_hide] column value.
     *
     * @return int
     */
    public function getOpac_hide()
    {
        return $this->opac_hide;
    }

    /**
     * Get the [promoted] column value.
     *
     * @return int
     */
    public function getPromoted()
    {
        return $this->promoted;
    }

    /**
     * Get the [labels] column value.
     *
     * @return string
     */
    public function getLabels()
    {
        return $this->labels;
    }

    /**
     * Get the [frequency_id] column value.
     *
     * @return int
     */
    public function getFrequencyId()
    {
        return $this->frequency_id;
    }

    /**
     * Get the [spec_detail_info] column value.
     *
     * @return string
     */
    public function getSpec_detail_info()
    {
        return $this->spec_detail_info;
    }

    /**
     * Get the [optionally formatted] temporal [input_date] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getInput_date($format = NULL)
    {
        if ($format === null) {
            return $this->input_date;
        } else {
            return $this->input_date instanceof \DateTimeInterface ? $this->input_date->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [last_update] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getLast_update($format = NULL)
    {
        if ($format === null) {
            return $this->last_update;
        } else {
            return $this->last_update instanceof \DateTimeInterface ? $this->last_update->format($format) : null;
        }
    }

    /**
     * Get the [uid] column value.
     *
     * @return int
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * Set the value of [biblio_id] column.
     *
     * @param int $v new value
     * @return $this|\Slims\Models\Bibliography\Biblio\Biblio The current object (for fluent API support)
     */
    public function setBiblioId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->biblio_id !== $v) {
            $this->biblio_id = $v;
            $this->modifiedColumns[BiblioTableMap::COL_BIBLIO_ID] = true;
        }

        return $this;
    } // setBiblioId()

    /**
     * Set the value of [title] column.
     *
     * @param string $v new value
     * @return $this|\Slims\Models\Bibliography\Biblio\Biblio The current object (for fluent API support)
     */
    public function setTitle($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->title !== $v) {
            $this->title = $v;
            $this->modifiedColumns[BiblioTableMap::COL_TITLE] = true;
        }

        return $this;
    } // setTitle()

    /**
     * Set the value of [sor] column.
     *
     * @param string $v new value
     * @return $this|\Slims\Models\Bibliography\Biblio\Biblio The current object (for fluent API support)
     */
    public function setSor($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->sor !== $v) {
            $this->sor = $v;
            $this->modifiedColumns[BiblioTableMap::COL_SOR] = true;
        }

        return $this;
    } // setSor()

    /**
     * Set the value of [edition] column.
     *
     * @param string $v new value
     * @return $this|\Slims\Models\Bibliography\Biblio\Biblio The current object (for fluent API support)
     */
    public function setEdition($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->edition !== $v) {
            $this->edition = $v;
            $this->modifiedColumns[BiblioTableMap::COL_EDITION] = true;
        }

        return $this;
    } // setEdition()

    /**
     * Set the value of [isbn_issn] column.
     *
     * @param string $v new value
     * @return $this|\Slims\Models\Bibliography\Biblio\Biblio The current object (for fluent API support)
     */
    public function setIsbn_issn($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->isbn_issn !== $v) {
            $this->isbn_issn = $v;
            $this->modifiedColumns[BiblioTableMap::COL_ISBN_ISSN] = true;
        }

        return $this;
    } // setIsbn_issn()

    /**
     * Set the value of [publisher_id] column.
     *
     * @param int $v new value
     * @return $this|\Slims\Models\Bibliography\Biblio\Biblio The current object (for fluent API support)
     */
    public function setPublisherId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->publisher_id !== $v) {
            $this->publisher_id = $v;
            $this->modifiedColumns[BiblioTableMap::COL_PUBLISHER_ID] = true;
        }

        if ($this->aPublisher !== null && $this->aPublisher->getPublisherId() !== $v) {
            $this->aPublisher = null;
        }

        return $this;
    } // setPublisherId()

    /**
     * Set the value of [publish_year] column.
     *
     * @param string $v new value
     * @return $this|\Slims\Models\Bibliography\Biblio\Biblio The current object (for fluent API support)
     */
    public function setPublish_year($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->publish_year !== $v) {
            $this->publish_year = $v;
            $this->modifiedColumns[BiblioTableMap::COL_PUBLISH_YEAR] = true;
        }

        return $this;
    } // setPublish_year()

    /**
     * Set the value of [collation] column.
     *
     * @param string $v new value
     * @return $this|\Slims\Models\Bibliography\Biblio\Biblio The current object (for fluent API support)
     */
    public function setCollation($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->collation !== $v) {
            $this->collation = $v;
            $this->modifiedColumns[BiblioTableMap::COL_COLLATION] = true;
        }

        return $this;
    } // setCollation()

    /**
     * Set the value of [series_title] column.
     *
     * @param string $v new value
     * @return $this|\Slims\Models\Bibliography\Biblio\Biblio The current object (for fluent API support)
     */
    public function setSeries_title($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->series_title !== $v) {
            $this->series_title = $v;
            $this->modifiedColumns[BiblioTableMap::COL_SERIES_TITLE] = true;
        }

        return $this;
    } // setSeries_title()

    /**
     * Set the value of [call_number] column.
     *
     * @param string $v new value
     * @return $this|\Slims\Models\Bibliography\Biblio\Biblio The current object (for fluent API support)
     */
    public function setCall_number($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->call_number !== $v) {
            $this->call_number = $v;
            $this->modifiedColumns[BiblioTableMap::COL_CALL_NUMBER] = true;
        }

        return $this;
    } // setCall_number()

    /**
     * Set the value of [language_id] column.
     *
     * @param string $v new value
     * @return $this|\Slims\Models\Bibliography\Biblio\Biblio The current object (for fluent API support)
     */
    public function setLanguageId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->language_id !== $v) {
            $this->language_id = $v;
            $this->modifiedColumns[BiblioTableMap::COL_LANGUAGE_ID] = true;
        }

        if ($this->aLanguage !== null && $this->aLanguage->getLanguageId() !== $v) {
            $this->aLanguage = null;
        }

        return $this;
    } // setLanguageId()

    /**
     * Set the value of [source] column.
     *
     * @param string $v new value
     * @return $this|\Slims\Models\Bibliography\Biblio\Biblio The current object (for fluent API support)
     */
    public function setSource($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->source !== $v) {
            $this->source = $v;
            $this->modifiedColumns[BiblioTableMap::COL_SOURCE] = true;
        }

        return $this;
    } // setSource()

    /**
     * Set the value of [publish_place_id] column.
     *
     * @param int $v new value
     * @return $this|\Slims\Models\Bibliography\Biblio\Biblio The current object (for fluent API support)
     */
    public function setPublishPlaceId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->publish_place_id !== $v) {
            $this->publish_place_id = $v;
            $this->modifiedColumns[BiblioTableMap::COL_PUBLISH_PLACE_ID] = true;
        }

        if ($this->aPlace !== null && $this->aPlace->getPlaceId() !== $v) {
            $this->aPlace = null;
        }

        return $this;
    } // setPublishPlaceId()

    /**
     * Set the value of [classification] column.
     *
     * @param string $v new value
     * @return $this|\Slims\Models\Bibliography\Biblio\Biblio The current object (for fluent API support)
     */
    public function setClassification($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->classification !== $v) {
            $this->classification = $v;
            $this->modifiedColumns[BiblioTableMap::COL_CLASSIFICATION] = true;
        }

        return $this;
    } // setClassification()

    /**
     * Set the value of [notes] column.
     *
     * @param string $v new value
     * @return $this|\Slims\Models\Bibliography\Biblio\Biblio The current object (for fluent API support)
     */
    public function setNotes($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->notes !== $v) {
            $this->notes = $v;
            $this->modifiedColumns[BiblioTableMap::COL_NOTES] = true;
        }

        return $this;
    } // setNotes()

    /**
     * Set the value of [image] column.
     *
     * @param string $v new value
     * @return $this|\Slims\Models\Bibliography\Biblio\Biblio The current object (for fluent API support)
     */
    public function setImage($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->image !== $v) {
            $this->image = $v;
            $this->modifiedColumns[BiblioTableMap::COL_IMAGE] = true;
        }

        return $this;
    } // setImage()

    /**
     * Set the value of [file_att] column.
     *
     * @param string $v new value
     * @return $this|\Slims\Models\Bibliography\Biblio\Biblio The current object (for fluent API support)
     */
    public function setFile_att($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->file_att !== $v) {
            $this->file_att = $v;
            $this->modifiedColumns[BiblioTableMap::COL_FILE_ATT] = true;
        }

        return $this;
    } // setFile_att()

    /**
     * Set the value of [opac_hide] column.
     *
     * @param int $v new value
     * @return $this|\Slims\Models\Bibliography\Biblio\Biblio The current object (for fluent API support)
     */
    public function setOpac_hide($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->opac_hide !== $v) {
            $this->opac_hide = $v;
            $this->modifiedColumns[BiblioTableMap::COL_OPAC_HIDE] = true;
        }

        return $this;
    } // setOpac_hide()

    /**
     * Set the value of [promoted] column.
     *
     * @param int $v new value
     * @return $this|\Slims\Models\Bibliography\Biblio\Biblio The current object (for fluent API support)
     */
    public function setPromoted($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->promoted !== $v) {
            $this->promoted = $v;
            $this->modifiedColumns[BiblioTableMap::COL_PROMOTED] = true;
        }

        return $this;
    } // setPromoted()

    /**
     * Set the value of [labels] column.
     *
     * @param string $v new value
     * @return $this|\Slims\Models\Bibliography\Biblio\Biblio The current object (for fluent API support)
     */
    public function setLabels($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->labels !== $v) {
            $this->labels = $v;
            $this->modifiedColumns[BiblioTableMap::COL_LABELS] = true;
        }

        return $this;
    } // setLabels()

    /**
     * Set the value of [frequency_id] column.
     *
     * @param int $v new value
     * @return $this|\Slims\Models\Bibliography\Biblio\Biblio The current object (for fluent API support)
     */
    public function setFrequencyId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->frequency_id !== $v) {
            $this->frequency_id = $v;
            $this->modifiedColumns[BiblioTableMap::COL_FREQUENCY_ID] = true;
        }

        if ($this->aFrequency !== null && $this->aFrequency->getFrequencyId() !== $v) {
            $this->aFrequency = null;
        }

        return $this;
    } // setFrequencyId()

    /**
     * Set the value of [spec_detail_info] column.
     *
     * @param string $v new value
     * @return $this|\Slims\Models\Bibliography\Biblio\Biblio The current object (for fluent API support)
     */
    public function setSpec_detail_info($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->spec_detail_info !== $v) {
            $this->spec_detail_info = $v;
            $this->modifiedColumns[BiblioTableMap::COL_SPEC_DETAIL_INFO] = true;
        }

        return $this;
    } // setSpec_detail_info()

    /**
     * Sets the value of [input_date] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Slims\Models\Bibliography\Biblio\Biblio The current object (for fluent API support)
     */
    public function setInput_date($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->input_date !== null || $dt !== null) {
            if ($this->input_date === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->input_date->format("Y-m-d H:i:s.u")) {
                $this->input_date = $dt === null ? null : clone $dt;
                $this->modifiedColumns[BiblioTableMap::COL_INPUT_DATE] = true;
            }
        } // if either are not null

        return $this;
    } // setInput_date()

    /**
     * Sets the value of [last_update] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Slims\Models\Bibliography\Biblio\Biblio The current object (for fluent API support)
     */
    public function setLast_update($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->last_update !== null || $dt !== null) {
            if ($this->last_update === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->last_update->format("Y-m-d H:i:s.u")) {
                $this->last_update = $dt === null ? null : clone $dt;
                $this->modifiedColumns[BiblioTableMap::COL_LAST_UPDATE] = true;
            }
        } // if either are not null

        return $this;
    } // setLast_update()

    /**
     * Set the value of [uid] column.
     *
     * @param int $v new value
     * @return $this|\Slims\Models\Bibliography\Biblio\Biblio The current object (for fluent API support)
     */
    public function setUid($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->uid !== $v) {
            $this->uid = $v;
            $this->modifiedColumns[BiblioTableMap::COL_UID] = true;
        }

        if ($this->aUser !== null && $this->aUser->getUserId() !== $v) {
            $this->aUser = null;
        }

        return $this;
    } // setUid()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : BiblioTableMap::translateFieldName('BiblioId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->biblio_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : BiblioTableMap::translateFieldName('Title', TableMap::TYPE_PHPNAME, $indexType)];
            $this->title = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : BiblioTableMap::translateFieldName('Sor', TableMap::TYPE_PHPNAME, $indexType)];
            $this->sor = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : BiblioTableMap::translateFieldName('Edition', TableMap::TYPE_PHPNAME, $indexType)];
            $this->edition = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : BiblioTableMap::translateFieldName('Isbn_issn', TableMap::TYPE_PHPNAME, $indexType)];
            $this->isbn_issn = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : BiblioTableMap::translateFieldName('PublisherId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->publisher_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : BiblioTableMap::translateFieldName('Publish_year', TableMap::TYPE_PHPNAME, $indexType)];
            $this->publish_year = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : BiblioTableMap::translateFieldName('Collation', TableMap::TYPE_PHPNAME, $indexType)];
            $this->collation = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : BiblioTableMap::translateFieldName('Series_title', TableMap::TYPE_PHPNAME, $indexType)];
            $this->series_title = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : BiblioTableMap::translateFieldName('Call_number', TableMap::TYPE_PHPNAME, $indexType)];
            $this->call_number = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : BiblioTableMap::translateFieldName('LanguageId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->language_id = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : BiblioTableMap::translateFieldName('Source', TableMap::TYPE_PHPNAME, $indexType)];
            $this->source = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : BiblioTableMap::translateFieldName('PublishPlaceId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->publish_place_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 13 + $startcol : BiblioTableMap::translateFieldName('Classification', TableMap::TYPE_PHPNAME, $indexType)];
            $this->classification = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 14 + $startcol : BiblioTableMap::translateFieldName('Notes', TableMap::TYPE_PHPNAME, $indexType)];
            $this->notes = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 15 + $startcol : BiblioTableMap::translateFieldName('Image', TableMap::TYPE_PHPNAME, $indexType)];
            $this->image = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 16 + $startcol : BiblioTableMap::translateFieldName('File_att', TableMap::TYPE_PHPNAME, $indexType)];
            $this->file_att = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 17 + $startcol : BiblioTableMap::translateFieldName('Opac_hide', TableMap::TYPE_PHPNAME, $indexType)];
            $this->opac_hide = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 18 + $startcol : BiblioTableMap::translateFieldName('Promoted', TableMap::TYPE_PHPNAME, $indexType)];
            $this->promoted = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 19 + $startcol : BiblioTableMap::translateFieldName('Labels', TableMap::TYPE_PHPNAME, $indexType)];
            $this->labels = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 20 + $startcol : BiblioTableMap::translateFieldName('FrequencyId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->frequency_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 21 + $startcol : BiblioTableMap::translateFieldName('Spec_detail_info', TableMap::TYPE_PHPNAME, $indexType)];
            $this->spec_detail_info = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 22 + $startcol : BiblioTableMap::translateFieldName('Input_date', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->input_date = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 23 + $startcol : BiblioTableMap::translateFieldName('Last_update', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->last_update = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 24 + $startcol : BiblioTableMap::translateFieldName('Uid', TableMap::TYPE_PHPNAME, $indexType)];
            $this->uid = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 25; // 25 = BiblioTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Slims\\Models\\Bibliography\\Biblio\\Biblio'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
        if ($this->aPublisher !== null && $this->publisher_id !== $this->aPublisher->getPublisherId()) {
            $this->aPublisher = null;
        }
        if ($this->aLanguage !== null && $this->language_id !== $this->aLanguage->getLanguageId()) {
            $this->aLanguage = null;
        }
        if ($this->aPlace !== null && $this->publish_place_id !== $this->aPlace->getPlaceId()) {
            $this->aPlace = null;
        }
        if ($this->aFrequency !== null && $this->frequency_id !== $this->aFrequency->getFrequencyId()) {
            $this->aFrequency = null;
        }
        if ($this->aUser !== null && $this->uid !== $this->aUser->getUserId()) {
            $this->aUser = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(BiblioTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildBiblioQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aPublisher = null;
            $this->aLanguage = null;
            $this->aPlace = null;
            $this->aFrequency = null;
            $this->aUser = null;
            $this->collBiblioAuthors = null;

            $this->collBiblioTopics = null;

            $this->collItems = null;

            $this->collAuthors = null;
            $this->collTopics = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Biblio::setDeleted()
     * @see Biblio::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(BiblioTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildBiblioQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($this->alreadyInSave) {
            return 0;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(BiblioTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                BiblioTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aPublisher !== null) {
                if ($this->aPublisher->isModified() || $this->aPublisher->isNew()) {
                    $affectedRows += $this->aPublisher->save($con);
                }
                $this->setPublisher($this->aPublisher);
            }

            if ($this->aLanguage !== null) {
                if ($this->aLanguage->isModified() || $this->aLanguage->isNew()) {
                    $affectedRows += $this->aLanguage->save($con);
                }
                $this->setLanguage($this->aLanguage);
            }

            if ($this->aPlace !== null) {
                if ($this->aPlace->isModified() || $this->aPlace->isNew()) {
                    $affectedRows += $this->aPlace->save($con);
                }
                $this->setPlace($this->aPlace);
            }

            if ($this->aFrequency !== null) {
                if ($this->aFrequency->isModified() || $this->aFrequency->isNew()) {
                    $affectedRows += $this->aFrequency->save($con);
                }
                $this->setFrequency($this->aFrequency);
            }

            if ($this->aUser !== null) {
                if ($this->aUser->isModified() || $this->aUser->isNew()) {
                    $affectedRows += $this->aUser->save($con);
                }
                $this->setUser($this->aUser);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            if ($this->authorsScheduledForDeletion !== null) {
                if (!$this->authorsScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->authorsScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[0] = $this->getBiblioId();
                        $entryPk[1] = $entry->getAuthorId();
                        $pks[] = $entryPk;
                    }

                    \Slims\Models\Masterfile\BiblioAuthor\BiblioAuthorQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->authorsScheduledForDeletion = null;
                }

            }

            if ($this->collAuthors) {
                foreach ($this->collAuthors as $author) {
                    if (!$author->isDeleted() && ($author->isNew() || $author->isModified())) {
                        $author->save($con);
                    }
                }
            }


            if ($this->topicsScheduledForDeletion !== null) {
                if (!$this->topicsScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->topicsScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[0] = $this->getBiblioId();
                        $entryPk[1] = $entry->getTopicId();
                        $pks[] = $entryPk;
                    }

                    \Slims\Models\Masterfile\BiblioTopic\BiblioTopicQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->topicsScheduledForDeletion = null;
                }

            }

            if ($this->collTopics) {
                foreach ($this->collTopics as $topic) {
                    if (!$topic->isDeleted() && ($topic->isNew() || $topic->isModified())) {
                        $topic->save($con);
                    }
                }
            }


            if ($this->biblioAuthorsScheduledForDeletion !== null) {
                if (!$this->biblioAuthorsScheduledForDeletion->isEmpty()) {
                    \Slims\Models\Masterfile\BiblioAuthor\BiblioAuthorQuery::create()
                        ->filterByPrimaryKeys($this->biblioAuthorsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->biblioAuthorsScheduledForDeletion = null;
                }
            }

            if ($this->collBiblioAuthors !== null) {
                foreach ($this->collBiblioAuthors as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->biblioTopicsScheduledForDeletion !== null) {
                if (!$this->biblioTopicsScheduledForDeletion->isEmpty()) {
                    \Slims\Models\Masterfile\BiblioTopic\BiblioTopicQuery::create()
                        ->filterByPrimaryKeys($this->biblioTopicsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->biblioTopicsScheduledForDeletion = null;
                }
            }

            if ($this->collBiblioTopics !== null) {
                foreach ($this->collBiblioTopics as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->itemsScheduledForDeletion !== null) {
                if (!$this->itemsScheduledForDeletion->isEmpty()) {
                    \Slims\Models\Bibliography\Item\ItemQuery::create()
                        ->filterByPrimaryKeys($this->itemsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->itemsScheduledForDeletion = null;
                }
            }

            if ($this->collItems !== null) {
                foreach ($this->collItems as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[BiblioTableMap::COL_BIBLIO_ID] = true;
        if (null !== $this->biblio_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . BiblioTableMap::COL_BIBLIO_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(BiblioTableMap::COL_BIBLIO_ID)) {
            $modifiedColumns[':p' . $index++]  = 'biblio_id';
        }
        if ($this->isColumnModified(BiblioTableMap::COL_TITLE)) {
            $modifiedColumns[':p' . $index++]  = 'title';
        }
        if ($this->isColumnModified(BiblioTableMap::COL_SOR)) {
            $modifiedColumns[':p' . $index++]  = 'sor';
        }
        if ($this->isColumnModified(BiblioTableMap::COL_EDITION)) {
            $modifiedColumns[':p' . $index++]  = 'edition';
        }
        if ($this->isColumnModified(BiblioTableMap::COL_ISBN_ISSN)) {
            $modifiedColumns[':p' . $index++]  = 'isbn_issn';
        }
        if ($this->isColumnModified(BiblioTableMap::COL_PUBLISHER_ID)) {
            $modifiedColumns[':p' . $index++]  = 'publisher_id';
        }
        if ($this->isColumnModified(BiblioTableMap::COL_PUBLISH_YEAR)) {
            $modifiedColumns[':p' . $index++]  = 'publish_year';
        }
        if ($this->isColumnModified(BiblioTableMap::COL_COLLATION)) {
            $modifiedColumns[':p' . $index++]  = 'collation';
        }
        if ($this->isColumnModified(BiblioTableMap::COL_SERIES_TITLE)) {
            $modifiedColumns[':p' . $index++]  = 'series_title';
        }
        if ($this->isColumnModified(BiblioTableMap::COL_CALL_NUMBER)) {
            $modifiedColumns[':p' . $index++]  = 'call_number';
        }
        if ($this->isColumnModified(BiblioTableMap::COL_LANGUAGE_ID)) {
            $modifiedColumns[':p' . $index++]  = 'language_id';
        }
        if ($this->isColumnModified(BiblioTableMap::COL_SOURCE)) {
            $modifiedColumns[':p' . $index++]  = 'source';
        }
        if ($this->isColumnModified(BiblioTableMap::COL_PUBLISH_PLACE_ID)) {
            $modifiedColumns[':p' . $index++]  = 'publish_place_id';
        }
        if ($this->isColumnModified(BiblioTableMap::COL_CLASSIFICATION)) {
            $modifiedColumns[':p' . $index++]  = 'classification';
        }
        if ($this->isColumnModified(BiblioTableMap::COL_NOTES)) {
            $modifiedColumns[':p' . $index++]  = 'notes';
        }
        if ($this->isColumnModified(BiblioTableMap::COL_IMAGE)) {
            $modifiedColumns[':p' . $index++]  = 'image';
        }
        if ($this->isColumnModified(BiblioTableMap::COL_FILE_ATT)) {
            $modifiedColumns[':p' . $index++]  = 'file_att';
        }
        if ($this->isColumnModified(BiblioTableMap::COL_OPAC_HIDE)) {
            $modifiedColumns[':p' . $index++]  = 'opac_hide';
        }
        if ($this->isColumnModified(BiblioTableMap::COL_PROMOTED)) {
            $modifiedColumns[':p' . $index++]  = 'promoted';
        }
        if ($this->isColumnModified(BiblioTableMap::COL_LABELS)) {
            $modifiedColumns[':p' . $index++]  = 'labels';
        }
        if ($this->isColumnModified(BiblioTableMap::COL_FREQUENCY_ID)) {
            $modifiedColumns[':p' . $index++]  = 'frequency_id';
        }
        if ($this->isColumnModified(BiblioTableMap::COL_SPEC_DETAIL_INFO)) {
            $modifiedColumns[':p' . $index++]  = 'spec_detail_info';
        }
        if ($this->isColumnModified(BiblioTableMap::COL_INPUT_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'input_date';
        }
        if ($this->isColumnModified(BiblioTableMap::COL_LAST_UPDATE)) {
            $modifiedColumns[':p' . $index++]  = 'last_update';
        }
        if ($this->isColumnModified(BiblioTableMap::COL_UID)) {
            $modifiedColumns[':p' . $index++]  = 'uid';
        }

        $sql = sprintf(
            'INSERT INTO biblio (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'biblio_id':
                        $stmt->bindValue($identifier, $this->biblio_id, PDO::PARAM_INT);
                        break;
                    case 'title':
                        $stmt->bindValue($identifier, $this->title, PDO::PARAM_STR);
                        break;
                    case 'sor':
                        $stmt->bindValue($identifier, $this->sor, PDO::PARAM_STR);
                        break;
                    case 'edition':
                        $stmt->bindValue($identifier, $this->edition, PDO::PARAM_STR);
                        break;
                    case 'isbn_issn':
                        $stmt->bindValue($identifier, $this->isbn_issn, PDO::PARAM_STR);
                        break;
                    case 'publisher_id':
                        $stmt->bindValue($identifier, $this->publisher_id, PDO::PARAM_INT);
                        break;
                    case 'publish_year':
                        $stmt->bindValue($identifier, $this->publish_year, PDO::PARAM_STR);
                        break;
                    case 'collation':
                        $stmt->bindValue($identifier, $this->collation, PDO::PARAM_STR);
                        break;
                    case 'series_title':
                        $stmt->bindValue($identifier, $this->series_title, PDO::PARAM_STR);
                        break;
                    case 'call_number':
                        $stmt->bindValue($identifier, $this->call_number, PDO::PARAM_STR);
                        break;
                    case 'language_id':
                        $stmt->bindValue($identifier, $this->language_id, PDO::PARAM_STR);
                        break;
                    case 'source':
                        $stmt->bindValue($identifier, $this->source, PDO::PARAM_STR);
                        break;
                    case 'publish_place_id':
                        $stmt->bindValue($identifier, $this->publish_place_id, PDO::PARAM_INT);
                        break;
                    case 'classification':
                        $stmt->bindValue($identifier, $this->classification, PDO::PARAM_STR);
                        break;
                    case 'notes':
                        $stmt->bindValue($identifier, $this->notes, PDO::PARAM_STR);
                        break;
                    case 'image':
                        $stmt->bindValue($identifier, $this->image, PDO::PARAM_STR);
                        break;
                    case 'file_att':
                        $stmt->bindValue($identifier, $this->file_att, PDO::PARAM_STR);
                        break;
                    case 'opac_hide':
                        $stmt->bindValue($identifier, $this->opac_hide, PDO::PARAM_INT);
                        break;
                    case 'promoted':
                        $stmt->bindValue($identifier, $this->promoted, PDO::PARAM_INT);
                        break;
                    case 'labels':
                        $stmt->bindValue($identifier, $this->labels, PDO::PARAM_STR);
                        break;
                    case 'frequency_id':
                        $stmt->bindValue($identifier, $this->frequency_id, PDO::PARAM_INT);
                        break;
                    case 'spec_detail_info':
                        $stmt->bindValue($identifier, $this->spec_detail_info, PDO::PARAM_STR);
                        break;
                    case 'input_date':
                        $stmt->bindValue($identifier, $this->input_date ? $this->input_date->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'last_update':
                        $stmt->bindValue($identifier, $this->last_update ? $this->last_update->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'uid':
                        $stmt->bindValue($identifier, $this->uid, PDO::PARAM_INT);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setBiblioId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = BiblioTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getBiblioId();
                break;
            case 1:
                return $this->getTitle();
                break;
            case 2:
                return $this->getSor();
                break;
            case 3:
                return $this->getEdition();
                break;
            case 4:
                return $this->getIsbn_issn();
                break;
            case 5:
                return $this->getPublisherId();
                break;
            case 6:
                return $this->getPublish_year();
                break;
            case 7:
                return $this->getCollation();
                break;
            case 8:
                return $this->getSeries_title();
                break;
            case 9:
                return $this->getCall_number();
                break;
            case 10:
                return $this->getLanguageId();
                break;
            case 11:
                return $this->getSource();
                break;
            case 12:
                return $this->getPublishPlaceId();
                break;
            case 13:
                return $this->getClassification();
                break;
            case 14:
                return $this->getNotes();
                break;
            case 15:
                return $this->getImage();
                break;
            case 16:
                return $this->getFile_att();
                break;
            case 17:
                return $this->getOpac_hide();
                break;
            case 18:
                return $this->getPromoted();
                break;
            case 19:
                return $this->getLabels();
                break;
            case 20:
                return $this->getFrequencyId();
                break;
            case 21:
                return $this->getSpec_detail_info();
                break;
            case 22:
                return $this->getInput_date();
                break;
            case 23:
                return $this->getLast_update();
                break;
            case 24:
                return $this->getUid();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['Biblio'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Biblio'][$this->hashCode()] = true;
        $keys = BiblioTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getBiblioId(),
            $keys[1] => $this->getTitle(),
            $keys[2] => $this->getSor(),
            $keys[3] => $this->getEdition(),
            $keys[4] => $this->getIsbn_issn(),
            $keys[5] => $this->getPublisherId(),
            $keys[6] => $this->getPublish_year(),
            $keys[7] => $this->getCollation(),
            $keys[8] => $this->getSeries_title(),
            $keys[9] => $this->getCall_number(),
            $keys[10] => $this->getLanguageId(),
            $keys[11] => $this->getSource(),
            $keys[12] => $this->getPublishPlaceId(),
            $keys[13] => $this->getClassification(),
            $keys[14] => $this->getNotes(),
            $keys[15] => $this->getImage(),
            $keys[16] => $this->getFile_att(),
            $keys[17] => $this->getOpac_hide(),
            $keys[18] => $this->getPromoted(),
            $keys[19] => $this->getLabels(),
            $keys[20] => $this->getFrequencyId(),
            $keys[21] => $this->getSpec_detail_info(),
            $keys[22] => $this->getInput_date(),
            $keys[23] => $this->getLast_update(),
            $keys[24] => $this->getUid(),
        );
        if ($result[$keys[22]] instanceof \DateTime) {
            $result[$keys[22]] = $result[$keys[22]]->format('c');
        }

        if ($result[$keys[23]] instanceof \DateTime) {
            $result[$keys[23]] = $result[$keys[23]]->format('c');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aPublisher) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'publisher';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'mst_publisher';
                        break;
                    default:
                        $key = 'Publisher';
                }

                $result[$key] = $this->aPublisher->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aLanguage) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'language';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'mst_language';
                        break;
                    default:
                        $key = 'Language';
                }

                $result[$key] = $this->aLanguage->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aPlace) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'place';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'mst_place';
                        break;
                    default:
                        $key = 'Place';
                }

                $result[$key] = $this->aPlace->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aFrequency) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'frequency';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'mst_frequency';
                        break;
                    default:
                        $key = 'Frequency';
                }

                $result[$key] = $this->aFrequency->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aUser) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'user';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'user';
                        break;
                    default:
                        $key = 'User';
                }

                $result[$key] = $this->aUser->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collBiblioAuthors) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'biblioAuthors';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'biblio_authors';
                        break;
                    default:
                        $key = 'BiblioAuthors';
                }

                $result[$key] = $this->collBiblioAuthors->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collBiblioTopics) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'biblioTopics';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'biblio_topics';
                        break;
                    default:
                        $key = 'BiblioTopics';
                }

                $result[$key] = $this->collBiblioTopics->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collItems) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'items';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'items';
                        break;
                    default:
                        $key = 'Items';
                }

                $result[$key] = $this->collItems->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\Slims\Models\Bibliography\Biblio\Biblio
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = BiblioTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Slims\Models\Bibliography\Biblio\Biblio
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setBiblioId($value);
                break;
            case 1:
                $this->setTitle($value);
                break;
            case 2:
                $this->setSor($value);
                break;
            case 3:
                $this->setEdition($value);
                break;
            case 4:
                $this->setIsbn_issn($value);
                break;
            case 5:
                $this->setPublisherId($value);
                break;
            case 6:
                $this->setPublish_year($value);
                break;
            case 7:
                $this->setCollation($value);
                break;
            case 8:
                $this->setSeries_title($value);
                break;
            case 9:
                $this->setCall_number($value);
                break;
            case 10:
                $this->setLanguageId($value);
                break;
            case 11:
                $this->setSource($value);
                break;
            case 12:
                $this->setPublishPlaceId($value);
                break;
            case 13:
                $this->setClassification($value);
                break;
            case 14:
                $this->setNotes($value);
                break;
            case 15:
                $this->setImage($value);
                break;
            case 16:
                $this->setFile_att($value);
                break;
            case 17:
                $this->setOpac_hide($value);
                break;
            case 18:
                $this->setPromoted($value);
                break;
            case 19:
                $this->setLabels($value);
                break;
            case 20:
                $this->setFrequencyId($value);
                break;
            case 21:
                $this->setSpec_detail_info($value);
                break;
            case 22:
                $this->setInput_date($value);
                break;
            case 23:
                $this->setLast_update($value);
                break;
            case 24:
                $this->setUid($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = BiblioTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setBiblioId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setTitle($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setSor($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setEdition($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setIsbn_issn($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setPublisherId($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setPublish_year($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setCollation($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setSeries_title($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setCall_number($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setLanguageId($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setSource($arr[$keys[11]]);
        }
        if (array_key_exists($keys[12], $arr)) {
            $this->setPublishPlaceId($arr[$keys[12]]);
        }
        if (array_key_exists($keys[13], $arr)) {
            $this->setClassification($arr[$keys[13]]);
        }
        if (array_key_exists($keys[14], $arr)) {
            $this->setNotes($arr[$keys[14]]);
        }
        if (array_key_exists($keys[15], $arr)) {
            $this->setImage($arr[$keys[15]]);
        }
        if (array_key_exists($keys[16], $arr)) {
            $this->setFile_att($arr[$keys[16]]);
        }
        if (array_key_exists($keys[17], $arr)) {
            $this->setOpac_hide($arr[$keys[17]]);
        }
        if (array_key_exists($keys[18], $arr)) {
            $this->setPromoted($arr[$keys[18]]);
        }
        if (array_key_exists($keys[19], $arr)) {
            $this->setLabels($arr[$keys[19]]);
        }
        if (array_key_exists($keys[20], $arr)) {
            $this->setFrequencyId($arr[$keys[20]]);
        }
        if (array_key_exists($keys[21], $arr)) {
            $this->setSpec_detail_info($arr[$keys[21]]);
        }
        if (array_key_exists($keys[22], $arr)) {
            $this->setInput_date($arr[$keys[22]]);
        }
        if (array_key_exists($keys[23], $arr)) {
            $this->setLast_update($arr[$keys[23]]);
        }
        if (array_key_exists($keys[24], $arr)) {
            $this->setUid($arr[$keys[24]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\Slims\Models\Bibliography\Biblio\Biblio The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(BiblioTableMap::DATABASE_NAME);

        if ($this->isColumnModified(BiblioTableMap::COL_BIBLIO_ID)) {
            $criteria->add(BiblioTableMap::COL_BIBLIO_ID, $this->biblio_id);
        }
        if ($this->isColumnModified(BiblioTableMap::COL_TITLE)) {
            $criteria->add(BiblioTableMap::COL_TITLE, $this->title);
        }
        if ($this->isColumnModified(BiblioTableMap::COL_SOR)) {
            $criteria->add(BiblioTableMap::COL_SOR, $this->sor);
        }
        if ($this->isColumnModified(BiblioTableMap::COL_EDITION)) {
            $criteria->add(BiblioTableMap::COL_EDITION, $this->edition);
        }
        if ($this->isColumnModified(BiblioTableMap::COL_ISBN_ISSN)) {
            $criteria->add(BiblioTableMap::COL_ISBN_ISSN, $this->isbn_issn);
        }
        if ($this->isColumnModified(BiblioTableMap::COL_PUBLISHER_ID)) {
            $criteria->add(BiblioTableMap::COL_PUBLISHER_ID, $this->publisher_id);
        }
        if ($this->isColumnModified(BiblioTableMap::COL_PUBLISH_YEAR)) {
            $criteria->add(BiblioTableMap::COL_PUBLISH_YEAR, $this->publish_year);
        }
        if ($this->isColumnModified(BiblioTableMap::COL_COLLATION)) {
            $criteria->add(BiblioTableMap::COL_COLLATION, $this->collation);
        }
        if ($this->isColumnModified(BiblioTableMap::COL_SERIES_TITLE)) {
            $criteria->add(BiblioTableMap::COL_SERIES_TITLE, $this->series_title);
        }
        if ($this->isColumnModified(BiblioTableMap::COL_CALL_NUMBER)) {
            $criteria->add(BiblioTableMap::COL_CALL_NUMBER, $this->call_number);
        }
        if ($this->isColumnModified(BiblioTableMap::COL_LANGUAGE_ID)) {
            $criteria->add(BiblioTableMap::COL_LANGUAGE_ID, $this->language_id);
        }
        if ($this->isColumnModified(BiblioTableMap::COL_SOURCE)) {
            $criteria->add(BiblioTableMap::COL_SOURCE, $this->source);
        }
        if ($this->isColumnModified(BiblioTableMap::COL_PUBLISH_PLACE_ID)) {
            $criteria->add(BiblioTableMap::COL_PUBLISH_PLACE_ID, $this->publish_place_id);
        }
        if ($this->isColumnModified(BiblioTableMap::COL_CLASSIFICATION)) {
            $criteria->add(BiblioTableMap::COL_CLASSIFICATION, $this->classification);
        }
        if ($this->isColumnModified(BiblioTableMap::COL_NOTES)) {
            $criteria->add(BiblioTableMap::COL_NOTES, $this->notes);
        }
        if ($this->isColumnModified(BiblioTableMap::COL_IMAGE)) {
            $criteria->add(BiblioTableMap::COL_IMAGE, $this->image);
        }
        if ($this->isColumnModified(BiblioTableMap::COL_FILE_ATT)) {
            $criteria->add(BiblioTableMap::COL_FILE_ATT, $this->file_att);
        }
        if ($this->isColumnModified(BiblioTableMap::COL_OPAC_HIDE)) {
            $criteria->add(BiblioTableMap::COL_OPAC_HIDE, $this->opac_hide);
        }
        if ($this->isColumnModified(BiblioTableMap::COL_PROMOTED)) {
            $criteria->add(BiblioTableMap::COL_PROMOTED, $this->promoted);
        }
        if ($this->isColumnModified(BiblioTableMap::COL_LABELS)) {
            $criteria->add(BiblioTableMap::COL_LABELS, $this->labels);
        }
        if ($this->isColumnModified(BiblioTableMap::COL_FREQUENCY_ID)) {
            $criteria->add(BiblioTableMap::COL_FREQUENCY_ID, $this->frequency_id);
        }
        if ($this->isColumnModified(BiblioTableMap::COL_SPEC_DETAIL_INFO)) {
            $criteria->add(BiblioTableMap::COL_SPEC_DETAIL_INFO, $this->spec_detail_info);
        }
        if ($this->isColumnModified(BiblioTableMap::COL_INPUT_DATE)) {
            $criteria->add(BiblioTableMap::COL_INPUT_DATE, $this->input_date);
        }
        if ($this->isColumnModified(BiblioTableMap::COL_LAST_UPDATE)) {
            $criteria->add(BiblioTableMap::COL_LAST_UPDATE, $this->last_update);
        }
        if ($this->isColumnModified(BiblioTableMap::COL_UID)) {
            $criteria->add(BiblioTableMap::COL_UID, $this->uid);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildBiblioQuery::create();
        $criteria->add(BiblioTableMap::COL_BIBLIO_ID, $this->biblio_id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getBiblioId();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getBiblioId();
    }

    /**
     * Generic method to set the primary key (biblio_id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setBiblioId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getBiblioId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Slims\Models\Bibliography\Biblio\Biblio (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setTitle($this->getTitle());
        $copyObj->setSor($this->getSor());
        $copyObj->setEdition($this->getEdition());
        $copyObj->setIsbn_issn($this->getIsbn_issn());
        $copyObj->setPublisherId($this->getPublisherId());
        $copyObj->setPublish_year($this->getPublish_year());
        $copyObj->setCollation($this->getCollation());
        $copyObj->setSeries_title($this->getSeries_title());
        $copyObj->setCall_number($this->getCall_number());
        $copyObj->setLanguageId($this->getLanguageId());
        $copyObj->setSource($this->getSource());
        $copyObj->setPublishPlaceId($this->getPublishPlaceId());
        $copyObj->setClassification($this->getClassification());
        $copyObj->setNotes($this->getNotes());
        $copyObj->setImage($this->getImage());
        $copyObj->setFile_att($this->getFile_att());
        $copyObj->setOpac_hide($this->getOpac_hide());
        $copyObj->setPromoted($this->getPromoted());
        $copyObj->setLabels($this->getLabels());
        $copyObj->setFrequencyId($this->getFrequencyId());
        $copyObj->setSpec_detail_info($this->getSpec_detail_info());
        $copyObj->setInput_date($this->getInput_date());
        $copyObj->setLast_update($this->getLast_update());
        $copyObj->setUid($this->getUid());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getBiblioAuthors() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addBiblioAuthor($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getBiblioTopics() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addBiblioTopic($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getItems() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addItem($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setBiblioId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \Slims\Models\Bibliography\Biblio\Biblio Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Declares an association between this object and a Publisher object.
     *
     * @param  Publisher $v
     * @return $this|\Slims\Models\Bibliography\Biblio\Biblio The current object (for fluent API support)
     * @throws PropelException
     */
    public function setPublisher(Publisher $v = null)
    {
        if ($v === null) {
            $this->setPublisherId(NULL);
        } else {
            $this->setPublisherId($v->getPublisherId());
        }

        $this->aPublisher = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Publisher object, it will not be re-added.
        if ($v !== null) {
            $v->addBiblio($this);
        }


        return $this;
    }


    /**
     * Get the associated Publisher object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return Publisher The associated Publisher object.
     * @throws PropelException
     */
    public function getPublisher(ConnectionInterface $con = null)
    {
        if ($this->aPublisher === null && ($this->publisher_id !== null)) {
            $this->aPublisher = PublisherQuery::create()->findPk($this->publisher_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aPublisher->addBiblios($this);
             */
        }

        return $this->aPublisher;
    }

    /**
     * Declares an association between this object and a Language object.
     *
     * @param  Language $v
     * @return $this|\Slims\Models\Bibliography\Biblio\Biblio The current object (for fluent API support)
     * @throws PropelException
     */
    public function setLanguage(Language $v = null)
    {
        if ($v === null) {
            $this->setLanguageId(NULL);
        } else {
            $this->setLanguageId($v->getLanguageId());
        }

        $this->aLanguage = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Language object, it will not be re-added.
        if ($v !== null) {
            $v->addBiblio($this);
        }


        return $this;
    }


    /**
     * Get the associated Language object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return Language The associated Language object.
     * @throws PropelException
     */
    public function getLanguage(ConnectionInterface $con = null)
    {
        if ($this->aLanguage === null && (($this->language_id !== "" && $this->language_id !== null))) {
            $this->aLanguage = LanguageQuery::create()->findPk($this->language_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aLanguage->addBiblios($this);
             */
        }

        return $this->aLanguage;
    }

    /**
     * Declares an association between this object and a Place object.
     *
     * @param  Place $v
     * @return $this|\Slims\Models\Bibliography\Biblio\Biblio The current object (for fluent API support)
     * @throws PropelException
     */
    public function setPlace(Place $v = null)
    {
        if ($v === null) {
            $this->setPublishPlaceId(NULL);
        } else {
            $this->setPublishPlaceId($v->getPlaceId());
        }

        $this->aPlace = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Place object, it will not be re-added.
        if ($v !== null) {
            $v->addBiblio($this);
        }


        return $this;
    }


    /**
     * Get the associated Place object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return Place The associated Place object.
     * @throws PropelException
     */
    public function getPlace(ConnectionInterface $con = null)
    {
        if ($this->aPlace === null && ($this->publish_place_id !== null)) {
            $this->aPlace = PlaceQuery::create()->findPk($this->publish_place_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aPlace->addBiblios($this);
             */
        }

        return $this->aPlace;
    }

    /**
     * Declares an association between this object and a Frequency object.
     *
     * @param  Frequency $v
     * @return $this|\Slims\Models\Bibliography\Biblio\Biblio The current object (for fluent API support)
     * @throws PropelException
     */
    public function setFrequency(Frequency $v = null)
    {
        if ($v === null) {
            $this->setFrequencyId(NULL);
        } else {
            $this->setFrequencyId($v->getFrequencyId());
        }

        $this->aFrequency = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Frequency object, it will not be re-added.
        if ($v !== null) {
            $v->addBiblio($this);
        }


        return $this;
    }


    /**
     * Get the associated Frequency object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return Frequency The associated Frequency object.
     * @throws PropelException
     */
    public function getFrequency(ConnectionInterface $con = null)
    {
        if ($this->aFrequency === null && ($this->frequency_id !== null)) {
            $this->aFrequency = FrequencyQuery::create()->findPk($this->frequency_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aFrequency->addBiblios($this);
             */
        }

        return $this->aFrequency;
    }

    /**
     * Declares an association between this object and a User object.
     *
     * @param  User $v
     * @return $this|\Slims\Models\Bibliography\Biblio\Biblio The current object (for fluent API support)
     * @throws PropelException
     */
    public function setUser(User $v = null)
    {
        if ($v === null) {
            $this->setUid(NULL);
        } else {
            $this->setUid($v->getUserId());
        }

        $this->aUser = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the User object, it will not be re-added.
        if ($v !== null) {
            $v->addBiblio($this);
        }


        return $this;
    }


    /**
     * Get the associated User object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return User The associated User object.
     * @throws PropelException
     */
    public function getUser(ConnectionInterface $con = null)
    {
        if ($this->aUser === null && ($this->uid !== null)) {
            $this->aUser = UserQuery::create()->findPk($this->uid, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aUser->addBiblios($this);
             */
        }

        return $this->aUser;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('BiblioAuthor' == $relationName) {
            return $this->initBiblioAuthors();
        }
        if ('BiblioTopic' == $relationName) {
            return $this->initBiblioTopics();
        }
        if ('Item' == $relationName) {
            return $this->initItems();
        }
    }

    /**
     * Clears out the collBiblioAuthors collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addBiblioAuthors()
     */
    public function clearBiblioAuthors()
    {
        $this->collBiblioAuthors = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collBiblioAuthors collection loaded partially.
     */
    public function resetPartialBiblioAuthors($v = true)
    {
        $this->collBiblioAuthorsPartial = $v;
    }

    /**
     * Initializes the collBiblioAuthors collection.
     *
     * By default this just sets the collBiblioAuthors collection to an empty array (like clearcollBiblioAuthors());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initBiblioAuthors($overrideExisting = true)
    {
        if (null !== $this->collBiblioAuthors && !$overrideExisting) {
            return;
        }

        $collectionClassName = BiblioAuthorTableMap::getTableMap()->getCollectionClassName();

        $this->collBiblioAuthors = new $collectionClassName;
        $this->collBiblioAuthors->setModel('\Slims\Models\Masterfile\BiblioAuthor\BiblioAuthor');
    }

    /**
     * Gets an array of BiblioAuthor objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildBiblio is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|BiblioAuthor[] List of BiblioAuthor objects
     * @throws PropelException
     */
    public function getBiblioAuthors(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collBiblioAuthorsPartial && !$this->isNew();
        if (null === $this->collBiblioAuthors || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collBiblioAuthors) {
                // return empty collection
                $this->initBiblioAuthors();
            } else {
                $collBiblioAuthors = BiblioAuthorQuery::create(null, $criteria)
                    ->filterByBiblio($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collBiblioAuthorsPartial && count($collBiblioAuthors)) {
                        $this->initBiblioAuthors(false);

                        foreach ($collBiblioAuthors as $obj) {
                            if (false == $this->collBiblioAuthors->contains($obj)) {
                                $this->collBiblioAuthors->append($obj);
                            }
                        }

                        $this->collBiblioAuthorsPartial = true;
                    }

                    return $collBiblioAuthors;
                }

                if ($partial && $this->collBiblioAuthors) {
                    foreach ($this->collBiblioAuthors as $obj) {
                        if ($obj->isNew()) {
                            $collBiblioAuthors[] = $obj;
                        }
                    }
                }

                $this->collBiblioAuthors = $collBiblioAuthors;
                $this->collBiblioAuthorsPartial = false;
            }
        }

        return $this->collBiblioAuthors;
    }

    /**
     * Sets a collection of BiblioAuthor objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $biblioAuthors A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildBiblio The current object (for fluent API support)
     */
    public function setBiblioAuthors(Collection $biblioAuthors, ConnectionInterface $con = null)
    {
        /** @var BiblioAuthor[] $biblioAuthorsToDelete */
        $biblioAuthorsToDelete = $this->getBiblioAuthors(new Criteria(), $con)->diff($biblioAuthors);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->biblioAuthorsScheduledForDeletion = clone $biblioAuthorsToDelete;

        foreach ($biblioAuthorsToDelete as $biblioAuthorRemoved) {
            $biblioAuthorRemoved->setBiblio(null);
        }

        $this->collBiblioAuthors = null;
        foreach ($biblioAuthors as $biblioAuthor) {
            $this->addBiblioAuthor($biblioAuthor);
        }

        $this->collBiblioAuthors = $biblioAuthors;
        $this->collBiblioAuthorsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related BaseBiblioAuthor objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related BaseBiblioAuthor objects.
     * @throws PropelException
     */
    public function countBiblioAuthors(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collBiblioAuthorsPartial && !$this->isNew();
        if (null === $this->collBiblioAuthors || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collBiblioAuthors) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getBiblioAuthors());
            }

            $query = BiblioAuthorQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByBiblio($this)
                ->count($con);
        }

        return count($this->collBiblioAuthors);
    }

    /**
     * Method called to associate a BiblioAuthor object to this object
     * through the BiblioAuthor foreign key attribute.
     *
     * @param  BiblioAuthor $l BiblioAuthor
     * @return $this|\Slims\Models\Bibliography\Biblio\Biblio The current object (for fluent API support)
     */
    public function addBiblioAuthor(BiblioAuthor $l)
    {
        if ($this->collBiblioAuthors === null) {
            $this->initBiblioAuthors();
            $this->collBiblioAuthorsPartial = true;
        }

        if (!$this->collBiblioAuthors->contains($l)) {
            $this->doAddBiblioAuthor($l);

            if ($this->biblioAuthorsScheduledForDeletion and $this->biblioAuthorsScheduledForDeletion->contains($l)) {
                $this->biblioAuthorsScheduledForDeletion->remove($this->biblioAuthorsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param BiblioAuthor $biblioAuthor The BiblioAuthor object to add.
     */
    protected function doAddBiblioAuthor(BiblioAuthor $biblioAuthor)
    {
        $this->collBiblioAuthors[]= $biblioAuthor;
        $biblioAuthor->setBiblio($this);
    }

    /**
     * @param  BiblioAuthor $biblioAuthor The BiblioAuthor object to remove.
     * @return $this|ChildBiblio The current object (for fluent API support)
     */
    public function removeBiblioAuthor(BiblioAuthor $biblioAuthor)
    {
        if ($this->getBiblioAuthors()->contains($biblioAuthor)) {
            $pos = $this->collBiblioAuthors->search($biblioAuthor);
            $this->collBiblioAuthors->remove($pos);
            if (null === $this->biblioAuthorsScheduledForDeletion) {
                $this->biblioAuthorsScheduledForDeletion = clone $this->collBiblioAuthors;
                $this->biblioAuthorsScheduledForDeletion->clear();
            }
            $this->biblioAuthorsScheduledForDeletion[]= clone $biblioAuthor;
            $biblioAuthor->setBiblio(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Biblio is new, it will return
     * an empty collection; or if this Biblio has previously
     * been saved, it will retrieve related BiblioAuthors from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Biblio.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|BiblioAuthor[] List of BiblioAuthor objects
     */
    public function getBiblioAuthorsJoinAuthor(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = BiblioAuthorQuery::create(null, $criteria);
        $query->joinWith('Author', $joinBehavior);

        return $this->getBiblioAuthors($query, $con);
    }

    /**
     * Clears out the collBiblioTopics collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addBiblioTopics()
     */
    public function clearBiblioTopics()
    {
        $this->collBiblioTopics = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collBiblioTopics collection loaded partially.
     */
    public function resetPartialBiblioTopics($v = true)
    {
        $this->collBiblioTopicsPartial = $v;
    }

    /**
     * Initializes the collBiblioTopics collection.
     *
     * By default this just sets the collBiblioTopics collection to an empty array (like clearcollBiblioTopics());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initBiblioTopics($overrideExisting = true)
    {
        if (null !== $this->collBiblioTopics && !$overrideExisting) {
            return;
        }

        $collectionClassName = BiblioTopicTableMap::getTableMap()->getCollectionClassName();

        $this->collBiblioTopics = new $collectionClassName;
        $this->collBiblioTopics->setModel('\Slims\Models\Masterfile\BiblioTopic\BiblioTopic');
    }

    /**
     * Gets an array of BiblioTopic objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildBiblio is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|BiblioTopic[] List of BiblioTopic objects
     * @throws PropelException
     */
    public function getBiblioTopics(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collBiblioTopicsPartial && !$this->isNew();
        if (null === $this->collBiblioTopics || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collBiblioTopics) {
                // return empty collection
                $this->initBiblioTopics();
            } else {
                $collBiblioTopics = BiblioTopicQuery::create(null, $criteria)
                    ->filterByBiblio($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collBiblioTopicsPartial && count($collBiblioTopics)) {
                        $this->initBiblioTopics(false);

                        foreach ($collBiblioTopics as $obj) {
                            if (false == $this->collBiblioTopics->contains($obj)) {
                                $this->collBiblioTopics->append($obj);
                            }
                        }

                        $this->collBiblioTopicsPartial = true;
                    }

                    return $collBiblioTopics;
                }

                if ($partial && $this->collBiblioTopics) {
                    foreach ($this->collBiblioTopics as $obj) {
                        if ($obj->isNew()) {
                            $collBiblioTopics[] = $obj;
                        }
                    }
                }

                $this->collBiblioTopics = $collBiblioTopics;
                $this->collBiblioTopicsPartial = false;
            }
        }

        return $this->collBiblioTopics;
    }

    /**
     * Sets a collection of BiblioTopic objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $biblioTopics A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildBiblio The current object (for fluent API support)
     */
    public function setBiblioTopics(Collection $biblioTopics, ConnectionInterface $con = null)
    {
        /** @var BiblioTopic[] $biblioTopicsToDelete */
        $biblioTopicsToDelete = $this->getBiblioTopics(new Criteria(), $con)->diff($biblioTopics);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->biblioTopicsScheduledForDeletion = clone $biblioTopicsToDelete;

        foreach ($biblioTopicsToDelete as $biblioTopicRemoved) {
            $biblioTopicRemoved->setBiblio(null);
        }

        $this->collBiblioTopics = null;
        foreach ($biblioTopics as $biblioTopic) {
            $this->addBiblioTopic($biblioTopic);
        }

        $this->collBiblioTopics = $biblioTopics;
        $this->collBiblioTopicsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related BaseBiblioTopic objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related BaseBiblioTopic objects.
     * @throws PropelException
     */
    public function countBiblioTopics(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collBiblioTopicsPartial && !$this->isNew();
        if (null === $this->collBiblioTopics || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collBiblioTopics) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getBiblioTopics());
            }

            $query = BiblioTopicQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByBiblio($this)
                ->count($con);
        }

        return count($this->collBiblioTopics);
    }

    /**
     * Method called to associate a BiblioTopic object to this object
     * through the BiblioTopic foreign key attribute.
     *
     * @param  BiblioTopic $l BiblioTopic
     * @return $this|\Slims\Models\Bibliography\Biblio\Biblio The current object (for fluent API support)
     */
    public function addBiblioTopic(BiblioTopic $l)
    {
        if ($this->collBiblioTopics === null) {
            $this->initBiblioTopics();
            $this->collBiblioTopicsPartial = true;
        }

        if (!$this->collBiblioTopics->contains($l)) {
            $this->doAddBiblioTopic($l);

            if ($this->biblioTopicsScheduledForDeletion and $this->biblioTopicsScheduledForDeletion->contains($l)) {
                $this->biblioTopicsScheduledForDeletion->remove($this->biblioTopicsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param BiblioTopic $biblioTopic The BiblioTopic object to add.
     */
    protected function doAddBiblioTopic(BiblioTopic $biblioTopic)
    {
        $this->collBiblioTopics[]= $biblioTopic;
        $biblioTopic->setBiblio($this);
    }

    /**
     * @param  BiblioTopic $biblioTopic The BiblioTopic object to remove.
     * @return $this|ChildBiblio The current object (for fluent API support)
     */
    public function removeBiblioTopic(BiblioTopic $biblioTopic)
    {
        if ($this->getBiblioTopics()->contains($biblioTopic)) {
            $pos = $this->collBiblioTopics->search($biblioTopic);
            $this->collBiblioTopics->remove($pos);
            if (null === $this->biblioTopicsScheduledForDeletion) {
                $this->biblioTopicsScheduledForDeletion = clone $this->collBiblioTopics;
                $this->biblioTopicsScheduledForDeletion->clear();
            }
            $this->biblioTopicsScheduledForDeletion[]= clone $biblioTopic;
            $biblioTopic->setBiblio(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Biblio is new, it will return
     * an empty collection; or if this Biblio has previously
     * been saved, it will retrieve related BiblioTopics from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Biblio.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|BiblioTopic[] List of BiblioTopic objects
     */
    public function getBiblioTopicsJoinTopic(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = BiblioTopicQuery::create(null, $criteria);
        $query->joinWith('Topic', $joinBehavior);

        return $this->getBiblioTopics($query, $con);
    }

    /**
     * Clears out the collItems collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addItems()
     */
    public function clearItems()
    {
        $this->collItems = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collItems collection loaded partially.
     */
    public function resetPartialItems($v = true)
    {
        $this->collItemsPartial = $v;
    }

    /**
     * Initializes the collItems collection.
     *
     * By default this just sets the collItems collection to an empty array (like clearcollItems());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initItems($overrideExisting = true)
    {
        if (null !== $this->collItems && !$overrideExisting) {
            return;
        }

        $collectionClassName = ItemTableMap::getTableMap()->getCollectionClassName();

        $this->collItems = new $collectionClassName;
        $this->collItems->setModel('\Slims\Models\Bibliography\Item\Item');
    }

    /**
     * Gets an array of Item objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildBiblio is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|Item[] List of Item objects
     * @throws PropelException
     */
    public function getItems(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collItemsPartial && !$this->isNew();
        if (null === $this->collItems || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collItems) {
                // return empty collection
                $this->initItems();
            } else {
                $collItems = ItemQuery::create(null, $criteria)
                    ->filterByBiblio($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collItemsPartial && count($collItems)) {
                        $this->initItems(false);

                        foreach ($collItems as $obj) {
                            if (false == $this->collItems->contains($obj)) {
                                $this->collItems->append($obj);
                            }
                        }

                        $this->collItemsPartial = true;
                    }

                    return $collItems;
                }

                if ($partial && $this->collItems) {
                    foreach ($this->collItems as $obj) {
                        if ($obj->isNew()) {
                            $collItems[] = $obj;
                        }
                    }
                }

                $this->collItems = $collItems;
                $this->collItemsPartial = false;
            }
        }

        return $this->collItems;
    }

    /**
     * Sets a collection of Item objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $items A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildBiblio The current object (for fluent API support)
     */
    public function setItems(Collection $items, ConnectionInterface $con = null)
    {
        /** @var Item[] $itemsToDelete */
        $itemsToDelete = $this->getItems(new Criteria(), $con)->diff($items);


        $this->itemsScheduledForDeletion = $itemsToDelete;

        foreach ($itemsToDelete as $itemRemoved) {
            $itemRemoved->setBiblio(null);
        }

        $this->collItems = null;
        foreach ($items as $item) {
            $this->addItem($item);
        }

        $this->collItems = $items;
        $this->collItemsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related BaseItem objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related BaseItem objects.
     * @throws PropelException
     */
    public function countItems(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collItemsPartial && !$this->isNew();
        if (null === $this->collItems || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collItems) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getItems());
            }

            $query = ItemQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByBiblio($this)
                ->count($con);
        }

        return count($this->collItems);
    }

    /**
     * Method called to associate a Item object to this object
     * through the Item foreign key attribute.
     *
     * @param  Item $l Item
     * @return $this|\Slims\Models\Bibliography\Biblio\Biblio The current object (for fluent API support)
     */
    public function addItem(Item $l)
    {
        if ($this->collItems === null) {
            $this->initItems();
            $this->collItemsPartial = true;
        }

        if (!$this->collItems->contains($l)) {
            $this->doAddItem($l);

            if ($this->itemsScheduledForDeletion and $this->itemsScheduledForDeletion->contains($l)) {
                $this->itemsScheduledForDeletion->remove($this->itemsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param Item $item The Item object to add.
     */
    protected function doAddItem(Item $item)
    {
        $this->collItems[]= $item;
        $item->setBiblio($this);
    }

    /**
     * @param  Item $item The Item object to remove.
     * @return $this|ChildBiblio The current object (for fluent API support)
     */
    public function removeItem(Item $item)
    {
        if ($this->getItems()->contains($item)) {
            $pos = $this->collItems->search($item);
            $this->collItems->remove($pos);
            if (null === $this->itemsScheduledForDeletion) {
                $this->itemsScheduledForDeletion = clone $this->collItems;
                $this->itemsScheduledForDeletion->clear();
            }
            $this->itemsScheduledForDeletion[]= clone $item;
            $item->setBiblio(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Biblio is new, it will return
     * an empty collection; or if this Biblio has previously
     * been saved, it will retrieve related Items from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Biblio.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|Item[] List of Item objects
     */
    public function getItemsJoinUser(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ItemQuery::create(null, $criteria);
        $query->joinWith('User', $joinBehavior);

        return $this->getItems($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Biblio is new, it will return
     * an empty collection; or if this Biblio has previously
     * been saved, it will retrieve related Items from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Biblio.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|Item[] List of Item objects
     */
    public function getItemsJoinColltype(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ItemQuery::create(null, $criteria);
        $query->joinWith('Colltype', $joinBehavior);

        return $this->getItems($query, $con);
    }

    /**
     * Clears out the collAuthors collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addAuthors()
     */
    public function clearAuthors()
    {
        $this->collAuthors = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collAuthors crossRef collection.
     *
     * By default this just sets the collAuthors collection to an empty collection (like clearAuthors());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initAuthors()
    {
        $collectionClassName = BiblioAuthorTableMap::getTableMap()->getCollectionClassName();

        $this->collAuthors = new $collectionClassName;
        $this->collAuthorsPartial = true;
        $this->collAuthors->setModel('\Slims\Models\Masterfile\Author\Author');
    }

    /**
     * Checks if the collAuthors collection is loaded.
     *
     * @return bool
     */
    public function isAuthorsLoaded()
    {
        return null !== $this->collAuthors;
    }

    /**
     * Gets a collection of Author objects related by a many-to-many relationship
     * to the current object by way of the biblio_author cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildBiblio is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|Author[] List of Author objects
     */
    public function getAuthors(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collAuthorsPartial && !$this->isNew();
        if (null === $this->collAuthors || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collAuthors) {
                    $this->initAuthors();
                }
            } else {

                $query = AuthorQuery::create(null, $criteria)
                    ->filterByBiblio($this);
                $collAuthors = $query->find($con);
                if (null !== $criteria) {
                    return $collAuthors;
                }

                if ($partial && $this->collAuthors) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collAuthors as $obj) {
                        if (!$collAuthors->contains($obj)) {
                            $collAuthors[] = $obj;
                        }
                    }
                }

                $this->collAuthors = $collAuthors;
                $this->collAuthorsPartial = false;
            }
        }

        return $this->collAuthors;
    }

    /**
     * Sets a collection of Author objects related by a many-to-many relationship
     * to the current object by way of the biblio_author cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $authors A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildBiblio The current object (for fluent API support)
     */
    public function setAuthors(Collection $authors, ConnectionInterface $con = null)
    {
        $this->clearAuthors();
        $currentAuthors = $this->getAuthors();

        $authorsScheduledForDeletion = $currentAuthors->diff($authors);

        foreach ($authorsScheduledForDeletion as $toDelete) {
            $this->removeAuthor($toDelete);
        }

        foreach ($authors as $author) {
            if (!$currentAuthors->contains($author)) {
                $this->doAddAuthor($author);
            }
        }

        $this->collAuthorsPartial = false;
        $this->collAuthors = $authors;

        return $this;
    }

    /**
     * Gets the number of Author objects related by a many-to-many relationship
     * to the current object by way of the biblio_author cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related Author objects
     */
    public function countAuthors(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collAuthorsPartial && !$this->isNew();
        if (null === $this->collAuthors || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAuthors) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getAuthors());
                }

                $query = AuthorQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByBiblio($this)
                    ->count($con);
            }
        } else {
            return count($this->collAuthors);
        }
    }

    /**
     * Associate a Author to this object
     * through the biblio_author cross reference table.
     *
     * @param Author $author
     * @return ChildBiblio The current object (for fluent API support)
     */
    public function addAuthor(Author $author)
    {
        if ($this->collAuthors === null) {
            $this->initAuthors();
        }

        if (!$this->getAuthors()->contains($author)) {
            // only add it if the **same** object is not already associated
            $this->collAuthors->push($author);
            $this->doAddAuthor($author);
        }

        return $this;
    }

    /**
     *
     * @param Author $author
     */
    protected function doAddAuthor(Author $author)
    {
        $biblioAuthor = new BiblioAuthor();

        $biblioAuthor->setAuthor($author);

        $biblioAuthor->setBiblio($this);

        $this->addBiblioAuthor($biblioAuthor);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$author->isBibliosLoaded()) {
            $author->initBiblios();
            $author->getBiblios()->push($this);
        } elseif (!$author->getBiblios()->contains($this)) {
            $author->getBiblios()->push($this);
        }

    }

    /**
     * Remove author of this object
     * through the biblio_author cross reference table.
     *
     * @param Author $author
     * @return ChildBiblio The current object (for fluent API support)
     */
    public function removeAuthor(Author $author)
    {
        if ($this->getAuthors()->contains($author)) {
            $biblioAuthor = new BiblioAuthor();
            $biblioAuthor->setAuthor($author);
            if ($author->isBibliosLoaded()) {
                //remove the back reference if available
                $author->getBiblios()->removeObject($this);
            }

            $biblioAuthor->setBiblio($this);
            $this->removeBiblioAuthor(clone $biblioAuthor);
            $biblioAuthor->clear();

            $this->collAuthors->remove($this->collAuthors->search($author));

            if (null === $this->authorsScheduledForDeletion) {
                $this->authorsScheduledForDeletion = clone $this->collAuthors;
                $this->authorsScheduledForDeletion->clear();
            }

            $this->authorsScheduledForDeletion->push($author);
        }


        return $this;
    }

    /**
     * Clears out the collTopics collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addTopics()
     */
    public function clearTopics()
    {
        $this->collTopics = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collTopics crossRef collection.
     *
     * By default this just sets the collTopics collection to an empty collection (like clearTopics());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initTopics()
    {
        $collectionClassName = BiblioTopicTableMap::getTableMap()->getCollectionClassName();

        $this->collTopics = new $collectionClassName;
        $this->collTopicsPartial = true;
        $this->collTopics->setModel('\Slims\Models\Masterfile\Topic\Topic');
    }

    /**
     * Checks if the collTopics collection is loaded.
     *
     * @return bool
     */
    public function isTopicsLoaded()
    {
        return null !== $this->collTopics;
    }

    /**
     * Gets a collection of Topic objects related by a many-to-many relationship
     * to the current object by way of the biblio_topic cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildBiblio is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|Topic[] List of Topic objects
     */
    public function getTopics(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collTopicsPartial && !$this->isNew();
        if (null === $this->collTopics || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collTopics) {
                    $this->initTopics();
                }
            } else {

                $query = TopicQuery::create(null, $criteria)
                    ->filterByBiblio($this);
                $collTopics = $query->find($con);
                if (null !== $criteria) {
                    return $collTopics;
                }

                if ($partial && $this->collTopics) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collTopics as $obj) {
                        if (!$collTopics->contains($obj)) {
                            $collTopics[] = $obj;
                        }
                    }
                }

                $this->collTopics = $collTopics;
                $this->collTopicsPartial = false;
            }
        }

        return $this->collTopics;
    }

    /**
     * Sets a collection of Topic objects related by a many-to-many relationship
     * to the current object by way of the biblio_topic cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $topics A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildBiblio The current object (for fluent API support)
     */
    public function setTopics(Collection $topics, ConnectionInterface $con = null)
    {
        $this->clearTopics();
        $currentTopics = $this->getTopics();

        $topicsScheduledForDeletion = $currentTopics->diff($topics);

        foreach ($topicsScheduledForDeletion as $toDelete) {
            $this->removeTopic($toDelete);
        }

        foreach ($topics as $topic) {
            if (!$currentTopics->contains($topic)) {
                $this->doAddTopic($topic);
            }
        }

        $this->collTopicsPartial = false;
        $this->collTopics = $topics;

        return $this;
    }

    /**
     * Gets the number of Topic objects related by a many-to-many relationship
     * to the current object by way of the biblio_topic cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related Topic objects
     */
    public function countTopics(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collTopicsPartial && !$this->isNew();
        if (null === $this->collTopics || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collTopics) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getTopics());
                }

                $query = TopicQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByBiblio($this)
                    ->count($con);
            }
        } else {
            return count($this->collTopics);
        }
    }

    /**
     * Associate a Topic to this object
     * through the biblio_topic cross reference table.
     *
     * @param Topic $topic
     * @return ChildBiblio The current object (for fluent API support)
     */
    public function addTopic(Topic $topic)
    {
        if ($this->collTopics === null) {
            $this->initTopics();
        }

        if (!$this->getTopics()->contains($topic)) {
            // only add it if the **same** object is not already associated
            $this->collTopics->push($topic);
            $this->doAddTopic($topic);
        }

        return $this;
    }

    /**
     *
     * @param Topic $topic
     */
    protected function doAddTopic(Topic $topic)
    {
        $biblioTopic = new BiblioTopic();

        $biblioTopic->setTopic($topic);

        $biblioTopic->setBiblio($this);

        $this->addBiblioTopic($biblioTopic);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$topic->isBibliosLoaded()) {
            $topic->initBiblios();
            $topic->getBiblios()->push($this);
        } elseif (!$topic->getBiblios()->contains($this)) {
            $topic->getBiblios()->push($this);
        }

    }

    /**
     * Remove topic of this object
     * through the biblio_topic cross reference table.
     *
     * @param Topic $topic
     * @return ChildBiblio The current object (for fluent API support)
     */
    public function removeTopic(Topic $topic)
    {
        if ($this->getTopics()->contains($topic)) {
            $biblioTopic = new BiblioTopic();
            $biblioTopic->setTopic($topic);
            if ($topic->isBibliosLoaded()) {
                //remove the back reference if available
                $topic->getBiblios()->removeObject($this);
            }

            $biblioTopic->setBiblio($this);
            $this->removeBiblioTopic(clone $biblioTopic);
            $biblioTopic->clear();

            $this->collTopics->remove($this->collTopics->search($topic));

            if (null === $this->topicsScheduledForDeletion) {
                $this->topicsScheduledForDeletion = clone $this->collTopics;
                $this->topicsScheduledForDeletion->clear();
            }

            $this->topicsScheduledForDeletion->push($topic);
        }


        return $this;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aPublisher) {
            $this->aPublisher->removeBiblio($this);
        }
        if (null !== $this->aLanguage) {
            $this->aLanguage->removeBiblio($this);
        }
        if (null !== $this->aPlace) {
            $this->aPlace->removeBiblio($this);
        }
        if (null !== $this->aFrequency) {
            $this->aFrequency->removeBiblio($this);
        }
        if (null !== $this->aUser) {
            $this->aUser->removeBiblio($this);
        }
        $this->biblio_id = null;
        $this->title = null;
        $this->sor = null;
        $this->edition = null;
        $this->isbn_issn = null;
        $this->publisher_id = null;
        $this->publish_year = null;
        $this->collation = null;
        $this->series_title = null;
        $this->call_number = null;
        $this->language_id = null;
        $this->source = null;
        $this->publish_place_id = null;
        $this->classification = null;
        $this->notes = null;
        $this->image = null;
        $this->file_att = null;
        $this->opac_hide = null;
        $this->promoted = null;
        $this->labels = null;
        $this->frequency_id = null;
        $this->spec_detail_info = null;
        $this->input_date = null;
        $this->last_update = null;
        $this->uid = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collBiblioAuthors) {
                foreach ($this->collBiblioAuthors as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collBiblioTopics) {
                foreach ($this->collBiblioTopics as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collItems) {
                foreach ($this->collItems as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collAuthors) {
                foreach ($this->collAuthors as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collTopics) {
                foreach ($this->collTopics as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collBiblioAuthors = null;
        $this->collBiblioTopics = null;
        $this->collItems = null;
        $this->collAuthors = null;
        $this->collTopics = null;
        $this->aPublisher = null;
        $this->aLanguage = null;
        $this->aPlace = null;
        $this->aFrequency = null;
        $this->aUser = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(BiblioTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preSave')) {
            return parent::preSave($con);
        }
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postSave')) {
            parent::postSave($con);
        }
    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preInsert')) {
            return parent::preInsert($con);
        }
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postInsert')) {
            parent::postInsert($con);
        }
    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preUpdate')) {
            return parent::preUpdate($con);
        }
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postUpdate')) {
            parent::postUpdate($con);
        }
    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preDelete')) {
            return parent::preDelete($con);
        }
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postDelete')) {
            parent::postDelete($con);
        }
    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
