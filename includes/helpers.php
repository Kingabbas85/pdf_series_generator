<?php
use Rats\Zkteco\Lib\ZKTeco;
use Spatie\Browsershot\Browsershot;

$user_domain = "PS19";
$logo = "images/fc_logo.png";
$logo_with_name = "images/fc_logo_new.png";
$logo_class = "ps-logo";
$logo_with_name_class = "ps-logo_with_name";

$onlyNumeric = "this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');";
$onlyCharacter = "this.value = this.value.replace(/[^A-Za-z ]/g, '');";
$forLocation = "this.value = this.value.replace(/[^A-Za-z0-9 ()-]/g, '').replace(/(\--*)\-/g, '$1');";
$forContactNo = "this.value = this.value.replace(/[^0-9+-]/g, '').replace(/(\--*)\-/g, '$1')";
$onlyUsername = "this.value = this.value.replace(/[^A-Za-z .]/g, '').replace(/(\..*)\./g, '$1')";
$forEmail = "this.value = this.value.replace(/[^A-Za-z0-9 . @ ]/g, '').replace(/(\@@*)\@/g, '$1');";
$aplhaNumeric = "this.value = this.value.replace(/[^A-Za-z0-9 ]/g, '');";
$aplhaNumericwithDash = "this.value = this.value.replace(/[^A-Za-z0-9 - ]/g, '').replace(/(\,,*)\,/g, '$1').replace(/(\, ,*)\,/g, '$1');";
$forAddress = "this.value = this.value.replace(/[^A-Za-z0-9) )(,&#-]/g, '');";


// Arrays
$getFullMonthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
$getShortMonthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

$countries = [
	"AF" => "Afghanistan", "AX" => "Åland Islands", "AL" => "Albania", "DZ" => "Algeria", "AS" => "American Samoa",
	"AD" => "Andorra", "AO" => "Angola", "AI" => "Anguilla", "AQ" => "Antarctica", "AG" => "Antigua and Barbuda",
	"AR" => "Argentina", "AM" => "Armenia", "AW" => "Aruba", "AU" => "Australia", "AT" => "Austria",
	"AZ" => "Azerbaijan", "BS" => "Bahamas", "BH" => "Bahrain", "BD" => "Bangladesh", "BB" => "Barbados",
	"BY" => "Belarus", "BE" => "Belgium", "BZ" => "Belize", "BJ" => "Benin", "BM" => "Bermuda",
	"BT" => "Bhutan", "BO" => "Bolivia", "BA" => "Bosnia and Herzegovina", "BW" => "Botswana", "BV" => "Bouvet Island",
	"BR" => "Brazil", "IO" => "British Indian Ocean Territory", "BN" => "Brunei Darussalam", "BG" => "Bulgaria", "BF" => "Burkina Faso",
	"BI" => "Burundi", "CV" => "Cabo Verde", "KH" => "Cambodia", "CM" => "Cameroon", "CA" => "Canada",
	"KY" => "Cayman Islands", "CF" => "Central African Republic", "TD" => "Chad", "CL" => "Chile", "CN" => "China",
	"CX" => "Christmas Island", "CC" => "Cocos (Keeling) Islands", "CO" => "Colombia", "KM" => "Comoros", "CG" => "Congo",
	"CD" => "Congo, Democratic Republic of the", "CK" => "Cook Islands", "CR" => "Costa Rica", "HR" => "Croatia", "CU" => "Cuba",
	"CY" => "Cyprus", "CZ" => "Czech Republic", "DK" => "Denmark", "DJ" => "Djibouti", "DM" => "Dominica",
	"DO" => "Dominican Republic", "EC" => "Ecuador", "EG" => "Egypt", "SV" => "El Salvador", "GQ" => "Equatorial Guinea",
	"ER" => "Eritrea", "EE" => "Estonia", "ET" => "Ethiopia", "FK" => "Falkland Islands (Malvinas)", "FO" => "Faroe Islands",
	"FJ" => "Fiji", "FI" => "Finland", "FR" => "France", "GF" => "French Guiana", "PF" => "French Polynesia",
	"TF" => "French Southern Territories", "GA" => "Gabon", "GM" => "Gambia", "GE" => "Georgia", "DE" => "Germany",
	"GH" => "Ghana", "GI" => "Gibraltar", "GR" => "Greece", "GL" => "Greenland", "GD" => "Grenada",
	"GP" => "Guadeloupe", "GU" => "Guam", "GT" => "Guatemala", "GG" => "Guernsey", "GN" => "Guinea",
	"GW" => "Guinea-Bissau", "GY" => "Guyana", "HT" => "Haiti", "HM" => "Heard Island and McDonald Islands", "VA" => "Holy See (Vatican City State)",
	"HN" => "Honduras", "HK" => "Hong Kong", "HU" => "Hungary", "IS" => "Iceland", "IN" => "India",
	"ID" => "Indonesia", "IR" => "Iran, Islamic Republic of", "IQ" => "Iraq", "IE" => "Ireland", "IM" => "Isle of Man",
	"IL" => "Israel", "IT" => "Italy", "JM" => "Jamaica", "JP" => "Japan", "JE" => "Jersey",
	"JO" => "Jordan", "KZ" => "Kazakhstan", "KE" => "Kenya", "KI" => "Kiribati", "KP" => "Korea, Democratic People's Republic of",
	"KR" => "Korea, Republic of", "KW" => "Kuwait", "KG" => "Kyrgyzstan", "LA" => "Lao People's Democratic Republic", "LV" => "Latvia",
	"LB" => "Lebanon", "LS" => "Lesotho", "LR" => "Liberia", "LY" => "Libyan Arab Jamahiriya", "LI" => "Liechtenstein",
	"LT" => "Lithuania", "LU" => "Luxembourg", "MO" => "Macao", "MK" => "Macedonia, the former Yugoslav Republic of", "MG" => "Madagascar",
	"MW" => "Malawi", "MY" => "Malaysia", "MV" => "Maldives", "ML" => "Mali", "MT" => "Malta",
	"MH" => "Marshall Islands", "MQ" => "Martinique", "MR" => "Mauritania", "MU" => "Mauritius", "YT" => "Mayotte",
	"MX" => "Mexico", "FM" => "Micronesia, Federated States of", "MD" => "Moldova, Republic of", "MC" => "Monaco", "MN" => "Mongolia",
	"ME" => "Montenegro", "MS" => "Montserrat", "MA" => "Morocco", "MZ" => "Mozambique", "MM" => "Myanmar",
	"NA" => "Namibia", "NR" => "Nauru", "NP" => "Nepal", "NL" => "Netherlands", "AN" => "Netherlands Antilles",
	"NC" => "New Caledonia", "NZ" => "New Zealand", "NI" => "Nicaragua", "NE" => "Niger", "NG" => "Nigeria",
	"NU" => "Niue", "NF" => "Norfolk Island", "MP" => "Northern Mariana Islands", "NO" => "Norway", "OM" => "Oman",
	"PK" => "Pakistan", "PW" => "Palau", "PS" => "Palestinian Territory, Occupied", "PA" => "Panama", "PG" => "Papua New Guinea",
	"PY" => "Paraguay", "PE" => "Peru", "PH" => "Philippines", "PN" => "Pitcairn", "PL" => "Poland",
	"PT" => "Portugal", "PR" => "Puerto Rico", "QA" => "Qatar", "RE" => "Reunion", "RO" => "Romania",
	"RU" => "Russian Federation", "RW" => "Rwanda", "BL" => "Saint Barthelemy", "SH" => "Saint Helena", "KN" => "Saint Kitts and Nevis",
	"LC" => "Saint Lucia", "MF" => "Saint Martin (French part)", "PM" => "Saint Pierre and Miquelon", "VC" => "Saint Vincent and the Grenadines", "WS" => "Samoa",
	"SM" => "San Marino", "ST" => "Sao Tome and Principe", "SA" => "Saudi Arabia", "SN" => "Senegal", "RS" => "Serbia",
	"SC" => "Seychelles", "SL" => "Sierra Leone", "SG" => "Singapore", "SK" => "Slovakia", "SI" => "Slovenia",
	"SB" => "Solomon Islands", "SO" => "Somalia", "ZA" => "South Africa", "GS" => "South Georgia and the South Sandwich Islands", "ES" => "Spain",
	"LK" => "Sri Lanka", "SD" => "Sudan", "SR" => "Suriname", "SJ" => "Svalbard and Jan Mayen", "SZ" => "Swaziland",
	"SE" => "Sweden", "CH" => "Switzerland", "SY" => "Syrian Arab Republic", "TW" => "Taiwan, Province of China", "TJ" => "Tajikistan",
	"TZ" => "Tanzania, United Republic of", "TH" => "Thailand", "TL" => "Timor-Leste", "TG" => "Togo", "TK" => "Tokelau",
	"TO" => "Tonga", "TT" => "Trinidad and Tobago", "TN" => "Tunisia", "TR" => "Turkey", "TM" => "Turkmenistan",
	"TC" => "Turks and Caicos Islands", "TV" => "Tuvalu", "UG" => "Uganda", "UA" => "Ukraine", "AE" => "United Arab Emirates",
	"GB" => "United Kingdom", "US" => "United States", "UM" => "United States Minor Outlying Islands", "UY" => "Uruguay", "UZ" => "Uzbekistan",
	"VU" => "Vanuatu", "VE" => "Venezuela", "VN" => "Viet Nam", "VG" => "Virgin Islands, British", "VI" => "Virgin Islands, U.S.",
	"WF" => "Wallis and Futuna", "EH" => "Western Sahara", "YE" => "Yemen", "ZM" => "Zambia", "ZW" => "Zimbabwe"
];

