<!-- front-end top bar element -->
<?php echo $this->element('front_topbar'); ?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Homes Template">
    <meta name="keywords" content="Homes, Marika">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Contact Us | Metrorooms</title>
    <?php $this->assign('title',' Contact Us | NAIM'); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<!-- Hero Section Begin, map place holder -->
<?php
if ($frontcontent->banner_image == null){
    $path = 'http://ie.infotech.monash.edu/team107/test/app/webroot/img/ie/toppage.jpg';
}else{
    $path = 'http://ie.infotech.monash.edu/team107/test/app/webroot/img/'.$frontcontent->banner_image;
}

?>
<section class="hero-section home-page set-bg" data-setbg="<?php echo $path; ?>">
    <!-- <section class="hero-section home-page set-bg" data-setbg="/img/ie/toppage.jpg"> -->
    <div class="container hero-text text-white">
        <h2>Contact Us</h2>
    </div>
</section>
<!-- Hero Section End -->

<style>
    .inline_field{
        display: inline-block;
    }

    /*
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
    */
    .col-xl-5 img{
        width: auto%;
        height: auto;
    }

    p{
        word-break: break-all;
    }

    header {
        background-color: #D33C44;
        font-size: 30px;
        height: 100px;
        line-height: 64px;
        padding: 16px 0;
        box-shadow: 0 1px rgba(0, 0, 0, 0.24);
    }

    .spt-40 {
        padding-top: 10px;
    }

    /* CARD */
    html {
        box-sizing: border-box;
    }

    *, *:before, *:after {
        box-sizing: inherit;
    }

    .column {
        float: left;
        width: 33.3%;
        margin-bottom: 16px;
        padding: 0 8px;
    }

    @media screen and (max-width: 650px) {
        .column {
            width: 100%;
            display: block;
        }
    }

    .card {
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
    }

    .container_ {
        padding: 0 16px;
    }

    .container_::after, .row::after {
        content: "";
        clear: both;
        display: table;
    }

    .title {
        color: grey;
    }

    .button {
        border: none;
        outline: 0;
        display: inline-block;
        padding: 8px;
        color: white;
        background-color: #000;
        text-align: center;
        cursor: pointer;
        width: 100%;
    }

    .button:hover {
        background-color: #555;
    }


</style>




<body>
<!-- About Us Sectiion Begin -->

<!-- About Us Section End -->

<hr style=" margin: auto; width:80%; ">

<section class="about-us" style="padding-bottom: 30px;">
    <div style="background-color:white">
        <div class="container">

            <!-- about Marika -->
            <div class="row sp-40 spt-40" style="padding-top: 0; padding-bottom:0;">
                <div class="col-lg-12">
                    <div style="padding-left: 30px; padding-right:10px; padding-top: 50px; padding-bottom: 50px; background-color: white; text-align:center;">
                        <div class="wrapper">

                            <!-- section title -->
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="section-title" style="margin-bottom: 50px;">
                                        <h2><span><?php
                                                if ($frontcontent->abt_person_title == '' || $frontcontent->abt_person_title == null){
                                                    echo 'Who Runs Metrorooms';
                                                }else{
                                                    echo $frontcontent->abt_person_title;
                                                }
                                                ?></span></h2>
                                    </div>
                                </div>
                            </div>

                            <!-- content -->
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="card">

                                        <div class="row">
                                            <div class="col-xl-1"></div>

                                            <!-- image -->
                                            <div class="col-xl-5">
                                                <?php
                                                if ($frontcontent->abt_person_image != null){

                                                    echo $this->Html->image($frontcontent->abt_person_image,
                                                        ['alt' => 'The Landlady Does Not Have A Photo to Display',
                                                            'style' => 'width:100%; padding:50px; padding-bottom:0; border-radius:10px;']);
                                                }else{
                                                    echo $this->Html->image('default-avatar.png',
                                                        ['alt' => 'The Landlady Does Not Have A Photo to Display',
                                                            'style' => 'width:100%; padding:50px; padding-bottom:0; border-radius:10px;']);
                                                }

                                                ?>
                                            </div>


                                            <!-- contact -->
                                            <div class="col-xl-5">
                                                <div class="container_" style="padding:50px; text-align: left">
                                                    <h3 style="padding-bottom:5px;"><?php
                                                        if ($frontcontent->abt_person_name == '' || $frontcontent->abt_person_name == null){
                                                            echo 'Sorry, the name of the person is not available';
                                                        }else{
                                                            echo $frontcontent->abt_person_name;
                                                        } ?></h3>
                                                    <div style="padding-left:10px;">

                                                        <p class="fa fa-envelope inline_field" style="color:black; margin-bottom: 0;"></p> &nbsp;<p class="inline_field" style="color:black"> <?php
                                                            if ($frontcontent->abt_person_email_new == '' || $frontcontent->abt_person_email_new == null){
                                                                echo 'No email currently available';
                                                            }else{
                                                                echo $frontcontent->abt_person_email_new;
                                                            } ?></p>
                                                        <br>
                                                        <p class="fa fa-phone" style="color:black;"></p> &nbsp;<p class="inline_field" style="color:black"> <?php
                                                            if ($frontcontent->abt_person_phone == '' || $frontcontent->abt_person_phone == null){
                                                                echo 'No phone currently available';
                                                            }else{
                                                                echo $frontcontent->abt_person_phone;
                                                            } ?></p>
                                                        <br>
                                                        <p style="color:black;">
                                                            <?php
                                                            if ($frontcontent->abt_person_desc == '' || $frontcontent->abt_person_desc== null){
                                                                echo 'Sorry, there is nothing currently provided about this person.';
                                                            }else{
                                                                echo $frontcontent->abt_person_desc;
                                                            } ?></p>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- section content -->

                        </div>
                    </div>
                </div>
            </div>
            <!-- end about Marika -->
        </div>
    </div>
</section>


<?php echo $this->element('front_footer'); ?>
</body>
