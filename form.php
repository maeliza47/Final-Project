<?php
include 'top.php';
//------------------------------------------------------------------------------
//
// SECTION: 1 Initialize Variables
//
// SECTION: 1a.
//We print out the post array so that we can see our form is working.
//if ($debug){ //later you can uncomment the if statement
print '<p>Post Array:</p><pre>';
print_r($_POST);
print '</pre>';
//}
//------------------------------------------------------------------------------
//
//SECTION: 1b Security
//
// define security variable to be used in SECTION 2a
    
$thisURL = $domain . $phpSelf;    
    
    
//------------------------------------------------------------------------------
//
// SECTION: 1c Form Variables
//
// Initialize variables one for each form element
// in the order they appear on the form

$firstName = '';
$lastName = '';
$email = '';

$gender = 'Male';

$NASA = false;
$spaceX = false;
$NKAF = false;
$totalChecked = 0;

$stateFrom = 'idkyet';

//------------------------------------------------------------------------------
//
// SECTION: 1d Form Error Flags
//
// Initialize Error Flags one for each form element we validate
// in the order they appear in section 1c
        
$firstNameERROR = '';
$lastNameERROR = '';
$emailERROR = '';

$genderERROR = '';

$organizationError = '';

$stateFromError = '';
        
//------------------------------------------------------------------------------
//
// SECTION: 1e Misc Variables
//
// create array to hold error messages filled (if any) in 2d displayed in 3c
$errorMsg = array();

// array used to hold form values that will be written to a CSV file
$dataRecord = array();

// have we mailed the information to the user?
$mailed = false;

//------------------------------------------------------------------------------
//
//SECTION: Array of States
//
//Referenced: https://stackoverflow.com/questions/1269562/how-to-create-an-array-from-a-csv-file-using-php-and-the-fgetcsv-function
//
$theStates = array(
    1=> 'Alabama',
    2=> 'Alaska',
    3=> 'Arizona',
    4=> 'Arkansas',
    5=> 'California',
    6=> 'Colorado',
    7=> 'Connecticut',
    8=> 'Delaware',
    9=> 'Florida',
    10=> 'Georgia',
    11=> 'Hawaii',
    12=> 'Idaho',
    13=> 'Illinois',
    14=> 'Indiana',
    15=> 'Iowa',
    16=> 'Kansas',
    17=> 'Kentucky',
    18=> 'Louisiana',
    19=> 'Maine',
    20=> 'Maryland',
    21=> 'Massachusetts',
    22=> 'Michigan',
    23=> 'Minnesota',
    24=> 'Mississippi',
    25=> 'Missouri',
    26=> 'Montana',
    27=> 'Nebraska',
    28=> 'Nevada',
    29=> 'New Hampshire',
    30=> 'New Jersey',
    31=> 'New Mexico',
    32=> 'New York',
    33=> 'North Carolina',
    34=> 'North Dakota',
    35=> 'Ohio',
    36=> 'Oklahoma',
    37=> 'Oregon',
    38=> 'Pennsylvania',
    39=> 'Rhode Island',
    40=> 'South Carolina',
    41=> 'South Dakota',
    42=> 'Tennessee',
    43=> 'Texas',
    44=> 'Utah',
    45=> 'Vermont',
    46=> 'Virginia',
    47=> 'Washington',
    48=> 'West Virginia',
    49=> 'Wisconsin',
    50=> 'Wyoming',
    51=> 'Not in the US',
);

$length = count($theStates);

