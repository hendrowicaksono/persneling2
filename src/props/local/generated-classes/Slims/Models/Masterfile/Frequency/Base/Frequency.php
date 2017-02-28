<?php

namespace Slims\Models\Masterfile\Frequency\Base;

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
use Slims\Models\Bibliography\Biblio\Biblio;
use Slims\Models\Bibliography\Biblio\BiblioQuery;
use Slims\Models\Bibliography\Biblio\Base\Biblio as BaseBiblio;
use Slims\Models\Bibliography\Biblio\Map\BiblioTableMap;
use Slims\Models\Masterfile\Frequency\Frequency as ChildFrequency;
use Slims\Models\Masterfile\Frequency\FrequencyQuery as ChildFrequencyQuery;
use Slims\Models\Masterfile\Frequency\Map\FrequencyTableMap;

/**
 * Base class that represents a row from the 'mst_frequency' table.
 *
 *
 *
 * @package    propel.generator.Slims.Models.Masterfile.Frequency.Base
 */
abstract class Frequency implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Slims\\Models\\Masterfile\\Frequency\\Map\\FrequencyTableMap';


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
     * The value for the frequency_id field.
     *
     * @var        int
     */
    protected $frequency_id;

    /**
     * The value for the frequency field.
     *
     * @var        string
     */
    protected $frequency;

    /**
     * The value for the language_prefix field.
     *
     * @var        string
     */
    protected $language_prefix;

    /**
     * The value for the time_increment field.
     *
     * @var        int
     */
    protected $time_increment;

    /**
     * The value for the time_unit field.
     *
     * @var        string
     */
    protected $time_unit;

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
     * @var        ObjectCollection|Biblio[] Collection to store aggregation of Biblio objects.
     */
    protected $collBiblios;
    protected $collBibliosPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|Biblio[]
     */
    protected $bibliosScheduledForDeletion = null;

    /**
     * Initializes internal state of Slims\Models\Masterfile\Frequency\Base\Frequency object.
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
     * Compares this with another <code>Frequency</code> instance.  If
     * <code>obj</code> is an instance of <code>Frequency</code>, delegates to
     * <code>equals(Frequency)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Frequency The current object, for fluid interface
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
     * Get the [frequency_id] column value.
     *
     * @return int
     */
    public function getFrequencyId()
    {
        return $this->frequency_id;
    }

    /**
     * Get the [frequency] column value.
     *
     * @return string
     */
    public function getFrequency()
    {
        return $this->frequency;
    }

    /**
     * Get the [language_prefix] column value.
     *
     * @return string
     */
    public function getLanguage_prefix()
    {
        return $this->language_prefix;
    }

    /**
     * Get the [time_increment] column value.
     *
     * @return int
     */
    public function getTime_increment()
    {
        return $this->time_increment;
    }

    /**
     * Get the [time_unit] column value.
     *
     * @return string
     */
    public function getTime_unit()
    {
        return $this->time_unit;
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
     * Set the value of [frequency_id] column.
     *
     * @param int $v new value
     * @return $this|\Slims\Models\Masterfile\Frequency\Frequency The current object (for fluent API support)
     */
    public function setFrequencyId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->frequency_id !== $v) {
            $this->frequency_id = $v;
            $this->modifiedColumns[FrequencyTableMap::COL_FREQUENCY_ID] = true;
        }

        return $this;
    } // setFrequencyId()

    /**
     * Set the value of [frequency] column.
     *
     * @param string $v new value
     * @return $this|\Slims\Models\Masterfile\Frequency\Frequency The current object (for fluent API support)
     */
    public function setFrequency($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->frequency !== $v) {
            $this->frequency = $v;
            $this->modifiedColumns[FrequencyTableMap::COL_FREQUENCY] = true;
        }

        return $this;
    } // setFrequency()

    /**
     * Set the value of [language_prefix] column.
     *
     * @param string $v new value
     * @return $this|\Slims\Models\Masterfile\Frequency\Frequency The current object (for fluent API support)
     */
    public function setLanguage_prefix($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->language_prefix !== $v) {
            $this->language_prefix = $v;
            $this->modifiedColumns[FrequencyTableMap::COL_LANGUAGE_PREFIX] = true;
        }

        return $this;
    } // setLanguage_prefix()

    /**
     * Set the value of [time_increment] column.
     *
     * @param int $v new value
     * @return $this|\Slims\Models\Masterfile\Frequency\Frequency The current object (for fluent API support)
     */
    public function setTime_increment($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->time_increment !== $v) {
            $this->time_increment = $v;
            $this->modifiedColumns[FrequencyTableMap::COL_TIME_INCREMENT] = true;
        }

        return $this;
    } // setTime_increment()

    /**
     * Set the value of [time_unit] column.
     *
     * @param string $v new value
     * @return $this|\Slims\Models\Masterfile\Frequency\Frequency The current object (for fluent API support)
     */
    public function setTime_unit($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->time_unit !== $v) {
            $this->time_unit = $v;
            $this->modifiedColumns[FrequencyTableMap::COL_TIME_UNIT] = true;
        }

        return $this;
    } // setTime_unit()

    /**
     * Sets the value of [input_date] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Slims\Models\Masterfile\Frequency\Frequency The current object (for fluent API support)
     */
    public function setInput_date($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->input_date !== null || $dt !== null) {
            if ($this->input_date === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->input_date->format("Y-m-d H:i:s.u")) {
                $this->input_date = $dt === null ? null : clone $dt;
                $this->modifiedColumns[FrequencyTableMap::COL_INPUT_DATE] = true;
            }
        } // if either are not null

        return $this;
    } // setInput_date()

    /**
     * Sets the value of [last_update] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Slims\Models\Masterfile\Frequency\Frequency The current object (for fluent API support)
     */
    public function setLast_update($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->last_update !== null || $dt !== null) {
            if ($this->last_update === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->last_update->format("Y-m-d H:i:s.u")) {
                $this->last_update = $dt === null ? null : clone $dt;
                $this->modifiedColumns[FrequencyTableMap::COL_LAST_UPDATE] = true;
            }
        } // if either are not null

        return $this;
    } // setLast_update()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : FrequencyTableMap::translateFieldName('FrequencyId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->frequency_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : FrequencyTableMap::translateFieldName('Frequency', TableMap::TYPE_PHPNAME, $indexType)];
            $this->frequency = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : FrequencyTableMap::translateFieldName('Language_prefix', TableMap::TYPE_PHPNAME, $indexType)];
            $this->language_prefix = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : FrequencyTableMap::translateFieldName('Time_increment', TableMap::TYPE_PHPNAME, $indexType)];
            $this->time_increment = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : FrequencyTableMap::translateFieldName('Time_unit', TableMap::TYPE_PHPNAME, $indexType)];
            $this->time_unit = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : FrequencyTableMap::translateFieldName('Input_date', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->input_date = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : FrequencyTableMap::translateFieldName('Last_update', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->last_update = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 7; // 7 = FrequencyTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Slims\\Models\\Masterfile\\Frequency\\Frequency'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(FrequencyTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildFrequencyQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collBiblios = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Frequency::setDeleted()
     * @see Frequency::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(FrequencyTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildFrequencyQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(FrequencyTableMap::DATABASE_NAME);
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
                FrequencyTableMap::addInstanceToPool($this);
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

            if ($this->bibliosScheduledForDeletion !== null) {
                if (!$this->bibliosScheduledForDeletion->isEmpty()) {
                    foreach ($this->bibliosScheduledForDeletion as $biblio) {
                        // need to save related object because we set the relation to null
                        $biblio->save($con);
                    }
                    $this->bibliosScheduledForDeletion = null;
                }
            }

            if ($this->collBiblios !== null) {
                foreach ($this->collBiblios as $referrerFK) {
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

        $this->modifiedColumns[FrequencyTableMap::COL_FREQUENCY_ID] = true;
        if (null !== $this->frequency_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . FrequencyTableMap::COL_FREQUENCY_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(FrequencyTableMap::COL_FREQUENCY_ID)) {
            $modifiedColumns[':p' . $index++]  = 'frequency_id';
        }
        if ($this->isColumnModified(FrequencyTableMap::COL_FREQUENCY)) {
            $modifiedColumns[':p' . $index++]  = 'frequency';
        }
        if ($this->isColumnModified(FrequencyTableMap::COL_LANGUAGE_PREFIX)) {
            $modifiedColumns[':p' . $index++]  = 'language_prefix';
        }
        if ($this->isColumnModified(FrequencyTableMap::COL_TIME_INCREMENT)) {
            $modifiedColumns[':p' . $index++]  = 'time_increment';
        }
        if ($this->isColumnModified(FrequencyTableMap::COL_TIME_UNIT)) {
            $modifiedColumns[':p' . $index++]  = 'time_unit';
        }
        if ($this->isColumnModified(FrequencyTableMap::COL_INPUT_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'input_date';
        }
        if ($this->isColumnModified(FrequencyTableMap::COL_LAST_UPDATE)) {
            $modifiedColumns[':p' . $index++]  = 'last_update';
        }

        $sql = sprintf(
            'INSERT INTO mst_frequency (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'frequency_id':
                        $stmt->bindValue($identifier, $this->frequency_id, PDO::PARAM_INT);
                        break;
                    case 'frequency':
                        $stmt->bindValue($identifier, $this->frequency, PDO::PARAM_STR);
                        break;
                    case 'language_prefix':
                        $stmt->bindValue($identifier, $this->language_prefix, PDO::PARAM_STR);
                        break;
                    case 'time_increment':
                        $stmt->bindValue($identifier, $this->time_increment, PDO::PARAM_INT);
                        break;
                    case 'time_unit':
                        $stmt->bindValue($identifier, $this->time_unit, PDO::PARAM_STR);
                        break;
                    case 'input_date':
                        $stmt->bindValue($identifier, $this->input_date ? $this->input_date->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'last_update':
                        $stmt->bindValue($identifier, $this->last_update ? $this->last_update->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
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
        $this->setFrequencyId($pk);

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
        $pos = FrequencyTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getFrequencyId();
                break;
            case 1:
                return $this->getFrequency();
                break;
            case 2:
                return $this->getLanguage_prefix();
                break;
            case 3:
                return $this->getTime_increment();
                break;
            case 4:
                return $this->getTime_unit();
                break;
            case 5:
                return $this->getInput_date();
                break;
            case 6:
                return $this->getLast_update();
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

        if (isset($alreadyDumpedObjects['Frequency'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Frequency'][$this->hashCode()] = true;
        $keys = FrequencyTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getFrequencyId(),
            $keys[1] => $this->getFrequency(),
            $keys[2] => $this->getLanguage_prefix(),
            $keys[3] => $this->getTime_increment(),
            $keys[4] => $this->getTime_unit(),
            $keys[5] => $this->getInput_date(),
            $keys[6] => $this->getLast_update(),
        );
        if ($result[$keys[5]] instanceof \DateTime) {
            $result[$keys[5]] = $result[$keys[5]]->format('c');
        }

        if ($result[$keys[6]] instanceof \DateTime) {
            $result[$keys[6]] = $result[$keys[6]]->format('c');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collBiblios) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'biblios';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'biblios';
                        break;
                    default:
                        $key = 'Biblios';
                }

                $result[$key] = $this->collBiblios->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Slims\Models\Masterfile\Frequency\Frequency
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = FrequencyTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Slims\Models\Masterfile\Frequency\Frequency
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setFrequencyId($value);
                break;
            case 1:
                $this->setFrequency($value);
                break;
            case 2:
                $this->setLanguage_prefix($value);
                break;
            case 3:
                $this->setTime_increment($value);
                break;
            case 4:
                $this->setTime_unit($value);
                break;
            case 5:
                $this->setInput_date($value);
                break;
            case 6:
                $this->setLast_update($value);
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
        $keys = FrequencyTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setFrequencyId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setFrequency($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setLanguage_prefix($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setTime_increment($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setTime_unit($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setInput_date($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setLast_update($arr[$keys[6]]);
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
     * @return $this|\Slims\Models\Masterfile\Frequency\Frequency The current object, for fluid interface
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
        $criteria = new Criteria(FrequencyTableMap::DATABASE_NAME);

        if ($this->isColumnModified(FrequencyTableMap::COL_FREQUENCY_ID)) {
            $criteria->add(FrequencyTableMap::COL_FREQUENCY_ID, $this->frequency_id);
        }
        if ($this->isColumnModified(FrequencyTableMap::COL_FREQUENCY)) {
            $criteria->add(FrequencyTableMap::COL_FREQUENCY, $this->frequency);
        }
        if ($this->isColumnModified(FrequencyTableMap::COL_LANGUAGE_PREFIX)) {
            $criteria->add(FrequencyTableMap::COL_LANGUAGE_PREFIX, $this->language_prefix);
        }
        if ($this->isColumnModified(FrequencyTableMap::COL_TIME_INCREMENT)) {
            $criteria->add(FrequencyTableMap::COL_TIME_INCREMENT, $this->time_increment);
        }
        if ($this->isColumnModified(FrequencyTableMap::COL_TIME_UNIT)) {
            $criteria->add(FrequencyTableMap::COL_TIME_UNIT, $this->time_unit);
        }
        if ($this->isColumnModified(FrequencyTableMap::COL_INPUT_DATE)) {
            $criteria->add(FrequencyTableMap::COL_INPUT_DATE, $this->input_date);
        }
        if ($this->isColumnModified(FrequencyTableMap::COL_LAST_UPDATE)) {
            $criteria->add(FrequencyTableMap::COL_LAST_UPDATE, $this->last_update);
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
        $criteria = ChildFrequencyQuery::create();
        $criteria->add(FrequencyTableMap::COL_FREQUENCY_ID, $this->frequency_id);

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
        $validPk = null !== $this->getFrequencyId();

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
        return $this->getFrequencyId();
    }

    /**
     * Generic method to set the primary key (frequency_id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setFrequencyId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getFrequencyId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Slims\Models\Masterfile\Frequency\Frequency (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setFrequency($this->getFrequency());
        $copyObj->setLanguage_prefix($this->getLanguage_prefix());
        $copyObj->setTime_increment($this->getTime_increment());
        $copyObj->setTime_unit($this->getTime_unit());
        $copyObj->setInput_date($this->getInput_date());
        $copyObj->setLast_update($this->getLast_update());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getBiblios() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addBiblio($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setFrequencyId(NULL); // this is a auto-increment column, so set to default value
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
     * @return \Slims\Models\Masterfile\Frequency\Frequency Clone of current object.
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
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('Biblio' == $relationName) {
            return $this->initBiblios();
        }
    }

    /**
     * Clears out the collBiblios collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addBiblios()
     */
    public function clearBiblios()
    {
        $this->collBiblios = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collBiblios collection loaded partially.
     */
    public function resetPartialBiblios($v = true)
    {
        $this->collBibliosPartial = $v;
    }

    /**
     * Initializes the collBiblios collection.
     *
     * By default this just sets the collBiblios collection to an empty array (like clearcollBiblios());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initBiblios($overrideExisting = true)
    {
        if (null !== $this->collBiblios && !$overrideExisting) {
            return;
        }

        $collectionClassName = BiblioTableMap::getTableMap()->getCollectionClassName();

        $this->collBiblios = new $collectionClassName;
        $this->collBiblios->setModel('\Slims\Models\Bibliography\Biblio\Biblio');
    }

    /**
     * Gets an array of Biblio objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildFrequency is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|Biblio[] List of Biblio objects
     * @throws PropelException
     */
    public function getBiblios(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collBibliosPartial && !$this->isNew();
        if (null === $this->collBiblios || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collBiblios) {
                // return empty collection
                $this->initBiblios();
            } else {
                $collBiblios = BiblioQuery::create(null, $criteria)
                    ->filterByFrequency($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collBibliosPartial && count($collBiblios)) {
                        $this->initBiblios(false);

                        foreach ($collBiblios as $obj) {
                            if (false == $this->collBiblios->contains($obj)) {
                                $this->collBiblios->append($obj);
                            }
                        }

                        $this->collBibliosPartial = true;
                    }

                    return $collBiblios;
                }

                if ($partial && $this->collBiblios) {
                    foreach ($this->collBiblios as $obj) {
                        if ($obj->isNew()) {
                            $collBiblios[] = $obj;
                        }
                    }
                }

                $this->collBiblios = $collBiblios;
                $this->collBibliosPartial = false;
            }
        }

        return $this->collBiblios;
    }

    /**
     * Sets a collection of Biblio objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $biblios A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildFrequency The current object (for fluent API support)
     */
    public function setBiblios(Collection $biblios, ConnectionInterface $con = null)
    {
        /** @var Biblio[] $bibliosToDelete */
        $bibliosToDelete = $this->getBiblios(new Criteria(), $con)->diff($biblios);


        $this->bibliosScheduledForDeletion = $bibliosToDelete;

        foreach ($bibliosToDelete as $biblioRemoved) {
            $biblioRemoved->setFrequency(null);
        }

        $this->collBiblios = null;
        foreach ($biblios as $biblio) {
            $this->addBiblio($biblio);
        }

        $this->collBiblios = $biblios;
        $this->collBibliosPartial = false;

        return $this;
    }

    /**
     * Returns the number of related BaseBiblio objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related BaseBiblio objects.
     * @throws PropelException
     */
    public function countBiblios(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collBibliosPartial && !$this->isNew();
        if (null === $this->collBiblios || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collBiblios) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getBiblios());
            }

            $query = BiblioQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByFrequency($this)
                ->count($con);
        }

        return count($this->collBiblios);
    }

    /**
     * Method called to associate a Biblio object to this object
     * through the Biblio foreign key attribute.
     *
     * @param  Biblio $l Biblio
     * @return $this|\Slims\Models\Masterfile\Frequency\Frequency The current object (for fluent API support)
     */
    public function addBiblio(Biblio $l)
    {
        if ($this->collBiblios === null) {
            $this->initBiblios();
            $this->collBibliosPartial = true;
        }

        if (!$this->collBiblios->contains($l)) {
            $this->doAddBiblio($l);

            if ($this->bibliosScheduledForDeletion and $this->bibliosScheduledForDeletion->contains($l)) {
                $this->bibliosScheduledForDeletion->remove($this->bibliosScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param Biblio $biblio The Biblio object to add.
     */
    protected function doAddBiblio(Biblio $biblio)
    {
        $this->collBiblios[]= $biblio;
        $biblio->setFrequency($this);
    }

    /**
     * @param  Biblio $biblio The Biblio object to remove.
     * @return $this|ChildFrequency The current object (for fluent API support)
     */
    public function removeBiblio(Biblio $biblio)
    {
        if ($this->getBiblios()->contains($biblio)) {
            $pos = $this->collBiblios->search($biblio);
            $this->collBiblios->remove($pos);
            if (null === $this->bibliosScheduledForDeletion) {
                $this->bibliosScheduledForDeletion = clone $this->collBiblios;
                $this->bibliosScheduledForDeletion->clear();
            }
            $this->bibliosScheduledForDeletion[]= $biblio;
            $biblio->setFrequency(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Frequency is new, it will return
     * an empty collection; or if this Frequency has previously
     * been saved, it will retrieve related Biblios from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Frequency.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|Biblio[] List of Biblio objects
     */
    public function getBibliosJoinPublisher(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = BiblioQuery::create(null, $criteria);
        $query->joinWith('Publisher', $joinBehavior);

        return $this->getBiblios($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Frequency is new, it will return
     * an empty collection; or if this Frequency has previously
     * been saved, it will retrieve related Biblios from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Frequency.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|Biblio[] List of Biblio objects
     */
    public function getBibliosJoinLanguage(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = BiblioQuery::create(null, $criteria);
        $query->joinWith('Language', $joinBehavior);

        return $this->getBiblios($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Frequency is new, it will return
     * an empty collection; or if this Frequency has previously
     * been saved, it will retrieve related Biblios from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Frequency.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|Biblio[] List of Biblio objects
     */
    public function getBibliosJoinPlace(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = BiblioQuery::create(null, $criteria);
        $query->joinWith('Place', $joinBehavior);

        return $this->getBiblios($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Frequency is new, it will return
     * an empty collection; or if this Frequency has previously
     * been saved, it will retrieve related Biblios from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Frequency.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|Biblio[] List of Biblio objects
     */
    public function getBibliosJoinUser(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = BiblioQuery::create(null, $criteria);
        $query->joinWith('User', $joinBehavior);

        return $this->getBiblios($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->frequency_id = null;
        $this->frequency = null;
        $this->language_prefix = null;
        $this->time_increment = null;
        $this->time_unit = null;
        $this->input_date = null;
        $this->last_update = null;
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
            if ($this->collBiblios) {
                foreach ($this->collBiblios as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collBiblios = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(FrequencyTableMap::DEFAULT_STRING_FORMAT);
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
