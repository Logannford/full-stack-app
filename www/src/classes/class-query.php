<?php 
	/**
	 * this will allow you to make new SQL_QUERIES where you can pass in what you would like
	 * i.e ALTER, INSERT etc etc
	*/

	class SqlQuery extends DbConfig{

		/**
		 * The array which is passed into the methods 
		 * which then set the params for the method
		 */
		public $scope;

		//set the properties to these defaults if they are not passed into $scope
		protected $data_select = "*";
		protected $table_name = "main";
		protected $value;
	
		//optional filter - if empty then select all in that table
		public $filter = "";

		public function __construct(){
			//here we are calling the constructor of the 'DbConfig' class
			parent::__construct();
		}

		/**		 
		 * 	using SELECT to select data from the db
		*/

		function select(array $scope = []){
			if(array_key_exists("table", $scope))
				//setters
				$this->table_name = $scope["table"];
			if(array_key_exists("select", $scope))
				$this->data_select = $scope["select"];
			
			if(!array_key_exists("filter", $scope))
				$this->filter = null;
			else
				$this->filter = $scope["filter"];

			//allowing to enter "all" as a param in the select method
			$this->data_select = "all" 
				? $this->value = "*" 
				: $this->value = $this->value;

			//if no connection then adios 
			if(!$this->connection)
				die();

			//setting some defaults so we can pass nothing in and still get
			//stuff out

			//the db query
			$db_query = 
				"SELECT {$this->data_select} 
				FROM 
				{$this->table_name} 
				{$this->filter}";

			//the sql query 
			$query = mysqli_query($this->connection, $db_query);
			
			//if no query go bye bye
			if(!$query)
				die();		

			//setting the data to be outputted
			$data_to_be_returned = [];
			
			//loop over all fields in the db
			while($row = mysqli_fetch_assoc($query))
				$data_to_be_returned[] = $row;

			//free up the memory
			mysqli_free_result($query);
			//close the connection to the db
			mysqli_close($this->connection);

			//return the data that we have so we can use it
			return $data_to_be_returned;
		}

		function insert(string $table_name, string $value){

			//setters
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

		//	mysqli_query($this-connection, $db_query);
			
		}
	}