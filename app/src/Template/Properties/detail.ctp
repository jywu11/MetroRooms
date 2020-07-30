
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Homes Template">
    <meta name="keywords" content="Homes, Marika">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Property Detail | Metrorooms</title>
    <?php $this->assign('title','Property Detail | NAIM'); ?>
</head>

<!--<script src='https://kit.fontawesome.com/a076d05399.js'></script>-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<?= $this->Html->css('my_front') ?>

<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Faq[]|\Cake\Collection\CollectionInterface $faqs
 */
?>
<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Faq[]|\Cake\Collection\CollectionInterface $faqs
 */
?>

<?php echo $this->element('front_topbar'); ?>

<!-- http://ie.infotech.monash.edu/team107/team107-app/app//webroot/img/empty.svg -->
<!-- Hero Section Begin, map place holder -->
<section class="hero-section home-page set-bg" data-setbg="">
<!-- <section class="hero-section home-page set-bg" data-setbg="/img/ie/toppage.jpg"> -->
</section>
<!-- Hero Section End -->

<style>
    .inline_field{
        display: inline-block;
    }

    .hero-section {
        height: 190px;
        position: relative;
        z-index: 1;
        opacity: 0.7;
    }

    .hero-section:after {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: #f9bd39;
        content: "";
        z-index: -1;
    }

    header {
        background-color: #D33C44;
        font-size: 30px;
        height: 100px;
        line-height: 64px;
        padding: 16px 0px;
        box-shadow: 0px 1px rgba(0, 0, 0, 0.24);
    }

    .line_divi{
        background-color: lightgrey;
        opacity: 20%;
    }

    .google-maps {
        position: relative;
        padding-bottom: 30%;
        height: 0;
        overflow: hidden;
    }

    .google-maps iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100% !important;
        height: 100% !important;
    }

    @media (min-width: 320px){
        .ling_img{
            display: block !important;
            max-width:100% !important;
            max-height:200px; !important;
            width: auto !important;
            height: auto !important;
        }
    }

    @media (min-width: 420px){
        .ling_img{
            display: block !important;
            max-width:100% !important;
            max-height:250px; !important;
            width: auto !important;
            height: auto !important;
        }
    }

    @media (min-width: 640px){
        .ling_img{
            display: block !important;
            max-width:100% !important;
            max-height:350px; !important;
            width: auto !important;
            height: auto !important;
        }
    }

    @media (min-width: 768px){
        .ling_img{
            display: block !important;
            max-width:100% !important;
            max-height:450px; !important;
            width: auto !important;
            height: auto !important;
        }
    }

    @media (min-width: 990px){
        .ling_img{
            display: block !important;
            max-width:100% !important;
            max-height:550px; !important;
            width: auto !important;
            height: auto !important;
        }
    }

    @media (min-width: 1024px){
        .ling_img{
            display: block !important;
            max-width:100% !important;
            max-height:700px; !important;
            width: auto !important;
            height: auto !important;
        }
    }

    @media (min-width: 1200px){
        .ling_img{
            display: block !important;
            max-width:100% !important;
            max-height:700px; !important;
            width: auto !important;
            height: auto !important;
        }
    }

    .display_redo p{
        color:black !important;
    }

    .display_redo strong{
        font-weight:900;
    }

    .display_redo h4{
        font-size:1.5em;
        margin-bottom: 0;
        margin-left: 0;
        margin-right: 0;
        font-weight:bold;
    }


</style>

<?php

$country = $property->country;
$state = $property->state;
$suburb = $property->suburb;
$street = $property->street;
$postcode = $property->postcode;

$br_num = $property->number_of_bedroom;
$ba_num = $property->number_of_bathroom;
$info = $property->general_information;
$st_location = $street.", ".$suburb.", ".$state." ".$postcode;
$location = $st_location.", ".$country;
$features = $property->features;
$room_type = $property->room_type;
$t_n = $property->number_of_toilet;
?>

