<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Frontcontent[]|\Cake\Collection\CollectionInterface $frontcontents
 */
?>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Front-end Content | Admin</title>
    <?php /*$this->assign("title","Front-end Content Management | Metrorooms Admin"); */?>
</head>

<!-- load DataTables formatting files -->
<?php
echo $this->Html->css('navbar.css');
echo $this->Html->script('https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js');
echo $this->Html->css(['https://cdn.datatables.net/v/ju/jqc-1.12.4/dt-1.10.18/b-1.5.6/b-print-1.5.6/r-2.2.2/rg-1.1.0/sc-2.0.0/sl-1.3.0/datatables.min.css']);
echo $this->Html->script(['https://cdn.datatables.net/v/ju/jqc-1.12.4/dt-1.10.18/b-1.5.6/b-print-1.5.6/r-2.2.2/rg-1.1.0/sc-2.0.0/sl-1.3.0/datatables.min.js']);
?>

<script src='https://kit.fontawesome.com/a076d05399.js'></script>
<!-- head of the page -->

<!-- end of header -->
<style>
    .inline_field{
        display: inline-block;
    }

    li{
        width:250px;
    }

    body{
        padding:0;
    }

    .dataTables_wrapper .dataTables_filter {
        float: right;
        text-align: left;
    }

    ul.breadcrumb {
        padding: 10px;
        list-style: none;
        background-color: #f4f4f4;
    }
    ul.breadcrumb li {
        display: inline;
        font-size: 18px;
    }
    ul.breadcrumb li+li:before {
        padding: 0;
        color: black;
        content: "|";
    }
    ul.breadcrumb li a {
        color: #0275d8;
        text-decoration: none;
    }
    ul.breadcrumb li a:hover {
        color: #01447e;
        text-decoration: underline;
    }

    .img_res{
        width: 100%;
        height: auto;
    }

</style>


<!-- top nav bar -->
<?php echo $this->element('admin_topbar'); ?>
<!-- end of top nav bar -->



