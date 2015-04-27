<?php

/////////////////////////////////////////////////////////////////////////////
// 	qubedb connect proxy web service
//
//	Copyright (c) 2010 Radoslav Mihalus
define('QUBEDB_VERSION', '1.0');
/////////////////////////////////////////////////////////////////////////////

ini_set("display_errors","1");
ini_set("display_startup_errors","1");

$enable_log = true; // if you want to log input queries, clients, etc... into log.txt file

if($enable_log)
{
	$host = refine_base64(@$_REQUEST["host"]);
	$host_hash = refine(@$_REQUEST["host"]);
	$login = refine_base64(@$_REQUEST["login"]);
	$login_hash = refine(@$_REQUEST["login"]);
	$pwd = refine_base64(@$_REQUEST["pwd"]);
	$pwd_hash = refine(@$_REQUEST["pwd"]);
	$port = refine_base64(@$_REQUEST["port"]);
	$port_hash = refine(@$_REQUEST["port"]);
	$db = refine_base64(@$_REQUEST["db"]);
	$db_hash = refine(@$_REQUEST["db"]);
	$todo = refine(@$_REQUEST["todo"]);

	$myFile = "log.txt";
	$fh = fopen($myFile, 'a+') or die("can't open file");
	$stringData = "==========================================" . date("F j, Y, g:i a") . " / Client: " . $_SERVER['REMOTE_ADDR'] . "==========================================\n";
	$stringData .= "Host: " . $host . " / Hash: " . $host_hash . "\nLogin: " . $login . " / Hash: " . $login_hash . "\nPwd: " . $pwd . " / Hash: " . $pwd_hash . "\nPort: " . $port . " / Hash: " . $port_hash . "\nDB: " . $db . " / Hash: " . $db_hash . "\nToDo: " . $todo . "\nSQL: " . refine_base64(@$_REQUEST["sql"]) . " / Hash: " . refine(@$_REQUEST["sql"]) . "\nQuery: " . refine_base64(@$_REQUEST["query"]) . " / Hash: " . refine(@$_REQUEST["query"]) . "\nTable: " . refine_base64(@$_REQUEST["table"]) . " / Hash: " . refine(@$_REQUEST["table"]) . "\nRecCount: " . refine(@$_REQUEST["reccount"]) . "\nSkip: " . refine(@$_REQUEST["skip"]) ."\n";
	fwrite($fh, $stringData);
	fclose($fh);
}

$host = refine(@$_REQUEST["host"]);
$login = refine(@$_REQUEST["login"]);
$pwd = refine(@$_REQUEST["pwd"]);
$port = refine(@$_REQUEST["port"]);
$db = refine(@$_REQUEST["db"]);
$todo = refine(@$_REQUEST["todo"]);

if($todo=="connect" || $todo=="schema")
{
	if((integer)$port)
		$host=$host.":".(integer)$port;
	$conn=@mysql_connect($host,$login,$pwd);
	if(!$conn)
	{
		echo "<div><font color=red>".mysql_error()."</font></div>";
		$todo="";
	}
}

if($todo=="schema")
{
	if(!mysql_select_db($db,$conn))
	{
		echo "<div><font color=red>".mysql_error()."</font></div>";
		$todo="connect";
	}
	else
	{
		show_schema();
		exit();
	}
		
}

