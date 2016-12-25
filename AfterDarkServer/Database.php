<?php

require_once (__DIR__.'/Output.php');

class Database {

    
    //const database_IP = "116.86.71.55";
    const database_IP = "127.0.0.1";
    const database_Name = "afterdarktest001";
    const username = "root";
    const password = "root";

    static $con;

    public static function BeginConnection() {
        error_reporting(1);
        self::$con = mysqli_connect(self::database_IP, self::username, self::password, self::database_Name, "3306");

        if (mysqli_connect_errno() != 0) {
            Output::Fail("cant connect to database server" . mysqli_connect_error());
            exit();
        }

        return self::$con;
    }

    public static function QueryStmtToArrayAssoc(mysqli_stmt $stmt) {
        $stmt->execute();
        $result = Database::get_result($stmt);

        $outputArray = array();

        //row is a dictionary here
        foreach ($result as $row) {
            array_push($outputArray, $row);
        }

        //outputs an array of dictionaries
        $output = $outputArray;
        return $output;
    }

    public static function QueryStringToArrayAssoc(String $query) {

        $resultArray = array();
        if ($result = mysqli_query(self::$con, $query)) {

            while ($row = $result->fetch_assoc()) {

                array_push($resultArray, $row);
            }
            $output = $resultArray;
        }
        return $output;
    }

    public static function SelectWhereColumn(String $request, String $table, String $column_name, String $row_value) {
        $query = "SELECT $request FROM $table WHERE $column_name = ?";

        
        if (!$stmt = mysqli_prepare(self::$con, $query)) {
            Output::Fail("failed to prepare statement");
        }


        $stmt->bind_param("s", $row_value);

        $output = self::QueryStmtToArrayAssoc($stmt);
        return $output;
    }

    public static function Select(String $request, String $table) {
        $query = "SELECT $request FROM $table";

        if (!$stmt = mysqli_prepare(self::$con, $query)) {
            Output::Fail("failed to prepare statement");
        }


        $output = self::QueryStmtToArrayAssoc($stmt);
        return $output;
    }

    public static function StatementSelectWhere(String $request, String $table,array $columns,array $values,String $types)
    {


        //check if number of values correspond to number of columns
        if(count($columns) != count($values))
        {
            Output::Fail("statement select failed: number of colums and values do not match");
        }
        
        if(strlen($types) != count($values))
        {
            Output::Fail("specified types do not tally with number of values");
        }
        
        //create column questionmark pair
        $condition = "";
        
        for($i = 0; $i < count($columns); $i++)
        {
            $column = $columns[$i];
            
            if($i != 0)
            {
                $condition .= " AND ";     
            }
            
            $condition .= $column;
            $condition .= " = ?";

        }
        
        if($condition == "")
        {
            return null;
        }
        
        $parameters = array_merge(array($types), $values);
        
        $query = "SELECT $request FROM $table WHERE $condition";

        if(!($stmt = mysqli_prepare(self::$con,$query)))
        {
            Output::Fail("failed to prepare statement");
        }
        
        //convert to reference
        foreach ($parameters as $key=>&$value) {
            $parameters[$key] = &$value;
        }
        
        call_user_func_array(array($stmt,'bind_param'), $parameters);
        
        if($stmt -> execute())
        {
            if ($result = $stmt->get_result()) {
                $row = $result ->fetch_assoc();
                $output = $row;
                
                return $output;
            }
        }
        
        return null;
    }
    
    public static function StatementCountWhere(String $table,array $columns,array $values,String $types)
    {


        //check if number of values correspond to number of columns
        if(count($columns) != count($values))
        {
            Output::Fail("statement select failed: number of colums and values do not match");
        }
        
        if(strlen($types) != count($values))
        {
            Output::Fail("specified types do not tally with number of values");
        }
        
        //create column questionmark pair
        $condition = "";
        
        for($i = 0; $i < count($columns); $i++)
        {
            $column = $columns[$i];
            
            if($i != 0)
            {
                $condition .= " AND ";     
            }
            
            $condition .= $column;
            $condition .= " = ?";

        }
        
        if($condition == "")
        {
            return null;
        }
        
        $parameters = array_merge(array($types), $values);
        
        $query = "SELECT COUNT(*) FROM $table WHERE $condition";

        
        if(!($stmt = mysqli_prepare(self::$con,$query)))
        {
            Output::Fail("failed to prepare statement");
        }
        
        //convert to reference
        foreach ($parameters as $key=>&$value) {
            $parameters[$key] = &$value;
        }
        
        call_user_func_array(array($stmt,'bind_param'), $parameters);
        
        if($stmt -> execute())
        {
            if ($result = $stmt->get_result()) {

                
                $row = $result ->fetch_array();
                $output = $row[0];
                return $output;
            }
            

        }
        
        return null;
    }
    
    
    
    public static function Count(String $table,String $condition, String $param)
    {
        $query = "SELECT COUNT(*) FROM $table WHERE $condition = ? ";
        
        if(!$stmt = mysqli_prepare(self::$con, $query))
        {
            Output::Fail("failed to prepare statement");
        }
        
        $stmt -> bind_param("s", $param);
        $stmt ->execute();
        $result = $stmt -> get_result();
        $outputArray = $result ->fetch_array();
        
        $output = $outputArray[0];
        return $output;
    }
    
