<?php

/**
 * $Id$
 *
 * Spaf/Library/Log/Manager.php
 * @created Wed Oct 03 11:02:06 +0200 2012
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\Library\Log;

/**
 * \Spaf\Library\Log\Manager
 *
 * The log manager class is simply
 * handling the log driver instances itself
 * and give you a unique interface to get each of them.
 *
 * @author Claudio Walser
 * @package Spaf\Library\Log
 * @namespace Spaf\Library\Log
 */
abstract class Manager {

    /**
     * Default log type. Possible values are
     * file | db
     *
     * @var string
     */
    private static $_defaultLogType = 'file';

	/**
	 * All allowed log types. No DB Driver yet
	 */
    private static $_allowedLogTypes = array('file'/*, 'db'*/);

    /**
     * Factory instances
     *
     * @var array Array with Spaf\Library\Log\Driver\Abstraction Objects
     */
    private static $_instances = array();

	/**
	 * Get all allowed log types
	 * you can pass to the factory method.
	 *
	 * @return array All log types
	 */
	public static function getAllowedTypes() {
		return self::$_allowedLogTypes;
	}

	/**
	 * Factory method itself is creating exactly one instance
	 * per type. That means you cannot have two
	 * different instances of the same type.
	 * I'll see if this really is usefull, if not,
	 * i have to pimp this a bit.
	 *
	 * @param string Logtype, to see possible values, call Spaf\Library\Log\Manager::getAllowedTypes()
	 * @return Spaf\Library\Loc\Driver\Abstraction Object of the asked logtype or file logger as default
	 */
    public static function factory($logType = 'file') {
        // always lower case
        $logType = strtolower($logType);
        // check if allowed type
        if (!in_array($logType, self::$_allowedLogTypes)) {
            $logType = self::$_defaultLogType;
        }

		// check and if needed, create instance
        if (!isset(self::$_instances[$logType]) || !self::$_instances[$logType] instanceof \Spaf\Library\Log\Abstraction) {
            switch ($logType) {
                /*case 'apc':
                    self::$_instances[$logType] = new Driver\Database();
                    break;*/
                default:
                    self::$_instances[$logType] = new Driver\File();
                    break;
            }
        }

		// return instance
		return self::$_instances[$logType];
    }

}

?>