<!-- <?php
// 2 character salt
if (CRYPT_STD_DES == 1)
{
echo "Standard DES: ".crypt('something','st')."\n<br>"; 
}
else
{
echo "Standard DES not supported.\n<br>";
}

// 4 character salt
if (CRYPT_EXT_DES == 1)
{
echo "Extended DES: ".crypt('something','_S4..some')."\n<br>";
}
else
{
echo "Extended DES not supported.\n<br>";
}

// 12 character salt starting with $1$ 
if (CRYPT_MD5 == 1)
{
echo "MD5: ".crypt('something','$1$somethin$')."\n<br>"; 
}
else
{
echo "MD5 not supported.\n<br>";
}

// Salt starting with $2a$. The two digit cost parameter: 09. 22 characters 
if (CRYPT_BLOWFISH == 1)
{
echo "Blowfish: ".crypt('something','$2a$09$anexamplestringforsalt$')."\n<br>"; 
}
else
{
echo "Blowfish DES not supported.\n<br>";
}

// 16 character salt starting with $5$. The default number of rounds is 5000.
if (CRYPT_SHA256 == 1) 
{
echo "SHA-256: ".crypt('something','$5$rounds=5000$anexamplestringforsalt$')."\n<br>"; }
else
{
echo "SHA-256 not supported.\n<br>";
}

// 16 character salt starting with $6$. The default number of rounds is 5000.
if (CRYPT_SHA512 == 1) 
{
echo "SHA-512: ".crypt('something','$6$rounds=5000$anexamplestringforsalt$')."\n<br>"; }
else
{
echo "SHA-512 not supported.";
}

//MY TEST
$fname = 'Kriss';
$pwd = 'Nihil13789108!1';
$salt = md5(@$fname."gamersUnite");
$newpwd = crypt($pwd,'$6$rounds=5000$'.$salt.'$');
echo ("Original name: ".$newpwd."\n<br>");
//MY TEST
$fname1 = 'Virus';
$pwd1 = 'Nihil13789108!1';
$salt1 = md5(@$fname1."gamersUnite");
$newpwd1 = crypt($pwd,'$6$rounds=5000$'.$salt1.'$');
echo ("Different name: ".$newpwd1."\n<br>");
?> -->

<?php 
$username = "Virus";
include ("inc/header.inc.php");
	$getposts = mysqli_query($conn, "SELECT * FROM posts ORDER BY id DESC LIMIT 10");
	while ($row = mysqli_fetch_assoc($getposts)) {
		$id = $row['id'];
		$body = $row['body'];
		$date_added = $row['date_added'];
		$added_by = $row['added_by'];
		$user_posted_to = $row['user_posted_to'];
		echo "<div class='posted_by'><a href='$added_by'>$added_by</a> - $date_added - </div>&nbsp;&nbsp;$body<br/><hr/>";
		echo $user_posted_to;
	}
	?>