<div class="wrapper">
    <div class="container">
        <div class="tab-wrap">
            <input type="radio" id="tab1" name="tabGroup1" class="tab" checked>
            <label for="tab1">Front-end Page-script Content</label>

            <input type="radio" id="tab2" name="tabGroup1" class="tab" onclick="window.location='faqs';">
            <label for="tab2">FAQ</label>

            <div class="tab__content">

                <!-- nav -->
                <br>
                <br>
                <div style="text-align: center; padding-bottom: 5px;">
                    <span>Navigation Around in this Page</span>
                </div>
                <div style="text-align:center;">
                    <ul class="breadcrumb inline_field" >
                        <li>
                            <?php
                            echo $this->Html->link(
                                'Home Page',
                                '#home_page',
                                [
                                    'class' => '']
                            );
                            ?>
                        </li>
                        <li> <?php
                            echo $this->Html->link(
                                'Contact Us',
                                '#contact_us',
                                [
                                    'class' => '']
                            );
                            ?>
                        </li>
                        <li> <?php
                            echo $this->Html->link(
                                'About Us',
                                '#about_us',
                                [
                                    'class' => '']
                            );
                            ?>
                        </li>
                        <li>
                            <?php
                            echo $this->Html->link(
                                'General Site Content',
                                '#general_site_content',
                                [
                                    'class' => '']
                            );
                            ?>
                        </li>
                        <li> <?php
                            echo $this->Html->link(
                                'Property Page',
                                '#property_page',
                                [
                                    'class' => '']
                            );
                            ?>
                        </li>
                        <li> <?php
                            echo $this->Html->link(
                                'Application Terms and Conditions',
                                '#terms_conditions',
                                [
                                    'class' => '']
                            );
                            ?>
                        </li>
                    </ul>
                </div>
                <ul class="" style="text-align:center; padding-right:10px; margin-left:0; margin-bottom: 0;">

                    <?php
                    echo $this->Html->Link(
                        'Edit Frontend Content',
                        ['controller' => 'Frontcontents', 'action' => 'edit', $frontcontent->id],
                        ['class' => 'button btn-large btn-warning', 'style' => 'height:45px;']
                    );
                    ?>
                    <?php
                    echo $this->Html->Link(
                        'Go To Frontend Website',
                        ['controller' => '/', 'action' => ''],
                        ['class' => 'button btn-large btn-info', 'style' => 'height:45px;', 'target'=>'_blank']
                    );
                    ?>
                </ul>
                <!-- end nav -->

                <div style="background-color: #fddfdf; border-radius: 7px;">
                    <div style="padding:10px;padding-bottom: 0;">
                        <p class="fas fa-file-image" style="color:red;"></p>
                        <span class="inline_field" style="color:black;">
                    Note that image name containing special characters like <b class="inline_field" style="font-weight:800;color:red;">()"'</b> etc cannot be interpreted properly when display. Please <b class="inline_field" style="font-weight:800;color:red;">avoiding using such character</b> for you image name.</span>
                    </div>
                </div>
                <br>

                <!-- Home Page Content -->
                <hr id="home_page">
                <div class="module" >
                    <div class="module-head"></div>
                    <div class="module-body">
                        <div class="form-horizontal row-fluid">
                            <div class="control-group" id="home_page_only_content">
                                <h2 style="margin-bottom: 0; text-align:center;">Home Page Only Content</h2>
                                <div style="text-align: center">
                                    <span >Contains content that will display on Home Page of the front-end website</span>
                                </div>
                            </div>

                            <!-- Home Banner -->
                            <div class="control-group">
                                <h3>Home Page Banner</h3>

                                <div style="padding-left: 20px">
                                    <h4><b style="color:black;">Banner Text:</b></h4>
                                    <?php
                                    if ($frontcontent->banner_title == null || $frontcontent->banner_title == ''){
                                        echo "<span style='padding-left:10px; color:red;'>**The banner text is empty, the default banner title is displayed</span>";
                                        echo "<p style='padding-left:10px;'>Metrorooms</p>";
                                    }else{
                                        echo "<p style='padding-left:10px;'>" . $frontcontent->banner_title . "</p>";
                                    }

                                    ?>
                                </div>
                                <div style="padding-top:10px;">
                                    <div style="" id="show_bt_info" onclick="show_bt_info()">
                                        <p class="inline_field fas fa-info-circle"></p>&nbsp;<span class="inline_field">Click me to see where it is displayed.</span>
                                    </div>
                                    <div style="background-color: #fff9e1; border-radius: 7px; display: none;" onclick="hide_bt_info()" id="mybt">
                                        <div style="padding:10px;padding-bottom: 0;">
                                            <p class="inline_field fas fa-info-circle"></p><span class="inline_field">&nbsp;(Click within the yellow box close me)</span><br>
                                            <span>The Banner Text is displayed in the Banner on Home page in the front-end website. (It is displayed on Home Page ONLY, not on about-us or faq pages)</span>
                                        </div>
                                        <br>
                                    </div>
                                </div>
                                <br>
                            </div>


                            <!-- home purpose section -->
                            <div class="control-group">
                                <h3>Home Page Promotion Text</h3>

                                <div style="padding-left: 20px">
                                    <h4><b style="color:black;">Promotion Title</b></h4>

                                    <?php

                                    if ($frontcontent->home_service_title == null || $frontcontent->home_service_title == ''){
                                        echo "<span style='padding-left:10px; color:red;'>**The promotion title is empty, the default promotion title is displayed</span>";
                                        echo "<p style='padding-left:10px;'>What is our purpose?</p>";
                                    }else{
                                        echo "<p style='padding-left:10px;'>" . $frontcontent->home_service_title . "</p>";
                                    }

                                    ?>
                                    <h4><b style="color:black;">Promotion Description:</b></h4>
                                    <?php
                                    if ($frontcontent->home_service_desc == null || $frontcontent->home_service_desc == ''){
                                        echo "<span style='padding-left:10px; color:red;'>**The promotion description is empty, the default promotion description is displayed</span>";
                                        echo "<p style='padding-left:10px;'>Our mission is to help students on their medical placements find accommodation.</p>";
                                    }else{
                                        echo "<p style='padding-left:10px;'>" . $frontcontent->home_service_desc . "</p>";
                                    }
                                    ?>
                                    <h4><b style="color:black;">Promotion Card Entries:</b></h4>
                                        <ul style="padding-left: 10px">
                                            <li style="width:100%">
                                                <p class='inline_field' style="color:black;">Entry 1:&nbsp;</p>
                                                <?php
                                                if ($frontcontent->home_service_entry1 == null || $frontcontent->home_service_entry1 == ''){
                                                    echo "<span class='inline_field' style='padding-left:10px; color:red;'>[Empty - Default Displayed]&nbsp;</span><p class='inline_field' style='padding-left:10px;'>Safe Neighborhood</p>";
                                                }else{
                                                    echo "<p class='inline_field'>" . $frontcontent->home_service_entry1 . "</p>";
                                                }
                                                ?>
                                            </li>
                                            <li style="width:100%">
                                                <p class='inline_field' style="color:black;">Entry 2:&nbsp;</p>
                                                <?php
                                                if ($frontcontent->home_service_entry2 == null || $frontcontent->home_service_entry2 == ''){
                                                    echo "<span class='inline_field' style='padding-left:10px; color:red;'>[Empty - Default Displayed]&nbsp;</span><p class='inline_field' style='padding-left:10px;'>Close to Hospital</p>";
                                                }else{
                                                    echo "<p class='inline_field'>" . $frontcontent->home_service_entry2 . "</p>";
                                                }
                                                ?>
                                            </li>
                                            <li style="width:100%">
                                                <p class='inline_field' style="color:black;">Entry 3:&nbsp;</p>
                                                <?php
                                                if ($frontcontent->home_service_entry3 == null || $frontcontent->home_service_entry3 == ''){
                                                    echo "<span class='inline_field' style='padding-left:10px; color:red;'>[Empty - Default Displayed]&nbsp;</span><p class='inline_field' style='padding-left:10px;'>Convenient Public Transport</p>";
                                                }else{
                                                    echo "<p class='inline_field'>" . $frontcontent->home_service_entry3 . "</p>";
                                                }
                                                ?>
                                            </li>
                                            <li style="width:100%">
                                                <p class='inline_field' style="color:black;">Entry 4:&nbsp;</p>
                                                <?php
                                                if ($frontcontent->home_service_entry4 == null || $frontcontent->home_service_entry4 == ''){
                                                    echo "<span class='inline_field' style='padding-left:10px; color:red;'>[Empty - Default Displayed]&nbsp;</span><p class='inline_field' style='padding-left:10px;'>Sparkling Clean</p>";
                                                }else{
                                                    echo "<p class='inline_field'>" . $frontcontent->home_service_entry4 . "</p>";
                                                }
                                                ?>
                                            </li>
                                        </ul>
                                </div>
                                <div style="padding-top:10px;">
                                    <div style="" id="show_ps_info" onclick="show_ps_info()">
                                        <p class="inline_field fas fa-info-circle"></p>&nbsp;<span class="inline_field">Click me to see where these are displayed.</span>
                                    </div>
                                    <div style="background-color: #fff9e1; border-radius: 7px; display: none;" onclick="hide_ps_info()" id="myps">
                                        <div style="padding:10px;padding-bottom: 0;">
                                            <p class="inline_field fas fa-info-circle"></p><span class="inline_field">&nbsp;(Click within the yellow box close me)</span><br>
                                            <span>The Home-Promotion-Text is displayed right under the Banner and above the Property Listing on the Home Page of the front-end website.</span><br>
                                            <span>The Promotion Card Entries are the text displayed on the four cards (under the four <span style="color:green">green ticks</span>).</span>
                                        </div>
                                        <br>
                                    </div>
                                </div>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Us Page Content -->
                <hr id="contact_us">
                <div class="module" >
                    <div class="module-head"></div>
                    <div class="module-body">
                        <div class="form-horizontal row-fluid">
                            <div class="control-group">
                                <h2 style="margin-bottom: 0; text-align:center;">Contact Us Page Only Content</h2>
                                <div style="text-align: center">
                                    <span >Contains content that will display on contact us page of the front-end website</span>
                                </div>
                            </div>

                            <div class="control-group">
                                <h3>Contact Section</h3>

                                <div style="padding-left: 20px">
                                    <h4><b style="color:black;">Contact Section Title:</b></h4>
                                    <?php
                                    if ($frontcontent->abt_person_title==null || $frontcontent->abt_person_title==""){
                                        echo "<span style='padding-left:10px; color:red;'>**The contact section title is empty, the default contact section title is displayed</span>";
                                        echo "<p style='padding-left:10px;'>Who Runs Metrorooms</p>";
                                    }else {
                                        echo "<p style='padding-left:10px;'>" . $frontcontent->abt_person_title . "</p>";
                                    }

                                    ?>
                                    <h4><b style="color:black;">Contact Information:</b></h4>
                                    <span style="color:red">**Note that your <b style="color:red">Contact Phone</b> and <b style="color:red">Contact Email</b> will also be displayed in the Footer '<b style="color:red">Get In Touch</b>' Section thoughout the entire Front-End website</span>
                                    <ul>
                                        <li style="width:100%">
                                            <?php
                                            if ($frontcontent->abt_person_name == null || $frontcontent->abt_person_name == ''){
                                                echo "<p class=\"inline_field\" style=\"color:black; display:inline-block;\">Contact Name:&nbsp;</p><span class='inline_field' style='padding-left:10px; color:red;'>[Empty - Default Displayed]&nbsp;</span><p class='inline_field' style='padding-left:10px;'>Sorry, the name of the person is not available</p>";
                                            }else{
                                                echo "<p class=\"inline_field\" style=\"color:black; display:inline-block;\">Contact Name:&nbsp;</p><p class='inline_field'>" . $frontcontent->abt_person_name . "</p>";
                                            }
                                            ?>
                                            <!--<p class="inline_field" style="color:black; display:inline-block;">Contact Name:&nbsp;</p>
                                                <p class='inline_field' style="display:inline-block;"><?php /*echo  $frontcontent->abt_person_name ; */?></p>-->
                                        </li>
                                        <li style="width:100%">
                                            <?php
                                            if ($frontcontent->abt_person_email_new == null || $frontcontent->abt_person_email_new == ''){
                                                echo "<p class=\"inline_field\" style=\"color:black; display:inline-block;\">Contact Email:&nbsp;</p><span class='inline_field' style='padding-left:10px; color:red;'>[Empty - Default Displayed]&nbsp;</span><p class='inline_field' style='padding-left:10px;'>No email currently available</p>";
                                            }else{
                                                echo "<p class=\"inline_field\" style=\"color:black; display:inline-block;\">Contact Email:&nbsp;</p><p class='inline_field'>" . $frontcontent->abt_person_email_new . "</p>";
                                            }
                                            ?>
                                            <!--  <p class="inline_field" style="color:black; display:inline-block;">Contact Email:&nbsp;</p>
                                                <p class='inline_field' style="display:inline-block;"><?php /*echo  $frontcontent->abt_person_email ; */?></p>-->
                                        </li>
                                        <li style="width:100%">
                                            <?php
                                            if ($frontcontent->abt_person_phone  == null || $frontcontent->abt_person_phone  == ''){
                                                echo "<p class=\"inline_field\" style=\"color:black; display:inline-block;\">Contact Phone:&nbsp;</p><span class='inline_field' style='padding-left:10px; color:red;'>[Empty - Default Displayed]&nbsp;</span><p class='inline_field' style='padding-left:10px;'>No phone currently available</p>";
                                            }else{
                                                echo "<p class=\"inline_field\" style=\"color:black; display:inline-block;\">Contact Phone:&nbsp;</p><p class='inline_field'>" . $frontcontent->abt_person_phone  . "</p>";
                                            }
                                            ?>
                                            <!--       <p style="color:black;">Contact Phone:&nbsp;</p>
                                                <p><?php /*echo  $frontcontent->abt_person_phone ; */?></p>-->
                                        </li>
                                        <li style="width:100%">
                                            <?php
                                            if ($frontcontent->abt_person_desc  == null || $frontcontent->abt_person_desc == ''){
                                                echo "<p style=\"color:black; \">Contact/Personal Description:&nbsp;</p><span class='inline_field' style='padding-left:10px; color:red;'>[Empty - Default Displayed]&nbsp;</span><p class='inline_field' style='padding-left:10px;'>Sorry, there is nothing currently provided about this person.</p>";
                                            }else{
                                                echo "<p style=\"color:black;\">Contact/Personal Description:&nbsp;</p><p class='inline_field'>" . $frontcontent->abt_person_desc . "</p>";
                                            }
                                            ?>
                                            <!--     <p class="inline_field" style="color:black; display:inline-block;">Contact/Personal Description:&nbsp;</p>
                                                <p class='inline_field' style="display:inline-block;"><?php /*echo  $frontcontent->abt_person_desc ; */?></p>-->
                                        </li>
                                    </ul>
                                    <h4><b style="color:black;">Display Photo:</b></h4>
                                    <div style="padding-left:10px;">
                                        <?php
                                        if ($frontcontent->abt_person_image == null){
                                            echo "<span style='color:red;'>**Note this is the default display photo, if you have no photo provided, this photo will be displayed.</span>";
                                            $name = 'default-avatar.png';
                                        }else{
                                            $name = $frontcontent->abt_person_image;
                                        }?>
                                        <div style="padding-bottom:10px;padding-top:5px; width:100%">
                                            <p class="inline_field far fa-eye" style="color:#4f619e;"></p>&nbsp;
                                            <?php
                                            echo $this->Html->link(
                                                'Click Me to View Full Image in Another Window',
                                                '/webroot/img/'.$name,
                                                ['class'=>'inline_field', 'target' => '_blank']
                                            ); ?>
                                        </div>
                                        <?php
                                        echo $this->Html->image($name,
                                            ['alt' => 'Display Photo',
                                                'style' => 'max-width:300px; height:auto; border: 1px solid lightgrey; border-radius:15px;',
                                                'class' => 'img_res']);
                                        ?>
                                        <br><br>

                                        <?php
                                        if ($frontcontent->abt_person_image != null){
                                            echo $this->Form->create($frontcontent); ?>
                                            <input type="hidden" name="DELETE_FLAG" value="display_photo">
                                            <?php
                                            $this->Form->unlockField('DELETE_FLAG');
                                            ?>
                                            <div class="inline_field">
                                                <?php
                                                echo $this->Form->button(__('Clear the Current Banner Image and Display the Default'), ['type'=>'submit',
                                                    'class'=>'btn btn-large btn-inverse', 'style' => 'word-break:break-all; white-space: normal;']);
                                                ?>
                                            </div>
                                            <?php
                                            echo $this->Form->end();
                                        } ?>

                                        <br>


                                        <!--  display photo image upload -->
                                        <div style="background-color: #eaf4e2; border-radius: 10px;">
                                            <div style="padding:10px;">
                                                <?php
                                                echo $this->Form->create($frontcontent, ['type' => 'file']); ?>
                                                <div class="inline_field">

                                                    <input type="hidden" name="IMG_FLAG" value="display_photo">
                                                    <?php
                                                    $this->Form->unlockField('IMG_FLAG');
                                                    ?>
                                                    <?php
                                                    echo $this->Form->control('file',
                                                        ['type'=>'file',
                                                            'label' => 'Upload Photo:',
                                                            'accept' => "image/png, image/jpeg, image/jpg",
                                                            'class' => 'file_valid',
                                                            'id' => 'file_input']);
                                                    ?>
                                                </div>
                                                <div class="inline_field">
                                                    <?php
                                                    echo $this->Form->button(__('Submit Display Photo'), ['type'=>'submit',
                                                        'class'=>'btn btn-large btn-success']);
                                                    ?>
                                                </div>
                                                <?php echo $this->Form->end(); ?>
                                            </div>
                                        </div>

                                        <span style='color:red;'>**Note that image's size cannot exceed the limit of 8 MB .</span>
                                    </div>
                                </div>
                                <br>
                                <div style="padding-top:10px;">
                                    <div style="" id="show_con_info" onclick="show_con_info()">
                                        <p class="inline_field fas fa-info-circle"></p>&nbsp;<span class="inline_field">Click me to see where these are displayed.</span>
                                    </div>
                                    <div style="background-color: #fff9e1; border-radius: 7px; display: none;" onclick="hide_con_info()" id="mycon">
                                        <div style="padding:10px;padding-bottom: 0;">
                                            <p class="inline_field fas fa-info-circle"></p><span class="inline_field">&nbsp;(Click within the yellow box close me)</span><br>
                                            <span>The Contact Us Information is displayed on the ContactUs page.</span><br>
                                            <span>**Note that your Phone and Email will also be displayed in the Footer 'Get In Touch' Section</span>
                                        </div>
                                        <br>
                                    </div>
                                </div>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- About Us Page Content -->
                <hr id="about_us">
                <div class="module" >
                    <div class="module-head"></div>
                    <div class="module-body">
                        <div class="form-horizontal row-fluid">
                            <div class="control-group">
                                <h2 style="margin-bottom: 0; text-align:center;">About Us Page Only Content</h2>
                                <div style="text-align: center">
                                    <span >Contains content that will display on about us page of the front-end website</span>
                                </div>
                            </div>

                            <!-- about us -->
                            <div class="control-group">
                                <h3>About Us Section</h3>
                                <div style="padding-left: 20px">
                                    <h4><b style="color:black;">About Us Title:</b></h4>
                                    <?php
                                    if ($frontcontent->abt_title==null || $frontcontent->abt_title=""){
                                        echo "<span style='padding-left:10px; color:red;'>**The about us title is empty, the default about us title is displayed</span>";
                                        echo "<p style='padding-left:10px;'>Think Accommodation, Think Metrorooms.</p>";
                                    }else {
                                        echo "<p style='padding-left:10px;'>" . $frontcontent->abt_title . "</p>";
                                    }
                                    ?>
                                    <h4><b style="color:black;">About Us Description: </b></h4>
                                    <?php
                                    if ($frontcontent->abt_desc==null || $frontcontent->abt_desc==""){
                                        echo "<span style='padding-left:10px; color:red;'>**The about us description is empty, the default about us description is displayed</span>";
                                        echo "<p style='padding-left:10px;'>Metrorooms provides medium term stay accommodation to student doctors or nurses on rotation in the healthcare system. We also face anyone who are interested in staying in these properties. </p>";
                                    }else {
                                        echo "<p style='padding-left:10px;'>" . $frontcontent->abt_desc . "</p>";
                                    }
                                    ?>
                                </div>
                                <div style="padding-top:10px;">
                                    <div style="" id="show_abtus_info" onclick="show_abtus_info()">
                                        <p class="inline_field fas fa-info-circle"></p>&nbsp;<span class="inline_field">Click me to see where these are displayed.</span>
                                    </div>
                                    <div style="background-color: #fff9e1; border-radius: 7px; display: none;" onclick="hide_abtus_info()" id="myabtus">
                                        <div style="padding:10px;padding-bottom: 0;">
                                            <p class="inline_field fas fa-info-circle"></p><span class="inline_field">&nbsp;(Click within the yellow box close me)</span><br>
                                            <span>The About-Us-Information is displayed on the AboutUs page.</span>
                                        </div>
                                        <br>
                                    </div>
                                </div>
                                <br>
                            </div>

                        </div>
                    </div>
                </div>


                <hr id="general_site_content">
                <!-- banner image and logo and footer promotion -->
                <div class="module">
                    <div class="module-head"></div>
                    <div class="module-body">
                        <div class="form-horizontal row-fluid">
                            <div class="control-group" >
                                <h2 style="margin-bottom: 0; text-align:center;">General Site Content</h2>
                                <div style="text-align: center">
                                    <span >Contains content that will display on every page (mostly) of the front-end website</span>
                                </div>
                                <hr>
                                <div>
                                    <h3><b style="color:black;">Footer Promotion Text</b></h3>
                                    <div style="padding-left: 20px">
                                        <?php
                                        if (strlen($frontcontent->foot_abt_desc)==0){
                                            echo "<span style='color:red;'>**Note that there are no footer promotion text provided, the default footer promotion is displayed.</span>";
                                            echo "<p>This is Metrorooms, a place you call home.</p>";
                                        }
                                        echo "<p>$frontcontent->foot_abt_desc</p>";  ?>
                                    </div>
                                </div>
                                <div style="padding-top:10px;">
                                    <div style="" id="show_fp_info" onclick="show_fp_info()">
                                        <p class="inline_field fas fa-info-circle"></p>&nbsp;<span class="inline_field">Click me to see where it is displayed.</span>
                                    </div>
                                    <div style="background-color: #fff9e1; border-radius: 7px; display: none;" onclick="hide_fp_info()" id="myfp">
                                        <div style="padding:10px;padding-bottom: 0;">
                                            <p class="inline_field fas fa-info-circle"></p><span class="inline_field">&nbsp;(Click within the yellow box close me)</span><br>
                                            <span>The Footer-Promotion-Text is displayed in the footer (bottom left) throughout all pages in the Front-End Website.</span>
                                        </div>
                                        <br>
                                    </div>
                                </div>
                                <br>
                                <hr>
                                <h3>Business Logo</h3>
                                <div style="padding-left:20px; ">
                                    <?php
                                    if ($frontcontent->top_foot_logo == null){
                                        echo "<span style='color:red;'>**Note this is the default logo, if you have no logo provided, this logo will be displayed.</span>";
                                        $name = 'logo.jpg';
                                    }else{
                                        $name = $frontcontent->top_foot_logo;
                                    }?>
                                    <div style="padding-bottom:10px;padding-top:5px;">
                                        <p class="inline_field far fa-eye" style="color:#4f619e;"></p>&nbsp;
                                        <?php
                                        echo $this->Html->link(
                                            'Click Me to View Full Image in Another Window',
                                            '/webroot/img/'.$name,
                                            ['class'=>'inline_field', 'target' => '_blank']
                                        ); ?>
                                    </div>
                                    <?php
                                    echo $this->Html->image($name,
                                        ['alt' => 'Business LOGO',
                                            'style' => 'max-width:400px; height:auto; border: 1px solid lightgrey; border-radius:15px;',
                                            'class' => 'img_res']);
                                    ?>
                                    <br><br>
                                    <?php
                                    if ($frontcontent->top_foot_logo != null){
                                        echo $this->Form->create($frontcontent); ?>
                                        <input type="hidden" name="DELETE_FLAG" value="business_logo">
                                        <?php
                                        $this->Form->unlockField('DELETE_FLAG');
                                        ?>
                                        <div class="inline_field">
                                            <?php
                                            echo $this->Form->button(__('Clear the Current Logo Image and Display the Default'), ['type'=>'submit',
                                                'class'=>'btn btn-large btn-inverse btn-responsive', 'style' => 'word-break:break-all; white-space: normal;']);
                                            ?>
                                        </div>
                                        <?php
                                        echo $this->Form->end();
                                    } ?>

                                    <br>

                                    <!--  logo image upload -->
                                    <div style="background-color: #eaf4e2; border-radius: 10px;">
                                        <div style="padding:10px;">
                                            <?php
                                            echo $this->Form->create($frontcontent, ['type' => 'file']); ?>
                                            <div class="inline_field">

                                                <input type="hidden" name="IMG_FLAG" value="business_logo">
                                                <?php
                                                $this->Form->unlockField('IMG_FLAG');
                                                ?>
                                                <?php
                                                echo $this->Form->control('file',
                                                    ['type'=>'file',
                                                        'label' => 'Upload Photo:',
                                                        'accept' => "image/png, image/jpeg, image/jpg",
                                                        'class' => 'file_valid',
                                                        'id' => 'file_input']);
                                                ?>
                                            </div>
                                            <div class="inline_field">
                                                <?php
                                                echo $this->Form->button(__('Submit Business Logo'), ['type'=>'submit',
                                                    'class'=>'btn btn-large btn-success']);
                                                ?>
                                            </div>
                                            <?php echo $this->Form->end(); ?>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                                <div style="padding-top:10px;">
                                    <div style="" id="show_logo_info" onclick="show_logo_info()">
                                        <p class="inline_field fas fa-info-circle"></p>&nbsp;<span class="inline_field">Click me to see where it is displayed.</span>
                                    </div>
                                    <div style="background-color: #fff9e1; border-radius: 7px; display: none;" onclick="hide_logo_info()" id="myDiv">
                                        <div style="padding:10px;padding-bottom: 0;">
                                            <p class="inline_field fas fa-info-circle"></p><span class="inline_field">&nbsp;The business logo is displayed on the Top left of the Front-end Top Navigation Bar, and the top center in the Page footer. (Click to close me)</span><br>
                                        </div>
                                    </div>
                                </div>
                                <hr>

                                <!-- banner image -->
                                <h3>Banner Background Image</h3>
                                <div style="padding-left:20px;">
                                    <div>

                                    <?php
                                    if ($frontcontent->banner_image == null){
                                        echo "<span style='color:red;'>**Note this is the default Banner Background Image, if you have no image provided, this image will be displayed.</span>";
                                        $name = 'ie/toppage.jpg';
                                    }else {
                                        $name = $frontcontent->banner_image;
                                    } ?>
                                        <div style="padding-bottom:10px;padding-top:5px;">
                                            <p class="inline_field far fa-eye" style="color:#4f619e;"></p>&nbsp;
                                            <?php echo $this->Html->link(
                                                'Click Me to View Full Image in Another Window',
                                                '/webroot/img/'.$name, ['target' => '_blank']
                                            ); ?>
                                        </div>

                                        <?php
                                    echo $this->Html->image($name, ['alt' => 'Banner Background Image',
                                        'class' => 'img_res',
                                        'style' => 'max-width: 100%; border: 1px solid lightgrey; border-radius:15px;']);

                                    ?>

                                    <br><br>

                                        <?php
                                        if ($frontcontent->banner_image != null){
                                            echo $this->Form->create($frontcontent); ?>
                                            <input type="hidden" name="DELETE_FLAG" value="banner_image">
                                            <?php
                                            $this->Form->unlockField('DELETE_FLAG');
                                            ?>
                                            <div class="inline_field">
                                                <?php
                                                echo $this->Form->button(__('Clear the Current Banner Image and Display the Default'), ['type'=>'submit',
                                                    'class'=>'btn btn-large btn-inverse', 'style' => 'word-break:break-all; white-space: normal;']);
                                                ?>
                                            </div>
                                            <?php
                                            echo $this->Form->end();
                                        } ?>

                                        <br>

                                    <!--  banner image upload -->
                                    <div style="background-color: #eaf4e2; border-radius: 10px;">



                                        <div style="padding:10px;">
                                            <?php
                                            echo $this->Form->create($frontcontent, ['type' => 'file']); ?>
                                            <div class="inline_field">

                                                <input type="hidden" name="IMG_FLAG" value="banner_image">
                                                <?php
                                                $this->Form->unlockField('IMG_FLAG');
                                                ?>
                                                <?php
                                                echo $this->Form->control('file',
                                                    ['type'=>'file',
                                                        'label' => 'Upload Photo:',
                                                        'accept' => "image/png, image/jpeg, image/jpg",
                                                        'class' => 'file_valid',
                                                        'id' => 'file_input']);
                                                ?>
                                            </div>
                                            <div class="inline_field">
                                                <?php
                                                echo $this->Form->button(__('Submit Banner Image'), ['type'=>'submit',
                                                    'class'=>'btn btn-large btn-success']);
                                                ?>
                                            </div>
                                            <?php echo $this->Form->end(); ?>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                                <div style="padding-top:10px;">
                                    <div style="" id="show_bi_info" onclick="show_bi_info()">
                                        <p class="inline_field fas fa-info-circle"></p>&nbsp;<span class="inline_field">Click me to see where is it displayed.</span>
                                    </div>
                                    <div style="background-color: #fff9e1; border-radius: 7px; display: none;" onclick="hide_bi_info()" id="myBI">
                                        <div style="padding:10px;padding-bottom: 0;">
                                            <p class="fas fa-info-circle inline_field"></p><span class="inline_field">&nbsp;The Banner Image is displayed throughout the entire site, on the pages that contains a Banner.</span>
                                            <span>Note that there's only one image you can choose for all the Banners. (Click to close me)</span><br>
                                        </div>
                                        <br>
                                    </div>
                                </div>
