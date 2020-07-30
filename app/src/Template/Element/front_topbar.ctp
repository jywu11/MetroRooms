<?php
// calling template stylesheets
echo $this->Html->css(['tem/bootstrap.min.css',
    'tem/nice-select.css']);
echo $this->Html->css('tem/owl.carousel.min.css');
echo $this->Html->css([
    'tem/jquery-ui.min.css',
    'tem/slicknav.min.css',
    'tem/flaticon.css',
    'tem/style.css']);
echo $this->Html->css('https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i')
?>


<style>
    .hero-section:after {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(1, 22, 39, 0.40);
        content: "";
        z-index: -1;
    }

    .footer-section {
        background: #F36C38;
    }
    /* rgba(197, 121, 27, 0.47) */

</style>

<!-- Header Section Begin -->
<header class="header-section" style="background-color:#F36C38">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="logo">

                        <!--<img src="/img/logo_sm.jpg" alt="logo" width="100" height="100" align="top">-->

                    <?php
                    if ($frontcontent->top_foot_logo == null){
                        echo $this->Html->image('../img/logo_sm.jpg', [
                            "alt" => "Business logo",
                            'url' => ['controller' => 'Properties', 'action' => 'index'],
                            'style' => 'width:135px;height:100px; border-radius:5px;'
                        ]);
                    }else{
                        $path = $frontcontent->top_foot_logo;
                        //debug($path);
                        echo $this->Html->image($path, [
                            "alt" => "Business logo",
                            'url' => ['controller' => 'Properties', 'action' => 'index'],
                            'style' => 'width:135px;height:100px; border-radius:5px;']);
                    }
                    ?>

                    <?php


                    ?>

                </div>
                <div class="main-menu">
                    <?= $this->html->link('Home',['controller' => 'Properties' , 'action' => 'index']);?>
                    <!-- <?= $this->html->link('Property List',['controller' => 'Pages' , 'action' => 'display']);?>-->
                    <?= $this->html->link('Contact Us',['controller' => 'Faqs' , 'action' => 'contactus']);?>
                    <?= $this->html->link('About Us',['controller' => 'Faqs' , 'action' => 'aboutus']);?>
                    <?= $this->html->link('FAQ',['controller' => 'Faqs' , 'action' => 'index']);?>
                </div>

                <div id="mobile-menu-wrap"></div>

            </div>
        </div>
    </div>
</header>
<!-- Header Section End -->