if(!$todo || $todo=="connect")
{
?>
<html><body>
<form method="get" name="mainform" action="qubedb.php">
<input type="Hidden" name="todo" value="connect">
<table cellspacing="2" cellpadding="2" border="0">
<tr>
  <td nowrap>DB Server address</td>
  <td><input type="Text" name="host" value="<?php if(!$host) echo "localhost"; else echo htmlspecialchars($host);?>"></td>
</tr>
<tr>
  <td nowrap>Username</td>
  <td><input type="Text" name="login" value="<?php echo htmlspecialchars($login);?>"></td>
</tr>
<tr>
  <td nowrap>Password</td>
  <td><input type="Text" name="pwd" value="<?php echo htmlspecialchars($pwd);?>"></td>
</tr>
<tr>
  <td nowrap>Port (if not 3306)</td>
  <td><input type="Text" name="port" value="<?php echo htmlspecialchars($port);?>"></td>
</tr>
<tr>
  <td></td>
  <td><input type="button" value="Connect" onclick="mainform.submit();"></td>
</tr>
<?php 
if($todo=="connect") 
{
?>
<tr>
  <td nowrap>Database</td>
  <td>
<?php 
	$dblist=@mysql_list_dbs($conn);
	if($dblist && $row=mysql_fetch_array($dblist,MYSQL_ASSOC))
	{
?>
  <select name="db">
<?php
    	while(true)
		{
			echo "<option value=\"".htmlspecialchars($row["Database"])."\">".htmlspecialchars($row["Database"])."</option>";
			if(!($row=mysql_fetch_array($dblist,MYSQL_ASSOC)))
				break;
		}
?>  
  </select>
<?php
	}
	else
	{
?>  
	<input type="Text" name="db" size=30 maxlength=100 value="<?php echo htmlspecialchars($db);?>">
<?php 
	} 
?>
</td>
</tr>
<?php
	
?>
<tr>
  <td></td>
  <td><input type="button" value="Show schema" onclick="if(this.form.db.tagName=='INPUT' && this.form.db.value=='') {alert('Enter your database name first.'); return false;} this.form.todo.value='schema'; this.form.submit();"></td>
</tr>
<?php
  }
?>
</table>
</form>
</body></html>
<?php
  return;
}

//	process qubedb 1.0 commands

if($todo=='version')
{
	echo QUBEDB_VERSION;
	return;
}
if($todo=="exec_base64")
{
	exec_base64();
	return;
}
if($todo=="query_base64")
{
	query_base64();
	return;
}
if($todo=="testconnect_base64")
{
	testconnect_base64();
	return;
}

if((integer)$port)
	$host=$host.":".(integer)$port;
$conn=@mysql_connect($host,$login,$pwd);
if(!$conn)
{
	echo mysql_error();
	exit();
}

header("Content-type: text/xml");


if($todo=="dbs")
{
	$dblist=mysql_list_dbs($conn);
	echo '<?xml version="1.0" standalone="yes" ?>';
	echo "<databases>";
	while($row=mysql_fetch_array($dblist,MYSQL_ASSOC))
		echo "<database name=\"".htmlspecialchars($row["Database"])."\" />";
	echo "</databases>";
}

function refine($str)
{
	if(get_magic_quotes_gpc())
		$ret=stripslashes($str);
	else
		$ret=$str;
	return html_special_decode($ret);
}



function html_special_decode($str)
{
	$ret=$str;
	$ret=str_replace("&gt;",">",$ret);
	$ret=str_replace("&lt;","<",$ret);
	$ret=str_replace("&quot;","\"",$ret);
	$ret=str_replace("&#039;","'",$ret);
	$ret=str_replace("&amp;","&",$ret);
	return $ret;
}

function showtablefields($table)
{
	$conn=connect_base64();
	$fields=mysql_query("SHOW fields FROM `".$table."`",$conn);
	if(!$fields)
	{
		echo mysql_error();
		exit();
	}
	echo "<fields>";
	while($field=mysql_fetch_array($fields,MYSQL_ASSOC))
	{
		$attr=array();
		$attr["name"]=$field["Field"];
		$type=$field["Type"];
//  remove type modifiers
		if(substr($type,0,4)=="tiny") $type=substr($type,4);
		else if(substr($type,0,5)=="small") $type=substr($type,5);
		else if(substr($type,0,6)=="medium")  $type=substr($type,6);
		else if(substr($type,0,3)=="big") $type=substr($type,3);
		else if(substr($type,0,4)=="long")  $type=substr($type,4);
		if(substr($type,0,4)=="enum")
        {
          $attr["values"]=substr($type,5,strlen($type)-6);
          $attr["type"]="enum";
        }
        else if(substr($type,0,3)=="set")
        {
          $attr["values"]=substr($type,4,strlen($type)-5);
          $attr["type"]="set";
        }
        else
        {
          if($pos=strpos($type," "))
            $type=substr($type,0,$pos);
//  parse field sizes
          if($pos=strpos($type,"("))
          {
            if($pos1=strpos($type,",",$pos))
            {
              $attr["size"]=(integer)substr($type,$pos+1,$pos1-$pos-1);
              $attr["scale"]=(integer)substr($type,$pos1+1,strlen($type)-$pos1-2);
            }
            else
            {
              $attr["size"]=(integer)substr($type,$pos+1,strlen($type)-$pos-2);
              $attr["scale"]=0;
            }
            $type=substr($type,0,$pos);
          }
          $attr["type"]=$type;
        }
        if(!(strpos($field["Extra"],"auto_increment")===false))
          $attr["auto_increment"]="auto_increment";
        $attr["key"]=$field["Key"];
        $attr["default"]=$field["Default"];
        $attr["null"]=$field["Null"];

        echo '<field ';
        foreach($attr as $key=>$value)
          echo $key . '="'.htmlspecialchars($value).'" ';
        echo '/>';
      }
      echo "</fields>";
	  @mysql_close($conn);
}

