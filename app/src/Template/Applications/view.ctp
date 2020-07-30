<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Application $application
 */
?>

<head>
    <?php $this->assign('title','Submission Successful | NAIM'); ?>
</head>

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/jquery-ui.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src='https://kit.fontawesome.com/a076d05399.js'></script>

<section id = "myHead">
    <?= $this->Html->css('my_front') ?>
    <?php echo $this->element('front_topbar'); ?>
</section>
<section  class="hero-section home-page set-bg" data-setbg="">
    <!-- <section class="hero-section home-page set-bg" data-setbg="/img/ie/toppage.jpg"> -->
</section>

<style>
    .contact-section {
        padding-top: 50px;
        padding-bottom: 100px;
    }

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
        padding: 16px 0;
        box-shadow: 0 1px rgba(0, 0, 0, 0.24);
    }

    .required label:after {
        color: #e32;
        content: ' *';
        display:inline;
    }

    #mybutton{
        padding-left:10px
    }
    .contact-form .site-btn.c-btn, .contact-info .site-btn.c-btn {
        border: none;
        background: #8AD144;
        color: #fff;
        position: inherit;
        /* top: -5px; */
    }

    .sticky {
        position: fixed;
        top: 50px;
    }

    .sticky + .content {
        padding-top: 102px;
    }

</style>


<?php
$room = $application->room;
$property = $application->property;
$rid = $room->id;
$pid = $property->id;
$r_n = $room->room_name;
$cap = $room->room_capacity;
$addr = $property->street.', '.$property->suburb.', '.$property->state.' '.$property->postcode." (".$r_n.")";
$applicants = $application->applicants;
?>

