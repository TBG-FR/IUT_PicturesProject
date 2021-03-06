<?php

require_once("classes/all.inc.php"); // Include all the Classes & Functions & Co + Session Start + Disconnection Management

?>

<script> 
    $(document).ready(function(){

    $(".filter-button").click(function(){
        var value = $(this).attr('data-filter');
        
        if(value == "all")
        {
            //$('.filter').removeClass('hidden');
            $('.filter').show('1000');
        }
        else
        {
//            $('.filter[filter-item="'+value+'"]').removeClass('hidden');
//            $(".filter").not('.filter[filter-item="'+value+'"]').addClass('hidden');
            $(".filter").not('.'+value).hide('3000');
            $('.filter').filter('.'+value).show('3000');
            
        }
    });
    
    if ($(".filter-button").removeClass("active")) {
$(this).removeClass("active");
}
$(this).addClass("active");

});
</script>

<!-- 'public_gallery.php' ~ Displays the public gallery (without login, and with watermarked pictures) -->

<!doctype html>

<html lang="en">

    <head>
        <meta charset="UTF-8">

        <title>Andrew Blind - Professional Photographer - Gallery</title>
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

            <div class="gallery">              
                     <?php
                
                // -------------------------- Filters Buttons (Keywords)

                 echo "<div>";
                        echo "<button class='btn btn-default btntext filter-button' data-filter=all>all</button>";
                     
                        $db=new Database();                   
                        $keywords=$db->getAllKeyword();
                   
                        foreach($keywords as $keyword) { echo "<button class='btn btn-default btntext filter-button' data-filter={$keyword}>{$keyword}</button>"; }
                
                echo "<div>";
                
                // -------------------------- Pictures

                foreach($_SESSION['public_gal']->getPictures() as $picture) {

                    switch ($picture->getState()) {

                            // State 0 : "normal" picture
                        case 0:
                            echo "
                                <div class='gal_element filter {$picture->getKeywordsSortable()}'>
                                
                                    <img src='public_images/".$picture->getPath()."' alt='".$picture->getTitle()."' height='250px' />
                                    
                                    <div class='gal_overlay'>
                                        <div class='gal_buttons'>
                                            <a href='?action=cart_add&item_id=".$picture->getID()."' class='littletextbtn btn btn-primary' role='button'>Add to Cart</a>
                                            <a href='##NOT_IMPLEMENTED_YET' class='littletextbtn btn btn-default' role='button'>View More</a>
                                        </div>
                                    </div>
                                </div>
                            ";
                            break;
                            

                            // State 1 : picture "selected" (in cart)
                        case 1:
                            echo "
                                <div class='gal_element filter {$picture->getKeywordsSortable()}'>
                                
                                    <img src='public_images/".$picture->getPath()."' alt='".$picture->getTitle()."' height='250px' />
                                    
                                    <div class='gal_overlay'>
                                        <div class='gal_buttons'>
                                            <a href='?action=cart_del&item_id=".$picture->getID()."' class='littletextbtn btn btn-danger' role='button'>Remove from Cart</a>
                                            <a href='##NOT_IMPLEMENTED_YET' class='littletextbtn btn btn-default' role='button'>View More</a>
                                        </div>
                                    </div>
                                </div>
                            ";
                            break;
                            

                            // State 2 : picture already bought
                        case 2:
                            echo "
                                <div class='gal_element filter {$picture->getKeywordsSortable()}'>
                                
                                    <img src='public_images/".$picture->getPath()."' alt='".$picture->getTitle()."' height='250px' />
                                    
                                    <div class='gal_overlay'>
                                        <div class='gal_buttons'>
                                            <a href='private_gallery.php?action=highlight&item_id=".$picture->getID()."' class='littletextbtn btn btn-success' role='button'>Already Bought</a>
                                            <a href='##NOT_IMPLEMENTED_YET' class='littletextbtn btn btn-default' role='button'>View More</a>
                                        </div>
                                    </div>
                                </div>
                            ";
                            break;
                    }

                }

                ?>

            </div>
        </div>

        <footer>
            <?php include_once("footer.php"); ?>
        </footer>

    </body>

</html>