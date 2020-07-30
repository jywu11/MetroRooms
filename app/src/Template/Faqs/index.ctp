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
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Homes Template">
    <meta name="keywords" content="Homes, Marika">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>FAQs | Metrorooms</title>
    <?php $this->assign('title',' FAQ | NAIM'); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<style>
    .inline_field{
        display: inline-block;
    }
</style>

<!-- front-end top bar element -->
<?php echo $this->element('front_topbar'); ?>

<?php
if ($frontcontent->banner_image == null){
    $path = "img/ie/toppage.jpg";
}else{
    $path = "img/".$frontcontent->banner_image;
}

?>

<!-- Hero Section Begin, map place holder -->
<section class="hero-section home-page set-bg" data-setbg="<?php echo $path; ?>">
    <div class="container hero-text text-white">
        <h2>Frequently Asked Question</h2>
    </div>
</section>
<!-- Hero Section End -->

    <body>

<!-- Page Preloder -->
<!--<div id="preloder">
    <div class="loader"></div>
</div>-->

<!-- FAQ Section Begin -->
<section class="blog-section">
    <div class="container">
        <!-- header -->
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h3>All You Need To Know</h3>
                </div>
            </div>
        </div>
        <!-- end of header -->
        <br>
        <div class="row">
            <!-- get each data -->
            <?php
            foreach ($faqs as $faq){
                $q = $faq->question;
                $a = $faq->answer;
                ?>
                <div class="col-lg-12" style="padding-bottom:0;">
                    <div class="blog-ins">
                        <div class="row">
                            <div class="col-lg-12" style="padding-bottom:0;">
                                <div class="blog-item" style="margin-bottom: 20px;">
                                    <div class="blog-text">

                                            <h5 style="word-break: break-all;"><?php echo $q; ?></h5>
                                            <p style="word-break: break-all;"><?php echo $a; ?></p>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>
<!-- front-end footer element -->
<?php echo $this->element('front_footer'); ?>
