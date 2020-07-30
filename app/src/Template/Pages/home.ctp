<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Metrorooms | Metrorooms provides cheap houseshare for students and family looking for rents</title>
    <?php $this->assign('title','Metrorooms | Metrorooms provides cheap houseshare for students and family looking for rents');  ?>
    <meta name="description" content="metrorooms provides you cheap houseshare and rent, for students and family who looks for furnished share houses with house mates, with
parking and locations lin inner suburbs">
    <meta name="keywords" content="Homes, Marika, accommodation, budget, cheap, houseshare, share house, student, housemate, house mate, furnished, room, rent,
    female, flat mate, flatmate, parking, transport, inner suburbs, metro">
</head>

<h1 style="display:none">Homes, Marika, accommodation, budget, cheap, houseshare, share house, student, housemate, house mate, furnished, room, rent,
    female, flat mate, flatmate, parking, transport, inner suburbs, metro</h1>
<!-- front-end top bar element -->
<?php echo $this->element('front_topbar'); ?>

<?php
if ($frontcontent->banner_image == null){
    $path = "img/ie/toppage.jpg";
}else{
    $path = "img/".$frontcontent->banner_image;
}

?>
<h1 style="display:none">Homes, Marika, accommodation, budget, cheap, houseshare, share house, student, housemate, house mate, furnished, room, rent,
    female, flat mate, flatmate, parking, transport, inner suburbs, metro</h1>
<!-- Hero Section Begin, map place holder -->
<section class="hero-section home-page set-bg" data-setbg="<?php echo $path; ?>">
    <!-- <section class="hero-section home-page set-bg" data-setbg="/img/ie/toppage.jpg"> -->
    <div class="container hero-text text-white">
        <h2><?php
            if ($frontcontent->banner_title == '' || $frontcontent->banner_title == null){
                echo 'Metrorooms';
            }else{
                echo $frontcontent->banner_title;
            }
            ?></h2>
    </div>
</section>
<!-- Hero Section End -->



<!-- scroll animate -->
<style>
    .scroll-down {
        opacity: 1;
        -webkit-transition: all .5s ease-in 3s;
        transition: all .5s ease-in 3s;
    }

    .scroll-down {
        text-align: center;
        background-color: #F36C38;
        position: relative;
        bottom: 30px;
        left: 50%;
        margin-left: -16px;
        display: block;
        width: 40px;
        height: 40px;
        border: 2px solid  #F36C38;
        background-size: 14px auto;
        border-radius: 50%;
        z-index: 2;
        -webkit-animation: bounce 2s infinite 2s;
        animation: bounce 2s infinite 2s;
        -webkit-transition: all .2s ease-in;
        transition: all .2s ease-in;
    }

    .scroll-down:before {
        position: absolute;
        top: calc(50% - 8px);
        left: calc(50% - 6px);
        transform: rotate(-45deg);
        display: block;
        width: 12px;
        height: 12px;
        content: "";
        border: 2px solid white;
        border-width: 0px 0 2px 2px;
    }

    @keyframes bounce {
        0%,
        100%,
        20%,
        50%,
        80% {
            -webkit-transform: translateY(0);
            -ms-transform: translateY(0);
            transform: translateY(0);
        }
        40% {
            -webkit-transform: translateY(-10px);
            -ms-transform: translateY(-10px);
            transform: translateY(-10px);
        }
        60% {
            -webkit-transform: translateY(-5px);
            -ms-transform: translateY(-5px);
            transform: translateY(-5px);
        }
    }

</style>

<!-- end scroll animate -->


<style>
    .inline_field{
        display: inline-block;
    }

    .card-body{
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        border-radius: 10px;
        height:150px;
        padding-top: 35px;
    }

    @media only screen and (max-width: 768px) {
        .card-body {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            border-radius: 10px;
            height: 110px;
        }
    }


</style>

<body>
<h1 style="display:none">Homes, Marika, accommodation, budget, cheap, houseshare, share house, student, housemate, house mate, furnished, room, rent,
    female, flat mate, flatmate, parking, transport, inner suburbs, metro</h1>
<!-- Page Preloder -->
<!--<div id="preloder">
    <div class="loader"></div>
</div>-->
<!-- Page Preloder ends -->