<?php
if ($property->property_status == 1){
    ?>
<div class="single-property">
    <div class="container">
        <div class="row">
            <ul class="breadcrumb">
                <li><?php echo $this->Html->link('Home', ['controller' => 'Properties', 'action' => 'index']); ?></li>
                <li style="color: white">Property Details</li>
            </ul>
        </div>
    </div>
</div>
<section class="property-details">
    <div class="container">
        <div class="row sp-40 spt-40">
            <p class="fa fa-frown-o" style="font-size:60px; text-align: center; color:red; "></p>
        </div>

        <div class="row sp-40 spt-40" style="padding-top:0; margin-top: 0;">
            <div class="inline_field">
                <h5 class="inline_field">Sorry, the Property you are looking for is currently unavailable. For more information, please&nbsp;</h5>
            </div>

                <?php
                echo $this->HTML->Link(
                    '<h5 class="inline_field"><u style="color: #007BFF" class="inline_field">Contact us</u></h5>',
                    ['controller'=>'Faqs', 'action'=>'contactus'],
                    ['escape'=>false, 'class'=>'inline_field']
                );
                ?>

            <div class="inline_field">
                <h5>&nbsp;or check the</h5>
            </div>
            <?php
            echo $this->HTML->Link(
                '&nbsp;<h5 class="inline_field"><u style="color: #007BFF" class="inline_field">FAQs</u></h5>',
                ['controller'=>'Faqs', 'action'=>'index'],
                ['escape'=>false, 'class'=>'inline_field']
            );
            ?>
            <br>
            <br>
            <br>

        </div>
    </div>
</section>

    <?php
}else{
?>
<!-- Single Property Section Begin -->
<div class="single-property">
    <div class="container">
        <div class="row">
            <ul class="breadcrumb">
                <li><?php echo $this->Html->link('Home', ['controller' => 'Properties', 'action' => 'index']); ?></li>
                <li style="color: white">Property Details</li>
            </ul>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="property-img owl-carousel" style="background-color: #f4f4f4;">

                <?php
                    $counter_1 = 0;
                    foreach ($propertyImages as $pi){
                        $counter_1 = $counter_1 + 1;
                    }
                    if ($counter_1===0){
                        //$path = '/img/placeholder.jpg';
                        //$path = '/img/placeholder.jpg'; ?>
                        <div class="single-img">
                            <?php echo $this->Html->image('placeholder.jpg', ['alt' => 'placeholder can\'t be displayed :((', 'class' => 'ling_img']); ?>
                        </div>
                    <?php }else{
                        // DISPLAY PROPERTY IMG FIRST
                        foreach ($propertyImages as $p){
                            if ($p->room_id == null){
                                $path = $p->photo_dir.$p->photo_name;
                            ?>
                            <div class="single-img ling_img">
                                <?php echo $this->Html->image($path, ['alt' => 'The image is gone :(((', 'class'=> 'ling_img']); ?>
                            </div>
                            <?php
                            }
                        }

                        // DISPLAY ROOM IMG
                            foreach ($propertyImages as $p){
                                if ($p->room_id != null){
                                    $path = $p->photo_dir.$p->photo_name;
                                    ?>
                                    <div class="single-img ling_img">
                                        <?php echo $this->Html->image($path, ['alt' => 'The image is gone :(((', 'class'=> 'ling_img']); ?>
                                    </div>
                                    <?php
                                }
                            }
                    }?>

                </div>
            </div>
        </div>
        <br>
        <div class="row spad-p">
            <div class="col-lg-12">
                <div class="property-title">
                    <h3>Address: </h3>
                    <h2><?php echo $location; ?></h2>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="property-details">
    <div class="container">
        <div class="row sp-40 spt-40">
            <div class="col-lg-12">
                <div class="p-ins">
                    <div class="row details-top">
                        <div class="col-lg-12">
                            <div class="t-details">
                                <div class="inline_field">
                                    <div class="beds">
                                        <p>Bedrooms</p>
                                        <!-- <img src="/img/tem/rooms/bed.png" alt=""> -->
                                        <?php echo $this->Html->image('tem/rooms/bed.png', ['alt' => ' ']); ?>
                                        <!--<img src="/img/tem/rooms/bed.png" alt="">-->
                                        <span><?php echo $br_num; ?></span>
                                    </div>
                                </div>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <div class="inline_field">
                                    <div class="baths">
                                        <p>Baths</p>
                                        <!-- <img src="/img/tem/rooms/bath.png" alt=""> -->
                                        <?php echo $this->Html->image('tem/rooms/bath.png', ['alt' => ' ']); ?>
                                        <!--<img src="/img/tem/rooms/bath.png" alt="">-->
                                        <span><?php echo $ba_num; ?></span>
                                    </div>
                                </div>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <div class="inline_field">
                                    <div class="baths">
                                        <p>Toilets</p>
                                        <!-- <img src="/img/tem/rooms/bath.png" alt=""> -->
                                        <?php echo $this->Html->image('toilet_1.png', ['alt' => ' ']); ?>
                                        <!--<img src="/img/tem/rooms/bath.png" alt="">-->
                                        <span><?php echo $t_n; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <!-- basic description -->
                            <div class="property-description">
                                <br>
                                <h4><b>Property Type: &nbsp;</b>
                                    <?php
                                    if ($property->type == null){
                                        echo "No property type information given";
                                    }else{
                                        echo $property->type->name;
                                    }
                                     ?></h4>
<hr class="line_divi">
                                <h4><b>Property Description</b></h4>

                                <div class="display_redo">
                                <?php
                                if ($info == null){
                                    echo "<p>This Property doesn't have a description</p>";
                                }else{
                                    ?>
                                    <p style="white-space: pre-line"><?php echo $info; ?></p>
                                <?php
                                }
                                ?>
                                </div>

                            </div>

                            <!-- map -->
                            <?php
                            if (strlen($property->map)!=0) {
                                ?>
                                <hr class="line_divi">
                                <div class="google-maps">
                                    <?php echo $property->map; ?>
                                </div>
                            <?php
                            }

                            ?>


                            <!-- end map -->
                            <hr class="line_divi">
                            <!--Sleeping arrangements-->
                            <br>
                            <div class="property-features" style="margin-bottom: 0;">
                                <h4 style="margin-bottom:0;"><b>Sleeping arrangements</b></h4>
                            </div>
                            <br>
                            <div class="row">
                            <?php
                            // debug($property);
                            $rooms = $property->rooms;
                            $counter = 1;
                            $path = '';
                            $flag = 0;
                           foreach ($rooms as $room){
                               // image
                               $my_image = null;
                               $path = '';
                               foreach ($propertyImages as $image){
                                   if ($image->room_id == $room->id){
                                       $my_image = $image;
                                       // debug($my_image);
                                       break;
                                   }
                               }
                               if ($my_image == null){
                                   $path ='../../webroot/img/placeholder.jpg';
                               }else{
                                  // http://ie.infotech.monash.edu/team107/test/app/webroot/img/property/196/room/51/O2AVAimages%20(2).jpg
                                   $path = "../../webroot/img/property/".$property->id."/room/".$room->id."/".$my_image->photo_name;
                                  // debug($path);
                               }

                               // room type
                               $r_t = $room->room_type;
                               $flag = 1;
                               ?>

                               <div class="col-lg-4 col-md-6" style="padding-bottom:10px;">
                                   <div class="room-items">

                                       <a href=<?php echo '../../rooms/detail/'.$room->id; ?>>
                                           <div class="room-img set-bg" data-setbg="<?php echo $path; ?>"></div>
                                       </a>

                                       <div class="room-text">
                                           <div class="room-details">
                                               <div class="room-title">
                                                   <a href=<?php echo '../../rooms/detail/'.$room->id; ?>><h5 style="text-decoration: underline;"><?php echo $room->room_name; ?></h5></a>
                                               </div>
                                           </div>

                                           <?php
                                           $r_t = $room->room_type;
                                           if ($r_t == 0){
                                               $r_t = 'Private';
                                               if ($room->room_type_desc != null){
                                                   $r_t = $r_t."&nbsp;-&nbsp;".$room->room_type_desc;
                                               }
                                           }else{
                                               $r_t = 'Sharing';
                                               if ($room->room_type_desc != null){
                                                   $r_t = $r_t."&nbsp;-&nbsp;".$room->room_type_desc;
                                               }
                                           }
                                           ?>
                                           <?php
                                           $room_capacity = 0;
                                           foreach ($all_room_beds as $rb){
                                               if ($rb->room_id == $room->id){
                                                   $room_capacity += $rb->capacity;
                                               }
                                           }
                                           ?>
                                               <div class="room-info">
                                                   <div><p class="inline_field" style="padding-bottom: 0; margin-bottom: 0;">Room Type: &nbsp;</p><?php echo "<h7 class='inline_field'><b>".$r_t."</b></h7>";?>&nbsp;&nbsp;<p class="inline_field">|</p>&nbsp;
                                                   <p class="inline_field" style="padding-bottom: 0; margin-bottom: 0;">Room Capacity: &nbsp;</p> <?php echo "<h7 class='inline_field'><b>".$room_capacity."</b></h7>"; ?></div>
                                               </div>

                                       </div>
                                       <div class="room-items" style="margin-bottom: 0;">
                                       <div class="room-text">
                                           <?php
                                           if ($room->rental_end_date != null){
                                               $e_d = $room->rental_end_date;
                                               $e_d = $e_d->i18nFormat('dd-MM-yyyy');

                                               // end date smaller than now
                                               $currentDate = \Cake\I18n\Time::now();
                                               $currentDate = date("Y-m-d", strtotime($currentDate->i18nFormat('yyyy-MM-dd')));
                                               // REMEMBER TO CHANGE DATE SMALLER THAN CURRENT DATE

                                               echo "<p class='inline_field' style='margin-bottom: 0;'>Available after:  &nbsp;</p>"."<h7 class='inline_field' style='margin-bottom: 0;'><b>".$e_d."</b></h7><br>";
                                           }else{
                                               echo "<h7 style='margin-bottom: 0;'><b>Available now!</b></h7>";
                                           }
                                           ?>
                                       </div>
                                   </div>
                                   <div class="room-text">
                                       <?php
                                       echo $this->Html->link(
                                           'Enquire Now!',
                                           ['controller' => 'applications', 'action' => 'frontadd', $room->id],
                                           ['class' => '',  'style' => 'font-size:100%;']
                                       );
                                       ?>
                                   </div>
                                   </div>
                               </div>

                            <!--<div class="col-lg-3 col-md-3">
                                <div class="room-items">

                                    <a href=<?php /*echo ''; */?>>
                                        <div class="room-img set-bg" data-setbg=<?php /*echo $path; */?>></div>
                                    </a>

                                    <div class="room-text">
                                        <div class="room-details">
                                            <div class="room-title">
                                                <h5>abc</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>-->
                           <?php
                           $counter += 1;
                           }
                           if ($flag == 0){
                               echo "&nbsp&nbsp&nbsp&nbsp <p>No Room Available</p>";
                           }

                            if(strlen($path)==0){
                                $path = 'img/placeholder.jpg';
                            }
                            ?>
                            </div>
                            <!-- end Sleeping arrangements-->

                            <hr class="line_divi">
                            <br>
                            <!-- Transport and Surrounding -->
                            <div class="property-features">
                                <h4><b>Public Transport and Surroundings</b></h4>
                                <br>
                                <div style="padding-left: 10px;" class="">
                                    <!-- public transport -->
                                    <p class="fa fa-automobile inline_field" ></p><h7 class="inline_field"><b>&nbsp;Parking and Taxis</b></h7>
                                    <div class="display_redo">
                                        <?php
                                        if (strlen($property->parking_taxi)==0){
                                            echo "<p>This property doesn't have any Parking and Taxis information recorded.</p>";
                                        }
                                        echo "".$property->parking_taxi."";  ?>
                                    </div>
                                    <br>
                                    <p class="fa fa-bus inline_field"></p><h7 class="inline_field"><b>&nbsp;Bus Routes and Tram Stops</b></h7>
                                    <div class="display_redo">
                                        <?php
                                        if (strlen($property->bus_tram)==0){
                                            echo "<p>This property doesn't have any Bus Routes or Tram Stops information recorded.</p>";
                                        }
                                        echo "".$property->bus_tram."";  ?>
                                    </div>
                                    <br>
                                    <p class="fa fa-subway inline_field"></p><h7 class="inline_field"><b>&nbsp;Train Stations</b></h7>
                                    <div class="display_redo">
                                        <?php
                                        if (strlen($property->train)==0){
                                            echo "<p>This property doesn't have any Train Station information recorded.</p>";
                                        }
                                        echo "".$property->train."";  ?>
                                    </div>
                                    <br>
                                    <p class="fa fa-coffee inline_field"></p><h7 class="inline_field"><b>&nbsp;House Surroundings</b></h7>
                                    <div class="display_redo">
                                        <?php
                                        if (strlen($property->surrounding)==0){
                                            echo "<p>This property doesn't have any House Surrounding information recorded.</p>";
                                        }
                                        echo "".$property->surrounding."";  ?>
                                    </div>
                                    <br>
                                    <!-- surroundings -->
                                </div>

                            </div>
                            <!-- end transport and surrounding -->
                            <hr class="line_divi">
                            <br>
                            <div class="property-features" style="margin-bottom: 0;">
                                <h4><b>House Rules</b></h4>
                                <div class="display_redo">
                                    <?php
                                    if (strlen($property->houserule) == 0){
                                        echo "<p>This property doesn't have any house rules.</p>";
                                    }else{

                                        echo $property->houserule;
                                    }

                                    ?>
                                </div>
                                <br>
                            </div>


                           <!-- <hr class="line_divi">-->
                            <hr class="line_divi">
                            <br>

                            <!-- HOUSE FEATURE -->
                            <div class="property-features" style="margin-bottom: 0;">
                                <h4><b>Property Features</b></h4>
                                <div class="property-table">
                                    <table>
                                        <?php
                                        $items = $property->items;
                                        // debug($items);
                                        $counter = 1;
                                        $reminder = 0; ?>
                                        <tr>
                                            <?php
                                            foreach($features as $f){
                                            if ($counter%3 != 0){?>
                                                <td><?php echo $this->Html->image('tem/check.png', ['alt' => ' ']); ?>
                                                    <!--<img src="/img/tem/check.png" alt="">--><?php echo $f->name;?></td>
                                            <?php }else{ ?>
                                            <td><?php echo $this->Html->image('tem/check.png', ['alt' => ' ']); ?><?php echo $f->name;?></td>

                                        </tr>
                                        <tr>
                                            <?php  }
                                            $counter = $counter + 1;
                                            }
                                            // items

                                            ?></tr>
                                    </table>
                                </div>
                            </div>
                            <!--<hr class="line_divi">-->
                            <!-- END HOUSE FEATURE -->
                            <br>

                            <!-- HOUSE ITEM -->
                            <div class="property-features" style="margin-bottom: 0;">
                                <h4><b>Furnishings In The Property</b></h4>
                                <div class="property-table">
                                    <table>
                                        <?php
                                        $items = $property->items;
                                        // debug($items);
                                        $counter = 1;
                                        $reminder = 0;
                                        ?>
                                        <tr>
                                            <?php
                                            foreach ($items as $item) {
                                                if ($counter % 3 != 0) { ?>
                                                    <td><?php echo $this->Html->image('tem/check.png', ['alt' => ' ']); ?>
                                                        <!--<img src="/img/tem/check.png" alt="">--><?php echo "with ".$item->_joinData->quantity." ".$item->name;?></td>
                                                <?php }
                                                else{ ?>
                                                    <td><?php echo $this->Html->image('tem/check.png', ['alt' => ' ']); ?><?php echo "with ".$item->_joinData->quantity." ".$item->name;?></td>
                                                    <!--<td><img src="/img/tem/check.png" alt=""></td>-->
                                        </tr>
                                        <tr>
                                           <?php     }
                                                $counter = $counter + 1;
                                            }
                                            ?>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <!-- END HOUSE ITEM -->

                           <!-- <hr class="line_divi">-->
                        </div>
                    </div>




                  <!--  <br>
-->


                    <div class="row">
                            <div class="inline_field">
                                <div class="col-lg-12">
                                    <?php
                                    if ($frontcontent->house_question == '' || $frontcontent->house_question == null){
                                        echo '<h5>How to Send An Enquiry</h5>';
                                    }else{
                                        echo "<h5>".$frontcontent->house_question."</h5>";
                                    }
                                    ?><br>
                                    <?php
                                    if ($frontcontent->house_answer == '' || $frontcontent->house_answer == null){
                                        echo '<p>Please check out the Rooms and place an enquiry on a particular room you like.</p>';
                                    }else{
                                        echo "<p>".$frontcontent->house_answer."</p>";
                                    }
                                    ?>

                                </div>
                            </div>
                        <div class="col-lg-12">
                            <?php
                            echo $this->Html->link(
                                'FAQ',
                                ['controller' => 'Faqs', 'action' => 'index'],
                                ['class' => 'site-btn btn-line']
                            );
                            ?>
                        </div>

                    </div>


                </div>
            </div>
        </div>
    </div>
</section>
<!-- Single Property End -->

<?php
}
?>



<!-- front-end footer element -->
<?php echo $this->element('front_footer'); ?>
</body>




