<?php

$page_title = "Supervisor";
require ('./bootstrap.php');
require ('./layout/header.php');
require ('../dbase/db-config.php');
require ('../include/common-function.php');
require ('../include/parse-function.php');
require ('../include/otp-function.php');

if ($_SESSION['permissions'][6] == false && $_SESSION['permissions'][7] == false)
	echo '<script language=javascript>alert("You do not have permissions to view this page."); window.location.replace("./");</script>';

if (!isset($_GET['page']))
	header('location: ?page=list');

?>
			<h3><?php echo $page_title; ?></h3>
			<div id='supervisornav'>
				<ul>
					<li><a href="?page=list">User's List</a></li>
					<li><a href="?page=registration">User's Registration</a></li>
					<li><a href="?page=report">Report</a></li>
				</ul>
			</div>
			<?php if ($_GET['page'] == 'list') { ?>
			<table class='tablelist' cellpadding='8' cellspacing='0'>
				<tr>
					<th rowspan='2'>MyKad Number</th>
					<th rowspan='2'>Full Name</th>
					<th colspan='6'>Permissions</th>
				</tr><tr class='smalltext'>
					<th>Generate OTP</th>
					<th>Register Candidates</th>
					<th>Register Voters</th>
					<th>View Candidates</th>
					<th>View Voters</th>
					<th>Supervisor</th>
				</tr>
				<?php
				
					if ($result = mysqli_query($sql, "SELECT usersdb.id, usersdb.mykad, usersprofile.fullname, userpermissions.isotp, userpermissions.isregcand, userpermissions.isregvote, userpermissions.isviewcand, userpermissions.isviewvote, userpermissions.issupervisor, userpermissions.isadmin FROM usersdb INNER JOIN usersprofile ON usersdb.id=usersprofile.id INNER JOIN userpermissions ON usersdb.id=userpermissions.id ORDER BY usersprofile.fullname ASC")) {
						while ($row = mysqli_fetch_row($result)) {
							$isize = count($row);
							if ($row[$isize - 1] == 1) {
								for ($i=3; $i<$isize; $i++) {
									$row[$i] = '&#x2714';
								}
							}
							else {
								for ($i=3; $i<$isize; $i++) {
									if ($row[$i] == 0)
										$row[$i] = '&#x2718';
									else if ($row[$i] == 1)
										$row[$i] = '&#x2714';
								}
							}
							echo '<tr>';
							echo '<td>', $row[1], '</td>';
							echo '<td align="left">', $row[2], '</td>';
							echo '<td>', $row[3], '</td>';
							echo '<td>', $row[4], '</td>';
							echo '<td>', $row[5], '</td>';
							echo '<td>', $row[6], '</td>';
							echo '<td>', $row[7], '</td>';
							echo '<td>', $row[8], '</td>';
							echo '</tr>';
						}
					}
					unset($isize);
					
				?>
			</table>
			
			<?php }  else if ($_GET['page'] == 'registration') { ?>
			<div class='form'>
				<form action='<?php echo $_SERVER['PHP_SELF'], '?page=registration'; ?>' method='POST' autocomplete='off'>
					<table class='formtable' cellpadding='20' cellspacing='0'>
						<tr>
							<td colspan='2'><h4>User Registration</h4></td>
						</tr><tr>
							<td>MyKad Number:</td>
							<td><input class='textboxform' type='number' maxlength='12' name='mykad' size='20' placeholder='MyKad Number' /></td>
						</tr><tr>
							<td>Full Name:</td>
							<td><input class='textboxform' type='text' maxlength='100' name='fullname' size='50' placeholder='Full Name' /></td>
						</tr><tr>
							<td>Password:</td>
							<td><input class='textboxform' type='password' maxlength='100' name='password' size='20' placeholder='Password' /></td>
						</tr><tr>
							<td>Permission(s):</td>
							<td><table class='formtable' cellspacing='0'><tr><td>
								<label><input type='checkbox' name='permission[]' value='0' />Generate OTP</label><br/>
								<label><input type='checkbox' name='permission[]' value='1' />Register Candidates</label><br/>
								<label><input type='checkbox' name='permission[]' value='2' />Register Voters</label><br/></td><td>
								<label><input type='checkbox' name='permission[]' value='3' checked />View Candidates List</label><br>
								<label><input type='checkbox' name='permission[]' value='4' />View Voters List</label><br>
								<label><input type='checkbox' name='permission[]' value='5' />Supervisor</label><br>
							</td></tr></table></td>
						</tr>
					</table>
					<p><input class='button' type='submit' value='Register' /></p>
				</form>
			</div>
			<?php
			
					if (!empty($_POST['fullname']) && !empty($_POST['mykad']) && !empty($_POST['password']) && !empty($_POST['permission'])) {
						$name = $_POST['fullname'];
						$salt = password_salt_generator();
						$permissions = parse_permissions_input($_POST['permission']);
						$insertusers = mysqli_query($sql, "INSERT INTO usersdb (mykad, password, salt) VALUES ('".$_POST['mykad']."', '".crypt($_POST['mykad'].$_POST['password'], $salt)."', '".$salt."')");
						$id = mysqli_insert_id($sql);
						$insertprofile = mysqli_query($sql, 'INSERT INTO usersprofile (id, fullname) VALUES ('.$id.', "'.strtoupper($name).'")');
						$insertpermission = mysqli_query($sql, 'INSERT INTO userpermissions VALUES ('.$id.', '.$permissions[0].', '.$permissions[1].', '.$permissions[2].', '.$permissions[3].', '.$permissions[4].', '.$permissions[5].', '.$permissions[6].')');						
						if ($insertpermission == true && $insertprofile == true && $insertusers == true)
							echo '<script language=javascript>alert("Registration is a success!"); window.location.replace("', $_SERVER['PHP_SELF'], '");</script>';
						else
							echo '<script language=javascript>alert("The system had encountered one or more errors. Please try again later."); window.location.replace("', $_SERVER['PHP_SELF'], '?page=registration', '");</script>';
					}
				}
				else if ($_GET['page'] == 'report') {
					if (!empty($_POST['report'])) {
						echo '<script language=javascript>window.open("./report.php?type='.$_POST['report'].'", "_blank", "toolbar=no, scrollbars=yes, resizable=no, top=80, width=1000, height=500");</script>';
					}
					
			?>
			<div class='form'>
				<form action='<?php echo $_SERVER['PHP_SELF'], '?page=report'; ?>' method='POST' autocomplete='off'>
					<table class='formtable' cellpadding='20' cellspacing='0'>
						<tr>
							<td colspan='2'><h4>Report Generator</h4></td>
						</tr><tr>
							<td colspan='2'>Please select the report you want to generate:</td>
						</tr><tr>
							<td colspan='2'>
								<label><input type='radio' name='report' value='votedvoters' />Voted voter's list</label><br/>
								<label><input type='radio' name='report' value='electionwin' />Election results</label><br/>
							</td>
						</tr>
					</table>
					<p><input class='button' type='submit' value='Generate' /></p>
				</form>
			</div>
			<?php
			
				}
				require ('./layout/footer.php');
				
			?>