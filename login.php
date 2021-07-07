<?php include_once("head.php"); ?>
<?php

if(isset($_SESSION['admin_id'])) {
    alert_msg("이미 로그인 돼있습니다.");
    goto_url(DASHBOARD_URL);
}

?>

<style>
	.login-page {
		width: 360px;
		padding: 8% 0 0;
		margin: auto;
	}

	.form {
		position: relative;
		z-index: 1;
		background: #FFFFFF;
		max-width: 360px;
		margin: 0 auto 100px;
		padding: 45px;
		text-align: center;
		box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
	}

	.form input {
		font-family: "Roboto", sans-serif;
		outline: 0;
		background: #f2f2f2;
		width: 100%;
		border: 0;
		margin: 0 0 15px;
		padding: 15px;
		box-sizing: border-box;
		font-size: 14px;
	}

	.form button {
		display: block;
		font-family: "Roboto", sans-serif;
		text-transform: uppercase;
		outline: 0;
		background: #4CAF50;
		width: 100%;
		border: 0;
		padding: 15px;
		color: #FFFFFF;
		font-size: 14px;
		-webkit-transition: all 0.3 ease;
		transition: all 0.3 ease;
		cursor: pointer;
	}

	.form button:hover,
	.form button:active,
	.form button:focus {
		background: #43A047;
	}

	.form .message {
		margin: 15px 0 0;
		color: #b3b3b3;
		font-size: 12px;
	}

	.form .message a {
		color: #4CAF50;
		text-decoration: none;
	}

	.form .register-form {
		display: none;
	}

	.container {
		position: relative;
		z-index: 1;
		max-width: 300px;
		margin: 0 auto;
	}

	.container:before,
	.container:after {
		content: "";
		display: block;
		clear: both;
	}

	.container .info {
		margin: 50px auto;
		text-align: center;
	}

	.container .info h1 {
		margin: 0 0 15px;
		padding: 0;
		font-size: 36px;
		font-weight: 300;
		color: #1a1a1a;
	}

	.container .info span {
		color: #4d4d4d;
		font-size: 12px;
	}

	.container .info span a {
		color: #000000;
		text-decoration: none;
	}

	.container .info span .fa {
		color: #EF3B3A;
	}

	body {
		background: #76b852;
		/* fallback for old browsers */
		background: -webkit-linear-gradient(right, #76b852, #8DC26F);
		background: -moz-linear-gradient(right, #76b852, #8DC26F);
		background: -o-linear-gradient(right, #76b852, #8DC26F);
		background: linear-gradient(to left, #76b852, #8DC26F);
		font-family: "Roboto", sans-serif;
		-webkit-font-smoothing: antialiased;
		-moz-osx-font-smoothing: grayscale;
    }
    
    .form img {
        margin-bottom: 10%;
    }
</style>

<div class="login-page">
	<div class="form">
        <img src="img/logo.png">
		<!-- <form id="register-form" class="register-form" method="POST" action="<?php echo AJAX_URL; ?>/ajax.register.php">
			<input type="text" name="admin_id" placeholder="ID" />
			<input type="password" name="admin_password1" placeholder="PASSWORD" />
			<input type="password" name="admin_password2" placeholder="PASSWORD 확인" />
			<input type="text" name="admin_name" placeholder="NAME(류대식/전기현)" />
			<button type="submit" form="register-form">CREATE</button>
			<p class="message">Already registered? <a href="#">Sign In</a></p>
		</form> -->
		<form id="login-form" class="login-form" method="POST" action="<?php echo AJAX_URL; ?>/ajax.login.php">
			<input type="text" name="admin_id" placeholder="ID" />
			<input type="password" name="admin_password" placeholder="PASSWORD" />
			<button type="submit" form="login-form">LOGIN</button>
			<!-- <p class="message">Not registered? <a href="#">Create an account</a></p> -->
		</form>
	</div>
</div>

<script>
	// $('.message a').click(function(){
	// 	$('form').animate({height: "toggle", opacity: "toggle"}, "slow");
	// });
</script>

<?php include_once("footer.php"); ?>