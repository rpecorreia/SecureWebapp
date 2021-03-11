<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'databasesi');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
$con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD) or die("Failed to connect to MySQL: " . mysqli_error());
//$db = mysqli_select_db(DB_NAME, $con) or die("Failed to connect to MySQL: " . mysqli_error());
$username = $_POST['myusername'];
$password = $_POST['mypassword'];
$failedAttempts = 0;


if (!isset($_POST['submit']))
	{

	SignIn($username,$password);	
	}

function SignIn($username,$password)
	{
		//echo "$username";
	if (!empty($username))
		{
		//$mysqli = new mysqli('localhost', 'root', '', 'databasesi');		
		//$sql = "SELECT * FROM User where username = '$_POST[myusername]', where password = '$_POST[mypassword]'";	
		//$result = $mysqli->query($query);
		//$row = mysqli_fetch_array($result,MYSQL_BOTH);
		//$row = $result->fetch_array(MYSQLI_NUM);
		$link = mysqli_connect('localhost', 'root', '', 'databasesi');
		//$id_get = mysqli_query($con, "SELECT id FROM User WHERE username='$username' LIMIT 1");
		//$id = mysqli_fetch_array($id_get);
		//$query = mysqli_query($link,"SELECT username FROM User = '$username'");		
		//$row = mysqli_fetch_row($query);
		$user_get = mysqli_query($link, "SELECT * FROM User WHERE username='$username'");
		$row = mysqli_fetch_array($user_get);
		echo $row['username'];		
		
		//echo "$row";
		//echo 'dei';
		if ($row['username'] == $username)
			{
			$failedAttempts = $row['failedAttempts'];
			if ($failedAttempts < 3)
				{				
				$salt = $row['salt'];				
				$readkey = fopen("server.key", "r");
				$key = fread($readkey, filesize("server.key"));
				fclose($readkey);
				$enc= $password . $salt;
				for ($i=1; $i <=1024 ; $i++) { 
   					$hash = hash_hmac("sha256",$enc,$key);
				}	
							
				if ($row['password'] == $hash)
					{
					$failedAttempts = 0;
					$username = $row['username'];
					$benfica23 = $username;
					$query2 = mysqli_query($link,"UPDATE User SET failedAttempts = 0 WHERE username = '$benfica23'") or die(mysql_error());					
					header("Location: http://localhost/index.html");
					exit();
					}
				  else
					{
					$failedAttempts = $failedAttempts + 1;
					$username = $row['username'];
					$benfica22 = $username;
					$query2 = mysqli_query($link,"UPDATE User SET failedAttempts = failedAttempts + 1 WHERE myusername ='$benfica22' ");
					//header("Location: http://localhost/tryagain.html"); //criar um echo botão para voltar atrás
					exit();
					}
				}
			  else
				{
					echo "Não cá nada";
				//header("Location: http://localhost/blocked.html"); //criar um echo botão para bloquear
				exit();
				}
			}
		  
		}
	}

?>

