<?php
	
$page_title = "Candidate Registration Form";
require ('./bootstrap.php');
require ('./layout/header.php');
require ('../dbase/db-config.php');
require ('../include/common-function.php');
require ('../include/parse-function.php');

if ($_SESSION['permissions'][2] == false && $_SESSION['permissions'][7] == false)
	echo '<script language=javascript>alert("You do not have permissions to view this page."); window.location.replace("./");</script>';

if (isset($_GET['candreg'])) {
	if ($_GET['candreg'] == 1) {
		if (isset($_FILES['image'])) {
			$file = '../images/candidates/cand'.$_POST['mykad'].'.'.strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
			move_uploaded_file($_FILES['image']['tmp_name'], $file);
			$insertcand = mysqli_query($sql, 'INSERT INTO candidates (mykad, officeid, photopath) VALUES ("'.$_POST['mykad'].'", "'.$_POST['office'].'", "'.substr($file, 1).'")');
			if ($insertcand == true)
				echo '<script language=javascript>alert("Registration is a success!"); window.location.replace("', $_SERVER['PHP_SELF'], '");</script>';
			else
				echo '<script language=javascript>alert("The system had encountered one or more errors. Please try again later."); window.location.replace("', $_SERVER['PHP_SELF'], '?page=registration', '");</script>';
		}
	}
}
else {

?>
			<h3><?php echo $page_title; ?></h3>
			<?php if (empty($_POST['mykad'])) { ?>
				<center>
				<form action='<?php echo $_SERVER['PHP_SELF']; ?>' method='POST'>
					<table cellpadding='10' cellspacing='0'>
						<tr>
							<td><input class='logintextbox' type='number' maxlength='12' name='mykad' size='30' placeholder='MyKad Number' /></td>
							<td><p><input class='loginbutton' type='submit' value='Find' /></p></td>
						</tr>
					</table>
				</form>
				</center>
			<?php
			
					}
					else {
						if (check_mykad($_POST['mykad'], $sql) == true) {

			?>
				<div class='form'>
					<form action='<?php echo $_SERVER['PHP_SELF'], '?candreg=1'; ?>' enctype='multipart/form-data' method='POST'>
						<input type='hidden' name='mykad' value='<?php echo $_POST['mykad']; ?>' />
						<table cellpadding='20' cellspacing='0'>
							<tr>
								<td>MyKad Number:</td>
								<td><?php echo $_POST['mykad']; ?></td>
							</tr><tr>
								<td>Full Name:</td>
								<td><?php echo parse_name($_POST['mykad'], $sql); ?></td>
							</tr><tr>
								<td>Contested Office*:</td>
								<td>
			<?php
			
							if ($result = mysqli_query($sql, 'SELECT * FROM office')) {
								while ($row = mysqli_fetch_row($result))
									echo '<label><input type="radio" name="office" value="', $row[0], '"/>', $row[1], '</label><br/>';
							}
					
			?>
								</td>
							</tr><tr>
								<td>Candidate's Picture:</td>
								<td><input type='file' name='image' accept='image/*' /></td>
							</tr><tr>
								<td colspan='2'>* Indicates required field.</td>
							</tr>
						</table>
						<p><input class='button' type='submit' value='Register' /></p>
					</form>
				</div>
			<?php
						}
						else
							echo '<script language=javascript>alert("Invalid MyKad number or the candidate has not registered as a voter."); window.location.replace("', $_SERVER['PHP_SELF'], '");</script>';
					}
				}
				require ('./layout/footer.php');
			
			?>