<br>
                            </div>
                        </div>
                    </div>
                </div>
                </div>

                <hr id="property_page">

                <!-- Property Page Content -->
                <div class="module" >
                    <div class="module-head"></div>
                    <div class="module-body">
                        <div class="form-horizontal row-fluid">

                            <div class="control-group">
                                <h2 style="margin-bottom: 0; text-align:center;">Property Page Only Content</h2>
                                <div style="text-align: center">
                                    <span >Contains content that will display on (the bottom of) the property page of the front-end website</span>
                                </div>
                            </div>

                            <div class="control-group">
                                <h3 style="color:black;">Property Page Help-Question</h3>
                                <div style="padding-left: 20px">
                                    <h4><b style="color:black;">Question: &nbsp;&nbsp;</b></h4>
                                    <?php
                                    if($frontcontent->house_question == null || $frontcontent->house_question==""){
                                        echo "<span style='color:red;'>**Note that there are no question provided, the default question is displayed.</span>";
                                        echo "<p style='padding-left:10px;'>How to Send An Enquiry</p>";
                                    }else {
                                        echo "<p style='padding-left:10px;'>" . $frontcontent->house_question . "</p>";
                                    }
                                    ?>
                                    <h4><b style="color:black;">Answer: &nbsp;&nbsp;</b></h4>
                                    <?php
                                    if($frontcontent->house_answer == null || $frontcontent->house_answer==""){
                                        echo "<span style='color:red;'>**Note that there are no answer provided, the default answer is displayed.</span>";
                                        echo "<p style='padding-left:10px;'>Please check out the Rooms and place an enquiry on a particular room you like.</p>";
                                    }else {
                                        echo "<p style='padding-left:10px;'>" . $frontcontent->house_answer . "</p>";
                                    }
                                    ?>
                                </div>

                                <div style="padding-top:10px;">
                                    <div style="" id="show_pq_info" onclick="show_pq_info()">
                                        <p class="inline_field fas fa-info-circle"></p>&nbsp;<span class="inline_field">Click me to see where these are displayed.</span>
                                    </div>
                                    <div style="background-color: #fff9e1; border-radius: 7px; display: none;" onclick="hide_pq_info()" id="mypq">
                                        <div style="padding:10px;padding-bottom: 0;">
                                            <p class="fas fa-info-circle inline_field"></p><span class="inline_field">&nbsp;(Click within the yellow box to close me)</span><br>
                                            <span>The Property-Page-Help-Question is displayed at the bottom of each Property Details Page.</span><br>
                                            <span>The suggested usage is to let your potentail tenants know where to apply for a rental, but you can edit it as you prefer. </span>
                                        </div>
                                        <br>
                                    </div>
                                </div>
                                <br>
                            </div>

                        </div>
                    </div>
                </div>

                <hr id="terms_conditions">

                <!-- terms condition -->
                <div class="module" >
                    <div class="module-head"></div>
                    <div class="module-body">
                        <div class="form-horizontal row-fluid">

                            <div class="control-group">
                                <h2 style="margin-bottom: 0; text-align:center;">Application Terms and Conditions</h2>
                                <div style="text-align: center">
                                    <span >Contains content that will display on (the bottom of) the application page of the front-end website</span>
                                </div>
                            </div>

                            <div class="control-group">
                                <h3 style="color:black;">Terms and Conditions</h3>
                                <div style="padding-left: 20px">
                                    <?php
                                    if($frontcontent->terms_conditions == null){
                                        ?>

                                    <span style="color:red;">**Note that if you don't have your own terms and conditions given, this default template will be displayed.</span><br><br>
                                    <?php
                                        echo "<p style='padding-left:10px;'>The expression of interest submitted by the applicant is non-binding. The owner reserves all rights to revoke the expression of interest for any reason. Please note that a response may take anywhere between 5 to 10 working days.</p>";
                                    }else {
                                        echo "<p style='padding-left:10px;'>" . $frontcontent->terms_conditions . "</p>";
                                    }
                                    ?>
                                </div>

                                <div style="padding-top:10px;">
                                    <div style="" id="show_tc_info" onclick="show_tc_info()">
                                        <p class="inline_field fas fa-info-circle"></p>&nbsp;<span class="inline_field">Click me to see where these are displayed.</span>
                                    </div>
                                    <div style="background-color: #fff9e1; border-radius: 7px; display: none;" onclick="hide_tc_info()" id="mytc">
                                        <div style="padding:10px;padding-bottom: 0;">
                                            <p class="fas fa-info-circle inline_field"></p><span class="inline_field">&nbsp;(Click within the yellow box to close me)</span><br>
                                            <span>The Terms and Conditions is displayed at the button of the application page. Your applicants will need to confirm agree with it, then submit the application form.</span><br>
                                        </div>
                                        <br>
                                    </div>
                                </div>
                                <br>
                            </div>

                        </div>
                    </div>
                </div>





            </div>
            <!--Top Foot Logo -->

        </div>
    </div>
