<!-- Js Plugins -->
<?php echo $this->Html->script([
    'jquery-3.3.1.min.js',
    'bootstrap.min.js',
    'jquery.nice-select.min.js',
    'owl.carousel.min.js',
    'jquery-ui.min.js',
    'jquery.slicknav.js',
    'main.js']);
//echo $this->Html->css('https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i')
?>

<style>
    .copyright {
        color: white;
        font-size: 12px;
        font-weight: 500;
        opacity: 0.5;
    }

    a:hover{
        color:#0e0e0e;
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">



<!-- Footer Section Begin -->
<footer class="footer-section  p-40">
    <div class="container">

        <!-- copyright Section Start -->
        <div class="row p-20">
            <div class="col-lg-12 text-center">
                <div class="row">
                    <div class="col-lg-12 text-center sp-60" style="padding-bottom:30px;">
                        <?php

                        if ($frontcontent->top_foot_logo != null){
                            $path = $frontcontent->top_foot_logo;
                           // debug($path);
                       // echo $this->Html->image($path, ['style'=>"width:100px; height:auto; border-radius:5px;"]);
                        }else{
                            $path = 'logo.jpg';
                        }

                        echo $this->Html->image($path, [$path, 'style'=>"width:100px; height:auto; border-radius:5px;"]);
                        ?>
                    </div>
                </div>

                <!-- content -->
                <div class="row p-37" style="padding:0; margin-bottom: 0;">
                    <!-- introduction -->
                    <div class="col-lg-4">
                        <div class="about-footer">
                            <h5>About Metrorooms</h5>
                            <p style="color:white;">
                                <?php if ($frontcontent->foot_abt_desc == '' || $frontcontent->foot_abt_desc == null){
                                echo 'This is Metrorooms, a place you call home.';
                                }else{
                                echo $frontcontent->foot_abt_desc;
                                } ?>
                            </p>
                        </div>
                    </div>

                    <!-- nav -->
                    <div class="col-lg-4 col-md-6">
                        <div class="footer-blog">
                            <h5>Navigating Around the Site</h5>
                            <div style="margin-bottom:6px;">
                                <?php
                                echo $this->Html->Link('Home', '/', []);
                                ?>
                            </div>

                            <div style="margin-bottom:6px;">
                                <?php
                                echo $this->Html->Link('Contact Us', '/faqs/contactus', []);
                                ?>
                            </div>

                            <div style="margin-bottom:6px;">
                                <?php
                                echo $this->Html->Link('About Us', '/faqs/aboutus', []);
                                ?>
                            </div>

                            <div style="margin-bottom:6px;">
                                <?php
                                echo $this->Html->Link('Frequently Asked Questions', '/faqs', []);
                                ?>
                            </div>
                        </div>
                    </div>

                    <!-- contact -->
                    <div class="col-lg-4 col-md-6">
                        <div class="footer-address">
                            <h5>Get In Touch</h5>
                            <ul>
                                <p class="fa fa-envelope inline_field" style="color:white;">&nbsp;&nbsp;</p>
                                <p class="inline_field" style="color:white;">  <?php if ($frontcontent->abt_person_email_new== '' || $frontcontent->abt_person_email_new == null){
                                        echo 'No email currently available';
                                    }else{
                                        echo $frontcontent->abt_person_email_new;
                                    } ?></p>
                            </ul>
                            <ul>
                                <p class="fa fa-phone inline_field" style="color:white;">&nbsp;&nbsp;</p>
                                <p class="inline_field" style="color:white;">  <?php if ($frontcontent->abt_person_phone== '' || $frontcontent->abt_person_phone == null){
                                        echo 'No phone currently available';
                                    }else{
                                        echo $frontcontent->abt_person_phone;
                                    } ?></p>
                            </ul>
                        </div>
                    </div>
                </div>



                <div class="copyright" style="padding-top:15px;">
                    <div style="color: white">
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        Developed by<b> &copy; 2019-s2 MONASH-IE-team107-We're_working_on_IT</b> All rights reserved.<br>
                        Template powered by Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">colorlib</a>
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- Footer Section End -->


