<?php

namespace Slims\Models\Masterfile\Author\Base;

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
use Slims\Models\Bibliography\Biblio\Biblio;
use Slims\Models\Bibliography\Biblio\BiblioQuery;
use Slims\Models\Masterfile\Author\Author as ChildAuthor;
use Slims\Models\Masterfile\Author\AuthorQuery as ChildAuthorQuery;
use Slims\Models\Masterfile\Author\Map\AuthorTableMap;
use Slims\Models\Masterfile\BiblioAuthor\BiblioAuthor;
use Slims\Models\Masterfile\BiblioAuthor\BiblioAuthorQuery;
use Slims\Models\Masterfile\BiblioAuthor\Base\BiblioAuthor as BaseBiblioAuthor;
use Slims\Models\Masterfile\BiblioAuthor\Map\BiblioAuthorTableMap;

/**
 * Base class that represents a row from the 'mst_author' table.
 *
 *
 *
 * @package    propel.generator.Slims.Models.Masterfile.Author.Base
 */
abstract class Author implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Slims\\Models\\Masterfile\\Author\\Map\\AuthorTableMap';


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
     * The value for the author_id field.
     *
     * @var        int
     */
    protected $author_id;

    /**
     * The value for the author_name field.
     *
     * @var        string
     */
    protected $author_name;

    /**
     * @var        ObjectCollection|BiblioAuthor[] Collection to store aggregation of BiblioAuthor objects.
     */
    protected $collBiblioAuthors;
    protected $collBiblioAuthorsPartial;

    /**
     * @var        ObjectCollection|Biblio[] Cross Collection to store aggregation of Biblio objects.
     */
    protected $collBiblios;

    /**
     * @var bool
     */
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
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|BiblioAuthor[]
     */
    protected $biblioAuthorsScheduledForDeletion = null;

    /**
     * Initializes internal state of Slims\Models\Masterfile\Author\Base\Author object.
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
     * Compares this with another <code>Author</code> instance.  If
     * <code>obj</code> is an instance of <code>Author</code>, delegates to
     * <code>equals(Author)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Author The current object, for fluid interface
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
     * Get the [author_id] column value.
     *
     * @return int
     */
    public function getAuthorId()
    {
        return $this->author_id;
    }

    /**
     * Get the [author_name] column value.
     *
     * @return string
     */
    public function getAuthor_name()
    {
        return $this->author_name;
    }

    /**
     * Set the value of [author_id] column.
     *
     * @param int $v new value
     * @return $this|\Slims\Models\Masterfile\Author\Author The current object (for fluent API support)
     */
    public function setAuthorId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->author_id !== $v) {
            $this->author_id = $v;
            $this->modifiedColumns[AuthorTableMap::COL_AUTHOR_ID] = true;
        }

        return $this;
    } // setAuthorId()

    /**
     * Set the value of [author_name] column.
     *
     * @param string $v new value
     * @return $this|\Slims\Models\Masterfile\Author\Author The current object (for fluent API support)
     */
    public function setAuthor_name($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->author_name !== $v) {
            $this->author_name = $v;
            $this->modifiedColumns[AuthorTableMap::COL_AUTHOR_NAME] = true;
        }

        return $this;
    } // setAuthor_name()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : AuthorTableMap::translateFieldName('AuthorId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->author_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : AuthorTableMap::translateFieldName('Author_name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->author_name = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 2; // 2 = AuthorTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Slims\\Models\\Masterfile\\Author\\Author'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(AuthorTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildAuthorQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collBiblioAuthors = null;

            $this->collBiblios = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Author::setDeleted()
     * @see Author::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(AuthorTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildAuthorQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(AuthorTableMap::DATABASE_NAME);
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
                AuthorTableMap::addInstanceToPool($this);
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
                    $pks = array();
                    foreach ($this->bibliosScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[1] = $this->getAuthorId();
                        $entryPk[0] = $entry->getBiblioId();
                        $pks[] = $entryPk;
                    }

                    \Slims\Models\Masterfile\BiblioAuthor\BiblioAuthorQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->bibliosScheduledForDeletion = null;
                }

            }

            if ($this->collBiblios) {
                foreach ($this->collBiblios as $biblio) {
                    if (!$biblio->isDeleted() && ($biblio->isNew() || $biblio->isModified())) {
                        $biblio->save($con);
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

        $this->modifiedColumns[AuthorTableMap::COL_AUTHOR_ID] = true;
        if (null !== $this->author_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . AuthorTableMap::COL_AUTHOR_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(AuthorTableMap::COL_AUTHOR_ID)) {
            $modifiedColumns[':p' . $index++]  = 'author_id';
        }
        if ($this->isColumnModified(AuthorTableMap::COL_AUTHOR_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'author_name';
        }

        $sql = sprintf(
            'INSERT INTO mst_author (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'author_id':
                        $stmt->bindValue($identifier, $this->author_id, PDO::PARAM_INT);
                        break;
                    case 'author_name':
                        $stmt->bindValue($identifier, $this->author_name, PDO::PARAM_STR);
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
        $this->setAuthorId($pk);

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
        $pos = AuthorTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getAuthorId();
                break;
            case 1:
                return $this->getAuthor_name();
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

        if (isset($alreadyDumpedObjects['Author'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Author'][$this->hashCode()] = true;
        $keys = AuthorTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getAuthorId(),
            $keys[1] => $this->getAuthor_name(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
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
     * @return $this|\Slims\Models\Masterfile\Author\Author
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = AuthorTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Slims\Models\Masterfile\Author\Author
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setAuthorId($value);
                break;
            case 1:
                $this->setAuthor_name($value);
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
        $keys = AuthorTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setAuthorId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setAuthor_name($arr[$keys[1]]);
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
     * @return $this|\Slims\Models\Masterfile\Author\Author The current object, for fluid interface
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
        $criteria = new Criteria(AuthorTableMap::DATABASE_NAME);

        if ($this->isColumnModified(AuthorTableMap::COL_AUTHOR_ID)) {
            $criteria->add(AuthorTableMap::COL_AUTHOR_ID, $this->author_id);
        }
        if ($this->isColumnModified(AuthorTableMap::COL_AUTHOR_NAME)) {
            $criteria->add(AuthorTableMap::COL_AUTHOR_NAME, $this->author_name);
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
        $criteria = ChildAuthorQuery::create();
        $criteria->add(AuthorTableMap::COL_AUTHOR_ID, $this->author_id);

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
        $validPk = null !== $this->getAuthorId();

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
        return $this->getAuthorId();
    }

    /**
     * Generic method to set the primary key (author_id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setAuthorId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getAuthorId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Slims\Models\Masterfile\Author\Author (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setAuthor_name($this->getAuthor_name());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getBiblioAuthors() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addBiblioAuthor($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setAuthorId(NULL); // this is a auto-increment column, so set to default value
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
     * @return \Slims\Models\Masterfile\Author\Author Clone of current object.
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
        if ('BiblioAuthor' == $relationName) {
            return $this->initBiblioAuthors();
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
     * If this ChildAuthor is new, it will return
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
                    ->filterByAuthor($this)
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
     * @return $this|ChildAuthor The current object (for fluent API support)
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
            $biblioAuthorRemoved->setAuthor(null);
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
                ->filterByAuthor($this)
                ->count($con);
        }

        return count($this->collBiblioAuthors);
    }

    /**
     * Method called to associate a BiblioAuthor object to this object
     * through the BiblioAuthor foreign key attribute.
     *
     * @param  BiblioAuthor $l BiblioAuthor
     * @return $this|\Slims\Models\Masterfile\Author\Author The current object (for fluent API support)
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
        $biblioAuthor->setAuthor($this);
    }

    /**
     * @param  BiblioAuthor $biblioAuthor The BiblioAuthor object to remove.
     * @return $this|ChildAuthor The current object (for fluent API support)
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
            $biblioAuthor->setAuthor(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Author is new, it will return
     * an empty collection; or if this Author has previously
     * been saved, it will retrieve related BiblioAuthors from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Author.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|BiblioAuthor[] List of BiblioAuthor objects
     */
    public function getBiblioAuthorsJoinBiblio(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = BiblioAuthorQuery::create(null, $criteria);
        $query->joinWith('Biblio', $joinBehavior);

        return $this->getBiblioAuthors($query, $con);
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
     * Initializes the collBiblios crossRef collection.
     *
     * By default this just sets the collBiblios collection to an empty collection (like clearBiblios());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initBiblios()
    {
        $collectionClassName = BiblioAuthorTableMap::getTableMap()->getCollectionClassName();

        $this->collBiblios = new $collectionClassName;
        $this->collBibliosPartial = true;
        $this->collBiblios->setModel('\Slims\Models\Bibliography\Biblio\Biblio');
    }

    /**
     * Checks if the collBiblios collection is loaded.
     *
     * @return bool
     */
    public function isBibliosLoaded()
    {
        return null !== $this->collBiblios;
    }

    /**
     * Gets a collection of Biblio objects related by a many-to-many relationship
     * to the current object by way of the biblio_author cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildAuthor is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|Biblio[] List of Biblio objects
     */
    public function getBiblios(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collBibliosPartial && !$this->isNew();
        if (null === $this->collBiblios || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collBiblios) {
                    $this->initBiblios();
                }
            } else {

                $query = BiblioQuery::create(null, $criteria)
                    ->filterByAuthor($this);
                $collBiblios = $query->find($con);
                if (null !== $criteria) {
                    return $collBiblios;
                }

                if ($partial && $this->collBiblios) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collBiblios as $obj) {
                        if (!$collBiblios->contains($obj)) {
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
     * Sets a collection of Biblio objects related by a many-to-many relationship
     * to the current object by way of the biblio_author cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $biblios A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildAuthor The current object (for fluent API support)
     */
    public function setBiblios(Collection $biblios, ConnectionInterface $con = null)
    {
        $this->clearBiblios();
        $currentBiblios = $this->getBiblios();

        $bibliosScheduledForDeletion = $currentBiblios->diff($biblios);

        foreach ($bibliosScheduledForDeletion as $toDelete) {
            $this->removeBiblio($toDelete);
        }

        foreach ($biblios as $biblio) {
            if (!$currentBiblios->contains($biblio)) {
                $this->doAddBiblio($biblio);
            }
        }

        $this->collBibliosPartial = false;
        $this->collBiblios = $biblios;

        return $this;
    }

    /**
     * Gets the number of Biblio objects related by a many-to-many relationship
     * to the current object by way of the biblio_author cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related Biblio objects
     */
    public function countBiblios(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collBibliosPartial && !$this->isNew();
        if (null === $this->collBiblios || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collBiblios) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getBiblios());
                }

                $query = BiblioQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByAuthor($this)
                    ->count($con);
            }
        } else {
            return count($this->collBiblios);
        }
    }

    /**
     * Associate a Biblio to this object
     * through the biblio_author cross reference table.
     *
     * @param Biblio $biblio
     * @return ChildAuthor The current object (for fluent API support)
     */
    public function addBiblio(Biblio $biblio)
    {
        if ($this->collBiblios === null) {
            $this->initBiblios();
        }

        if (!$this->getBiblios()->contains($biblio)) {
            // only add it if the **same** object is not already associated
            $this->collBiblios->push($biblio);
            $this->doAddBiblio($biblio);
        }

        return $this;
    }

    /**
     *
     * @param Biblio $biblio
     */
    protected function doAddBiblio(Biblio $biblio)
    {
        $biblioAuthor = new BiblioAuthor();

        $biblioAuthor->setBiblio($biblio);

        $biblioAuthor->setAuthor($this);

        $this->addBiblioAuthor($biblioAuthor);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$biblio->isAuthorsLoaded()) {
            $biblio->initAuthors();
            $biblio->getAuthors()->push($this);
        } elseif (!$biblio->getAuthors()->contains($this)) {
            $biblio->getAuthors()->push($this);
        }

    }

    /**
     * Remove biblio of this object
     * through the biblio_author cross reference table.
     *
     * @param Biblio $biblio
     * @return ChildAuthor The current object (for fluent API support)
     */
    public function removeBiblio(Biblio $biblio)
    {
        if ($this->getBiblios()->contains($biblio)) {
            $biblioAuthor = new BiblioAuthor();
            $biblioAuthor->setBiblio($biblio);
            if ($biblio->isAuthorsLoaded()) {
                //remove the back reference if available
                $biblio->getAuthors()->removeObject($this);
            }

            $biblioAuthor->setAuthor($this);
            $this->removeBiblioAuthor(clone $biblioAuthor);
            $biblioAuthor->clear();

            $this->collBiblios->remove($this->collBiblios->search($biblio));

            if (null === $this->bibliosScheduledForDeletion) {
                $this->bibliosScheduledForDeletion = clone $this->collBiblios;
                $this->bibliosScheduledForDeletion->clear();
            }

            $this->bibliosScheduledForDeletion->push($biblio);
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
        $this->author_id = null;
        $this->author_name = null;
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
            if ($this->collBiblios) {
                foreach ($this->collBiblios as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collBiblioAuthors = null;
        $this->collBiblios = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(AuthorTableMap::DEFAULT_STRING_FORMAT);
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