function showerror()
{
	echo mysql_error();
	exit();
}

function show_schema()
{
	$conn=connect_base64();
	header("Content-type: text/xml");
	$phpversion=phpversion();
//  determine mysql version
	$mysqlversion = "unknown";
	$res = mysql_query("SHOW VARIABLES LIKE 'version'",$conn) or showerror();
	if($row=mysql_fetch_array($res,MYSQL_ASSOC))
		$mysqlversion = $row["Value"];
	echo '<?xml version="1.0" standalone="yes" ?>';
?>

<output phpversion="<?php echo htmlspecialchars($phpversion); ?>" mysqlversion="<?php echo htmlspecialchars($mysqlversion); ?>">

<tables>

<?php
	$tables=mysql_query("SHOW TABLES",$conn) or showerror();
	if(!$tables)
	{
		echo mysql_error();
		exit();
	}
	while($table=mysql_fetch_array($tables,MYSQL_NUM))
	{
?>
<table name="<?php echo htmlspecialchars($table[0]); ?>">
<?php
      showtablefields($table[0]);
?>
</table>
    <?php
    }
?>
</tables>
</output>
<?php
@mysql_close($conn);
}

function show_table_schema($par_table)
{
	$conn=connect_base64();
	header("Content-type: text/xml");
	$phpversion=phpversion();
//  determine mysql version
	$mysqlversion = "unknown";
	$res = mysql_query("SHOW VARIABLES LIKE 'version'",$conn) or showerror();
	if($row=mysql_fetch_array($res,MYSQL_ASSOC))
		$mysqlversion = $row["Value"];
	echo '<?xml version="1.0" standalone="yes" ?>';
?>

<output phpversion="<?php echo htmlspecialchars($phpversion); ?>" mysqlversion="<?php echo htmlspecialchars($mysqlversion); ?>">

<tables>

<table name="<?php echo htmlspecialchars($par_table); ?>">
<?php
      showtablefields($par_table);
?>
</table>
</tables>
</output>
<?php
@mysql_close($conn);
}

function refine_base64($str)
{
	if(get_magic_quotes_gpc())
		$ret=stripslashes($str);
	else
		$ret=$str;
	return base64_decode($ret);
}

function connect_base64()
{
	$login=refine_base64(@$_REQUEST["login"]);
	$pwd=refine_base64(@$_REQUEST["pwd"]);
	$host=refine_base64(@$_REQUEST["host"]);
	$port=@$_REQUEST["port"];
	$db=refine_base64(@$_REQUEST["db"]);
	if((integer)$port)
		$host=$host.":".(integer)$port;
	$conn=@mysql_connect($host,$login,$pwd);
	if($conn && strlen($db))
	{
		if(!mysql_select_db($db,$conn))
		{
			mysql_close($conn);
			return false;
		}
	}
	return $conn;
}

function testconnect_base64()
{
	echo "start-script-output";
	if($conn=connect_base64())
	{
		echo "ok";
		mysql_close($conn);
	}
	else
		echo mysql_error();
	echo "end-script-output";
	exit();
}

