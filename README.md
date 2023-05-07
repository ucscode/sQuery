# sQuery

sQuery is a simple PHP class that provides a convenient way to construct SQL queries. It offers static methods for generating SELECT, INSERT, UPDATE, and DELETE queries, making it easier to interact with databases in PHP.

The sQuery class provides a simplified and efficient way to interact with databases in PHP, specifically by easing the CRUD (Create, Read, Update, Delete) operations.

## Features

- Generate SELECT queries to retrieve data from a table.
- Generate INSERT queries to insert new records into a table.
- Generate UPDATE queries to update existing records in a table.
- Generate DELETE queries to delete records from a table.

## Requirements

- PHP 5.6 or higher.
- A compatible database (e.g., MySQL, MariaDB) and appropriate database extensions (e.g., MySQLi, PDO) to execute the generated queries.

## Usage

1. Include the `sQuery` class in your PHP file:

   ```php
   require_once 'sQuery.php';
   ```

2. To generate a SELECT query, use the `select()` method:

   ```php
   $query = sQuery::select('tablename', 'condition');
   ```

   Replace `'tablename'` with the name of the table you want to select from, and `'condition'` with the desired condition for filtering the rows.

3. To generate an INSERT query, use the `insert()` method:

   ```php
   $data = array(
      'column1' => 'value1', 
      'column2' => 'value2'
   );
   $query = sQuery::insert('tablename', $data, $mysqli);
   ```

   Replace `'tablename'` with the name of the table you want to insert into, `$data` with an associative array containing the column-value pairs, and `$mysqli` with a valid MySQLi object if you want to escape the values.

4. To generate an UPDATE query, use the `update()` method:

   ```php
   $data = array(
      'column1' => 'value1', 
      'column2' => 'value2'
   );
   $query = sQuery::update('tablename', $data, 'condition', $mysqli);
   ```

   Replace `'tablename'` with the name of the table you want to update, `$data` with an associative array containing the column-value pairs, `'condition'` with the condition for filtering the rows to be updated, and `$mysqli` with a valid MySQLi object if you want to escape the values.

5. To generate a DELETE query, use the `delete()` method:

   ```php
   $query = sQuery::delete('tablename', 'condition');
   ```

   Replace `'tablename'` with the name of the table you want to delete from, and `'condition'` with the condition for filtering the rows to be deleted.

## Limitations

It's important to note that the sQuery class provided is designed to handle basic CRUD operations and may not support more advanced queries involving JOIN clauses or complex SQL statements.

While the class simplifies the construction of SELECT, INSERT, UPDATE, and DELETE queries for individual tables, it may not be suitable for scenarios where JOIN operations are required to combine data from multiple tables. JOIN queries typically involve more complex logic and require a different approach to handle the join conditions and table relationships.

If you need to perform advanced queries involving JOINs or complex SQL statements, it's recommended to use more comprehensive database abstraction libraries or frameworks that offer built-in support for such operations. These libraries or frameworks provide more robust query-building capabilities and handle various types of SQL operations, including JOINs, aggregations, subqueries, and more.

However, for simple CRUD operations on individual tables, the sQuery class can still be a helpful tool to generate the basic SQL queries needed. It offers a convenient and concise way to construct queries without the need to write SQL statements manually.

## Note

Please note that the `sQuery` class only generates SQL query strings; it does not execute them against a database. To execute these queries, you would need to establish a database connection and use appropriate methods from the MySQLi or PDO libraries.

## License

This project is licensed under the [MIT License](LICENSE).