//------------------------------------------------------------------------------
//
// SECTION: 2 Process for when the form is submitted
//
if (isset($_POST['btnSubmit'])){        
        
        //---------------------
        //
        // SECTION: 2a Security
        //
        if(!securityCheck($thisURL)) {
            $msg = '<p>Sorry you cannpt access this page. ';
            $msg .= 'Security breach detected and reported.</p>';
            die($msg);
        }
        
        //---------------------
        //
        // SECTION: 2b Sanitize (clean) data
        // remove any potential JavaScript or html code from users input on the
        // form. Note it is best to follow the same order as declared in section 1c.
        
        $firstName = htmlentities($_POST['txtFirstName'], ENT_QUOTES, 'UTF-8');
        $dataRecord[] = $firstName;
        
        $lastName = htmlentities($_POST['txtLastName'], ENT_QUOTES, 'UTF-8');
        $dataRecord[] = $lastName;
        
        $email = filter_var($_POST['txtEmail'], FILTER_SANITIZE_EMAIL);
        $dataRecord[] = $email;
        
        $gender = htmlentities($_POST["radGender"], ENT_QUOTES, "UTF-8");
        $dataRecord[] = $gender;
        
        $stateFrom = htmlentities($_POST["listStateFrom"], ENT_QUOTES, "UTF-8");
        
        //---------------------
        //
        // SECTION: 2c Validation
        //
        // Validation section. Check each value for possible errors, empty or
        // not what we expect. You will need an IF block for each element you will
        // check (see above section 1c and 1d). The if blocks should also be in the
        // order that the elements appear on your form so that the error messages
        // will be in the order they appear. errorMsg will be displayed on the form
        // see section 3b. The error flag ($emailERROR) will be used in section 3c.
        if ($firstName == ''){
            $errorMsg[] = 'Please enter your first name';
            $firstNameERROR = true;
        } elseif (!verifyAlphaNum($firstName)) {
            $errorMsg[] = 'Your first name appears to have an extra character.';
            $firstNameERROR = true;
        }
        
        if ($lastName == ''){
            $errorMsg[] = 'Please enter your last name';
            $lastNameERROR = true;
        } elseif (!verifyAlphaNum($firstName)) {
            $errorMsg[] = 'Your last name appears to have an extra character.';
            $lastNameERROR = true;
        }
        
        if($email == ''){
            $errorMsg[] = 'Please enter your email address';
            $emailERROR = true;
        } elseif (!verifyEmail($email)){
            $errorMsg[] = 'Your email address appears to be incorrect.';
            $emailERROR = true;
        }
        
        if($gender != 'Male' AND $gender != 'Female' AND $gender != 'Other' AND $gender != 'Prefer not to answer'){
            $errorMsg[] = 'Please choose a gender';
            $genderERROR = true;
        }
        
        if (isset($_POST["chkNASA"])) {
            $NASA = true;
            $totalChecked++;
        } else {
            $NASA = false;
        }
        $dataRecord[] = $NASA;
        
        if (isset($_POST["chkspaceX"])) {
            $spaceX = true;
            $totalChecked++;
        } else {
            $spaceX = false;
        }
        $dataRecord[] = $spaceX;
        
        if (isset($_POST["chkNKAF"])) {
            $NKAF = true;
            $totalChecked++;
        } else {
            $NKAF = false;
        }
        $dataRecord[] = $NKAF;
        
        if($totalChecked < 1){
            $errorMsg[] = 'Please choose at least one organization';
            $animalERROR = true;
        }
        
        if($stateFrom == ""){
            $errorMsg[] = "Please indicate which state you are from";
        }
        
        //---------------------
        //
        // SECTION: 2d Process Form - Passed Validation
        //
        // Process for when the form passes validation (the errorMsg array is empty)
        //
        if(!$errorMsg){
            if($debug)
                print PHP_EOL . '<p>Form is valid</p>';
            
        //---------------------
        //
        // SECTION: 2e Save Data
        //
        // This block saves the data to a CSV file
        $myFolder = 'data/';
        
        $myFileName = 'registration';
        
        $fileExt = '.csv';
        
        $filename = $myFolder . $myFileName . $fileExt;
        if ($debug) print PHP_EOL . '<p>filename is ' . $filename;
        
        // now we just open the file for append
        $file = fopen($filename, 'a');
        
        // write the forms informations
        fputcsv($file, $dataRecord);
        //
        // close the file
        fclose($file);
        
        //---------------------
        //
        // SECTION: 2f Create Message
        //
        // build a message to display on the screen in section 3a and to mail
        // to the person filling out the form (section 2g)
        $message = '<h2>Your Information.</h2>';
        
        foreach ($_POST as $htmlName => $value) {
        
            $message .= '<p>';
            //breaks up the form names into words, for example
            //txtFirstName becomes First Name
            $camelCase = preg_split('/(?=[A-Z])/', substr($htmlName, 3));
        
            foreach($camelCase as $oneWord){
                $message .= $oneWord . ' ';
            }  
        
            $message .= ' = ' . htmlentities($value, ENT_QUOTES, "UTF-8") . '</p>';
        
        }
                
        //---------------------
        //
        // SECTION: 2g Mail to user
        //
        // Process for mailing a message which contains the forms data
        // the message was built in section 2f.
        $to = $email; //the person filling out the form
        $cc = '';
        $bcc = '';
        
        $from = 'astrophotography site <customer.service@astro.com';
        
        //subject of all mail should make sense to your form
        $subject = "Interest in Astrophotography: ";
        
        $mailed = sendMail($to, $cc, $bcc, $from, $subject, $message);
        
        
        }//end form is valid     
        
}//ends if form was submitted