/**
 * [Domain returns the exact path of a file]
 * @param [type] $url [file path after 'hrms/']
 * @return [string] [complete root path of a file]
 */
function Domain($url) {
	return $_SERVER['DOCUMENT_ROOT'] . '/freight_calculator/' . $url;
}
/**
 * [imsSendEmail sends Emails to users]
 * @param  [string] $to          [description]
 * @param  [string] $subject     [description]
 * @param  [string] $message     [description]
 * @param  [array] $attachments [description]
 * @param  [array] $recipients  [description]
 * @return [boolean] [description]
 */
function SendEmail($sendTo = array(), $subject, $message = '', $attachments = array(), $recipients = array())
{

	// $mail_autoload = dirname(__FILE__).DIRECTORY_SEPARATOR.'packages/phpmailer/PHPMailerAutoload.php';
	// include Domain('packages/phpmailer/PHPMailerAutoload.php');
	$include_file_path = Domain('packages/phpmailer/PHPMailerAutoload.php');
	require_once($include_file_path);

	$mail = new PHPMailer;
	// $mail->SMTPDebug = 4; // Enable verbose debug output
	$mail->isSMTP(); // Set mailer to use SMTP
	$mail->Host = 'vt-mex01.venturetronics.com'; // Specify main and backup SMTP servers
	$mail->SMTPAuth = true; // Enable SMTP authentication
	$mail->Username = 'VT-INVEN@venturetronics.com'; // SMTP username
	$mail->Password = 'WelcomeIMS_$5'; // SMTP password
	$mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
	$mail->Port = 587; // TCP port to connect to

	$mail->SMTPOptions = array(
		'ssl' => array(
			'verify_peer' => false,
			'verify_peer_name' => false,
			'allow_self_signed' => true
		)
	);

	$mail->setFrom('VT-INVEN@venturetronics.com', 'AMS');


	// // Sent To
	if ( !empty( $sendTo ) && is_array( $sendTo ) ) {
		foreach ( $sendTo as $to ) {
			$mail->addAddress( $to );
		}
	}
	// $mail->addAddress('junaid.khalil@venturetronics.com');
	// $mail->addAddress('ali.abbas@raythorne.com');

	// // Add CC
	if ( !empty( $recipients ) && is_array( $recipients ) ) {
		foreach ( $recipients as $cc ) {
			$mail->addCC( $cc );
		}
	}
	// $mail->addCC('junaidkhalil114@gmail.com');


	$mail->addReplyTo('no-reply@venturetronics.com');

	if (!empty($attachments) && is_array($attachments)) {
		foreach ($attachments as $attachment) {
			$mail->addAttachment($attachment);
		}
	}

	// $attachment = "assets/demands/2404 - (Ahmed Ali).pdf";
	// $mail->addAttachment($attachment);

	$message .= "<html>
					<body>
						<br><br><br>
						<div style='border-top:1px solid #D0D3D4; width:100%; padding-top:5px;'>
							<span style='font-size:16px; font-weight:600;'>
								<i> Note: </i>
							</span>
							<span>
								<i> AMS - This is a system-generated email for your convenience and needs no reply. </i>
							</span>
						</div>
					</body>
				</html>";

	$mail->isHTML(true); // Set email format to HTML

	$mail->Subject = $subject;
	$mail->Body = $message;


	// Add image in email body
	$mail->AddEmbeddedImage("./assets/Local_Items_Report/Pending Items Report - (Local).jpeg", "local_chart");
	$mail->AddEmbeddedImage("./assets/Imported_Items_Report/Pending Items Report - (Internatinal).jpeg", "import_chart");


	if (!$mail->send()) {
		return false;
	} else {
		return true;
	}
}


function getYearsList()
{

	$yearList = array();
	// $year_name = date('Y', strtotime('2025-06-20'));
	$year_name = date('Y');
	$start_range = 2023 - $year_name;
	for ($i = $start_range; $i < 1; $i++) {
		$yearList[] = $year_name + $i;
	}
	return $yearList;
}

