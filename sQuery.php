<?php
/**
 * sQuery
 *
 * A simple SQL query builder class that provides methods for generating SQL statements.
 */
class sQuery {
	
	/**
	 * Format the column name by applying backticks if needed.
	 *
	 * @param string|null $column The column name to format.
	 * @return string|null The formatted column name.
	 */
	private static function backtick_data(?string $column) {
		if ($column) {
			$division = array_map(function($column) {
				return !preg_match('/^\*|`.*`$/', $column) ? "`$column`" : $column;
			}, explode('.', $column));
			$column = implode(".", $division);
		};
		return $column;
	}
	
	/**
	 * Check if a column syntax strictly matches the SQL convention.
	 *
	 * @param string $column The column syntax to check.
	 * @return string A transformation of the column syntax that matches the SQL convention.
	 */
	private function alias_column( string $column ) {
		
		$column = trim($column);
		$expr = "(?:\w+|`\w+`|\*)";
		
		$alias = preg_split("/\s(?:as)\s/i", $column);
		
		array_walk($alias, function(&$identifier, $key) use($expr) {
			$is_column_name = preg_match("/^{$expr}(?:\.{$expr})?$/i", $identifier);
			if( $is_column_name ) $identifier = self::backtick_data( $identifier );
			return $identifier;
		});
		
		$alias = implode(' AS ', $alias);
		
		return $alias;
		
	}

	/**
	 * Generate a SELECT SQL statement.
	 *
	 * @param string $tableName The name of the table.
	 * @param string|int|null $condition The condition for the WHERE clause.
	 * @param string|array|null $columns The columns to select. Defaults to '*'.
	 * @return string The generated SELECT SQL statement.
	 */
	public static function select(string $tablename, ?string $condition = null, $columns = '*') {
		
		if( is_null($condition) ) $condition = 1;
		
		if( !is_array($columns) ) $columns = array($columns);
		
		$columns = implode(', ', array_map(function($column) {
			return self::alias_column($column);
		}, $columns));
		
		$tablename = self::backtick_data($tablename);
		
		$SQL = "SELECT {$columns} FROM {$tablename} WHERE {$condition}";
		
		return $SQL;
	}
	
	/**
	 * Format a value for use in an SQL statement.
	 *
	 * @param mixed $value The value to format.
	 * @return string The formatted value.
	 */
	public static function val($value) {
		if (is_null($value)) {
			return 'NULL';
		} else {
			return "'{$value}'";
		}
	}
	
	/**
	 * Generate an INSERT SQL statement.
	 *
	 * @param string $tableName The name of the table.
	 * @param array $data The data to insert.
	 * @return string The generated INSERT SQL statement.
	 */
	public static function insert(string $tablename, array $data) {
		
		$columns = implode(", ", array_map(function($key) {
			return self::backtick_data( $key );
		}, array_keys($data)));
		
		$values = array_map(function($value) {
			return self::val($value);
		}, array_values($data));
		
		$values = implode(", ", $values);
		
		$tablename = self::backtick_data( $tablename );
		
		$SQL = "INSERT INTO {$tablename} ($columns) VALUES ($values)";
		
		return $SQL;
	}
	
	/**
	 * Generate an UPDATE SQL statement.
	 *
	 * @param string $tableName The name of the table.
	 * @param array $data The data to update.
	 * @param string $condition The condition for the WHERE clause.
	 * @return string The generated UPDATE SQL statement.
	 */
	public static function update(string $tablename, array $data, ?string $condition) {
		
		$tablename = self::backtick_data( $tablename );
		
		$fieldset = array_map(function($key, $value) {
			return self::backtick_data($key) . " = " . self::val($value);
		}, array_keys($data), array_values($data));
		
		$fieldset = implode(", ", $fieldset);
		
		if( is_null($condition) ) $condition = 1;
		
		$SQL = "UPDATE {$tablename} SET {$fieldset} WHERE {$condition}";
		
		return $SQL;
		
	}
	
	/**
	 * Generate a DELETE SQL statement.
	 *
	 * @param string $tableName The name of the table.
	 * @param string|int $condition The condition for the WHERE clause.
	 * @return string The generated DELETE SQL statement.
	 */
	public static function delete(string $tablename, string $condition) {
		
		$tablename = self::backtick_data( $tablename );
		
		$SQL = "DELETE FROM {$tablename} WHERE {$condition}";
		
		return $SQL;
		
	}
	
}