    public static function Insert(String $table,String $columns,String $types, array $values)
    {
        self::QuestionMarksFromArray($values);
        

        
        $query = "INSERT INTO $table ($columns) VALUES ($questionMarks)";
        
        $stmt = mysqli_prepare(self::$con, $query);
        
        $parameters = array();

        //first set types into array
        array_push($parameters,$types);
        
        //add the parameters into array
        for($i = 0; $i < $number_of_values; $i++)
        {
           $thisValue = $values[$i];
           array_push($parameters,$thisValue); 
        }
        
        //turn values to references
        foreach ($parameters as $key=>&$value) {
            $parameters[$key] = &$value;
        }
        
        //bind parameters
        call_user_func_array(array($stmt,'bind_param'), $parameters);

        //run statement
        if($stmt ->execute())
        {
            //success
            return true;

        }
        else
        {
            Output::Fail($stmt -> error);
            return false;
        }   
         
        
    }
    
    public static function StatementInsertWhere(String $table,array $set_columns,array $set_values,String $to_set_types)
    {
        

        //check if number of values correspond to number of columns
        if(count($set_columns) != count($set_values))
        {
            Output::Fail("statement select failed: number of columns and values (to set) do not match");
        }

        if(strlen($to_set_types) != count($set_values))
        {
            Output::Fail("specified types do not tally with number of values");
            
        }

        $values_questionmarks = "";
        for($i = 0; $i < count($set_values); $i++)
        {
            if($i != 0)
            {
                $values_questionmarks .= ",";
            }
            
            $values_questionmarks .= "?";

        }
      
        
        $columns = implode(",", $set_columns);
        
        
        
        //query        
        $query = "INSERT INTO $table ($columns) VALUES ($values_questionmarks)";       
        $parameters = array_merge(array($to_set_types),$set_values);
                
        if(!($stmt = mysqli_prepare(self::$con,$query)))
        {
            Output::Fail("failed to prepare statement");
        }
        
        //convert to reference
        foreach ($parameters as $key=>&$value) {
            $parameters[$key] = &$value;
        }
        
        call_user_func_array(array($stmt,'bind_param'), $parameters);
        
        if($stmt -> execute())
        {
            return true;
        }
        
    }
    
    
    public static function StatementUpdateWhere(String $table,array $set_columns,array $set_values,String $to_set_types,array $condition_columns,array $condition_values,String $condition_types)
    {
        

        //check if number of values correspond to number of columns
        if(count($set_columns) != count($set_values))
        {
            Output::Fail("statement select failed: number of columns and values (to set) do not match");
        }
        
        if(count($condition_columns) != count($condition_values))
        {
            Output::Fail("statement select failed: number of colums and values (to check) do not match");
        }
        
        if(strlen($to_set_types) != count($set_values))
        {
            Output::Fail("specified types do not tally with number of values");
            
        }
        if(strlen($condition_types) != count($condition_values))
        {
            Output::Fail("specified types do not tally with number of values");
            
        }
        //build to set key value pair
        $to_set_pair_array = array();
        for($i = 0; $i < count($set_columns); $i++)
        {
            //puts it in format "condition = ?"
            $column = $set_columns[$i];
            
            $set_key_value_pair = $column;
            $set_key_value_pair .= " = ?";
            
            //adds key value pair to array
            array_push($to_set_pair_array,$set_key_value_pair);
        }
        
        //joins all to set values into string
        $to_set = implode(" , ", $to_set_pair_array);
        
        $conditions_pair_array = array();
        for($i = 0; $i < count($condition_columns); $i++)
        {
            $column = $condition_columns[$i];
            
            $condition_key_value_pair = $column . " = ?";
            
            //adds key value pair to array
            array_push($conditions_pair_array,$condition_key_value_pair);
        }
        
        $conditions = implode(" AND ", $conditions_pair_array);
        
        //query        
        $query = "UPDATE $table SET $to_set WHERE $conditions ";

        $all_parameters_types = $to_set_types . $condition_types;
        
        $all_parameter_values = array_merge($set_values,$condition_values);
       
        $parameters = array_merge(array($all_parameters_types),$all_parameter_values);
                
        if(!($stmt = mysqli_prepare(self::$con,$query)))
        {
            Output::Fail("failed to prepare statement");
        }
        
        //convert to reference
        foreach ($parameters as $key=>&$value) {
            $parameters[$key] = &$value;
        }
        
        call_user_func_array(array($stmt,'bind_param'), $parameters);
        
        if($stmt -> execute())
        {
            return true;
        }
        
    }
    
    
    //non associative
    public static function FirstResultFromQuery(String $query) {
        if ($result = mysqli_query(self::$con, $query)) 
        {
            while ($row = mysqli_fetch_array($result)) 
            {
                return $row[0];
            }
        }
        return "query failed: " . $query;
    }

    public static function EndConnection() {
        if (self::$con != nil) {
            mysqli_close(self::$con);
        }
    }
    
    public static function QuestionMarksFromArray(array $array)
    {
        $questionMarks = "";
        $number_of_values = count($array);


        for ($i = 0; $i < $number_of_values; $i++) {
            $questionMarks .= "?";
            if ($i != $number_of_values - 1) {
                $questionMarks .= ",";
            }
        }

        return $questionMarks;
    }	
    
    public static function get_result( $Statement ) {
    $RESULT = array();
    $Statement->store_result();
    for ( $i = 0; $i < $Statement->num_rows; $i++ ) {
        $Metadata = $Statement->result_metadata();
        $PARAMS = array();
        while ( $Field = $Metadata->fetch_field() ) {
            $PARAMS[] = &$RESULT[ $i ][ $Field->name ];
        }
        call_user_func_array( array( $Statement, 'bind_result' ), $PARAMS );
        $Statement->fetch();
    }
    return $RESULT;
}

}
