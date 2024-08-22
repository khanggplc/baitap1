<?php
include 'db.php';
?>
<?php
if(isset($_POST['uname'])&& isset($_POST['password']))
{
	function validate($data)
	{
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);

		return $data;
	}

	$uname = validate($_POST['uname']);
	$pass = validate($_POST['password']);

	if (empty($uname))
	{
		header ("Location: login.php?error=User Name is required");
	}
	elseif (empty($pass))
	{
		header ("Location: login.php?error=Password is required");
	}
	else{
		$sql = "SELECT * FROM account WHERE EMAIL='$uname' and MATKHAU='$pass'";
		$result = mysqli_query($conect, $sql);

		if(mysqli_num_rows($result)===1)
		{
			$row = mysqli_fetch_assoc($result);
			if ($row['EMAIL'] === $uname && $row['MATKHAU'] === $pass)
			{
				$_SESSION['EMAIL'] = $row['EMAIL'];
				$_SESSION['HOTEN'] = $row['HOTEN'];
				$_SESSION['ID_DANGNHAP'] = $row['ID_DANGNHAP'];
				header ("Location: Trang chủ.php");
				exit();
			}
			else
			{
				header("Location: login.php?error=Incorect User name or password");
				exit();
			}
		}else
		{
			header("Location: login.php?error=Email hoặc mật khẩu bị sai. Hãy thử lại!");
			exit();
		}
	}
	
	
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="loginstyle.css">
	<link rel="stylesheet" href="login.css">
		<script>

		var input = document.querySelector('.pswrd');
		var show = document.querySelector('.show');
		show.addEventListener('click', active);
		function active(){
			if(input.type === "password"){
				input.type = "text";
				show.style.color = "#1DA1F2";
				show.textContent = "HIDE";
			}else{
				input.type = "password";
				show.textContent = "SHOW";
				show.style.color = "#111";
			}
		}
	
	</script>
</head>

<body>
    <div class="container">
		<header>Đăng nhập</header>
		<form action="" method="POST">
			<?php if(isset($_GET['error'])) {?> <p class="error"><?php echo $_GET['error']; ?></p> <?php } ?>
			<div class="input-field">
				<input type="text" name="uname" required>
				<label>Email</label>
			</div>
			<div class="input-field">
				<input class="pswrd" type="password" name="password"  required>
				<span class="show">SHOW</span>
				<label>Mật khẩu</label>
			</div>
			<div class="button">
				<div class="inner">
				</div>
				<button name="login" type="submit">Đăng nhập</button>
			</div>
		</form>
		<div class="signup">
			<a href="signup.html">Tạo tài khoản</a>
		</div>
		<div class="signup">
			<a href="signup.html">Quên mật khẩu?</a>
		</div>
	</div>
</body>
</html>