function getStartAndEndDateOfMonth($month, $year)
{
	// Get the number of days in the specified month
	if (!empty($month)) {
		$numberOfDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
		// Create a DateTime object for the first day of the month
		$startDate = new DateTime("$year-$month-01");

		// Create a DateTime object for the last day of the month
		$endDate = new DateTime("$year-$month-$numberOfDays");

		// Format the dates as strings in the desired format
		$startDateStr = $startDate->format('Y-m-d');
		$endDateStr = $endDate->format('Y-m-d');
		return array('start_date' => $startDateStr, 'end_date' => $endDateStr);
	}

	// Return an array containing the start date and end date
	return false;
}

// Function to get the start and end dates of the selected month
// function getStartAndEndDateOfMonth($month, $year) {
// 	$start_date = new DateTime();
// 	$start_date->setDate($year, $month, 1);
// 	$start_date->setTime(0, 0, 0);

// 	$end_date = new DateTime();
// 	$end_date->setDate($year, $month, cal_days_in_month(CAL_GREGORIAN, $month, $year));
// 	$end_date->setTime(23, 59, 59);

// 	return [
// 		'start_date' => $start_date->format('Y-m-d H:i:s'),
// 		'end_date' => $end_date->format('Y-m-d H:i:s')
// 	];
// }

// function gtlGetYearsList() {
// 	$yearList = array();
// 	// $year_name = date('Y', strtotime('2025-06-20'));
// 	$year_name = date('Y');
// 	$start_range = 2023 - $year_name;
// 	for ($i = $start_range; $i < 1; $i++) {
// 		$yearList[] = $year_name + $i;
// 	}
// 	return $yearList;
// }
// function getTotalNumberOfDays($start_date, $end_date) {
// 	$start_date = strtotime($start_date);
// 	$end_date = strtotime($end_date);
// 	$difference = $end_date - $start_date;
// 	$days = round($difference / (60 * 60 * 24));
// 	return $days;
// }
// function getWeekStartDateWithWeekNumber($startdate) {

// 	$daynumber = date("w", strtotime($startdate));
// 	$daysdifference = 6 - ((6 - $daynumber) + 1);
// 	if ($daysdifference < 0) {
// 		$daysdifference = 6;
// 	}
// 	$_startdate = date('Y-m-d', strtotime($startdate . ' - ' . $daysdifference . ' days'));

// 	$startdateyear = date("Y", strtotime($startdate));
// 	$selectedyearstartdate = date($startdateyear . '-01-01');
// 	$day = date("w", strtotime($selectedyearstartdate));
// 	if ($day == 0) {
// 		$selectedyearstartdate = date($startdateyear . '-01-02');
// 	} else if ($day == 6) {
// 		$selectedyearstartdate = date($startdateyear . '-01-03');
// 	} else if ($day == 5) {
// 		$selectedyearstartdate = date($startdateyear . '-01-04');
// 	} else if ($day == 4) {
// 		$selectedyearstartdate = date($startdateyear . '-01-05');
// 	} else if ($day == 3) {
// 		$selectedyearstartdate = date($startdateyear . '-01-06');
// 	} else if ($day == 2) {
// 		$selectedyearstartdate = date($startdateyear . '-01-07');
// 	}
// 	$mergedvalue = $_startdate . "[spr]" . $selectedyearstartdate . "[spr]" . getTotalNumberOfDays($selectedyearstartdate, $startdate);
// 	return $mergedvalue;
// }
// function getWeekStartDate2() {
// 	$this_year_first_date = date('Y-01-01');
// 	$first_day_this_month = date('Y-m-01');
// 	$this_year_first_day = date("w", strtotime($this_year_first_date));
// 	if ($this_year_first_day == 0) {
// 		$this_year_first_date = date('Y-01-02');
// 	} else if ($this_year_first_day == 6) {
// 		$this_year_first_date = date('Y-01-03');
// 	} else if ($this_year_first_day == 5) {
// 		$this_year_first_date = date('Y-01-04');
// 	} else if ($this_year_first_day == 4) {
// 		$this_year_first_date = date('Y-01-05');
// 	} else if ($this_year_first_day == 3) {
// 		$this_year_first_date = date('Y-01-06');
// 	} else if ($this_year_first_day == 2) {
// 		$this_year_first_date = date('Y-01-07');
// 	}
// 	$newdata = $this_year_first_date . "spr" . $first_day_this_month;
// 	return $newdata;
// }


// Define domain name
$Domain = "http://$_SERVER[HTTP_HOST]";
$DomainName = "/HRMS";

// Get user details by user_id
function getUserByUserid($connection, $user_id)
{
	$query = "Select * FROM users WHERE Id = '$user_id'";
	$result = mysqli_query($connection, $query);
	if ($result && mysqli_num_rows($result)) {
		$user_details = mysqli_fetch_assoc($result);
		return $user_details;
	} else {
		return null;
	}
}

// Get user details by user_id
function getUserByUserZKid($connection, $zk_id)
{
	$query = "Select * FROM users WHERE zk_id = '$zk_id' && active = 1";
	$result = mysqli_query($connection, $query);
	if ($result && mysqli_num_rows($result)) {
		$user_details = mysqli_fetch_assoc($result);
		return $user_details;
	} else {
		return null;
	}
}
// Get user details by username
function getUserByUsername($connection, $username)
{
	$query = "Select * FROM users WHERE user_name = '$username'";
	$result = mysqli_query($connection, $query);
	if ($result && mysqli_num_rows($result)) {
		$user_details = mysqli_fetch_assoc($result);
		return $user_details;
	} else {
		return null;
	}
}

// Get full name of the user by username
function getFullName($connection, $username)
{
	$query = "Select display_name FROM users WHERE user_name = '$username'";
	$result = mysqli_query($connection, $query);
	if ($result && mysqli_num_rows($result)) {
		$row = mysqli_fetch_assoc($result);
		return $row['display_name'];
	}
	return '';
}

// Get designation from username
function getDesignation($connection, $username)
{
	$query = "Select designation FROM profiles_experience WHERE user_name = '$username'";
	$result = mysqli_query($connection, $query);
	if ($result && mysqli_num_rows($result)) {
		$row = mysqli_fetch_assoc($result);
		return $row['designation'];
	}
	return '';
}

// Get allowed leave in a year
function getAllowedLeave($connection, $year)
{
	$allowed_leaves = 0;
	$query = "Select * FROM counter WHERE Id = '1' && type = 'allowed_leaves'";
	$result = mysqli_query($connection, $query);
	if (mysqli_num_rows($result)) {
		while ($row = mysqli_fetch_assoc($result)) {
			$allowed_leaves = $row['value'];
		}
	}
	return $allowed_leaves;
}

