<?php
	function fetchArray($result)
	{
		$array = array();
	
		if($result instanceof mysqli_stmt)
		{
			$result->store_result();
	
			$variables = array();
			$data = array();
			$meta = $result->result_metadata();
	
			while($field = $meta->fetch_field())
				$variables[] = &$data[$field->name]; // pass by reference
	
			call_user_func_array(array($result, 'bind_result'), $variables);
	
			$i=0;
			while($result->fetch())
			{
				$array[$i] = array();
				foreach($data as $k=>$v)
					$array[$i][$k] = $v;
				$i++;
	
				// don't know why, but when I tried $array[] = $data, I got the same one result in all rows
			}
		}
		elseif($result instanceof mysqli_result)
		{
			while($row = $result->fetch_assoc())
				$array[] = $row;
		}
	
		return $array;
	}
	
	function fetchRow($stmt)
	{
	    if($stmt->num_rows>0)
	    {
	        $result = array();
	        $md = $stmt->result_metadata();
	        $params = array();
	        while($field = $md->fetch_field()) {
	            $params[] = &$result[$field->name];
	        }
	        call_user_func_array(array($stmt, 'bind_result'), $params);
	        if($stmt->fetch())
	            return $result;
	    }
	
	    return null;
	}
?>