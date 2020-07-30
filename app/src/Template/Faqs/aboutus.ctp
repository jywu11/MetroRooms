<!-- front-end top bar element -->
<?php echo $this->element('front_topbar'); ?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="To be changed">
    <meta name="keywords" content="Homes, Marika">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>About Us | Metrorooms</title>
    <?php $this->assign('title',' About Us | Metrorooms'); ?>
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
        <h2>About Us</h2>
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
<section class="about-us">
    <div style="background-color: white;">
        <div class="container" >

            <!--  about us -->
            <div class="row sp-40 spt-40" style="padding-bottom:0;">
                <div class="col-lg-12">
                    <div style="padding-left: 30px; padding-right:10px; padding-top: 50px; padding-bottom: 50px; background-color: white; text-align:center;">
                        <div class="wrapper">
                            <div>
                                <div class="about-text" style="width:100%; max-width: 100%;">
                                    <h3 style="color:black;"><?php
                                        if ($frontcontent->abt_title == '' || $frontcontent->abt_title == null){
                                            echo 'Think Accommodation, Think Metrorooms.';
                                        }else{
                                            echo $frontcontent->abt_title;
                                        } ?></h3><br>
                                    <p style="color:black;"><?php
                                        if ($frontcontent->abt_desc == '' || $frontcontent->abt_desc == null){
                                            echo '<p style="word-break: break-word; color:black;">Metrorooms provides medium term stay accommodation to student doctors or nurses on rotation in the healthcare system. We also face anyone who are interested in staying in these properties.</p>';
                                        }else{
                                            echo '<p style="word-break: break-word; color:black;">'.$frontcontent->abt_desc.'</p>';
                                        }
                                        ?></p>
                                    <?php
                                    echo $this->Html->Link('View Our Property Listings', '/#pro_list', ['class' => 'site-btn a-btn', 'style' => 'position:initial;']);
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--  end about us -->
        </div>
    </div>
</section>
<!-- About Us Section End -->

<hr style=" margin: auto; width:80%; ">




<?php echo $this->element('front_footer'); ?>
</body>