// Get used leaves by username
function getUsedLeaves($connection, $username, $year)
{
	$used_leaves = 0;
	$start_date = "$year-01-01";
	$end_date = "$year-12-31";
	$query = "Select * FROM leaves WHERE username = '$username' && (from_date BETWEEN '$start_date' AND '$end_date') && status = 'approved'";
	$result = mysqli_query($connection, $query);
	// return mysqli_num_rows($result);
	if (mysqli_num_rows($result)) {
		while ($row = mysqli_fetch_assoc($result)) {
			$from_date = $row['from_date'];
			$to_date = $row['to_date'];
			$used_leaves += countBusinessDays($from_date, $to_date);
			// $used_leaves += $row['number_of_days'];
		}
	}
	return $used_leaves;
}

// Get pending leaves by username
function getPendingLeaves($connection, $username)
{
	// Implement as needed
}

// Get report_to rights by login username
function getLoginUserReportToRights($connection, $username)
{
	$query = "Select * FROM profiles WHERE report_to = '$username'";
	$result = mysqli_query($connection, $query);
	return mysqli_num_rows($result);
}

// Get profile details by username
function getProfileDataByUsername($connection, $username)
{
	$query = "Select * FROM profiles WHERE user_name = '$username' || email = '$username'";
	$result = mysqli_query($connection, $query);
	if (mysqli_num_rows($result)) {
		$user_details = mysqli_fetch_assoc($result);
		return $user_details;
	} else {
		return "NOT_EXIST";
	}
}

// Get team name by team_id details by username
function getTeamNameByTeamId($connection, $team_id)
{
	$team_name = "";
	$query = "Select * FROM teams WHERE team_id = '$team_id'";
	$result = mysqli_query($connection, $query);
	if (mysqli_num_rows($result)) {
		while ($row = mysqli_fetch_assoc($result)) {
			$team_name = ucwords($row['team_name']);
		}
	}
	return $team_name;
}

// Get Designation name by designation_id details by username
function getDesignationNameById($connection, $designation_id)
{
	$designation_name = "";
	$query = "Select * FROM designations WHERE Id = '$designation_id'";
	$result = mysqli_query($connection, $query);
	if (mysqli_num_rows($result)) {
		while ($row = mysqli_fetch_assoc($result)) {
			$designation_name = ucwords($row['name']);
		}
	}
	return $designation_name;
}

function isDateInRange($dateToCheck, $startDate, $endDate)
{
	// return $startDate." - ".$endDate;
	// Convert dates to Unix timestamps for easier comparison
	$dateToCheckTimestamp = strtotime($dateToCheck);
	$startDateTimestamp = strtotime($startDate);
	$endDateTimestamp = strtotime($endDate);

	// Check if the date falls between the start and end dates
	if ($dateToCheckTimestamp >= $startDateTimestamp && $dateToCheckTimestamp <= $endDateTimestamp) {
		return true;
	} else {
		return false;
	}
}

function isHolidayonSelectedDate($connection, $year, $date)
{
	$is_holiday = "";
	$is_holiday_array = array();
	$query = "Select * FROM holidays WHERE year = '$year'";
	$result = mysqli_query($connection, $query);
	if (mysqli_num_rows($result)) {
		while ($row = mysqli_fetch_assoc($result)) {
			$from = $row['from_date'];
			$to = $row['to_date'];
			$is_holiday = isDateInRange($date, $from, $to);
			if ($is_holiday) {
				$is_holiday_array[] = $date;
			}
		}
	}
	// if (in_array($date, $is_holiday_array)) {
	// 	return $is_holiday;
	// }
	return $is_holiday_array;
}

function isOnLeaveOnSelectedDate($connection, $username, $date)
{
	$is_leave = "";
	$query = "Select * FROM leaves WHERE username = '$username' && status = 'approved'";
	$result = mysqli_query($connection, $query);
	if (mysqli_num_rows($result)) {
		while ($row = mysqli_fetch_assoc($result)) {
			$from = $row['from_date'];
			$to = $row['to_date'];
			return $is_leave = isDateInRange($date, $from, $to);
		}
	}
	return $is_leave;
}


function countBusinessDays($start_date, $end_date)
{

	if (!strtotime($start_date) || !strtotime($end_date)) {
		return -1; // Indicates invalid date format
	}
	$start_date = new DateTime($start_date);
	$end_date = new DateTime($end_date);
	$interval = new DateInterval('P1D'); // 1 day interval
	$date_range = new DatePeriod($start_date, $interval, $end_date);

	$working_days = 0;
	foreach ($date_range as $date) {
		$week_day = (int)$date->format('N');
		// Exclude Saturday (6) and Sunday (7) from working days
		if ($week_day < 6) {
			$working_days++;
		}
	}
	return $working_days + 1;
}

function countNoDaysBetweenDates($start_date, $end_date)
{

	if (!strtotime($start_date) || !strtotime($end_date)) {
		return -1; // Indicates invalid date format
	}
	$start_date = new DateTime($start_date);
	$end_date = new DateTime($end_date);
	$interval = new DateInterval('P1D'); // 1 day interval
	$date_range = new DatePeriod($start_date, $interval, $end_date);

	$working_days = 0;
	foreach ($date_range as $date) {

			$working_days++;
	}
	return $working_days + 1;
}
/**
 * [pre_r echo the array]
 * @param  [type] $array [description]
 * @return [type]        [description]
 */
function pre_r($array)
{
	echo '<pre>';
	print_r($array);
	echo '</pre>';
}

// Get task by module permission ID
function getTaskByPermissionId($connection, $permission_id)
{
	$query = "SELECT task FROM module_permissions WHERE id = $permission_id AND is_active = 1";
	$result = mysqli_query($connection, $query);
	if ($result && mysqli_num_rows($result)) {
		$module_permission = mysqli_fetch_assoc($result);
		return $module_permission['task']; // Return the 'task' value from the fetched row
	} else {
		return false;
	}
}
//function to count permssions attcahed to the role
function getPermissionCountByRoleId($connection, $role_id)
{
	$permission_count = 0;
	$query = "SELECT * FROM role_has_permissions WHERE role_id = $role_id";
	$result = mysqli_query($connection, $query);
	if ($result) {
		// Fetch all rows as an associative array
		$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
		$permission_count = count($rows);
	}

	// Return the permission count
	return $permission_count;
}

// Function to get permissions by role ID
function getPermissionByRoleId($connection, $role_id)
{
	$permissions = array(); // Initialize an empty array to store permissions
	$query = "SELECT * FROM role_has_permissions WHERE role_id = '$role_id'";
	$result = mysqli_query($connection, $query);
	if ($result && mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			$module_id = $row['module_id'];
			$task = $row['task'];
			// Store the permission in the array with module_id as the key
			$query_permissions = "SELECT * FROM module_permissions WHERE module_id = '$module_id' AND task = '$task'";

			$result_permissions = mysqli_query($connection, $query_permissions);
			while ($row_permission = mysqli_fetch_assoc($result_permissions)) {
				$module_permissions_id = $row_permission['id'];
				$permissions[$module_id][] = $module_permissions_id;
			}
		}
	}
	return $permissions;
}
//get user role by name 
function getRoleByUserId($connection, $user_id)
{
	$role = null;
	$query = "SELECT roles.* FROM roles INNER JOIN user_has_role ON roles.id = user_has_role.role_id WHERE user_has_role.user_id = '$user_id'";
	$result = mysqli_query($connection, $query);
	if ($result && mysqli_num_rows($result)) {
		$role = mysqli_fetch_assoc($result);
	}
	return $role;
}

