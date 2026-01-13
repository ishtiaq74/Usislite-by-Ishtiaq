<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<meta name="description" content="Connect User Login"/>
	<title>Connect | Login & Signup</title>

	<style>
		/* Reset */
		* {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
			font-family: Arial, Helvetica, sans-serif;
		}

		body {
			min-height: 100vh;
			background: linear-gradient(
				to bottom,
				#243447,
				#5F7A92,
				#AFC6D1,
				#EFE7DA
			);
			display: flex;
			justify-content: center;
			align-items: center;
		}

		.container {
			display: flex;
			gap: 40px;
			padding: 30px;
			flex-wrap: wrap;
		}

		section {
			background: rgba(255, 255, 255, 0.9);
			padding: 25px 30px;
			border-radius: 10px;
			width: 320px;
			box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
		}

		h1 {
			text-align: center;
			margin-bottom: 20px;
			color: #243447;
		}

		.form_design div {
			margin-bottom: 15px;
		}

		.form_design input[type="text"],
		.form_design input[type="password"],
		.form_design input[type="email"],
		.form_design input[type="tel"] {
			width: 100%;
			padding: 10px;
			border: 1px solid #AFC6D1;
			border-radius: 5px;
			outline: none;
			font-size: 14px;
		}

		.form_design input:focus {
			border-color: #5F7A92;
			box-shadow: 0 0 5px rgba(95, 122, 146, 0.4);
		}

		.form_design input[type="submit"] {
			width: 100%;
			padding: 10px;
			background-color: #243447;
			color: #ffffff;
			border: none;
			border-radius: 5px;
			font-size: 15px;
			cursor: pointer;
			transition: background-color 0.3s ease;
		}

		.form_design input[type="submit"]:hover {
			background-color: #5F7A92;
		}

		@media (max-width: 700px) {
			.container {
				flex-direction: column;
				align-items: center;
			}
		}
	</style>
</head>

<body>
	<div class="container">
		<section id="signin">
			<h1>Login to Connect</h1>
			<form action="signin.php" class="form_design" method="post">
				<div>
					<input type="text" name="username" placeholder="Username" required>
				</div>
				<div>
					<input type="password" name="password" placeholder="Password" required>
				</div>
				<div>
					<input type="submit" value="Sign In">
				</div>
			</form>
		</section>

		<section id="signup">
			<h1>Sign Up to Connect</h1>
				<form action="signup.php" class="form_design" method="post">

					<div>
						<input type="text" name="username" placeholder="Username" required>
					</div>

					<div>
						<input type="password" name="password" placeholder="Password" required>
					</div>

					<div>
						<input type="text" name="name" placeholder="Full Name" required>
					</div>

					<div>
						<input type="email" name="email" placeholder="Email" required>
					</div>

					<div>
						<input type="tel" name="phoneno" placeholder="Phone Number" required>
					</div>

					<div>
						<select name="role" required style="width:100%;padding:10px;">
							<option value="">Select Role</option>
							<option value="student">Student</option>
							<option value="faculty">Faculty</option>
						</select>
					</div>

					<div>
						<input type="submit" value="Sign Up">
					</div>

				</form>
		</section>

	</div>
</body>
</html>
