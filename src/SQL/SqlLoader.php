<?php

namespace PA036;

use Doctrine\DBAL\Driver\Connection;

/**
 * 
 * @author Marian Rusnak
 */
class SqlLoader
{
	public static function initDatabase(Connection $connection, $print = true)
	{
		foreach (glob(__DIR__."/*.sql") as $filename) {
			if ($print) {
				echo "EXECUTING \"$filename\"\n";
			}
			$connection->exec(file_get_contents($filename));
		}
		if ($print) {
			echo "\nFINISHED SUCCESSFULLY\n";
		}
	}
}
