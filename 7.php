<?php
$cookie_name = "loggedin";
$servername = "localhost";
$username = "michu007_dexter";
$password = "admin";
$database = "michu007_dex";



$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn){
	die("błąd: ".msqli_connect_error());
}

if (isset($_POST['login']))
{

	$user = $_POST['username'];
	$pass = $_POST['password'];
	
	$phash = sha1(sha1($pass."salt")."salt");
	
	$sql = "SELECT * FROM users WHERE username='$user' AND password='$phash'";
	$result = $conn->query ($sql);
	$count = mysqli_num_rows($result);
	
	
	if ($count == 1){
		$cookie_value = $user;
		setcookie($cookie_name, $cookie_value, time()+ (86400 * 30), "/");
		header("Location: personal.php");
	}
	else {
		echo "Złe hasło lub login.";echo "<br>";
		echo '<a href="zadanie3.php">Wróć do logowania</a>';echo "<br>";
	}
}
else if (isset($_POST['register'])){
      
	$user = $_POST['username'];
	$pass = $_POST['password'];
	$spr = strlen($pass);
	$spr1 = mysqli_fetch_array($conn ->query("SELECT COUNT(*) FROM users WHERE username='$user' LIMIT 1"));
	if ($spr < 8 || $spr1[0] >= 1) {
  
		echo "Błąd. Hasło musi mieć conajmniej 8 znaków lub login zajęty.";echo "<br>";
		echo '<a href="zadanie3.php">Wróć do logowania</a>';echo "<br>";
	}
	else{
			
               
		
		$phash = sha1(sha1($pass."salt")."salt");
		echo "Zajerestrowano: $user";echo "<br>";
		echo '<a href="zadanie3.php">Wróć do logowania</a>';
		echo "<br>";
               
 $sql = "INSERT INTO users (id, username, password, kolor) VALUES ('', '$user', '$phash', 'red')";
		$result = $conn->query($sql);
}

}}
?>