function checkPermission($connection, $user_id, $module_id, $task)
{
	$user_role = getRoleByUserId($connection, $user_id);

	if ($user_role && ($user_role['name'] == "super admin")) {
		return true; // Super admin or admin has all permissions
	}

	// Query to check if the user's role has permission for the task in the module
	$query = "SELECT COUNT(*) AS permission_count FROM role_has_permissions WHERE role_id IN (SELECT role_id FROM user_has_role WHERE user_id = '$user_id') AND module_id = '$module_id' AND task = '$task'";
	$result = mysqli_query($connection, $query);
	if ($result && mysqli_num_rows($result) > 0) {
		$row = mysqli_fetch_assoc($result);
		$permission_count = $row['permission_count'];
		if ($permission_count > 0) {
			return true; // User has permission
		}
	}

	return false; // User does not have permission
}


function calculateCheckinHours($checkindatetime, $checkoutdatetime) {
	
	$date1 = new DateTime($checkindatetime);
	$date2 = new DateTime($checkoutdatetime);
	// Get the difference between the two dates
	$interval = $date1->diff($date2);
	// Calculate the total number of hours
	$hours = ($interval->days * 24) + $interval->h + ($interval->i / 60) + ($interval->s / 3600);
	return $hours;
}

function checkIfDifferenceIsNegative($pickedcheckindate, $pickedcheckintime, $pickedcheckoutdate, $pickedcheckouttime) {
	
	$checkindatetime = strtotime($pickedcheckindate." ".$pickedcheckintime);
    $checkoutdatetime = strtotime($pickedcheckoutdate." ".$pickedcheckouttime);
    $is_nagative = $checkoutdatetime - $checkindatetime;
	if ($is_nagative < 0) {
		return true;
	}
	return false;
}

function addRandomSecondsInTime($time) {
	
	if ($time) {
		$checkouttime = explode(':', $time);
		if (count($checkouttime) > 2 && $checkouttime[2] != "00") {
			return $time = $checkouttime[0].":".$checkouttime[1].":".$checkouttime[2];
		}
		$random_seconds = rand(0,59);
		if ($random_seconds < 10) {
			$random_seconds = "0".$random_seconds;
		}
        return $time = $checkouttime[0].":".$checkouttime[1].":".$random_seconds;
    }
	return $time;
}

function addRandomSecondsIfUserIsSuperAdmin($connection, $session_username, $time) {
	
	$user = getUserByUsername($connection, $session_username);
	$user_id = $user['Id'];
	$user_role = getRoleByUserId($connection, $user_id);
	if ($user_role && ($user_role['name'] == "super admin")) {
		return addRandomSecondsInTime($time);
	}
	return $time;
}


function split_date_time($cur_date_time)
{
	// split date_time components
	$date_time_split = explode(' ', $cur_date_time);
	$date_time_arr['date'] = $date_time_split[0];
	$date_time_arr['time'] = $date_time_split[1];
	return $date_time_arr;
}

// Function to calculate the number of check-ins for a user on a specific date
function calculateNumberOfCheckins($connection, $username, $date)
{
	$query = "SELECT * FROM attendance WHERE username = '$username' AND checkin_date = '$date'";
	$result = mysqli_query($connection, $query);
	if (mysqli_num_rows($result)) {
		return mysqli_num_rows($result);
	}

	$date = date('Y-m-d', strtotime('-1 day', strtotime('+3 Hours')));
	$query = "SELECT * FROM attendance WHERE username = '$username' AND checkin_date = '$date'";
	$result = mysqli_query($connection, $query);
	if (mysqli_num_rows($result)) {
		return mysqli_num_rows($result);
	}
	return 1;
}


// Function to calculate Total Checkin Duration for a user on a specific date
function calculateTotalCheckinDuration($connection, $username, $date)
{
	$query = "SELECT checkin_time, checkout_time FROM attendance WHERE username = '$username' AND checkin_date = '$date'";
	$result = mysqli_query($connection, $query);
	$totalDuration = 0;
	if (mysqli_num_rows($result)) {
		while ($row = mysqli_fetch_assoc($result)) {
			$checkinTime = strtotime($row['checkin_time']);
			$checkoutTime = strtotime($row['checkout_time']);

			if ($checkinTime && $checkoutTime) {
				$totalDuration += $checkoutTime - $checkinTime;
			}
		}
	}

	return $totalDuration;
}

