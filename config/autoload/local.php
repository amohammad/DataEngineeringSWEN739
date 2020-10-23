<?php
/**
 * Local Configuration Override
 *
 * This configuration override file is for overriding environment-specific and
 * security-sensitive configuration information. Copy this file without the
 * .dist extension at the end and populate values as needed.
 *
 * @NOTE: This file is ignored from Git by default with the .gitignore included
 * in ZendSkeletonApplication. This is a good practice, as it prevents sensitive
 * credentials from accidentally being committed into version control.
 */

return array(
	'doctrine' => array(
		'connection' => array(
			// default connection name
			'orm_default' => array(
				'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
				'params' => array(
					'host'     => 'localhost',
					'port'     => '3306',
					'user'     => 'root',
					'password' => 'qweQWE123!@#',
					'dbname'   => 'Data_Engineering_SWEN739',
					'charset'  => 'utf8',
					'driverOptions' => array(1002 => 'SET NAMES utf8')
				)
			)
		),
	    'configuration' => array(
	        'orm_default' => array(
	            'datetime_functions' => array(
	                'date'          => 'Oro\ORM\Query\AST\Functions\SimpleFunction',
	                'time'          => 'Oro\ORM\Query\AST\Functions\SimpleFunction',
	                'timestamp'     => 'Oro\ORM\Query\AST\Functions\SimpleFunction',
	                'convert_tz'    => 'Oro\ORM\Query\AST\Functions\DateTime\ConvertTz',
	            ),
	            'numeric_functions' => array(
	                'timestampdiff' => 'Oro\ORM\Query\AST\Functions\Numeric\TimestampDiff',
	                'dayofyear'     => 'Oro\ORM\Query\AST\Functions\SimpleFunction',
	                'dayofmonth'    => 'Oro\ORM\Query\AST\Functions\SimpleFunction',
	                'dayofweek'     => 'Oro\ORM\Query\AST\Functions\SimpleFunction',
	                'week'          => 'Oro\ORM\Query\AST\Functions\SimpleFunction',
	                'day'           => 'Oro\ORM\Query\AST\Functions\SimpleFunction',
	                'hour'          => 'Oro\ORM\Query\AST\Functions\SimpleFunction',
	                'minute'        => 'Oro\ORM\Query\AST\Functions\SimpleFunction',
	                'month'         => 'Oro\ORM\Query\AST\Functions\SimpleFunction',
	                'quarter'       => 'Oro\ORM\Query\AST\Functions\SimpleFunction',
	                'second'        => 'Oro\ORM\Query\AST\Functions\SimpleFunction',
	                'year'          => 'Oro\ORM\Query\AST\Functions\SimpleFunction',
	                'sign'          => 'Oro\ORM\Query\AST\Functions\Numeric\Sign',
	                'pow'           => 'Oro\ORM\Query\AST\Functions\Numeric\Pow',
	                'round'         => 'Oro\ORM\Query\AST\Functions\Numeric\Round',
	            ),
	            'string_functions'  => array(
	                'md5'           => 'Oro\ORM\Query\AST\Functions\SimpleFunction',
	                'group_concat'  => 'Oro\ORM\Query\AST\Functions\String\GroupConcat',
	                'cast'          => 'Oro\ORM\Query\AST\Functions\Cast',
	                'concat_ws'     => 'Oro\ORM\Query\AST\Functions\String\ConcatWs',
	                'replace'       => 'Oro\ORM\Query\AST\Functions\String\Replace',
	                'date_format'   => 'Oro\ORM\Query\AST\Functions\String\DateFormat'
	            )
	        )
	    )
	),
    'GMaps'=> array(
        'api_key' => 'AIzaSyCUg1QEV_SzAeuZUc4JnoE1l6OOtzp2Olw',
    ),
);