//------------------------------------------------------------------------------
//
// SECTION 3 Display Form
//
?>

<article id="main">
    
    <?php
    //---------------------
    //
    // SECTION 3a
    //
    // If its the first time coming to the form or there are errors we are going
    // to display the form
    if (isset($_POST['btnSubmit']) AND empty($errorMsg)) {//closing of if marked with: end body submit
        print '<h2>Thank you for providing your information! It is greatly appreciated!</h2>';
        
        print '<p>For your records a copy of this data has ';
        
    if(!$mailed) {    
        print "not ";
    }
        print 'been sent:</p>';
        print '<p>To: ' . $email . '</p>';
        
        print $message;
    } else {
        
        print '<h2>Register Today</h2>';
        print '<p class = "form-heading">Interested in Astrophotography? Fill out this survey to receive an email!</p>';
            
        //---------------------
        //
        // SECTION: 3b Error Messages
        //
        // display any error messages before we print out the form
    
        if($errorMsg){
            print '<div id = "errors">' . PHP_EOL;
            print '<h2>Your form has the following mistakes that need to be fixed. </h2>' . PHP_EOL;
            print '<ol>' . PHP_EOL;
            
            foreach ($errorMsg as $err){
                print '<li>' . $err . '</li' . PHP_EOL;
            }
            
            print '</ol>' . PHP_EOL;
            print '</div>' . PHP_EOL;
        }
    
        //---------------------
        //
        // SECTION: 3c html Form
        //
        /* DISPLAY the HTML form. note that the action is to this same page. $phpSelf
         * is defined in top.php
         * NOTE the line:
         * value = <?php print $email; ?>
         * this makes the form sticky by displaying either the initial default value (line ??)
         * or the value they typed in (line ??)
         * NOTE this line:
         * <?php if ($emailERROR) print 'class="mistake"'; ?>
         * this prints out a css class so that we can highlight the background etc. to
         * make it stand out that a mistake happened here.
         */
    ?>

    <form action='<?php print $phpSelf; ?>'
          id='frmRegister'
          method='post'>
        
                <fieldset class='contact'>
                    <legend>Contact Information</legend>
                    
                    <p>    
                        <label class = 'required text-field' for='txtFirstName'>First Name</label>
                        <input autofocus
                               <?php if ($firstNameERROR) print 'class="mistake"'; ?>
                               id ='txtFirstName'
                               maxlength ='45'
                               name ='txtFirstName'
                               onfocus='this.select()'
                               placeholder='Enter your first name'
                               tabindex='100'
                               type='text'
                               value='<?php print $firstName; ?>'
                        >
                    </p>
                    
                    <p>    
                        <label class = 'required text-field' for='txtLastName'>Last Name</label>
                        <input autofocus
                               <?php if ($lastNameERROR) print 'class="mistake"'; ?>
                               id ='txtLastName'
                               maxlength ='45'
                               name ='txtLastName'
                               onfocus='this.select()'
                               placeholder='Enter your last name'
                               tabindex='110'
                               type='text'
                               value='<?php print $lastName; ?>'
                        >
                    </p>
                    
                    <p>
                        <label class='required text-field' for='txtEmail'>Email</label>
                        <input
                            <?php if ($emailERROR) print 'class=mistake'; ?>
                            id='txtEmail'
                            maxlength='45'
                            name='txtEmail'
                            onfocus='this.select()'
                            placeholder='Enter a valid email address'
                            tabindex='120'
                            type='text'
                            value='<?php print $email; ?>'
                        >
                    </p>
                    
                </fieldset>
                
                <fieldset class ="radio <?php if ($genderERROR) print ' mistake'; ?>">
                    <legend>What is your gender?</legend>
                    <p>
                        <label class="radio-field">
                            <input type="radio"
                                id="radGenderMale"
                                name="radGender"
                                value="Male"
                                tabindex="572"
                                <?php if ($gender == "Male") echo ' checked="checked" '; ?>>
                        Male</label>
                    </p>
                    
                    <p>
                        <label class="radio-field">
                            <input type="radio"
                                   id="radGenderFemale"
                                   name="radGender"
                                   value="Female"
                                   tabindex="582"
                                   <?php if ($gender == "Female") echo ' checked="checked" '; ?>>
                        Female</label>
                    </p>
                    
                    <p>
                        <label class="radio-field">
                            <input type="radio"
                                   id="radGenderOther"
                                   name="radGender"
                                   value="Other"
                                   tabindex="582"
                                   <?php if ($gender == "Other") echo ' checked="checked" '; ?>>
                        Other</label>
                    </p>
                    
                    <p>
                        <label class="radio-field">
                            <input type="radio"
                                   id="radGenderPNTA"
                                   name="radGender"
                                   value="Prefer not to answer"
                                   tabindex="582"
                                   <?php if ($gender == "Prefer not to answer") echo ' checked="checked" '; ?>>
                        Prefer not to answer</label>
                    </p>
                    
                </fieldset>
                
                <fieldset class ="checkbox <?php if ($organizationError) print ' mistake'; ?>">
                    <legend> Which organizations have you heard of? (choose at least one and check all that apply):</legend>
                    
                    <p>
                        <label class ="check-field">
                            <input <?php if ($NASA) print " checked"; ?>
                                id="chkNASA"
                                name="chkNASA"
                                tabindex="420"
                                type="checkbox"
                                value="NASA"> NASA </label>
                        
                        <label class ="check-field">
                            <input <?php if ($spaceX) print " checked"; ?>
                                id="chkspaceX"
                                name="chkspaceX"
                                tabindex="430"
                                type="checkbox"
                                value="Space X"> SpaceX </label>
                        
                        <label class ="check-field">
                            <input <?php if ($NKAF) print " checked"; ?>
                                id="chkNKAF"
                                name="chkNKAF"
                                tabindex="440"
                                type="checkbox"
                                value="NKAF"> NKAF </label>
                        
                </fieldset>
                
                <fieldset class="listbox <?php if ($stateFromErrorERROR) print ' mistake'; ?>">
                        <legend>Where are you from?</legend>
                        <p>
                        <select id="listStateFrom"
                                name="listStateFrom"
                                tabindex="520" >
                        <?php foreach($theStates as $key => $value) { ?>
                            <option value="<?php echo $key ?>"><?php echo $value ?></option>
                        <?php }?>
                        </select>
                    </p>
                </fieldset>               
                
            <fieldset class ='buttons'>
              <legend></legend>
              <input class='button' id='btnSubmit' name="btnSubmit" tabindex='900' type='submit' value='Register'>
            </fieldset> <!-- ends buttons -->
    </form>
    
<?php    
    } //end body submit
?>    
    
</article>

<?php include 'footer.php'; ?>

</body>
</html>