<!-- Property Room Section Begin -->
<section class="-rooms spad" style="padding-top: 30px;">
    <div class="container">


        <!-- Introduction Section Begin -->
        <section class="services-section" style="padding-bottom:0; padding-top:30px;">
            <div class="container">
                <h2 style="text-align: center;padding-bottom: 10px;">
                    <span>
                        <?php
                        if ($frontcontent->home_service_title == '' || $frontcontent->home_service_title == null){
                            echo 'What is our purpose?';
                        }else{
                            echo $frontcontent->home_service_title;
                        }
                        ?>

                        <?php /*echo $frontcontent->home_service_title ; */?></span></h2>

                <div class="left-side " style="text-align: center">
                    <p>
                        <?php
                        if ($frontcontent->home_service_desc == '' || $frontcontent->home_service_desc == null){
                            echo '<h4 style="font-weight:300;color:#6F6F8A; font-family: Roboto;">Our mission is to help students on their medical placements find accommodation.</h4>';
                        }else{
                            echo $frontcontent->home_service_desc;
                        }
                        ?>
                       <!-- --><?php /*echo $frontcontent->home_service_desc ; */?></p>
                </div>

                <br><br>
                <div class="row">
                    <div class="col-lg-3" style="padding-bottom: 40px;">
                        <div id="card-hover">
                            <div class="card text-center" style="margin-bottom: 10px; border-color:white; background-color: white">
                                <div class="card-body">
                                    <img src="img/tem/check.png" alt="">
                                    <br><br>
                                    <p style="width:100%; color:black;">
                                        <?php
                                        if ($frontcontent->home_service_entry1 == '' || $frontcontent->home_service_entry1 == null){
                                            echo 'Safe Neighborhood';
                                        }else{
                                            echo $frontcontent->home_service_entry1;
                                        }
                                        ?>

                                        <?php /*echo $frontcontent->home_service_entry1 ; */?></p>
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3" style="padding-bottom: 40px;">
                        <div class="card text-center" style=" margin-bottom: 10px; border-color:white; background-color: white">
                            <div class="card-body">
                                <img src="img/tem/check.png" alt=""><br><br>
                                <p style="width:100%; color:black;">  <?php
                                    if ($frontcontent->home_service_entry2 == '' || $frontcontent->home_service_entry2 == null){
                                        echo 'Close to Hospital';
                                    }else{
                                        echo $frontcontent->home_service_entry2;
                                    }
                                    ?></p>
                                <br>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3" style="padding-bottom: 40px;">
                        <div class="card text-center" style="margin-bottom: 10px; border-color:white; background-color: white">
                            <div class="card-body">

                                <img src="img/tem/check.png" alt=""><br><br>
                                <p style="width:100%; color:black;"><?php
                                    if ($frontcontent->home_service_entry3 == '' || $frontcontent->home_service_entry3 == null){
                                        echo 'Convenient Public Transport';
                                    }else{
                                        echo $frontcontent->home_service_entry3;
                                    }
                                    ?></p>
                                <br>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3" style="padding-bottom: 40px;">
                        <div class="card text-center" style=" margin-bottom: 10px; border-color:white; background-color: white">
                            <div class="card-body">

                                <img src="img/tem/check.png" alt=""><br><br>
                                <p style="width:100%; color:black;"><?php
                                    if ($frontcontent->home_service_entry4 == '' || $frontcontent->home_service_entry4 == null){
                                        echo 'Sparkling Clean';
                                    }else{
                                        echo $frontcontent->home_service_entry4;
                                    }
                                    ?>
                                </p>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
                <br><br>
                <div class="left-side " style="text-align: center">
                    <p>Go down to see our listings.</p>
                </div>
                <div style="padding-top: 60px;">
                    <a href="#pro_list" class="scroll-down"></a>
                </div>
            </div>
        </section>
        <!-- Introduction Section End -->

        <hr id="pro_list">
        <br>

        <div>
            <!-- header -->
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h3>Existing Properties</h3>
                    </div>
                </div>
            </div>
            <!-- end of header -->
            <br>
            <br>
            <div class="row">


                <?php
                $currentDate = \Cake\I18n\Time::now();
                //debug($currentDate);
                //debug($currentDate->i18nFormat('yyyy-MM-dd'));
                $currentDate = date("Y-m-d", strtotime($currentDate->i18nFormat('yyyy-MM-dd')));

                // debug(date("Y-m-d", strtotime('24-12-2019')) > date("Y-m-d", strtotime('10-04-2021')));

                // for each property, display in card
                foreach($properties as $property) {
                    if ($property->property_status != 1) {


                        // set data to be displayed in variables
                        $state_postcode = $property->state . " " . $property->postcode;
                        $location = $property->street . " " . $property->suburb . " " . $state_postcode;

                        $bedroom_num = $property->number_of_bedroom;
                        $bathroom_num = $property->number_of_bathroom;
                        $toilet_num = $property->number_of_toilet;

                        $images = $property->properties_images;
                        $counter = 0;
                        $path = '';


                        // FIRST CHECK FOR PUBLIC AREA IMAGES
                        $image_to_use = null;
                        foreach ($images as $image){
                            if ($image->room_id == null){
                                $image_to_use = $image; // PUBLIC AREA IMG EXISTS
                                $img_name = $image->photo_name;
                                $path = "img/property/".$image->property_id."/". $img_name;
                                // $path = "/webroot/img/".$img_name;
                                break;
                            }
                        }
                        if ($image_to_use == null){ // NO PUBLIC AREA IMG
                            foreach ($images as $image) {
                                if ($image->room_id == null){
                                    $img_name = $image->photo_name;
                                    $path = "img/property/".$image->property_id."/". $img_name;
                                    // $path = "/webroot/img/".$img_name;
                                    break;
                                }
                                else{
                                    $img_name = $image->photo_name;
                                    $path = "img/property/".$image->property_id."/room/".$image->room_id."/". $img_name;
                                    // $path = "/webroot/img/".$img_name;
                                    break;
                                }
                            }
                        }


                        /*foreach ($images as $image) {
                            if ($image->room_id == null){
                                $img_name = $image->photo_name;
                                $path = "img/property/".$image->property_id."/". $img_name;
                                // $path = "/webroot/img/".$img_name;
                                break;
                            }
                           else{
                               $img_name = $image->photo_name;
                               $path = "img/property/".$image->property_id."/room/".$image->room_id."/". $img_name;
                               // $path = "/webroot/img/".$img_name;
                               break;
                           }
                        }*/







                        // Get room availability
                        $rooms = $property->rooms;
                        $ava = "";
                        $d = "";
                        $ava_now_flag = 0;
                        $no_room_flag = 1;
                        if ($rooms != null) {                                                                                           // if property has room
                            $no_room_flag = 0;
                            foreach ($rooms as $room) {
                                // if the room has a end date to be null
                                if ($room->rental_end_date == null) {                                                                   // IF ROOM NO END DATE --> AVA NOW
                                    $ava = array();
                                    $ava[0] = $room->id;
                                    $ava[1] = "<h7><p class='inline_field'>Contains a room that is &nbsp;</p><b class='inline_field'>Available Now</b>!</h7>";
                                    $ava_now_flag = 1;
                                    break;
                                } elseif ($room->rental_end_date != null) {                                                             // RENTAL END DATE NOT NULL, CHECK IS IT BIGGER THAN OLD ONE
                                    $cur = $room->rental_end_date;
                                    $cur_n = date("Y-m-d", strtotime($cur->i18nFormat('yyyy-MM-dd')));
                                    if ($d == null) {                                                                                    // NO OLD ONE
                                        $currentDate = \Cake\I18n\Time::now();
                                        $currentDate = date("Y-m-d", strtotime($currentDate->i18nFormat('yyyy-MM-dd')));
                                        if ($cur_n >= $currentDate) {                                                                                 // CHECK IF IS BIGGER THAN TODAY
                                            $ava = array();                                                                                         // IF YEA RECORD IT
                                            $ava[0] = $room->id;
                                            $ava[1] = "<p class='inline_field' style='margin-bottom:0;'>Room available the earliest from: &nbsp</p><b class='inline_field'>" . date('d/m/Y',strtotime($cur)) . "</b>";
                                            $d = $cur_n;
                                        } else {                                                                                                    // IF NO AVA NOW
                                            $ava = array();
                                            $ava[0] = $room->id;
                                            $ava[1] = "<h7><p class='inline_field' style='margin-bottom:0;'>Contains a room that is &nbsp;</p><b class='inline_field'>Available Now</b>!</h7>";
                                            $ava_now_flag = 1;
                                            break;
                                        }
                                    } else {                                                                                                 // HAS OLD DATE
                                        $currentDate = \Cake\I18n\Time::now();
                                        $currentDate = date("Y-m-d", strtotime($currentDate->i18nFormat('yyyy-MM-dd')));
                                        if ($d > $cur_n && $cur_n >= $currentDate) {                                                            // CHECK IF BIGGER THAN TODAY AND SMALLER THAN OLD DATE
                                            $ava = array();
                                            $ava[0] = $room->id;
                                            $ava[1] = "<p class='inline_field' style='margin-bottom:0;'>Room available the earliest from: &nbsp;</p><b class='inline_field'>".date('d/m/Y',strtotime($cur)) ."</b>";
                                        } elseif ($cur_n < $currentDate) {                                                                                                            // SMALLER THAN TODAY, AVA NOW
                                            // or smaller than today
                                            $ava = array();
                                            $ava[0] = $room->id;
                                            $ava[1] = "<h7><p class='inline_field' style='margin-bottom:0;'>Contains a room that is &nbsp;</p><b class='inline_field'>Available Now</b></h7>!";
                                            $ava_now_flag = 1;
                                            break;
                                            /* }*/
                                        }
                                        // check date in the past or future
                                    }
                                }

                            }
                        }


                        if (strlen($path) == 0) {
                            $path = 'img/placeholder.jpg';
                        }
                        ?>

                        <div class="col-lg-4 col-md-6">
                            <div class="room-items">

                                <a href=<?php echo "properties/detail/" . $property->id; ?>>
                                    <div class="room-img set-bg" data-setbg=<?php echo $path; ?>></div>
                                </a>

                                <div class="room-text" style="padding-bottom:0;">
                                    <div class="room-details">
                                        <div class="room-title">
                                            <h5><?php echo $location; ?></h5>
                                        </div>
                                    </div>
                                    <div class="room-features" style="margin-bottom:0;">
                                        <div class="room-info">
                                            <div class="beds">
                                                <p>Bedrooms</p>
                                                <img src="img/tem/rooms/bed.png" alt="">
                                                <span><?php echo $bedroom_num; ?></span>
                                            </div>
                                            <div class="baths">
                                                <p>Baths</p>
                                                <img src="img/tem/rooms/bath.png" alt="">
                                                <span><?php echo $bathroom_num; ?></span>
                                            </div>
                                            <div class="baths">
                                                <p>Toilet</p>
                                                <img src="img/toilet_1.png" alt="">
                                                <span><?php echo $toilet_num; ?></span>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <?php
                                if ($no_room_flag == 1) {               // NO ROOM AVAILABLE
                                    ?>
                                    <?php
                                    echo "<div class=\"room-text\" style='padding-top:10px; padding-bottom:10px;'><p style='margin-bottom: 0;'>No room currently is available in this property.</p></div>";
                                    ?>

                                    <?php
                                } else {
                                    // ROOM AVAILABLE, CHECK AVAILABILITY
                                    ?>
                                    <div class="room-items col-md-12" style="padding-bottom: 10px; padding-top: 10px; margin-bottom: 0; background-color: #ffffff;">
                                        <?php echo "<h7>" .$ava[1] ."</h7>"; ?>
                                    </div>
                                    <div class="room-text" style="">
                                        <?php
                                        echo $this->Html->link(
                                            'Enquire the earliest available room!',
                                            ['controller' => 'applications', 'action' => 'frontadd', $ava[0]],
                                            ['class' => '', 'style' => 'font-size:100%;']
                                        );
                                        ?>
                                    </div>
                                    <?php
                                }
                                ?>
                                <div class="room-items col-md-12" style="margin-top:0; margin-bottom:0; padding-bottom:0;">
                                    <?php echo $this->Html->link(
                                        'View Property',
                                        ['controller' => 'Properties', 'action' => 'detail', $property->id],
                                        ['class' => 'site-btn btn-line', 'style' => 'margin-bottom: 10px; margin-top:20px;']
                                    ); ?>
                                </div>



                            </div>

                        </div>
                        <?php
                    }


                }?>

            </div>
        </div>
    </div>
</section>
<!-- Property Room Section End -->

<!-- front-end footer element -->
<?php echo $this->element('front_footer'); ?>
</body>

<!--  scroll down js-->
<script>
    $(function() {
        $('.scroll-down').click (function() {
            $('html, body').animate({scrollTop: $('section.ok').offset().top }, 'slow');
            return false;
        });
    });
</script>
<!-- end scroll down js -->