</div>
</div>




<script>
    // logo help text
    function hide_logo_info() {
        var x = document.getElementById("myDiv");
        x.style.display = "none";
        var y = document.getElementById("show_logo_info");
        y.setAttribute("style", "");
    }
    function show_logo_info(){
        var x = document.getElementById("show_logo_info");
        x.style.display = "none";
        var y = document.getElementById("myDiv");
        y.setAttribute("style", "background-color: #fff9e1; border-radius: 7px;");
    }

    // banner image help text
    function hide_bi_info() {
        var x = document.getElementById("myBI");
        x.style.display = "none";
        var y = document.getElementById("show_bi_info");
        y.setAttribute("style", "");
    }
    function show_bi_info(){
        var x = document.getElementById("show_bi_info");
        x.style.display = "none";
        var y = document.getElementById("myBI");
        y.setAttribute("style", "background-color: #fff9e1; border-radius: 7px;");
    }

    // banner text help text
    function hide_bt_info() {
        var x = document.getElementById("mybt");
        x.style.display = "none";
        var y = document.getElementById("show_bt_info");
        y.setAttribute("style", "");
    }
    function show_bt_info(){
        var x = document.getElementById("show_bt_info");
        x.style.display = "none";
        var y = document.getElementById("mybt");
        y.setAttribute("style", "background-color: #fff9e1; border-radius: 7px;");
    }

    // home promotion section help text
    function hide_ps_info() {
        var x = document.getElementById("myps");
        x.style.display = "none";
        var y = document.getElementById("show_ps_info");
        y.setAttribute("style", "");
    }
    function show_ps_info(){
        var x = document.getElementById("show_ps_info");
        x.style.display = "none";
        var y = document.getElementById("myps");
        y.setAttribute("style", "background-color: #fff9e1; border-radius: 7px;");
    }

    // home promotion section help text
    function hide_abtus_info() {
        var x = document.getElementById("myabtus");
        x.style.display = "none";
        var y = document.getElementById("show_abtus_info");
        y.setAttribute("style", "");
    }
    function show_abtus_info(){
        var x = document.getElementById("show_abtus_info");
        x.style.display = "none";
        var y = document.getElementById("myabtus");
        y.setAttribute("style", "background-color: #fff9e1; border-radius: 7px;");
    }

    // aboutus contact section help text
    function hide_con_info() {
        var x = document.getElementById("mycon");
        x.style.display = "none";
        var y = document.getElementById("show_con_info");
        y.setAttribute("style", "");
    }
    function show_con_info(){
        var x = document.getElementById("show_con_info");
        x.style.display = "none";
        var y = document.getElementById("mycon");
        y.setAttribute("style", "background-color: #fff9e1; border-radius: 7px;");
    }

    // home promotion section help text
    function hide_fp_info() {
        var x = document.getElementById("myfp");
        x.style.display = "none";
        var y = document.getElementById("show_fp_info");
        y.setAttribute("style", "");
    }
    function show_fp_info(){
        var x = document.getElementById("show_fp_info");
        x.style.display = "none";
        var y = document.getElementById("myfp");
        y.setAttribute("style", "background-color: #fff9e1; border-radius: 7px;");
    }

    // pb section help text
    function hide_pq_info() {
        var x = document.getElementById("mypq");
        x.style.display = "none";
        var y = document.getElementById("show_pq_info");
        y.setAttribute("style", "");
    }
    function show_pq_info(){
        var x = document.getElementById("show_pq_info");
        x.style.display = "none";
        var y = document.getElementById("mypq");
        y.setAttribute("style", "background-color: #fff9e1; border-radius: 7px;");
    }

    // pb section help text
    function hide_tc_info() {
        var x = document.getElementById("mytc");
        x.style.display = "none";
        var y = document.getElementById("show_tc_info");
        y.setAttribute("style", "");
    }
    function show_tc_info(){
        var x = document.getElementById("show_tc_info");
        x.style.display = "none";
        var y = document.getElementById("mytc");
        y.setAttribute("style", "background-color: #fff9e1; border-radius: 7px;");
    }


</script>

<!-- footer -->
<?php echo $this->element('admin_footer'); ?>
<!-- end of footer -->

<!-- format image url -->
<script>
    $(document).ready(function(){

    });



</script>
<!-- format url -->
<script>
    $(document).ready(function(){
        window.onload = function(){
            var tab2 = document.getElementById("tab2");

            var my_url = window.location.href;
            if (my_url.includes("frontcontents/")){
                // alert("here index");
                tab2.setAttribute("onclick", "window.location='faqs';");
            }else{
                // alert("here no index");
                tab2.setAttribute("onclick", "window.location='Faqs/view';");
            }
        };
    });

</script>
<!-- end format url -->