<body>
<section class="contact-section">
    <div class="container">
        <div class="inline_field"><i class='fas fa-check-circle' style='font-size:45px;color:green'></i></div>
        <div class="inline_field">
            <h4> Thank you for your application, it has been submitted</h4>
            <b> We will get back to you in two weeks! You will be notified to attend an interview with the landlady</b>
        </div>
        <br>
        <br>
        <div>

            <?php
            echo $this->Html->link(
                'Back to Room',
                ['controller' => 'Rooms', 'action' => 'detail', $rid],
                ['style' => 'text-align:center',
                    'class' => 'btn btn-primary']
            )
            ?>
        </div>
        <br>
        <h4><span>Your Application Number is <?= h($application->id) ?></span>. Please take note of this.</h4>
        <p>If you have made a mistake in your application, please submit a new one and notify us in the 'Additional Comments' section</p>
        <div>
            <div class="inline_field">
                Application on
            </div>
            <div class="inline_field">
                <h5><span><?php echo $addr; ?></span></h5>
            </div>

        </div>
        <br>
        <div class="row">
            <div class="applications view large-9 medium-8 col-lg-9">

                <div class="card">
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <!-- Applicant -->
                            <li class="list-group-item">
                                <div class="inline_field">
                                    <i class="	fas fa-user"></i>
                                </div>
                                <div class="inline_field">
                                    <h5>Applicants</h5>
                                </div>
                                <p>Number of People Staying: <?php echo $application->number_of_people;?></p>
                                <div>
                                    <div class="applications view ">
                                        <?php
                                        $count = 1;
                                        foreach ($applicants as $applicant){
                                            echo "<div style='padding-bottom: 5px;'>";
                                            echo "<h7><b><u>Applicant ".$count."</u></b></h7>";
                                            echo "</div>";
                                            $count += 1;
                                            $name = $applicant->first_name." ".$applicant->last_name;
                                            if ($applicant->preferred_name != null){
                                                $name = $name." (".$applicant->preferred_name."), ";
                                            }
                                            if ($applicant->gender == 0){
                                                $gender = "Male";
                                            }else{
                                                $gender = "Female";
                                            }
                                            if ($applicant->australian_citizen == 0){
                                                $ac = ", Australian Citizen";
                                            }else{
                                                $ac = ", Not Australian Citizen";
                                            }
                                            $name = $name."  ".$gender.$ac;
                                            if ($applicant->personal_contact_phone != null){
                                                $phone = " ("."<i class='fas fa-comments'></i>".$applicant->personal_contact_phone.")";
                                                $name = $name.$phone;
                                            }else{
                                                $phone = " (<i class='fas fa-comments'></i> ----)";
                                                $name = $name.$phone;
                                            }
                                            echo $name;
                                            ?>
                                            <?php
                                        }
                                        ?>
                                        <br>
                                    </div>
                                </div>
                                <br>

                            </li>
                            <!-- applicant end -->

                            <!-- time -->
                            <li class="list-group-item">

                                <div class="inline_field">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <div class="inline_field" style="padding-bottom: 5px;">
                                    <h5>Expected Date and Duration</h5>
                                </div>
                                <br>
                                <div class="applications view">
                                    <?php
                                    $s_d = $application->start_date;
                                    $e_d = $application->end_date;
                                    $e_d = $e_d->i18nFormat('dd-MM-yyyy');
                                    $s_d = $s_d->i18nFormat('dd-MM-yyyy');
                                    $start = "Expected Staying Period: <b>".$s_d."</b> to <b>".$e_d."</b>"." (".$application->duration." months)";
                                    echo $start;
                                    ?>
                                </div>

                                <br>

                            </li>
                            <!-- time end -->


                            <!-- contact -->
                            <li class="list-group-item">

                                <div class="inline_field">
                                    <i class="fas fa-paper-plane"></i>
                                </div>
                                <div class="inline_field" style="padding-bottom: 5px;">
                                    <h5>Main Contact</h5>
                                </div>
                                <br>
                                <div class="applications view">
                                    <?php
                                    $name = "Contact Name: ".$application->contact_name;
                                    echo $name;
                                    $contact = " (<i class='fas fa-phone'></i>"." ".$application->contact_number.", ";
                                    $contact = $contact." "."<i class='fas fa-envelope'></i>"." ".$application->contact_email.")";
                                    echo $contact;
                                    ?>
                                </div>
                                <br>

                            </li>
                            <!-- contact end -->


                            <li class="list-group-item">
                                <div class="inline_field">
                                    <i class="fas fa-sticky-note"></i>
                                </div>
                                <div class="inline_field" style="padding-bottom: 5px;">
                                    <h5>Additional Comment</h5>
                                </div>
                                <br>
                                <div class="applications view">
                                    <?php
                                    if ($application->additional_comment != null){
                                        ?>
                                        <p><?php echo $application->additional_comment;?></p>
                                        <?php
                                    }else{
                                        ?>
                                        <p><?php echo "No Additional Comment.";?></p>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- other rooms/properties -->
            <div class="applications view large-9 medium-8 col-lg-3">

                <div class="row">
                    <?php
                    // debug($property);
                    if ($other_r != null){
                        ?>
                        Other Rooms in this Property
                        <br><br>
                        <?php
                        $counter = 1;
                        $images = $other_r->properties_images;
                        $num_of_room_left = 0;
                        $path = '';
                        foreach ($images as $image) {
                            $path = "/team107/team107-app/app/img/" . $image->photo_name;
                            break;
                        }
                        if ($path == ''){
                            $path = '/team107/team107-app/app/img/placeholder.jpg';
                        }
                        $r_t = $other_r->room_type;

                        ?>
                        <div class="col-lg-12">
                            <div class="room-items">

                                <a href=<?php echo "http://ie.infotech.monash.edu/team107/team107-app/app/rooms/detail/" . $other_r->id; ?>>
                                    <div class="room-img set-bg" data-setbg=<?php echo $path; ?>></div>
                                </a>

                                <div class="room-text">
                                    <div class="room-details">
                                        <div class="room-title">
                                            <a href=""><h5
                                                        style="text-decoration: underline;"><?php echo $other_r->room_name; ?></h5>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="room-info">
                                        <h5>Room Type: <?php echo $r_t; ?></h5>
                                    </div>

                                </div>

                            </div>
                        </div>

                    <?php }
                    elseif ($other_p != null){
                        ?>
                        Other Popular Properties
                        <br>
                        <br>
                        <?php
                        $property = $other_p;
                        $state_postcode = $property->state." ".$property->postcode;
                        $location = $property->street." ".$property->suburb." ".$state_postcode;

                        $bedroom_num = $property->number_of_bedroom;
                        $bathroom_num = $property->number_of_bathroom;
                        $toilet_num = $property->number_of_toilet;

                        $images = $property->properties_images;
                        $counter = 0;
                        $path = '';
                        foreach($images as $image){
                            $img_name = $image->photo_name;
                            $path = "img/".$img_name;
                            // $path = "/webroot/img/".$img_name;
                            break;
                        }
                        if (strlen($path)==0){
                            $path ='img/placeholder.jpg';
                        }



                        ?>
                        <div class="">
                            <div class="room-items">

                                <a href=<?php echo "properties/detail/".$property->id; ?>>
                                    <div class="room-img set-bg" data-setbg=<?php echo $path; ?>></div>
                                </a>

                                <div class="room-text">
                                    <div class="room-details">
                                        <div class="room-title">
                                            <h5><?php echo $location; ?></h5>
                                        </div>
                                    </div>
                                    <div class="room-features">
                                        <div class="room-info">
                                            <div class="beds">
                                                <p>Beds</p>
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
                                    <?php echo $this->Html->link(
                                        'View Property',
                                        ['controller' => 'Properties', 'action' => 'detail', $property->id],
                                        ['class' => 'site-btn btn-line']
                                    ); ?>
                                </div>
                            </div>
                        </div>





                        <?php
                    } ?>

                </div>

            </div>
            <!-- end other rooms/properties -->
        </div>


    </div>
</section>


<?php echo $this->element('front_footer'); ?>
</body>