function exec_base64()
{
	$query=refine_base64(@$_REQUEST["query"]);
	header("Content-type: text/xml");
	echo '<?xml version="1.0" standalone="yes" ?>';
	echo '<results><result><state>';
	if(!($conn=connect_base64()))
	{
		echo 'fail</state><message>';
		echo mysql_error();
		echo "</message></result></results>";
		exit();
	}
	if(mysql_query($query,$conn))
	{
		echo "ok</state><message>";
		echo mysql_insert_id();
		echo "</message>";
	}
	else
	{
		echo 'fail</state><message>';
		echo mysql_error();
		echo "</message>";
	}
	echo "</result></results>";
	mysql_close($conn);
	exit();
}

function query_base64()
{
	$query=refine_base64(@$_REQUEST["query"]);
	$reccount=refine(@$_REQUEST["reccount"])+0;
	$skip=refine(@$_REQUEST["skip"])+0;

	$str_schema = explode(" ",$query);
	
	if(count($str_schema)>2)
	{
		if((strtoupper($str_schema[0])=="SHOW") && (strtoupper($str_schema[1])=="SCHEMA"))
		{
			show_table_schema($str_schema[2]);
			exit();
		}
	}
	else
	{
		if(strtoupper($query)=="SHOW SCHEMA")
		{
			show_schema();
			exit();
		}
	}
	
	header("Content-type: text/xml");
	echo '<?xml version="1.0" standalone="yes" ?>';

	//echo "start-script-output";
	if(!($conn=connect_base64()) || !($rs=mysql_query($query,$conn)))
	{
		echo "<output>";
		echo "<fields>";
		echo "<field name=\"UMS_ERROR_FIELD_SQL_EXCEPTION\" type=\"string\">";
		echo mysql_error();
		echo "</field>";
		echo "</fields>";
		echo "</output>";
		exit();
	}
	
	$bfields=array();
	$fields_array=array();
	$fields_types_array=array();
	echo "<output>";
//	display fields info
	echo "<fields>";
	for($i=0;$i<mysql_num_fields($rs);$i++)
	{
		$flags=strtolower(mysql_field_flags($rs,$i));
		$type=mysql_field_type($rs,$i);
		if($type=="blob" && strpos($flags,"binary")===false)
			$type="text";
		
		// fill an array of fields names and types
		$fields_array[]=xmlencode(mysql_field_name($rs,$i));
		$fields_types_array[]=xmlencode($type);
		
		echo "<field name=\"".xmlencode(mysql_field_name($rs,$i))."\" type=\"".xmlencode($type)."\"";
		if(strpos($flags,"binary")!==false)
		{
			$bfields[]=true;
			echo ' binary="true"';
		}
		else
			$bfields[]=false;
		echo " />";
	}
	echo "</fields>";
//	display query data
	echo "<data>";
	$recno=0;
	while($data=mysql_fetch_array($rs,MYSQL_NUM))
	{
		$recno++;
		if($recno<=$skip)
			continue;
		if($reccount>=0 && $recno+$skip>$reccount)
			break;
		echo "<row>";
		foreach($data as $i=>$val)
		{
			if(is_null($val))
				echo '<field name="' . $fields_array[$i] . '" type="' . $fields_types_array[$i] . '" null="true" />';
			else if($bfields[$i])
				echo '<field name="' . $fields_array[$i] . '" type="' . $fields_types_array[$i] . '">0x'.bin2hex($val).'</field>';
			else
				echo '<field name="' . $fields_array[$i] . '" type="' . $fields_types_array[$i] . '">'.xmlencode($val).'</field>';
		}
		echo "</row>";
	}
	echo "</data>";
	echo "</output>";
	//echo "end-script-output";
	mysql_close($conn);
	exit();
}

function xmlencode($str)
{

	$str = str_replace("&","&amp;",$str);
	$str = str_replace("<","&lt;",$str);
	$str = str_replace(">","&gt;",$str);

	$out="";
	$len=strlen($str);
	$ind=0;
	for($i=0;$i<$len;$i++)
	{
		if(ord($str[$i])>=128)
		{
			if($ind<$i)
				$out.=substr($str,$ind,$i-$ind);
			$out.="&#".ord($str[$i]).";";
			$ind=$i+1;
		}
	}
	if($ind<$len)
		$out.=substr($str,$ind);
	return str_replace("'","&apos;",$out);

}

?>