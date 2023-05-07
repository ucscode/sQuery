<?php
/**
 * sQuery
 */

class sQuery {
	
	public static function select( $tablename, $condition = 1 ) {
		$SQL = "SELECT * FROM `{$tablename}` WHERE {$condition}";
		return $SQL;
	}
	
	public static function val( $value ) {
		if( is_null($value) ) return 'NULL';
		else return "'{$value}'";
	}
	
	public static function insert( string $tablename, array $data, ?MYSQLI $mysqli = null ) {
		$columns = implode(", ", array_map(function($key) {
			return "`{$key}`";
		}, array_keys($data)));
		$values = array_map(function($value) use($mysqli) {
			if( $mysqli && !is_null($value) ) $value = $mysqli->real_escape_string( $value );
			return self::val( $value );
		}, array_values($data));
		$values = implode(", ", $values);
		$SQL = "INSERT INTO `{$tablename}` ($columns) VALUES ($values)";
		return $SQL;
	}
	
	public static function update( string $tablename, array $data, $condition = 1, ?MYSQLI $mysqli = null ) {
		$fieldset = array_map(function($key, $value) use($mysqli) {
			if( $mysqli && !is_null($value) ) $value = $mysqli->real_escape_string( $value );
			return "`{$key}` = " . self::val( $value );
		}, array_keys($data), array_values($data));
		$fieldset = implode(", ", $fieldset);
		$SQL = "UPDATE `{$tablename}` SET {$fieldset} WHERE {$condition}";
		return $SQL;
	}
	
	public static function delete( string $tablename, string $condition ) {
		$SQL = "DELETE FROM `{$tablename}` WHERE {$condition}";
		return $SQL;
	}
	
}