<?php

namespace Slims\Models\Bibliography\Item\Base;

use \DateTime;
use \Exception;
use \PDO;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;
use Slims\Models\Bibliography\Biblio\Biblio;
use Slims\Models\Bibliography\Biblio\BiblioQuery;
use Slims\Models\Bibliography\Item\ItemQuery as ChildItemQuery;
use Slims\Models\Bibliography\Item\Map\ItemTableMap;
use Slims\Models\Masterfile\Colltype\Colltype;
use Slims\Models\Masterfile\Colltype\ColltypeQuery;
use Slims\Models\System\User\User;
use Slims\Models\System\User\UserQuery;

/**
 * Base class that represents a row from the 'item' table.
 *
 *
 *
 * @package    propel.generator.Slims.Models.Bibliography.Item.Base
 */
abstract class Item implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Slims\\Models\\Bibliography\\Item\\Map\\ItemTableMap';


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
     * The value for the item_id field.
     *
     * @var        int
     */
    protected $item_id;

    /**
     * The value for the item_code field.
     *
     * @var        string
     */
    protected $item_code;

    /**
     * The value for the biblio_id field.
     *
     * @var        int
     */
    protected $biblio_id;

    /**
     * The value for the call_number field.
     *
     * @var        string
     */
    protected $call_number;

    /**
     * The value for the coll_type_id field.
     *
     * @var        int
     */
    protected $coll_type_id;

    /**
     * The value for the inventory_code field.
     *
     * @var        string
     */
    protected $inventory_code;

    /**
     * The value for the received_date field.
     *
     * @var        DateTime
     */
    protected $received_date;

    /**
     * The value for the supplier_id field.
     *
     * @var        int
     */
    protected $supplier_id;

    /**
     * The value for the order_no field.
     *
     * @var        string
     */
    protected $order_no;

    /**
     * The value for the location_id field.
     *
     * @var        string
     */
    protected $location_id;

    /**
     * The value for the order_date field.
     *
     * @var        DateTime
     */
    protected $order_date;

    /**
     * The value for the item_status_id field.
     *
     * @var        string
     */
    protected $item_status_id;

    /**
     * The value for the site field.
     *
     * @var        string
     */
    protected $site;

    /**
     * The value for the source field.
     *
     * @var        int
     */
    protected $source;

    /**
     * The value for the invoice field.
     *
     * @var        string
     */
    protected $invoice;

    /**
     * The value for the price field.
     *
     * @var        int
     */
    protected $price;

    /**
     * The value for the price_currency field.
     *
     * @var        string
     */
    protected $price_currency;

    /**
     * The value for the invoice_date field.
     *
     * @var        DateTime
     */
    protected $invoice_date;

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
     * @var        Biblio
     */
    protected $aBiblio;

    /**
     * @var        User
     */
    protected $aUser;

    /**
     * @var        Colltype
     */
    protected $aColltype;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * Initializes internal state of Slims\Models\Bibliography\Item\Base\Item object.
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
     * Compares this with another <code>Item</code> instance.  If
     * <code>obj</code> is an instance of <code>Item</code>, delegates to
     * <code>equals(Item)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Item The current object, for fluid interface
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
     * Get the [item_id] column value.
     *
     * @return int
     */
    public function getItemId()
    {
        return $this->item_id;
    }

    /**
     * Get the [item_code] column value.
     *
     * @return string
     */
    public function getItem_code()
    {
        return $this->item_code;
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
     * Get the [call_number] column value.
     *
     * @return string
     */
    public function getCall_number()
    {
        return $this->call_number;
    }

    /**
     * Get the [coll_type_id] column value.
     *
     * @return int
     */
    public function getColl_type_id()
    {
        return $this->coll_type_id;
    }

    /**
     * Get the [inventory_code] column value.
     *
     * @return string
     */
    public function getInventory_code()
    {
        return $this->inventory_code;
    }

    /**
     * Get the [optionally formatted] temporal [received_date] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getReceived_date($format = NULL)
    {
        if ($format === null) {
            return $this->received_date;
        } else {
            return $this->received_date instanceof \DateTimeInterface ? $this->received_date->format($format) : null;
        }
    }

    /**
     * Get the [supplier_id] column value.
     *
     * @return int
     */
    public function getSupplierId()
    {
        return $this->supplier_id;
    }

    /**
     * Get the [order_no] column value.
     *
     * @return string
     */
    public function getOrder_no()
    {
        return $this->order_no;
    }

    /**
     * Get the [location_id] column value.
     *
     * @return string
     */
    public function getLocationId()
    {
        return $this->location_id;
    }

    /**
     * Get the [optionally formatted] temporal [order_date] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getOrder_date($format = NULL)
    {
        if ($format === null) {
            return $this->order_date;
        } else {
            return $this->order_date instanceof \DateTimeInterface ? $this->order_date->format($format) : null;
        }
    }

    /**
     * Get the [item_status_id] column value.
     *
     * @return string
     */
    public function getItemStatusId()
    {
        return $this->item_status_id;
    }

    /**
     * Get the [site] column value.
     *
     * @return string
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * Get the [source] column value.
     *
     * @return int
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Get the [invoice] column value.
     *
     * @return string
     */
    public function getInvoice()
    {
        return $this->invoice;
    }

    /**
     * Get the [price] column value.
     *
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Get the [price_currency] column value.
     *
     * @return string
     */
    public function getPrice_currency()
    {
        return $this->price_currency;
    }

    /**
     * Get the [optionally formatted] temporal [invoice_date] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getInvoice_date($format = NULL)
    {
        if ($format === null) {
            return $this->invoice_date;
        } else {
            return $this->invoice_date instanceof \DateTimeInterface ? $this->invoice_date->format($format) : null;
        }
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
     * Set the value of [item_id] column.
     *
     * @param int $v new value
     * @return $this|\Slims\Models\Bibliography\Item\Item The current object (for fluent API support)
     */
    public function setItemId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->item_id !== $v) {
            $this->item_id = $v;
            $this->modifiedColumns[ItemTableMap::COL_ITEM_ID] = true;
        }

        return $this;
    } // setItemId()

    /**
     * Set the value of [item_code] column.
     *
     * @param string $v new value
     * @return $this|\Slims\Models\Bibliography\Item\Item The current object (for fluent API support)
     */
    public function setItem_code($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->item_code !== $v) {
            $this->item_code = $v;
            $this->modifiedColumns[ItemTableMap::COL_ITEM_CODE] = true;
        }

        return $this;
    } // setItem_code()

    /**
     * Set the value of [biblio_id] column.
     *
     * @param int $v new value
     * @return $this|\Slims\Models\Bibliography\Item\Item The current object (for fluent API support)
     */
    public function setBiblioId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->biblio_id !== $v) {
            $this->biblio_id = $v;
            $this->modifiedColumns[ItemTableMap::COL_BIBLIO_ID] = true;
        }

        if ($this->aBiblio !== null && $this->aBiblio->getBiblioId() !== $v) {
            $this->aBiblio = null;
        }

        return $this;
    } // setBiblioId()

    /**
     * Set the value of [call_number] column.
     *
     * @param string $v new value
     * @return $this|\Slims\Models\Bibliography\Item\Item The current object (for fluent API support)
     */
    public function setCall_number($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->call_number !== $v) {
            $this->call_number = $v;
            $this->modifiedColumns[ItemTableMap::COL_CALL_NUMBER] = true;
        }

        return $this;
    } // setCall_number()

    /**
     * Set the value of [coll_type_id] column.
     *
     * @param int $v new value
     * @return $this|\Slims\Models\Bibliography\Item\Item The current object (for fluent API support)
     */
    public function setColl_type_id($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->coll_type_id !== $v) {
            $this->coll_type_id = $v;
            $this->modifiedColumns[ItemTableMap::COL_COLL_TYPE_ID] = true;
        }

        if ($this->aColltype !== null && $this->aColltype->getCollTypeId() !== $v) {
            $this->aColltype = null;
        }

        return $this;
    } // setColl_type_id()

    /**
     * Set the value of [inventory_code] column.
     *
     * @param string $v new value
     * @return $this|\Slims\Models\Bibliography\Item\Item The current object (for fluent API support)
     */
    public function setInventory_code($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->inventory_code !== $v) {
            $this->inventory_code = $v;
            $this->modifiedColumns[ItemTableMap::COL_INVENTORY_CODE] = true;
        }

        return $this;
    } // setInventory_code()

    /**
     * Sets the value of [received_date] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Slims\Models\Bibliography\Item\Item The current object (for fluent API support)
     */
    public function setReceived_date($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->received_date !== null || $dt !== null) {
            if ($this->received_date === null || $dt === null || $dt->format("Y-m-d") !== $this->received_date->format("Y-m-d")) {
                $this->received_date = $dt === null ? null : clone $dt;
                $this->modifiedColumns[ItemTableMap::COL_RECEIVED_DATE] = true;
            }
        } // if either are not null

        return $this;
    } // setReceived_date()

    /**
     * Set the value of [supplier_id] column.
     *
     * @param int $v new value
     * @return $this|\Slims\Models\Bibliography\Item\Item The current object (for fluent API support)
     */
    public function setSupplierId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->supplier_id !== $v) {
            $this->supplier_id = $v;
            $this->modifiedColumns[ItemTableMap::COL_SUPPLIER_ID] = true;
        }

        return $this;
    } // setSupplierId()

    /**
     * Set the value of [order_no] column.
     *
     * @param string $v new value
     * @return $this|\Slims\Models\Bibliography\Item\Item The current object (for fluent API support)
     */
    public function setOrder_no($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->order_no !== $v) {
            $this->order_no = $v;
            $this->modifiedColumns[ItemTableMap::COL_ORDER_NO] = true;
        }

        return $this;
    } // setOrder_no()

    /**
     * Set the value of [location_id] column.
     *
     * @param string $v new value
     * @return $this|\Slims\Models\Bibliography\Item\Item The current object (for fluent API support)
     */
    public function setLocationId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->location_id !== $v) {
            $this->location_id = $v;
            $this->modifiedColumns[ItemTableMap::COL_LOCATION_ID] = true;
        }

        return $this;
    } // setLocationId()

    /**
     * Sets the value of [order_date] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Slims\Models\Bibliography\Item\Item The current object (for fluent API support)
     */
    public function setOrder_date($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->order_date !== null || $dt !== null) {
            if ($this->order_date === null || $dt === null || $dt->format("Y-m-d") !== $this->order_date->format("Y-m-d")) {
                $this->order_date = $dt === null ? null : clone $dt;
                $this->modifiedColumns[ItemTableMap::COL_ORDER_DATE] = true;
            }
        } // if either are not null

        return $this;
    } // setOrder_date()

    /**
     * Set the value of [item_status_id] column.
     *
     * @param string $v new value
     * @return $this|\Slims\Models\Bibliography\Item\Item The current object (for fluent API support)
     */
    public function setItemStatusId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->item_status_id !== $v) {
            $this->item_status_id = $v;
            $this->modifiedColumns[ItemTableMap::COL_ITEM_STATUS_ID] = true;
        }

        return $this;
    } // setItemStatusId()

    /**
     * Set the value of [site] column.
     *
     * @param string $v new value
     * @return $this|\Slims\Models\Bibliography\Item\Item The current object (for fluent API support)
     */
    public function setSite($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->site !== $v) {
            $this->site = $v;
            $this->modifiedColumns[ItemTableMap::COL_SITE] = true;
        }

        return $this;
    } // setSite()

    /**
     * Set the value of [source] column.
     *
     * @param int $v new value
     * @return $this|\Slims\Models\Bibliography\Item\Item The current object (for fluent API support)
     */
    public function setSource($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->source !== $v) {
            $this->source = $v;
            $this->modifiedColumns[ItemTableMap::COL_SOURCE] = true;
        }

        return $this;
    } // setSource()

    /**
     * Set the value of [invoice] column.
     *
     * @param string $v new value
     * @return $this|\Slims\Models\Bibliography\Item\Item The current object (for fluent API support)
     */
    public function setInvoice($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->invoice !== $v) {
            $this->invoice = $v;
            $this->modifiedColumns[ItemTableMap::COL_INVOICE] = true;
        }

        return $this;
    } // setInvoice()

    /**
     * Set the value of [price] column.
     *
     * @param int $v new value
     * @return $this|\Slims\Models\Bibliography\Item\Item The current object (for fluent API support)
     */
    public function setPrice($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->price !== $v) {
            $this->price = $v;
            $this->modifiedColumns[ItemTableMap::COL_PRICE] = true;
        }

        return $this;
    } // setPrice()

    /**
     * Set the value of [price_currency] column.
     *
     * @param string $v new value
     * @return $this|\Slims\Models\Bibliography\Item\Item The current object (for fluent API support)
     */
    public function setPrice_currency($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->price_currency !== $v) {
            $this->price_currency = $v;
            $this->modifiedColumns[ItemTableMap::COL_PRICE_CURRENCY] = true;
        }

        return $this;
    } // setPrice_currency()

    /**
     * Sets the value of [invoice_date] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Slims\Models\Bibliography\Item\Item The current object (for fluent API support)
     */
    public function setInvoice_date($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->invoice_date !== null || $dt !== null) {
            if ($this->invoice_date === null || $dt === null || $dt->format("Y-m-d") !== $this->invoice_date->format("Y-m-d")) {
                $this->invoice_date = $dt === null ? null : clone $dt;
                $this->modifiedColumns[ItemTableMap::COL_INVOICE_DATE] = true;
            }
        } // if either are not null

        return $this;
    } // setInvoice_date()

    /**
     * Sets the value of [input_date] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Slims\Models\Bibliography\Item\Item The current object (for fluent API support)
     */
    public function setInput_date($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->input_date !== null || $dt !== null) {
            if ($this->input_date === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->input_date->format("Y-m-d H:i:s.u")) {
                $this->input_date = $dt === null ? null : clone $dt;
                $this->modifiedColumns[ItemTableMap::COL_INPUT_DATE] = true;
            }
        } // if either are not null

        return $this;
    } // setInput_date()

    /**
     * Sets the value of [last_update] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Slims\Models\Bibliography\Item\Item The current object (for fluent API support)
     */
    public function setLast_update($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->last_update !== null || $dt !== null) {
            if ($this->last_update === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->last_update->format("Y-m-d H:i:s.u")) {
                $this->last_update = $dt === null ? null : clone $dt;
                $this->modifiedColumns[ItemTableMap::COL_LAST_UPDATE] = true;
            }
        } // if either are not null

        return $this;
    } // setLast_update()

    /**
     * Set the value of [uid] column.
     *
     * @param int $v new value
     * @return $this|\Slims\Models\Bibliography\Item\Item The current object (for fluent API support)
     */
    public function setUid($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->uid !== $v) {
            $this->uid = $v;
            $this->modifiedColumns[ItemTableMap::COL_UID] = true;
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : ItemTableMap::translateFieldName('ItemId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->item_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : ItemTableMap::translateFieldName('Item_code', TableMap::TYPE_PHPNAME, $indexType)];
            $this->item_code = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : ItemTableMap::translateFieldName('BiblioId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->biblio_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : ItemTableMap::translateFieldName('Call_number', TableMap::TYPE_PHPNAME, $indexType)];
            $this->call_number = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : ItemTableMap::translateFieldName('Coll_type_id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->coll_type_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : ItemTableMap::translateFieldName('Inventory_code', TableMap::TYPE_PHPNAME, $indexType)];
            $this->inventory_code = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : ItemTableMap::translateFieldName('Received_date', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00') {
                $col = null;
            }
            $this->received_date = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : ItemTableMap::translateFieldName('SupplierId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->supplier_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : ItemTableMap::translateFieldName('Order_no', TableMap::TYPE_PHPNAME, $indexType)];
            $this->order_no = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : ItemTableMap::translateFieldName('LocationId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->location_id = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : ItemTableMap::translateFieldName('Order_date', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00') {
                $col = null;
            }
            $this->order_date = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : ItemTableMap::translateFieldName('ItemStatusId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->item_status_id = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : ItemTableMap::translateFieldName('Site', TableMap::TYPE_PHPNAME, $indexType)];
            $this->site = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 13 + $startcol : ItemTableMap::translateFieldName('Source', TableMap::TYPE_PHPNAME, $indexType)];
            $this->source = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 14 + $startcol : ItemTableMap::translateFieldName('Invoice', TableMap::TYPE_PHPNAME, $indexType)];
            $this->invoice = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 15 + $startcol : ItemTableMap::translateFieldName('Price', TableMap::TYPE_PHPNAME, $indexType)];
            $this->price = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 16 + $startcol : ItemTableMap::translateFieldName('Price_currency', TableMap::TYPE_PHPNAME, $indexType)];
            $this->price_currency = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 17 + $startcol : ItemTableMap::translateFieldName('Invoice_date', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00') {
                $col = null;
            }
            $this->invoice_date = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 18 + $startcol : ItemTableMap::translateFieldName('Input_date', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->input_date = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 19 + $startcol : ItemTableMap::translateFieldName('Last_update', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->last_update = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 20 + $startcol : ItemTableMap::translateFieldName('Uid', TableMap::TYPE_PHPNAME, $indexType)];
            $this->uid = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 21; // 21 = ItemTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Slims\\Models\\Bibliography\\Item\\Item'), 0, $e);
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
        if ($this->aBiblio !== null && $this->biblio_id !== $this->aBiblio->getBiblioId()) {
            $this->aBiblio = null;
        }
        if ($this->aColltype !== null && $this->coll_type_id !== $this->aColltype->getCollTypeId()) {
            $this->aColltype = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(ItemTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildItemQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aBiblio = null;
            $this->aUser = null;
            $this->aColltype = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Item::setDeleted()
     * @see Item::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ItemTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildItemQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(ItemTableMap::DATABASE_NAME);
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
                ItemTableMap::addInstanceToPool($this);
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

            if ($this->aBiblio !== null) {
                if ($this->aBiblio->isModified() || $this->aBiblio->isNew()) {
                    $affectedRows += $this->aBiblio->save($con);
                }
                $this->setBiblio($this->aBiblio);
            }

            if ($this->aUser !== null) {
                if ($this->aUser->isModified() || $this->aUser->isNew()) {
                    $affectedRows += $this->aUser->save($con);
                }
                $this->setUser($this->aUser);
            }

            if ($this->aColltype !== null) {
                if ($this->aColltype->isModified() || $this->aColltype->isNew()) {
                    $affectedRows += $this->aColltype->save($con);
                }
                $this->setColltype($this->aColltype);
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

        $this->modifiedColumns[ItemTableMap::COL_ITEM_ID] = true;
        if (null !== $this->item_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ItemTableMap::COL_ITEM_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ItemTableMap::COL_ITEM_ID)) {
            $modifiedColumns[':p' . $index++]  = 'item_id';
        }
        if ($this->isColumnModified(ItemTableMap::COL_ITEM_CODE)) {
            $modifiedColumns[':p' . $index++]  = 'item_code';
        }
        if ($this->isColumnModified(ItemTableMap::COL_BIBLIO_ID)) {
            $modifiedColumns[':p' . $index++]  = 'biblio_id';
        }
        if ($this->isColumnModified(ItemTableMap::COL_CALL_NUMBER)) {
            $modifiedColumns[':p' . $index++]  = 'call_number';
        }
        if ($this->isColumnModified(ItemTableMap::COL_COLL_TYPE_ID)) {
            $modifiedColumns[':p' . $index++]  = 'coll_type_id';
        }
        if ($this->isColumnModified(ItemTableMap::COL_INVENTORY_CODE)) {
            $modifiedColumns[':p' . $index++]  = 'inventory_code';
        }
        if ($this->isColumnModified(ItemTableMap::COL_RECEIVED_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'received_date';
        }
        if ($this->isColumnModified(ItemTableMap::COL_SUPPLIER_ID)) {
            $modifiedColumns[':p' . $index++]  = 'supplier_id';
        }
        if ($this->isColumnModified(ItemTableMap::COL_ORDER_NO)) {
            $modifiedColumns[':p' . $index++]  = 'order_no';
        }
        if ($this->isColumnModified(ItemTableMap::COL_LOCATION_ID)) {
            $modifiedColumns[':p' . $index++]  = 'location_id';
        }
        if ($this->isColumnModified(ItemTableMap::COL_ORDER_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'order_date';
        }
        if ($this->isColumnModified(ItemTableMap::COL_ITEM_STATUS_ID)) {
            $modifiedColumns[':p' . $index++]  = 'item_status_id';
        }
        if ($this->isColumnModified(ItemTableMap::COL_SITE)) {
            $modifiedColumns[':p' . $index++]  = 'site';
        }
        if ($this->isColumnModified(ItemTableMap::COL_SOURCE)) {
            $modifiedColumns[':p' . $index++]  = 'source';
        }
        if ($this->isColumnModified(ItemTableMap::COL_INVOICE)) {
            $modifiedColumns[':p' . $index++]  = 'invoice';
        }
        if ($this->isColumnModified(ItemTableMap::COL_PRICE)) {
            $modifiedColumns[':p' . $index++]  = 'price';
        }
        if ($this->isColumnModified(ItemTableMap::COL_PRICE_CURRENCY)) {
            $modifiedColumns[':p' . $index++]  = 'price_currency';
        }
        if ($this->isColumnModified(ItemTableMap::COL_INVOICE_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'invoice_date';
        }
        if ($this->isColumnModified(ItemTableMap::COL_INPUT_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'input_date';
        }
        if ($this->isColumnModified(ItemTableMap::COL_LAST_UPDATE)) {
            $modifiedColumns[':p' . $index++]  = 'last_update';
        }
        if ($this->isColumnModified(ItemTableMap::COL_UID)) {
            $modifiedColumns[':p' . $index++]  = 'uid';
        }

        $sql = sprintf(
            'INSERT INTO item (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'item_id':
                        $stmt->bindValue($identifier, $this->item_id, PDO::PARAM_INT);
                        break;
                    case 'item_code':
                        $stmt->bindValue($identifier, $this->item_code, PDO::PARAM_STR);
                        break;
                    case 'biblio_id':
                        $stmt->bindValue($identifier, $this->biblio_id, PDO::PARAM_INT);
                        break;
                    case 'call_number':
                        $stmt->bindValue($identifier, $this->call_number, PDO::PARAM_STR);
                        break;
                    case 'coll_type_id':
                        $stmt->bindValue($identifier, $this->coll_type_id, PDO::PARAM_INT);
                        break;
                    case 'inventory_code':
                        $stmt->bindValue($identifier, $this->inventory_code, PDO::PARAM_STR);
                        break;
                    case 'received_date':
                        $stmt->bindValue($identifier, $this->received_date ? $this->received_date->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'supplier_id':
                        $stmt->bindValue($identifier, $this->supplier_id, PDO::PARAM_INT);
                        break;
                    case 'order_no':
                        $stmt->bindValue($identifier, $this->order_no, PDO::PARAM_STR);
                        break;
                    case 'location_id':
                        $stmt->bindValue($identifier, $this->location_id, PDO::PARAM_STR);
                        break;
                    case 'order_date':
                        $stmt->bindValue($identifier, $this->order_date ? $this->order_date->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'item_status_id':
                        $stmt->bindValue($identifier, $this->item_status_id, PDO::PARAM_STR);
                        break;
                    case 'site':
                        $stmt->bindValue($identifier, $this->site, PDO::PARAM_STR);
                        break;
                    case 'source':
                        $stmt->bindValue($identifier, $this->source, PDO::PARAM_INT);
                        break;
                    case 'invoice':
                        $stmt->bindValue($identifier, $this->invoice, PDO::PARAM_STR);
                        break;
                    case 'price':
                        $stmt->bindValue($identifier, $this->price, PDO::PARAM_INT);
                        break;
                    case 'price_currency':
                        $stmt->bindValue($identifier, $this->price_currency, PDO::PARAM_STR);
                        break;
                    case 'invoice_date':
                        $stmt->bindValue($identifier, $this->invoice_date ? $this->invoice_date->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
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
        $this->setItemId($pk);

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
        $pos = ItemTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getItemId();
                break;
            case 1:
                return $this->getItem_code();
                break;
            case 2:
                return $this->getBiblioId();
                break;
            case 3:
                return $this->getCall_number();
                break;
            case 4:
                return $this->getColl_type_id();
                break;
            case 5:
                return $this->getInventory_code();
                break;
            case 6:
                return $this->getReceived_date();
                break;
            case 7:
                return $this->getSupplierId();
                break;
            case 8:
                return $this->getOrder_no();
                break;
            case 9:
                return $this->getLocationId();
                break;
            case 10:
                return $this->getOrder_date();
                break;
            case 11:
                return $this->getItemStatusId();
                break;
            case 12:
                return $this->getSite();
                break;
            case 13:
                return $this->getSource();
                break;
            case 14:
                return $this->getInvoice();
                break;
            case 15:
                return $this->getPrice();
                break;
            case 16:
                return $this->getPrice_currency();
                break;
            case 17:
                return $this->getInvoice_date();
                break;
            case 18:
                return $this->getInput_date();
                break;
            case 19:
                return $this->getLast_update();
                break;
            case 20:
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

        if (isset($alreadyDumpedObjects['Item'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Item'][$this->hashCode()] = true;
        $keys = ItemTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getItemId(),
            $keys[1] => $this->getItem_code(),
            $keys[2] => $this->getBiblioId(),
            $keys[3] => $this->getCall_number(),
            $keys[4] => $this->getColl_type_id(),
            $keys[5] => $this->getInventory_code(),
            $keys[6] => $this->getReceived_date(),
            $keys[7] => $this->getSupplierId(),
            $keys[8] => $this->getOrder_no(),
            $keys[9] => $this->getLocationId(),
            $keys[10] => $this->getOrder_date(),
            $keys[11] => $this->getItemStatusId(),
            $keys[12] => $this->getSite(),
            $keys[13] => $this->getSource(),
            $keys[14] => $this->getInvoice(),
            $keys[15] => $this->getPrice(),
            $keys[16] => $this->getPrice_currency(),
            $keys[17] => $this->getInvoice_date(),
            $keys[18] => $this->getInput_date(),
            $keys[19] => $this->getLast_update(),
            $keys[20] => $this->getUid(),
        );
        if ($result[$keys[6]] instanceof \DateTime) {
            $result[$keys[6]] = $result[$keys[6]]->format('c');
        }

        if ($result[$keys[10]] instanceof \DateTime) {
            $result[$keys[10]] = $result[$keys[10]]->format('c');
        }

        if ($result[$keys[17]] instanceof \DateTime) {
            $result[$keys[17]] = $result[$keys[17]]->format('c');
        }

        if ($result[$keys[18]] instanceof \DateTime) {
            $result[$keys[18]] = $result[$keys[18]]->format('c');
        }

        if ($result[$keys[19]] instanceof \DateTime) {
            $result[$keys[19]] = $result[$keys[19]]->format('c');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aBiblio) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'biblio';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'biblio';
                        break;
                    default:
                        $key = 'Biblio';
                }

                $result[$key] = $this->aBiblio->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
            if (null !== $this->aColltype) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'colltype';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'mst_coll_type';
                        break;
                    default:
                        $key = 'Colltype';
                }

                $result[$key] = $this->aColltype->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
     * @return $this|\Slims\Models\Bibliography\Item\Item
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = ItemTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Slims\Models\Bibliography\Item\Item
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setItemId($value);
                break;
            case 1:
                $this->setItem_code($value);
                break;
            case 2:
                $this->setBiblioId($value);
                break;
            case 3:
                $this->setCall_number($value);
                break;
            case 4:
                $this->setColl_type_id($value);
                break;
            case 5:
                $this->setInventory_code($value);
                break;
            case 6:
                $this->setReceived_date($value);
                break;
            case 7:
                $this->setSupplierId($value);
                break;
            case 8:
                $this->setOrder_no($value);
                break;
            case 9:
                $this->setLocationId($value);
                break;
            case 10:
                $this->setOrder_date($value);
                break;
            case 11:
                $this->setItemStatusId($value);
                break;
            case 12:
                $this->setSite($value);
                break;
            case 13:
                $this->setSource($value);
                break;
            case 14:
                $this->setInvoice($value);
                break;
            case 15:
                $this->setPrice($value);
                break;
            case 16:
                $this->setPrice_currency($value);
                break;
            case 17:
                $this->setInvoice_date($value);
                break;
            case 18:
                $this->setInput_date($value);
                break;
            case 19:
                $this->setLast_update($value);
                break;
            case 20:
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
        $keys = ItemTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setItemId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setItem_code($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setBiblioId($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setCall_number($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setColl_type_id($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setInventory_code($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setReceived_date($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setSupplierId($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setOrder_no($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setLocationId($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setOrder_date($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setItemStatusId($arr[$keys[11]]);
        }
        if (array_key_exists($keys[12], $arr)) {
            $this->setSite($arr[$keys[12]]);
        }
        if (array_key_exists($keys[13], $arr)) {
            $this->setSource($arr[$keys[13]]);
        }
        if (array_key_exists($keys[14], $arr)) {
            $this->setInvoice($arr[$keys[14]]);
        }
        if (array_key_exists($keys[15], $arr)) {
            $this->setPrice($arr[$keys[15]]);
        }
        if (array_key_exists($keys[16], $arr)) {
            $this->setPrice_currency($arr[$keys[16]]);
        }
        if (array_key_exists($keys[17], $arr)) {
            $this->setInvoice_date($arr[$keys[17]]);
        }
        if (array_key_exists($keys[18], $arr)) {
            $this->setInput_date($arr[$keys[18]]);
        }
        if (array_key_exists($keys[19], $arr)) {
            $this->setLast_update($arr[$keys[19]]);
        }
        if (array_key_exists($keys[20], $arr)) {
            $this->setUid($arr[$keys[20]]);
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
     * @return $this|\Slims\Models\Bibliography\Item\Item The current object, for fluid interface
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
        $criteria = new Criteria(ItemTableMap::DATABASE_NAME);

        if ($this->isColumnModified(ItemTableMap::COL_ITEM_ID)) {
            $criteria->add(ItemTableMap::COL_ITEM_ID, $this->item_id);
        }
        if ($this->isColumnModified(ItemTableMap::COL_ITEM_CODE)) {
            $criteria->add(ItemTableMap::COL_ITEM_CODE, $this->item_code);
        }
        if ($this->isColumnModified(ItemTableMap::COL_BIBLIO_ID)) {
            $criteria->add(ItemTableMap::COL_BIBLIO_ID, $this->biblio_id);
        }
        if ($this->isColumnModified(ItemTableMap::COL_CALL_NUMBER)) {
            $criteria->add(ItemTableMap::COL_CALL_NUMBER, $this->call_number);
        }
        if ($this->isColumnModified(ItemTableMap::COL_COLL_TYPE_ID)) {
            $criteria->add(ItemTableMap::COL_COLL_TYPE_ID, $this->coll_type_id);
        }
        if ($this->isColumnModified(ItemTableMap::COL_INVENTORY_CODE)) {
            $criteria->add(ItemTableMap::COL_INVENTORY_CODE, $this->inventory_code);
        }
        if ($this->isColumnModified(ItemTableMap::COL_RECEIVED_DATE)) {
            $criteria->add(ItemTableMap::COL_RECEIVED_DATE, $this->received_date);
        }
        if ($this->isColumnModified(ItemTableMap::COL_SUPPLIER_ID)) {
            $criteria->add(ItemTableMap::COL_SUPPLIER_ID, $this->supplier_id);
        }
        if ($this->isColumnModified(ItemTableMap::COL_ORDER_NO)) {
            $criteria->add(ItemTableMap::COL_ORDER_NO, $this->order_no);
        }
        if ($this->isColumnModified(ItemTableMap::COL_LOCATION_ID)) {
            $criteria->add(ItemTableMap::COL_LOCATION_ID, $this->location_id);
        }
        if ($this->isColumnModified(ItemTableMap::COL_ORDER_DATE)) {
            $criteria->add(ItemTableMap::COL_ORDER_DATE, $this->order_date);
        }
        if ($this->isColumnModified(ItemTableMap::COL_ITEM_STATUS_ID)) {
            $criteria->add(ItemTableMap::COL_ITEM_STATUS_ID, $this->item_status_id);
        }
        if ($this->isColumnModified(ItemTableMap::COL_SITE)) {
            $criteria->add(ItemTableMap::COL_SITE, $this->site);
        }
        if ($this->isColumnModified(ItemTableMap::COL_SOURCE)) {
            $criteria->add(ItemTableMap::COL_SOURCE, $this->source);
        }
        if ($this->isColumnModified(ItemTableMap::COL_INVOICE)) {
            $criteria->add(ItemTableMap::COL_INVOICE, $this->invoice);
        }
        if ($this->isColumnModified(ItemTableMap::COL_PRICE)) {
            $criteria->add(ItemTableMap::COL_PRICE, $this->price);
        }
        if ($this->isColumnModified(ItemTableMap::COL_PRICE_CURRENCY)) {
            $criteria->add(ItemTableMap::COL_PRICE_CURRENCY, $this->price_currency);
        }
        if ($this->isColumnModified(ItemTableMap::COL_INVOICE_DATE)) {
            $criteria->add(ItemTableMap::COL_INVOICE_DATE, $this->invoice_date);
        }
        if ($this->isColumnModified(ItemTableMap::COL_INPUT_DATE)) {
            $criteria->add(ItemTableMap::COL_INPUT_DATE, $this->input_date);
        }
        if ($this->isColumnModified(ItemTableMap::COL_LAST_UPDATE)) {
            $criteria->add(ItemTableMap::COL_LAST_UPDATE, $this->last_update);
        }
        if ($this->isColumnModified(ItemTableMap::COL_UID)) {
            $criteria->add(ItemTableMap::COL_UID, $this->uid);
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
        $criteria = ChildItemQuery::create();
        $criteria->add(ItemTableMap::COL_ITEM_ID, $this->item_id);

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
        $validPk = null !== $this->getItemId();

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
        return $this->getItemId();
    }

    /**
     * Generic method to set the primary key (item_id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setItemId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getItemId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Slims\Models\Bibliography\Item\Item (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setItem_code($this->getItem_code());
        $copyObj->setBiblioId($this->getBiblioId());
        $copyObj->setCall_number($this->getCall_number());
        $copyObj->setColl_type_id($this->getColl_type_id());
        $copyObj->setInventory_code($this->getInventory_code());
        $copyObj->setReceived_date($this->getReceived_date());
        $copyObj->setSupplierId($this->getSupplierId());
        $copyObj->setOrder_no($this->getOrder_no());
        $copyObj->setLocationId($this->getLocationId());
        $copyObj->setOrder_date($this->getOrder_date());
        $copyObj->setItemStatusId($this->getItemStatusId());
        $copyObj->setSite($this->getSite());
        $copyObj->setSource($this->getSource());
        $copyObj->setInvoice($this->getInvoice());
        $copyObj->setPrice($this->getPrice());
        $copyObj->setPrice_currency($this->getPrice_currency());
        $copyObj->setInvoice_date($this->getInvoice_date());
        $copyObj->setInput_date($this->getInput_date());
        $copyObj->setLast_update($this->getLast_update());
        $copyObj->setUid($this->getUid());
        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setItemId(NULL); // this is a auto-increment column, so set to default value
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
     * @return \Slims\Models\Bibliography\Item\Item Clone of current object.
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
     * Declares an association between this object and a Biblio object.
     *
     * @param  Biblio $v
     * @return $this|\Slims\Models\Bibliography\Item\Item The current object (for fluent API support)
     * @throws PropelException
     */
    public function setBiblio(Biblio $v = null)
    {
        if ($v === null) {
            $this->setBiblioId(NULL);
        } else {
            $this->setBiblioId($v->getBiblioId());
        }

        $this->aBiblio = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Biblio object, it will not be re-added.
        if ($v !== null) {
            $v->addItem($this);
        }


        return $this;
    }


    /**
     * Get the associated Biblio object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return Biblio The associated Biblio object.
     * @throws PropelException
     */
    public function getBiblio(ConnectionInterface $con = null)
    {
        if ($this->aBiblio === null && ($this->biblio_id !== null)) {
            $this->aBiblio = BiblioQuery::create()->findPk($this->biblio_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aBiblio->addItems($this);
             */
        }

        return $this->aBiblio;
    }

    /**
     * Declares an association between this object and a User object.
     *
     * @param  User $v
     * @return $this|\Slims\Models\Bibliography\Item\Item The current object (for fluent API support)
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
            $v->addItem($this);
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
                $this->aUser->addItems($this);
             */
        }

        return $this->aUser;
    }

    /**
     * Declares an association between this object and a Colltype object.
     *
     * @param  Colltype $v
     * @return $this|\Slims\Models\Bibliography\Item\Item The current object (for fluent API support)
     * @throws PropelException
     */
    public function setColltype(Colltype $v = null)
    {
        if ($v === null) {
            $this->setColl_type_id(NULL);
        } else {
            $this->setColl_type_id($v->getCollTypeId());
        }

        $this->aColltype = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Colltype object, it will not be re-added.
        if ($v !== null) {
            $v->addItem($this);
        }


        return $this;
    }


    /**
     * Get the associated Colltype object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return Colltype The associated Colltype object.
     * @throws PropelException
     */
    public function getColltype(ConnectionInterface $con = null)
    {
        if ($this->aColltype === null && ($this->coll_type_id !== null)) {
            $this->aColltype = ColltypeQuery::create()->findPk($this->coll_type_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aColltype->addItems($this);
             */
        }

        return $this->aColltype;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aBiblio) {
            $this->aBiblio->removeItem($this);
        }
        if (null !== $this->aUser) {
            $this->aUser->removeItem($this);
        }
        if (null !== $this->aColltype) {
            $this->aColltype->removeItem($this);
        }
        $this->item_id = null;
        $this->item_code = null;
        $this->biblio_id = null;
        $this->call_number = null;
        $this->coll_type_id = null;
        $this->inventory_code = null;
        $this->received_date = null;
        $this->supplier_id = null;
        $this->order_no = null;
        $this->location_id = null;
        $this->order_date = null;
        $this->item_status_id = null;
        $this->site = null;
        $this->source = null;
        $this->invoice = null;
        $this->price = null;
        $this->price_currency = null;
        $this->invoice_date = null;
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
        } // if ($deep)

        $this->aBiblio = null;
        $this->aUser = null;
        $this->aColltype = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ItemTableMap::DEFAULT_STRING_FORMAT);
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
