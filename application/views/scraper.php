<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title> Identityiq scraper </title>
	<style>
		* {
			margin: 0;
			padding:0
		}
		.form_container {
			display: table;
		}
		.form_container * {
			padding: 2px;
			margin: 2px;
		}
		.form_container label, .form_container input {
			display: table-cell;
		}

	</style>
</head>
<body>
<?php echo validation_errors(); ?>
<?php echo form_open("scraper"); ?>
<div class="form_container">
	<p> Please enter <strong>identityiq</strong> details below :</p>

	<div style="display: table-row">
		<label for="username"> Username</label>
		<input id="username" type="text" name="username" value="ctorre19@aol.com"/>
		<?php echo form_error("username"); ?>
	</div>
	<div style="display: table-row">
		<label for="passwd"> Password</label>
		<input id="passwd" type="password" name="passwd" value="credit123"/>
		<?php echo form_error("passwd"); ?>
	</div>
	<div style="display: table-row">
		<label for="code"> Security code</label>
		<input id="code" type="number" name="code" value="9581"/>
		<?php echo form_error("code"); ?>
	</div>
	<div style="display: table-row">
		<label></label>
		<input type="submit" value="Start" />
	</div>
</div>
</form>
</body>
</html>
