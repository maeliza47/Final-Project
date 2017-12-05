<?php
$phpSelf = htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES, "UTF-8");

$path_parts = pathinfo($phpSelf);

 ?>	
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Astrophotography for Dummies</title>

        <meta charset="utf-8">
        <meta name="author" content="Aaron M. Evans, Mary E. Foran">
        <meta name="description" content="Description">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link rel="stylesheet" href="../finalProject/css/final.css" type="text/css" media="screen">

        <?php
        $debug = false;
    
        //This if statement allows us in the classroom to see what out variables are
        //This is Never done on a live site
        if (isset($_GET["debug"])){
            $debug = true;
        }
        
// %^%^%^%^%^%^%%%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%        
//
//Path Setup
//

$domain = '//';

$server = htmlentities($_SERVER['SERVER_NAME'], ENT_QUOTES, 'UTF-8');

$domain .= $server;

        
        if($debug){
            
            print '<p>php Self: ' . $phpSelf;
            print '<p>Path Parts<pre>';
            print_r($path_parts);
            print '</pre></p>';
        }
        
// %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
//include all libraries
//
//Common mistake: not have the lib folder with these files.
//Google the difference between require and include
//      
        print PHP_EOL . '<!--include libraries -->' . PHP_EOL;
        
        require_once('lib/security.php');
        
        //NOTICE this statement only includes the function if it is
        //form page. A common mistake is to make a form and call the page
        //join.php which means you need to change it below (or delete the if)
        if ($path_parts['filename'] == 'form'){
            print PHP_EOL . '<!-- include form libraries -->' . PHP_EOL;
            include "lib/validation-functions.php";
            include "lib/mail-message.php";
        }
        
        print PHP_EOL . '<!-- finished including libraries -->' . PHP_EOL;
        ?>
    
    </head>
    <!-- ### body section ### -->
    
    <?php
    print '<body id="' . $path_parts['filename'] . '">';
    
    include('header.php');
    include ('nav.php');

    if($debug){
        print '<p>DEBUG MODE IS ON</p>';
    }
    ?>
