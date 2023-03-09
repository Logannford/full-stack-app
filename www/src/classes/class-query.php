<?php 
	/**
	 * this will allow you to make new SQL_QUERIES where you can pass in what you would like
	 * i.e ALTER, INSERT etc etc
	*/

	class SqlQuery extends DbConfig{

		protected $data_select;
		protected $table_name;
		protected $value;
		protected $scope;
		protected $filter;

		public function __construct(){
			//here we are calling the constructor of the 'DbConfig' class
			parent::__construct();
		}

		/**		 
		 * 	using SELECT to select data from the db
		*/

		function select(array $scope){
			//setters
			$this->table_name = $scope["table"];
			$this->data_select = $scope["select"];
			$this->filter = $scope["filter"];

			//allowing to enter "all" as a param in the select method
			$this->data_select = "all" 
				? $this->value = "*" 
				: $this->value = $this->value;

			//if no connection then adios 
			if(!$this->connection)
				die();
			//check setters that aren't optional aren't null
			if(is_null($this->data_select) || is_null($this->table_name))
				die();

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