// Function to calculate Total Work Time for a user on a specific date in HH:MM format
function calculateTotalWorkTime($connection, $username, $date)
{
	$totalWorkTime = 0;
	$query = "SELECT * FROM attendance WHERE username = '$username' AND checkin_date = '$date' AND checkout_date IS NOT NULL";
	$result = mysqli_query($connection, $query);
	if (mysqli_num_rows($result)) {
		while ($row = mysqli_fetch_assoc($result)) {
			$checkin_date = $row['checkin_date'];
			$checkin_time = $row['checkin_time'];
			$checkout_date = $row['checkout_date'];
			$checkout_time = $row['checkout_time'];

			$checkin_datetime = strtotime($checkin_date." ".$checkin_time);
			$checkout_datetime = strtotime($checkout_date." ".$checkout_time);

			if ($checkin_datetime && $checkout_datetime) {
				$totalWorkTime += ($checkout_datetime - $checkin_datetime);
			}
		}

		// Convert total work time from seconds to hours and minutes
		$hours = floor($totalWorkTime / 3600);
		$minutes = floor(($totalWorkTime % 3600) / 60);
		$seconds = floor(($totalWorkTime % 3600) % 60);

		return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds); // formatting to HH:MM:SS
	}


	$query = "SELECT * FROM attendance WHERE username = '$username' AND checkin_date = '$date'";
	$result = mysqli_query($connection, $query);
	// Check if the query returned any results
	if (mysqli_num_rows($result)) {

	} else {
		$date = date('Y-m-d', strtotime('-1 day', strtotime('+3 Hours')));
		$query = "SELECT * FROM attendance WHERE username = '$username' AND checkin_date = '$date'";
		$result = mysqli_query($connection, $query);
	}

	if (mysqli_num_rows($result)) {
		while ($row = mysqli_fetch_assoc($result)) {
			$checkin_date = $row['checkin_date'];
			$checkin_time = $row['checkin_time'];
			$checkout_date = $row['checkout_date'];
			$checkout_time = $row['checkout_time'];

			$checkin_datetime = strtotime($checkin_date." ".$checkin_time);
			$checkout_datetime = strtotime($checkout_date." ".$checkout_time);

			if (isset($checkout_date) && $checkin_datetime && $checkout_datetime) {
				$totalWorkTime += ($checkout_datetime - $checkin_datetime);
			}
		}

		if ($totalWorkTime) {
			// Convert total work time from seconds to hours and minutes
			$hours = floor($totalWorkTime / 3600);
			$minutes = floor(($totalWorkTime % 3600) / 60);
			$seconds = floor(($totalWorkTime % 3600) % 60);
	
			return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds); // formatting to HH:MM:SS
		} return "-";
	}
	return "-";
}
// Function to calculate Session Work Time for a user on a specific date in HH:MM format
function calculateSessionWorkTime($connection, $username, $date)
{
	$query = "SELECT checkin_time, checkout_time FROM attendance WHERE username = '$username' AND checkin_date = '$date' ORDER BY checkin_date, checkin_time DESC LIMIT 1";
	$result = mysqli_query($connection, $query);
	
	$sessionWorkTime = 0;
	if (mysqli_num_rows($result)) {
		
		$row = mysqli_fetch_assoc($result);
		$checkinTime = strtotime($row['checkin_time']);
		$checkoutTime = strtotime($row['checkout_time']);
	
		if ($checkinTime && $checkoutTime) {
			$sessionWorkTime = $checkoutTime - $checkinTime;
		}
	
		// Convert session work time from seconds to hours and minutes
		$hours = floor($sessionWorkTime / 3600);
		$minutes = floor(($sessionWorkTime % 3600) / 60);
		$seconds = floor(($sessionWorkTime % 3600) % 60);
	
		return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds); // formatting to HH:MM:SS
	}
	return false;
}
// Function to get the last entry check-in and check-out date and time in the format "mm/dd/yyyy HH:MM"
function getLastCheckInOutDateTime($connection, $username)
{
	$query = "SELECT checkin_date, checkin_time, checkout_date, checkout_time 
			FROM attendance 
			WHERE username = '$username' 
			ORDER BY Id DESC 
			LIMIT 1";
	$result = mysqli_query($connection, $query);
	// Check if the query returned any results
	if (mysqli_num_rows($result)) {
		$row = mysqli_fetch_assoc($result);
		$checkin_date = $row['checkin_date'];
		$checkin_time = $row['checkin_time'];
		$checkout_date = $row['checkout_date'];
		$checkout_time = $row['checkout_time'];

		// Format check-in date and time
		$formatted_checkin_date = date("d-M-y", strtotime($checkin_date));
		$formatted_checkin_datetime = $formatted_checkin_date . " " . $checkin_time;

		// Format check-out date and time
		$formatted_checkout_date = $checkout_date ? date("d-M-y", strtotime($checkout_date)) : "-";
		$formatted_checkout_datetime = $checkout_date ? $formatted_checkout_date . " " . $checkout_time : "-";

		return [
			'checkin_datetime' => $formatted_checkin_datetime,
			'checkout_datetime' => $formatted_checkout_datetime,
		];
	}

	return null; // Return null if no records are found
}

// Function to get the last zk_id from the users table
function getLastZkId($connection)
{
	// Query to get the last zk_id based on zk_id order
	$query = "SELECT zk_id FROM users ORDER BY zk_id DESC LIMIT 1";
	$result = mysqli_query($connection, $query);

	if ($row = mysqli_fetch_assoc($result)) {
		return $row['zk_id'];
	} else {
		return 0; // Return null if no zk_id is found
	}
}

/**
 * Get the value of a specific setting by its name.
 *
 * @param string $settingName The name of the setting to retrieve.
 * @return string|null The value of the setting, or null if not found.
 */
function testDeviceConnection($connection, $id)
{
	$deviceIp = getSettingRecord($connection, $id);
	$zk = new ZKTeco($deviceIp);
	$ret = $zk->connect();
	if ($ret) {
		return "success";
	} else {
		return "error";
	}
}
/**
 * Get the value of a specific setting by its name.
 *
 * @param string $settingName The name of the setting to retrieve.
 * @return string|null The value of the setting, or null if not found.
 */
function getAllDeviceUsers($connection, $ip)
{

	$deviceIp = getSettingRecord($connection, $ip);
	$zk = new ZKTeco($deviceIp);
	$ret = $zk->connect();
	if ($ret) {
		$users = $zk->getUser();
		return $users;
	} else {
		return false;
	}
}

/**
 * Get team leader name from config
 *
 * @param [type] $teamId
 * @param [type] $teams
 * @return void
 */
function getTeamLeaderByTeamId($teamId, $teams_with_leads) {
    foreach ($teams_with_leads as $username => $userTeams) {
        if (in_array($teamId, $userTeams)) {
            return $username;
        }
    }
    return null; // Return null if no team leader is found
}
/**
 * Get monthly attendace of user by user name 
 *
 * @param [type] $connection
 * @param [type] $username
 * @param [type] $year
 * @param [type] $month
 * @return array
 */
