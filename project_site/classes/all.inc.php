<?php       // File "all.inc.php" : Include all files (classes, various things, etc.)

    require_once("various.inc.php"); // COMMENT
    require_once("conf.bdd.php"); // COMMENT
    require_once("Database.php"); // COMMENT
    require_once("User.php"); // COMMENT
    //include_once("example.inc.php"); // COMMENT
    //include_once("imgwatermark.inc.php"); // COMMENT
    include_once("Picture.php"); // COMMENT
    include_once("Gallery.php"); // COMMENT

    session_start(); // Session Creation or Recovery

//    if( isset($_SESSION['login_status']) == FALSE ) { $_SESSION['login_status'] = ''; }
//    if( isset($_SESSION['login_errors']) == FALSE ) { $_SESSION['login_errors'] = ''; }
    if( isset($_SESSION['user']) == FALSE ) { $_SESSION['user'] = ''; }
    if( isset($_SESSION['public_gal']) == FALSE ) { $_SESSION['public_gal'] = new Gallery(0, FALSE, TRUE); }
    if( isset($_SESSION['private_gal']) == FALSE ) { $_SESSION['private_gal'] = ''; }
    if( isset($_SESSION['cart']) == FALSE ) { $_SESSION['cart'] = new Gallery(-1, TRUE, FALSE); }

    require_once("logout.inc.php"); // COMMENT
    require_once("cart.inc.php"); // COMMENT

?>