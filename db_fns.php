<?php
	function db_connect()
{
	$host='';
	$db = '';
	$user='';
	$pswd='';
	
	$connection=mysql_connect($host, $user, $pswd);
	mysql_set_charset( 'utf8' );
	if(!$connection || !mysql_select_db($db,$connection)) {
		return false;
	}
	return $connection;
}

	function db_result_to_array($result)
	{
		$res_array=array();
		$count=0;
		while($row=mysql_fetch_array($result))
		{
		$res_array[$count]=$row;
		$count++;
		}
		return $res_array;
	}



	function GetProducts($category)
	{
		db_connect();
		$query="SELECT * FROM ".$category." ORDER BY id ASC";
		$result = mysql_query($query);
		$result=db_result_to_array($result);
		return $result;
	}



	
	
	function GetSingleProduct($category,$id)
	{
		db_connect();

		$query=("SELECT * FROM ".$category." WHERE id='$id' ");

		$result = mysql_query($query);
		
		$row = mysql_fetch_array($result);
		
		return $row;

	}


?>