function getMonthlyAttendance($connection, $username, $year, $month) {
    $dateRange = getStartAndEndDateOfMonth($month + 1, $year);
    $start_date = $dateRange['start_date'];
    $end_date = $dateRange['end_date'];

    $start_year = date("Y", strtotime($start_date));
    $current_date = new DateTime();
    $current_year = $current_date->format('Y');
    $current_month = $current_date->format('m');
    $current_day = $current_date->format('d');

    if ($year == $current_year && $month + 1 == $current_month) {
        $end_date = $current_date->format('Y-m-d');
    }

    $user_filter = "";
    if ($username) {
        $user_filter = "user_name = '$username' AND";
    }

    $query1 = "SELECT * FROM users WHERE $user_filter active = '1' ORDER BY display_name ASC";
    $result1 = mysqli_query($connection, $query1);

    $user_data_array = [];

    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_assoc($result1)) {
            $username = $row1['user_name'];
            $display_name = ucwords($row1['display_name']);
            $user_data_array[$username] = [
                'display_name' => $display_name,
                'records' => [],
                'present_days' => [],
                'total_duration' => 0,
                'present_count' => 0,
                'absent_count' => 0,
                'leave_count' => 0,
                'working_days' => 0
            ];
        }
    }

    $start_date_time = new DateTime($start_date);
    $end_date_time = new DateTime($end_date);

    foreach ($user_data_array as $user_key => &$data) {
        $current_date = clone $start_date_time;
        while ($current_date <= $end_date_time) {
            $current_date_str = $current_date->format('Y-m-d');
            $date = $current_date->format('d M, Y');
            $week_day = $current_date->format('l');
            $date_display = $date . " - " . $week_day;

            $holiday_or_leave = "Absent";
            $holiday_or_leave_class = "text-danger";
            $day_number = $current_date->format('w');

            if ($day_number == 6 || $day_number == 0) {
                $holiday_or_leave = "Holiday";
                $holiday_or_leave_class = "text-primary";
            }

            $is_on_leave = isOnLeaveOnSelectedDate($connection, $user_key, $current_date_str);
            if ($is_on_leave) {
                $holiday_or_leave = "Leave";
                $holiday_or_leave_class = "text-dark";
            }

            $is_holiday_array = isHolidayonSelectedDate($connection, $start_year, $current_date_str);
            if (in_array($current_date_str, $is_holiday_array)) {
                $holiday_or_leave = "Holiday";
                $holiday_or_leave_class = "text-primary";
            }

            $query = "SELECT * FROM attendance WHERE username = '$user_key' AND checkin_date = '$current_date_str' AND status = '1' ORDER BY checkin_date, checkin_time, checkout_date, checkout_time ASC";
            $result = mysqli_query($connection, $query);

            if (mysqli_num_rows($result)) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $checkin_date = $row['checkin_date'];
                    $checkin_time = $row['checkin_time'];
                    $checkout_date = $row['checkout_date'];
                    $checkout_time = $row['checkout_time'];

                    $checkin_datetime = strtotime($checkin_date . " " . $checkin_time);
                    $checkout_datetime = strtotime($checkout_date . " " . $checkout_time);

                    $duration_formatted = "00:00:00";
                    if ($checkout_time) {
                        $duration = $checkout_datetime - $checkin_datetime;
                        $duration_minutes = $duration / 60;
                        $hours = floor($duration_minutes / 60);
                        $minutes = $duration_minutes % 60;
                        $seconds = floor($duration % 60);
                        if ($hours < 10) {
                            $hours = "0" . $hours;
                        }
                        if ($minutes < 10) {
                            $minutes = "0" . $minutes;
                        }
                        $duration_formatted = "$hours:$minutes:$seconds";

                        $time_parts = explode(':', $duration_formatted);
                        $data['total_duration'] += ($time_parts[0] * 60) + $time_parts[1];
                    }

                    $data['records'][] = [
                        'date_display' => $date_display,
                        'duration' => $duration_formatted,
                        'checkin' => date("d-M-y", strtotime($checkin_date)) . " " . $checkin_time,
                        'checkout' => $checkout_date ? date("d-M-y", strtotime($checkout_date)) . " " . $checkout_time : '-'
                    ];

                    if (!isset($data['present_days'][$checkin_date])) {
                        $data['present_days'][$checkin_date] = true;
                        $data['present_count']++;
                        $data['working_days']++;
                    }
                }
            } else {
                $data['records'][] = [
                    'date_display' => $date_display,
                    'duration' => $holiday_or_leave,
                    'checkin' => '',
                    'checkout' => ''
                ];

                if ($holiday_or_leave == "Leave") {
                    $data['leave_count']++;
                } elseif ($holiday_or_leave == "Absent") {
                    $data['absent_count']++;
                    $data['working_days']++;
                }
            }

            $current_date->modify('+1 day');
        }
    }

    return $user_data_array;
}

/**
 * Get consective absence of user from current week in bakward based on monthly attendace 
 *
 * @param [type] $connection
 * @param [type] $username
 * @param [type] $year
 * @param [type] $month
 * @return void
 */
function countConsecutiveAbsences($connection, $username, $year, $month) {
    $attendance_data = getMonthlyAttendance($connection, $username, $year, $month);

    // Get today's date
    $today = new DateTime();
    $current_date = $today;
    $absent_days = 0;

    for ($i = 0; $i < 7; $i++) {
        $current_date_str = $current_date->format('Y-m-d');
        $day_of_week = $current_date->format('w');
        $date_display = $current_date->format('d M, Y') . " - " . $current_date->format('l');

        // Skip weekends
        if ($day_of_week == 6 || $day_of_week == 0) {
            $current_date->modify('-1 day');
            continue;
        }

        // Check if it's a holiday or leave
        $is_on_leave = isOnLeaveOnSelectedDate($connection, $username, $current_date_str);
        $is_holiday_array = isHolidayonSelectedDate($connection, $year, $current_date_str);

        if ($is_on_leave || in_array($current_date_str, $is_holiday_array)) {
            $current_date->modify('-1 day');
            continue;
        }

        // Check if the user was absent on this day
        foreach ($attendance_data[$username]['records'] as $record) {
            if ($record['date_display'] == $date_display && $record['duration'] == "Absent") {
                $absent_days++;
                break;
            }
        }

        // If the user was present on this day, stop counting
        foreach ($attendance_data[$username]['records'] as $record) {
            if ($record['date_display'] == $date_display && $record['duration'] != "Absent") {
                return $absent_days;
            }
        }

        // Move to the previous day
        $current_date->modify('-1 day');
    }

    return $absent_days;
}

/**
 * Check absence of user also take screenshot and send email also attaching screenshot
 *
 * @param [type] $connection
 * @param [type] $year
 * @param [type] $month
 * @return void
 */
function checkConsecutiveAbsencesAndSendEmail($connection, $year, $month, $teams_with_leads) {
    $query = "SELECT * FROM users WHERE active = '1' AND Id > 2";
    $result = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        $user_id = $row['Id'];
        $username = $row['user_name'];
        $user_email = $row['email'];
		$report_to = $row['report_to'];
		$team_id = $row['team_id'];
        
        // Check consecutive absences
        $consecutive_absences = countConsecutiveAbsences($connection, $username, $year, $month);
        
        // If user was absent for 2 or more consecutive days
        if ($consecutive_absences >= 2) {

			$to =array($user_email);
            // Take a screenshot of the monthly attendance report
            $Domain = "http://$_SERVER[HTTP_HOST]";
            $DomainName = "/HRMS";
            $url = $Domain . $DomainName . "/ajaxcallforemailnotifications.php?username=$username&year=$year&month=$month";
            $image_path = Domain("assets/screenshots/attendance_report_$username.png");

            // Using Browsershot to take a screenshot
            Browsershot::url($url)
			->waitUntilNetworkIdle()
			->deviceScaleFactor(3)
			->fullPage()
			->timeout(120) // Set timeout to 120 seconds
			->save($image_path);


            // Send email with the screenshot
            $subject = 'Attendance Report';
            $body = 'Please find the attached file.';
              // Replace with the recipient's email address

            $attachments = [$image_path];

			// //Adding to cc
			$recipients =array();// report_to; 
			if($consecutive_absences>=3 && !empty($report_to)) {
				$recipient= getUserByUsername($connection, $report_to);
				$recipients[] = $recipient['email'];// report_to; 
			}
			$lead_username = getTeamLeaderByTeamId($team_id, $teams_with_leads);

			if($consecutive_absences>=5 && $lead_username != null) {
				$lead= getUserByUsername($connection, $lead_username);
				$recipients[] = $lead['email'];// manager; 
			}
			
			$user_role = getRoleByUserId($connection, $user_id);
			if ($user_role && ($user_role['name'] != "super admin" && $user_role['name'] != "Admin") ) {
				SendEmail($to, $subject, $body, $attachments, $recipients);
			}
        }
    }
}


