<?php

include 'config.php';
include 'sendmail.php';


error_reporting(0);

session_start();


if (isset($_POST['submit'])) {
	$username = $_POST['username'];
	$email = $_POST['email'];
	$password = md5($_POST['password']);
	$cpassword = md5($_POST['cpassword']);

	$check_query = mysqli_query($conn, "SELECT * FROM users where email ='$email'");
	$rowCount = mysqli_num_rows($check_query);
	if (!empty($email) && !empty($password)) {
		if ($rowCount > 0) {
?>
			<script>
				alert("User with email already exist!");
				window.location.replace('index.php');
			</script>
			<?php
		} else {

			if ($password == $cpassword) {

				//function call
				$otp = rand(100000, 999999);
				$_SESSION['otp'] = $otp;
				$_SESSION['username'] = $username;
				$_SESSION['email'] = $email;
				$_SESSION['password'] = $password;

				$check = sendotpmail($otp, $email);


				if (!$check) {
			?>
					<script>
						alert("<?php echo "Register Failed, Invalid Email " ?>");
					</script>
				<?php
				} else {
				?>
					<script>
						alert("<?php echo " OTP sent to " . $email ?>");
						window.location.replace('otp.php');
					</script>
<?php
				}
			} else {
				echo "<script>alert('Password Not Matched.')</script>";
			}
		}
	}
}

?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" type="text/css" href="style.css">

	<title>Register Form</title>

	<script>
		function validateform() {
			var username = document.registrationform.username.value;
			var password = document.registrationform.password.value;

			if (username == null || username == " ") {
				alert("Username can't be blank");
				return false;
			} else if (password.length < 6) {
				alert("Password must be at least 6 characters long.");
				return false;
			}
		}
	</script>

</head>

<body>
	<div class="container">
		<form action="" method="POST" class="login-email" name="registrationform" onsubmit="return validateform()">
			<p class="login-text" style="font-size: 2rem; font-weight: 800;">Register</p>
			<div class="input-group">
				<input type="text" placeholder="Username" name="username" value="<?php echo $username; ?>" required>
			</div>
			<div class="input-group">
				<input type="email" placeholder="Email" name="email" value="<?php echo $email; ?>" required>
			</div>
			<div>
				Role :
				<input type="radio" name="role" value="t" id="teacher" onclick="displayNone()"> Teacher
				<input type="radio" name="role" id="student" value="s" onclick="getYear()"> Student

			</div>
			<div class="input-group">
				<label id="slbranch" style="display:none">Select your Branch </label>
				<select id="branch" style="display:none" name="branch">

					<option value="Computer">COMPUTER</option>
					<option value="ENE">ENE</option>
					<option value="IT">IT</option>
					<option value="ETC">ETC</option>
					<option value="MECH">MECH</option>
					<option value="CIVIL">CIVIL</option>
				</select>
			</div>
			<div class="input-group">
				<label id="slyear" style="display:none">Select your year </label>
				<select id="year" style="display:none" name="year">

					<option value="FE">FE</option>
					<option value="SE">SE</option>
					<option value="TE">TE</option>
					<option value="BE">BE</option>
				</select>
			</div>
			<script>
				function getYear() {
					// Get the checkbox
					var checkBox = document.getElementById("student");
					// Get the output text
					var text = document.getElementById("year");
					var branch = document.getElementById("branch");

					var lableforyear = document.getElementById("slyear");
					var lableforbranch = document.getElementById("slbranch");

					// If the checkbox is checked, display the output text
					if (checkBox.checked == true) {
						text.style.display = "inline";
						lableforyear.style.display = "inline";
						lableforbranch.style.display = "inline";
						branch.style.display = "inline";

					} else {
						text.style.display = "none";
						lableforyear.style.display = "none";
						lableforbranch.style.display = "none";
						branch.style.display = "none";
					}
				}

				function displayNone() {
					// Get the checkbox
					var checkBox = document.getElementById("teacher");
					// Get the output text
					var text = document.getElementById("year");
					var branch = document.getElementById("branch");

					var lableforyear = document.getElementById("slyear");
					var lableforbranch = document.getElementById("slbranch");

					// If the checkbox is checked, display the output text
					if (checkBox.checked == true) {
						text.style.display = "none";
						lableforyear.style.display = "none";
						lableforbranch.style.display = "none";
						branch.style.display = "none";

					} else {
						text.style.display = "inline";
						lableforyear.style.display = "inline";
						lableforbranch.style.display = "inline";
						branch.style.display = "inline";
					}
				}
			</script>


			<div class="input-group">
				<input type="password" placeholder="Password" name="password" value="<?php echo $_POST['password']; ?>" required>
			</div>
			<div class="input-group">
				<input type="password" placeholder="Confirm Password" name="cpassword" value="<?php echo $_POST['cpassword']; ?>" required>
			</div>
			<div class="input-group">
				<button name="submit" class="btn">Register</button>
			</div>
			<p class="login-register-text">Have an account? <a href="index.php">Login Here</a>.</p>
		</form>
	</div>
</body>

</html>