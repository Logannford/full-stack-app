<?php 
	/**
	 * this will allow you to make new SQL_QUERIES where you can pass in what you would like
	 * i.e ALTER, INSERT etc etc
	*/

	class SqlQuery extends DbConfig{

		public $data_select;
		public $table_name;
		protected $value;

		public function __construct(){
			//here we are calling the constructor of the 'DbConfig' class
			parent::__construct();
		}

		/**		 
		 * 	using SELECT to select data from the db
		 */

		function select(string $table_name, string $data_select){
			//setters
			$this->table_name = $table_name;
			$this->data_select = $data_select;
			//if no connection then adios 
			if(!$this->connection)
				die();
			//check setters aren't null
			if(is_null($this->data_select) || is_null($this->table_name))
				die();

			//the db query
			$db_query = "SELECT {$this->data_select} FROM " . $this->table_name;

			//the sql query 
			$query = mysqli_query($this->connection, $db_query);
			
			//if no query go bye bye
			if(!$query)
				die();			
			//outputting the rows
			while($row = mysqli_fetch_assoc($query)):
				echo('ID: ' . $row["id"] . ' Name: ' . $row["name"] . '<br>');
			endwhile;
				//free up the memory
			mysqli_free_result($query);
			//close the connection to the db
			mysqli_close($this->connection);
		}


		function insert(string $table_name, string $value){

			$this->table_name = $table_name;
			$this->value = $value;

			//check the connection
			if(!$this->connection)
				die();

			$db_query = 
				"INSERT INTO {$this->table_name}
				(name, dob, date_created)
				VALUES ('test', '10/10/2010', 'date')
				";

			mysqli_query($this-connection, $db_query);
			
		}
	}