function checkAttendanceState($connection, $username) {
	
	$query = "Select * FROM attendance WHERE username='$username' && checkout_date IS NULL";
	$result = mysqli_query($connection, $query);
	if (mysqli_num_rows($result)) {
		return "checkout";
	}
	return "checkin";
}

function calculateSessionTime($checkin_datetime, $checkout_datetime) {

	// return $checkin_datetime." - ".$checkout_datetime;
	if ($checkin_datetime && $checkout_datetime) {
	
		$total_time = $checkout_datetime - $checkin_datetime;
		// Convert session work time from seconds to hours and minutes
		$hours = floor($total_time / 3600);
		$minutes = floor(($total_time % 3600) / 60);
		$seconds = floor(($total_time % 3600) % 60);
	
		return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds); // formatting to HH:MM:SS
	}
	return false;
		
}

function calculateCurrentSessionTime($connection, $username, $checkout_date, $checkout_time) {
	
	$query = "Select * FROM attendance WHERE username='$username' && checkout_date IS NULL && status = 1 ORDER By Id DESC LIMIT 1";
	$result = mysqli_query($connection, $query);
	if (mysqli_num_rows($result)) {
		
		while ($row = mysqli_fetch_assoc($result)) {
			$checkin_date = $row['checkin_date'];
			$checkin_time = $row['checkin_time'];
		}

		$checkin_datetime = strtotime($checkin_date." ".$checkin_time);
		$checkout_datetime = strtotime($checkout_date." ".$checkout_time);

		// return $checkin_datetime." - ".$checkout_datetime;

		return $total_time = calculateSessionTime($checkin_datetime, $checkout_datetime);
	}
	return false;
}

// function calculateCurrentSessionTime($connection, $username, $checkout_date, $checkout_time) {
	
// 	$query = "Select * FROM attendance WHERE username='$username' && checkout_date IS NULL && status = 1 ORDER By Id DESC LIMIT 1";
// 	$result = mysqli_query($connection, $query);
// 	if (mysqli_num_rows($result)) {
		
// 		while ($row = mysqli_fetch_assoc($result)) {
// 			$checkin_date = $row['checkin_date'];
// 			$checkin_time = $row['checkin_time'];
// 		}

// 		$checkin_datetime = strtotime($checkin_date." ".$checkin_time);
// 		$checkout_datetime = strtotime($checkout_date." ".$checkout_time);

// 		return $total_time = calculateSessionTime($checkin_datetime, $checkout_datetime);
// 	}
// 	return false;
// }



function getRegionNameById($connection, $region_id)
{
    $region_name = "";
    $query = "SELECT * FROM regions WHERE Id = '$region_id'";
    $result = mysqli_query($connection, $query);
    
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $region_name = ucwords($row['name']);
        }
    }
    
    return $region_name;
}

function getCountryNameById($connection, $country_id)
{
    $country_name = "";
    $query = "SELECT * FROM countries WHERE Id = '$country_id'";
    $result = mysqli_query($connection, $query);
    
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $country_name = ucwords($row['name']);
        }
    }
    
    return $country_name;
}

function getCityNameById($connection, $city_id)
{
    $city_name = "";
    $query = "SELECT * FROM cities WHERE Id = '$city_id'";
    $result = mysqli_query($connection, $query);
    
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $city_name = ucwords($row['name']);
        }
    }
    
    return $city_name;
}


// function getEntityNameByCountryId($connection, $country_id)
// {
//     $country_name = "";
//     $query = "SELECT * FROM countries WHERE Id = '$country_id'";
//     $result = mysqli_query($connection, $query);
    
//     if (mysqli_num_rows($result)) {
//         while ($row = mysqli_fetch_assoc($result)) {
//             // Get the first three letters of the country name
//             $country_name = strtoupper(substr($row['name'], 0, 3)) . " ENTITY";
//         }
//     }
    
//     return $country_name;
// }

function getEntityNameByCountryId($connection, $country_id)
{
    $country_name = "";
    $query = "SELECT name FROM countries WHERE Id = '$country_id'";
    $result = mysqli_query($connection, $query);
    
    if (mysqli_num_rows($result)) {
        $row = mysqli_fetch_assoc($result);
        $name = $row['name'];

        // Check if the country name contains multiple words
        $name_parts = explode(" ", $name);
        if (count($name_parts) > 1) {
            // Get the first letter of each word to form an acronym
            $acronym = "";
            foreach ($name_parts as $part) {
                $acronym .= strtoupper($part[0]);
            }
            $country_name = $acronym . " ENTITY";
        } else {
            // Single word: take the first 3 letters
            $country_name = strtoupper(substr($name, 0, 3)) . " ENTITY";
        }
    }
    
    return $country_name;
}

/**
 * Get the value of a specific setting by its name.
 *
 * @param string $settingName The name of the setting to retrieve.
 * @return string|null The value of the setting, or null if not found.
 */
function getDefaultValuesByName($connection, $name)
{
	$query = "SELECT * FROM settings WHERE name = '$name'";
	$result = mysqli_query($connection, $query);
	if ($result && mysqli_num_rows($result)) {
		while ($row = mysqli_fetch_assoc($result)) {
			$val = $row['val'];
			return $val;
		}
	} else {
		return null; // Return null if the setting is not found
	}
}

function getEntityById($connection, $entity_id)
{
    $entity = null; // Initialize the entity as null
    
    // SQL query to fetch the entity by its ID
    $query = "SELECT * FROM entities WHERE Id = '$entity_id'";
    $result = mysqli_query($connection, $query);
    
    // Check if the result has any rows
    if (mysqli_num_rows($result)) {
        // Fetch the entity as an associative array
        $entity = mysqli_fetch_assoc($result);
    }
    
    // Return the entity object (or null if not found)
    return $entity;
}

function getCustomerById($connection, $customer_id)
{
    $customer = null; // Initialize the customer as null
    
    // SQL query to fetch the customer by its customer_id
    $query = "SELECT * FROM customers WHERE Id = '$customer_id'";
    $result = mysqli_query($connection, $query);
    
    // Check if the result has any rows
    if (mysqli_num_rows($result)) {
        // Fetch the customer as an associative array
        $customer = mysqli_fetch_assoc($result);
    }
    
    // Return the customer object (or null if not found)
    return $customer;
}

function CreateFourDigitNumber($number)
{

	if ($number <= 9) {
		$number = "000" . $number;
	}
	if ($number > 9 && $number <= 99) {
		$number = "00" . $number;
	}
	if ($number > 99 && $number <= 999) {
		$number = "0" . $number;
	}
	return $number;
}
function CreateSixDigitNumber($number)
{

	if ($number <= 9) {
		$number = "00000" . $number;
	}
	if ($number > 9 && $number <= 99) {
		$number = "0000" . $number;
	}
	if ($number > 99 && $number <= 999) {
		$number = "000" . $number;
	}
	if ($number > 999 && $number <= 9999) {
		$number = "00" . $number;
	}
	if ($number > 9999 && $number <= 99999) {
		$number = "0" . $number;
	}
	return $number;
}
