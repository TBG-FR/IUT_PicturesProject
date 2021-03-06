<?php

    require_once("classes/all.inc.php"); // Include all the Classes & Functions & Co + Session Start + Disconnection Management

    if ( $_GET ) {

        if($_GET['action'] == 'bought') {

            echo "<div class='notification alert alert-success' role='alert'>You've successfully bought those pictures ! They're now available in your personal Gallery, enjoy !</div>";
            
        }        
    }

?>

<!-- 'login.php' ~ Login & Registering Management -->

<!doctype html>

<html lang="en">

    <head>
        <meta charset="UTF-8">

        <title>Andrew Blind - Professional Photographer - Login/Register</title>
        <!-- <meta name="description" content=""> -->
        <!-- <meta name="author" content=""> -->

        <?php include_once("head.php"); // Make all the CSS & JavaScript links ?>

    </head>

    <body>

        <header>
            <?php include_once("header.php"); ?>
            <?php include_once("navbar.php"); ?>
        </header>

        <div class="content">

            <?php            
            
            /* ===== ===== ===== IF A FORM HAS BEEN SENT => VALIDATE THE FORM, CHECK THE VALUES AND GET THE RESULTS ===== ===== ===== */            
            if ( $_POST ) {
                
                $db = new Database();
                
                //foreach ($_POST as $champ => $valeur)
                 //   echo $champ.' --- '.$valeur.'<br />';
                //print_r($_POST);
                
                // If the User tried to Log himself to his account
                if ($_POST['action'] == 'login') {
                    
                    // Transform the given credentials to avoid injections & other attacks
                    $username=var_secure($_POST['username']);
                    $password=var_secure($_POST['password']);
                    
                    // Create a new Instance of User Class with the given credentials (and catch errors if they're wrong)                    
                    try {
                        
                        $_SESSION['user'] = User::constructByLogin($username, $password);
                    
                        //Creating the public and private galleries for this user with construct : ($user_id, $logged, $public)
                        $_SESSION['public_gal'] = new Gallery($_SESSION['user']->getID(), TRUE, TRUE);
                        $_SESSION['private_gal'] = new Gallery($_SESSION['user']->getID(), TRUE, FALSE);
                        
                        //Creating the Cart for this user if it doesn't exist (Gallery with id -1)
                        if( isset($_SESSION['cart']) == FALSE ) { $_SESSION['cart'] = new Gallery(-1, TRUE, FALSE); }
                        
                    }
                    
                    catch (Exception $e) {
                        
                        if($e->getMessage() == 'Err_BadCredentials') {                             
                            echo "<div class='notification alert alert-danger' role='alert'>Error : Wrong User/Password combination ! Please try again.</div>"; }
                        
                        else if ($e->getMessage() == 'Err_UnknownUsername') {
                            echo "<div class='notification alert alert-danger' role='alert'>Error : Unknown Username ! Please try again.</div>"; }
                        
                    }
                    
                }
                
                // If the User tried to Register a new account
                else if ($_POST['action'] == 'register') {
                    
                    // Transform the given informations to avoid injections & other attacks
                    $username=var_secure($_POST['username']);
                    $password=var_secure($_POST['password']);
                    $password_verif=var_secure($_POST['password_verif']);
                    $firstname=var_secure($_POST['firstname']);
                    $lastname=var_secure($_POST['lastname']);
                    $mail=var_secure($_POST['mail']);
                    
                    // Create a new Instance of User Class with the given credentials (and catch errors if they're wrong)                    
                    try {
                        
                        $_SESSION['user'] = User::constructByRegister($username, $password, $password_verif, $firstname, $lastname, $mail);
                    
                        //Creating the public and private galleries for this user with construct : ($user_id, $logged, $public)
                        $_SESSION['public_gal'] = new Gallery($_SESSION['user']->getID(), TRUE, TRUE);
                        $_SESSION['private_gal'] = new Gallery($_SESSION['user']->getID(), TRUE, FALSE);
                        
                        //Creating the Cart for this user if it doesn't exist (Gallery with id -1)
                        if( isset($_SESSION['cart']) == FALSE ) { $_SESSION['cart'] = new Gallery(-1, TRUE, FALSE); }
                        
                    }
                    
                    catch (Exception $e) {
                        
                        if($e->getMessage() == 'Err_UsernameExists') {                             
                            echo "<div class='notification alert alert-danger' role='alert'>Error : Username already taken ! Please try again with another one.</div>"; }
                        
                        else if ($e->getMessage() == 'Err_PasswordMatch') {
                            echo "<div class='notification alert alert-danger' role='alert'>Error : Passwords aren't matching ! Please try again.</div>"; }
                        
                        else if ($e->getMessage() == 'Err_RegisterFail') {
                            echo "<div class='notification alert alert-danger' role='alert'>Error : Registering failed ! Please try again or Contact us.</div>"; }
                        
                    }
                    
                }
            }
                
            /* ===== ===== ===== IF USER IS CONNECTED => DISPLAY USEFUL LINKS ===== ===== ===== */ 
            if( $_SESSION['user'] instanceof User && $_SESSION['user']->getStatus() == TRUE ) {

                $l_username=$_SESSION['user']->getUsername();
                
                echo "
                
                    <div class='mini_menu'>
                        <!-- Connected - Header -->
                        <p class='title'>Logged as ".$l_username."</p><br />

                        <!-- Connected - Links -->
                        <a href='edit_account.php' class='btn btn-primary btn-block btntext' role='button'>Account Informations</a>
                        <a href='private_gallery.php' class='btn btn-primary btn-block btntext' role='button'>Personal Gallery</a>
                        <a href='###NOT_YET_IMPLEMENTED' class='btn btn-warning btn-block btntext' role='button'>Purchase History</a>
                        <a href='?action=disconnect' class='btn btn-danger btn-block btntext' role='button'>Log out</a>
                    </div>
                    
                "; /* Echo[HTML] : End */
            }
            
            /* ===== ===== ===== ELSE (FIRST ACCESS, OR ERRORS WERE FOUND WHILE PROCESSING THE FORM) => DISPLAY THE FORMS ===== ===== ===== */
            else {
                
                /* Here we could keep the user's entries in case of error or reconnection */

                echo "
                
                <div id='inline-forms'>
                    <!-- Logging Form -->
                    <div id='login'>

                        <p class='title'>Login</p><br />

                        <form class='text' action='login.php' method='post'>
                        
                            <!-- ADD : Mail or Username -->
                            Username : <input type='text' name='username' value='' required> <br />
                            Password : <input type='password' name='password' placeholder='Enter your password' required> <br />
                            <!-- ADD : Captcha [] -->
                            
                             <br />
                            <input type='hidden' name='action' value='login'/>                
                            <input type='submit' value='Login'>
                        </form>

                    </div>

                    <!-- Registering Form -->
                    <div id='register'>

                         <p class='title'>Register</p><br />

                         <form class='text' action='login.php' method='post'>
                         
                             Mail : <input type='text' name='mail' value='' required> <br />
                             First name : <input type='text' name='firstname' value=''> <br />
                             Last name : <input type='text' name='lastname' value=''> <br />
                             <br />
                             Username : <input type='text' name='username' value='' required> <br />
                             Password : <input type='password' name='password' placeholder='Enter your desired password' required> <br />
                             Password (Repeat) : <input type='password' name='password_verif' placeholder='Repeat your desired  password' required> <br />
                             <!-- ADD : Captcha [] -->
                             
                             <br />
                             <input type='hidden' name='action' value='register'/>                
                             <input type='submit' value='Register'>
                         </form>

                    </div>
                </div>

                "; /* Echo[HTML] : End */

            }

            ?>

        </div>

        <footer>
            <?php include_once("footer.php"); ?>
        </footer>

    </body>

</html>