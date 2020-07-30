<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Frontcontent $frontcontent
 */
?>

<?php
echo $this->Html->css('navbar.css');
echo $this->Html->script('https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js');
echo $this->Html->css(['https://cdn.datatables.net/v/ju/jqc-1.12.4/dt-1.10.18/b-1.5.6/b-print-1.5.6/r-2.2.2/rg-1.1.0/sc-2.0.0/sl-1.3.0/datatables.min.css']);
echo $this->Html->script(['https://cdn.datatables.net/v/ju/jqc-1.12.4/dt-1.10.18/b-1.5.6/b-print-1.5.6/r-2.2.2/rg-1.1.0/sc-2.0.0/sl-1.3.0/datatables.min.js']);
?>
<!-- head of the page -->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Front-End Content | Admin</title>
    <?php $this->assign("title","Edit Frontend Content | NAIM Admin"); ?>
</head>
<!-- end of header -->

<script src="https://cdn.tiny.cloud/1/jbk00ag3ada6z8zdcyb2wn3uhv5qv7pplarpvbd2373zc2ql/tinymce/5/tinymce.min.js"></script>
<script src='https://kit.fontawesome.com/a076d05399.js'></script>

<style>

    .inline_field{
        display: inline-block;
    }

    .checkbox{
        padding-right: 30px;
        display:inline-block;
    }

    label.feature {
        /*border:1px solid #ccc;*/

        display:inline-block;
    }

    label.feature:hover {
        background:#eee;
        cursor:pointer;
    }

    ul.breadcrumb {
        padding: 10px;
        list-style: none;
        background-color: white;
    }
    ul.breadcrumb li {
        display: inline;
        font-size: 18px;
    }
    ul.breadcrumb li+li:before {
        padding: 0;
        color: black;
        content: "/\00a0";
    }
    ul.breadcrumb li a {
        color: #0275d8;
        text-decoration: none;
    }
    ul.breadcrumb li a:hover {
        color: #01447e;
        text-decoration: underline;
    }

</style>

<!-- front-end top bar element -->
<?php echo $this->element('admin_topbar'); ?>
<!-- end of top nav bar -->
<body>

<!-- Update Start Here -->
<?php echo $this->Form->create($frontcontent); ?>

<div class="wrapper">
    <div class="container">
        <div class="inline_field">
            <ul class="pull-left" style="padding-right:10px;">
                <?php
                echo $this->Html->link(
                    'Back',
                    $this->request->referer(),
                    ['confirm' => 'Are you sure to go back?\nAll your changes will not be saved', 'class' => 'button btn-large btn-inverse']
                );
                ?>
            </ul>
            <ul class="breadcrumb inline_field">
                <li>
                    <?php
                    echo $this->Html->link(
                        'Dashboard',
                        ['controller' => 'Admins', 'action' => 'cpanel'],
                        ['confirm' => 'Are you sure to leave this page?\nAll your changes will not be saved']
                    );
                    ?>
                </li>
                <li>
                    <?php
                    echo $this->Html->link(
                        'Front-End Content Management',
                        ['controller' => 'Frontcontents', 'action' => 'index'],
                        ['confirm' => 'Are you sure to leave this page?\nAll your changes will not be saved']
                    );
                    ?>
                </li>
                <li>Edit Frontend Content</li>
            </ul>
        </div>
        <br>
        <div class="inline_field">
            <h1>Edit Frontend Content</h1>
        </div>
        <!-- padding -->
        <br>
        <!-- form begins -->


        <div style="background-color: #fddfdf; border-radius: 7px;">
            <div style="padding:10px;padding-bottom: 0;">
                <p class="fas fa-file-image" style="color:red;"></p>
                <p class="inline_field" style="color:black;">Note that you can ONLY upload images in the Front-end-Script View page. If you wish to upload any images, please save this page and then upload.</p>
            </div>
        </div>
        <br>

        <!-- Home Page Only Content Section -->
        <div class="module">
            <div class="module-head"></div>
            <div class="module-body">
                <div class="form-horizontal row-fluid">
                    <div class="control-group">
                        <h2>Home Page Only Content</h2>
                    </div>
                    <hr>

                    <!-- Home Page Management -->
                    <div class="control-group">
                        <h3 style="color:black;">Home Page Banner</h3>
                        <div style="background-color: #ecfaff; border-radius: 7px;">
                            <div style="padding:10px;padding-bottom: 0;">
                                <p class="inline_field far fa-bell" style="color:green;"></p>
                                <span class="inline_field" style="color:black;">Please keep this Banner Text short. If it's too long it might not be displayed properly on all screen sizes.</span><br>
                            </div>
                        </div>
                        <br>
                        <div class="input textarea required">
                            <?php
                            echo $this->Form->control('banner_title',
                                ['label'=>'Banner Text:', 'type' => 'textarea',
                                    'class' => 'span12', 'style' => 'width: 100&%; height:35px;'
                                ]);
                            ?>
                            <div style="padding-top:10px;">
                                <div style="" id="show_bt_info" onclick="show_bt_info()">
                                    <p class="inline_field fas fa-info-circle"></p>&nbsp;<span class="inline_field">Click me to see where it is displayed.</span>
                                </div>
                                <div style="background-color: #fff9e1; border-radius: 7px; display: none;" onclick="hide_bt_info()" id="mybt">
                                    <div style="padding:10px;padding-bottom: 0;">
                                        <p class="inline_field fas fa-info-circle"></p><span class="inline_field">&nbsp;(Click within the yellow box close me)</span><br>
                                        <span>The Banner Text is displayed in the Banner on Home page in the front-end website. (It is displayed on Home Page ONLY, not on aboutus or faaq pages)</span>
                                    </div>
                                    <br>
                                </div>
                            </div>
                        </div>

                    </div>
                    <br>

                    <!-- Home Service Description -->
                    <div class="control-group">
                        <h3 style="color:black;">Home Page Promotion Text</h3>
                        <div style="padding-left: 10px;">
                            <h4 style="color:black;">Promotion Title and Short Description</h4>
                            <div style="padding-left:10px;">
                                <div style="background-color: #ecfaff; border-radius: 7px;">
                                    <div style="padding:10px;padding-bottom: 0;">
                                        <p class="inline_field far fa-bell" style="color:green;"></p>
                                        <span class="inline_field" style="color:black;">Please keep this Promotion Title and Description short. If it's too long it might look ugly on the home page.</span><br>
                                    </div>
                                </div>
                                <br>
                                <div class="input textarea required">
                                    <?php
                                    echo $this->Form->control('home_service_title',
                                        ['label'=>'Promotion Title:', 'type' => 'textarea',
                                            'class' => 'span12', 'style'=> 'width:100%; height:35px;',
                                        ]);
                                    ?>
                                </div>
                                <br>
                                <div class="input textarea required">
                                    <?php
                                    echo $this->Form->control('home_service_desc',[
                                        'label' => "Promotion Description:", 'type' => 'textarea',
                                        'class' => 'span12', 'style'=> 'width:100%; height:35px;'
                                    ]);
                                    ?>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div style="padding-left: 10px;">
                            <h4 style="color:black;">Promotion Card Entries</h4>
                            <div style="padding-left:10px;">
                                <div style="background-color: #ecfaff; border-radius: 7px;">
                                    <div style="padding:10px;padding-bottom: 0;">
                                        <p class="inline_field far fa-bell" style="color:green;"></p>
                                        <span class="inline_field" style="color:black;">Please keep the four promotion card entries the same length. If the difference in lentgh are too different it might look ugly on the home page.</span><br>
                                    </div>
                                </div>
                                <br>

                                    <div class="inline_field">
                                        <?php
                                        echo $this->Form->control('home_service_entry1',
                                            ['label'=>'Entry 1:', 'type' => 'textarea',
                                                'class' => ''
                                            ]);
                                        ?>
                                    </div>
                                    <div class="inline_field">
                                        <?php
                                        echo $this->Form->control('home_service_entry2',
                                            ['label'=>'Entry 2:', 'type' => 'textarea',
                                                'class' => ''
                                            ]);
                                        ?>
                                    </div>
                                    <div class="inline_field">
                                        <?php
                                        echo $this->Form->control('home_service_entry3',
                                            ['label'=>'Entry 3:', 'type' => 'textarea',
                                                'class' => ''
                                            ]);
                                        ?>
                                    </div>
                                    <div class="inline_field">
                                        <?php
                                        echo $this->Form->control('home_service_entry4',
                                            ['label'=>'Entry 4:', 'type' => 'textarea',
                                                'class' => ''
                                            ]);
                                        ?>
                                    </div>



                            </div>
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
                    <!-- Home Page Content ends -->
                </div>
            </div>
        </div>
        <!-- end -->

        <hr>

        <!-- Contact Page Only Content Section -->
        <div class="module">
            <div class="module-head"></div>
            <div class="module-body">
                <div class="form-horizontal row_fluid">
                    <br>
                    <div class="control-group">
                        <h2>Contact Us Page Only Content</h2>
                    </div>

                    <hr>

                    <!-- Contact Information-->
                    <div class="control-group">
                        <h3 style="color:black;">Contact Section</h3>
                        <div style="background-color: #ecfaff; border-radius: 7px;">
                            <div style="padding:10px;padding-bottom: 0;">
                                <p class="inline_field far fa-bell" style="color:green;"></p>
                                <span class="inline_field" style="color:black;">Please keep the contact section title short. If it's too long it will be ugly on the aboutus page.</span><br>
                            </div>
                        </div><br>
                        <div class="input textarea required" style="padding-left:10px;">
                            <?php
                            echo $this->Form->control('abt_person_title',
                                ['label'=>'Contact Section Title:', 'type' => 'text',
                                    'style' => 'width:100%; height:35px;'
                                ]);
                            ?>
                        </div>
                        <br>
                        <div style="padding-left:10px;">
                            <div class="">
                                <?php
                                echo $this->Form->control('abt_person_name',
                                    ['label'=>'Contact Name:', 'type' => 'text',
                                        'class' => 'span5', 'style' => 'padding-right:10px; margin-bottom:10px; height:35px;',
                                        'data-validation'=>'custom',
                                        'data-validation-regexp' => "^([A-Za-z ]+)$",
                                        'data-validation-error-msg'=> "Please enter a valid name",
                                        'data-validation-optional' => 'true'
                                    ]);
                                ?>
                            </div>
                            <div class="">
                                <?php
                                echo $this->Form->control('abt_person_email_new',
                                    ['label'=>'Contact Email:', 'type' => 'text',
                                        'class' => 'span5', 'style' => 'padding-right:10px;margin-bottom:10px; height:35px;',
                                        'data-validation' => 'email',
                                        'data-validation-optional' => 'true'

                                    ]);
                                ?>
                            </div>
                            <div class="">
                                <?php
                                echo $this->Form->control('abt_person_phone',
                                    ['label'=>'Contact Phone:', 'type' => 'text',
                                        'class' => 'span5', 'style' => 'padding-right:10px;margin-bottom:10px; height:35px;',
                                        'placeholder'=>'04',
                                        "data-validation" => "number length",
                                        "data-validation-length" => "10",
                                        "data-validation-error-msg" => "Please enter a valid contact phone number.",
                                        'data-validation-optional' => 'true'
                                    ]);
                                ?>
                            </div>
                            <br>
                            <div>
                                <?php
                                echo $this->Form->control('abt_person_desc',
                                    ['label'=>'Contact/Personal Description:', 'type' => 'textarea',
                                        'class' => 'span12'
                                    ]);
                                ?>
                            </div>
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
                                <span>The Contact Section is displayed right below the About-Us-Section on the AboutUs page.</span><br>
                                <span>**Note that your Phone and Email will also be displayed in the Footer 'Get In Touch' Section</span>
                            </div>
                            <br>
                        </div>
                    </div>
                    <br>
                </div>
            </div>
        </div>

        <!-- About Page Only Content Section -->
        <div class="module">
            <div class="module-head"></div>
            <div class="module-body">
                <div class="form-horizontal row-fluid">
                    <br>
                    <div class="control-group">
                        <h2>About Us Page Only Content</h2>
                    </div>

                    <hr>


                    <div class="control-group">
                        <h3 style="color:black;">About Us Section</h3>
                       <!-- <div style="background-color: #ecfaff; border-radius: 7px;">
                            <div style="padding:10px;padding-bottom: 0;">
                                <p class="inline_field far fa-bell" style="color:green;"></p>
                                <span class="inline_field" style="color:black;">Please keep this Banner Text short. If it's too long it might not be displayed properly on all screen sizes.</span><br>
                            </div>   <br>
                        </div>-->
                        <div style="padding-left:10px;">
                            <div class="input textarea">
                                <?php
                                echo $this->Form->control('abt_title',
                                    ['label'=>'About Us Title:', 'type' => 'textarea',
                                        'style' => 'width:100%; height:35px;'
                                    ]);
                                ?>
                            </div>
<br>
                            <?php
                            echo $this->Form->control('abt_desc',[
                                'label' => "About Us Description:", 'type' => 'textarea',
                                'class' => 'span12'
                            ]);
                            ?>
                        </div>
                    </div>
                    <br>
                    <!-- Home Service Description -->

                    <div style="padding-top:10px;">
                        <div style="" id="show_abtus_info" onclick="show_abtus_info()">
                            <p class="inline_field fas fa-info-circle"></p>&nbsp;<span class="inline_field">Click me to see where these are displayed.</span>
                        </div>
                        <div style="background-color: #fff9e1; border-radius: 7px; display: none;" onclick="hide_abtus_info()" id="myabtus">
                            <div style="padding:10px;padding-bottom: 0;">
                                <p class="inline_field fas fa-info-circle"></p><span class="inline_field">&nbsp;(Click within the yellow box close me)</span><br>
                                <span>The About-Us-Section is displayed right below the Banner and above the Contact-Section on the AboutUs page.</span>
                            </div>
                            <br>
                        </div>
                    </div>

                    <br>

                </div>
                <!-- About Us Page Content ends -->
            </div>
        </div>
        <!-- end -->

        <hr>

        <!-- General Site Content -->
        <div class="module">
            <div class="module-head"></div>
            <div class="module-body">
                <div class="form-horizontal row-fluid"><br>
                    <div class="control-group">
                        <h2>General Site Content</h2>
                    </div>
                    <!-- Footer description -->
                    <div class="control-group">
                        <h3>Footer Promotion Text</h3>
                        <div style="background-color: #ecfaff; border-radius: 7px;">
                            <div style="padding:10px;padding-bottom: 0;">
                                <p class="inline_field far fa-bell" style="color:green;"></p>
                                <span class="inline_field" style="color:black;">Please keep the footer description short. If it's too long it will be ugly in the page footers.</span><br>
                            </div>
                        </div><br>
                        <div class="input textarea required" style="padding-left:10px;">
                            <?php
                            echo $this->Form->control('foot_abt_desc',
                                ['label'=>'Footer Description:', 'type' => 'textarea',
                                    'class' => 'span12', 'style' => 'width;100%;'
                                ]);
                            ?>
                        </div>
                        <br>
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
                    </div>

                </div>
            </div>
        </div>
        <!-- end -->

        <hr>

        <!-- Property Page Only Content Section -->
        <div class="module">
            <div class="module-head"></div>
            <div class="module-body">
                <div class="form-horizontal row-fluid"><br>
                    <div class="control-group">
                        <h2>Property Page Only Content Section</h2>
                    </div>

                    <!-- Question -->
                    <div class="control-group">
                        <h3 style="color:black;">Property Page Help-Question</h3>
                        <div style="background-color: #ecfaff; border-radius: 7px;">
                            <div style="padding:10px;padding-bottom: 0;">
                                <p class="inline_field far fa-bell" style="color:green;"></p>
                                <span class="inline_field" style="color:black;">Note this Property-Page-Help-Question is used to remind the potential tenants where to submit an application, but you can change this as you required. </span><br>
                            </div>
                        </div><br>

                        <div style="padding-left: 10px;">
                            <div class="input textarea required">
                                <?php
                                echo $this->Form->control('house_question',
                                    ['label'=>'Question:', 'type' => 'text',
                                        'class' => 'span12', 'style'=>'width:100%'
                                    ]);
                                ?>
                            </div>
                            <br>
                            <?php
                            echo $this->Form->control('house_answer',[
                                'label' => "Answer:", 'type' => 'textarea',
                                'class' => 'span12', 'style' => 'width:100%'
                            ]);
                            ?>
                        </div>
                    </div>
                    <br>
                        <div style="padding-top:10px;">
                            <div style="" id="show_pq_info" onclick="show_pq_info()">
                                <p class="inline_field fas fa-info-circle"></p>&nbsp;<span class="inline_field">Click me to see where these are displayed.</span>
                            </div>
                            <div style="background-color: #fff9e1; border-radius: 7px; display: none;" onclick="hide_pq_info()" id="mypq">
                                <div style="padding:10px;padding-bottom: 0;">
                                    <p class="fas fa-info-circle inline_field"></p><span class="inline_field">&nbsp;(Click within the yellow box to close me)</span><br>
                                    <span>The Property-Page-Help-Question is displayed at the bottom of each Property Details Page.</span><br>
                                    <span>The suggested usage is to let your potential tenants know where to apply for a rental, but you can edit it as you prefer. </span>
                                </div>
                                <br>
                            </div>
                        </div>
                        <br>
                    </div>
                </div>
                    <!-- House Question Content ends -->
                </div>
        <!-- end -->

        <hr>

        <!-- terms and conditions -->
        <div class="module">
            <div class="module-head"></div>
            <div class="module-body">
                <div class="form-horizontal row-fluid"><br>
                    <div class="control-group">
                        <h2>Application Terms and Conditions</h2>
                    </div>

                    <!-- Question -->
                    <div class="control-group">
                        <div style="background-color: #ecfaff; border-radius: 7px;">
                            <div style="padding:10px;padding-bottom: 0;">
                                <p class="inline_field far fa-bell" style="color:green;"></p>
                                <span class="inline_field" style="color:black;">This Terms and Conditions let you put anything that you want your potential tenant to be aware of when they submit an application.</span><br>
                            </div>
                        </div><br>

                        <div style="padding-left: 10px;">

                            <?php
                            echo $this->Form->control('terms_conditions',[
                                'label' => "Terms and Conditions:", 'type' => 'textarea',
                                'class' => 'span12', 'style' => 'width:100%'
                            ]);
                            ?>
                        </div>
                    </div>
                    <br>
                    <div style="padding-top:10px;">
                        <div style="" id="show_tc_info" onclick="show_tc_info()">
                            <p class="inline_field fas fa-info-circle"></p>&nbsp;<span class="inline_field">Click me to see where these are displayed.</span>
                        </div>
                        <div style="background-color: #fff9e1; border-radius: 7px; display: none;" onclick="hide_tc_info()" id="mytc">
                            <div style="padding:10px;padding-bottom: 0;">
                                <p class="fas fa-info-circle inline_field"></p><span class="inline_field">&nbsp;(Click within the yellow box to close me)</span><br>
                                <span>The Terms and Conditions is displayed at the buttom of the application page. Your applicants will need to confirm agree with it, then submit the application form.</span><br>
                            </div>
                            <br>
                        </div>
                    </div>
                    <br>
                </div>
            </div>
            <!-- House Question Content ends -->
        </div>




        <br>
        <?php echo $this->Form->button('Save All',
            ['type' => 'submit',
                'class' => 'button btn-success span11',
                'style' => 'border-radius: 8px;',
                'confirm' => 'Are you sure you want to save and create?'
            ]); ?>
        <!-- form ends -->
            </div>
        </div>





    <!-- container ends -->

</body>
<?= $this->Form->end() ?>

<script>
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

    // about us section help text
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

    // General Site section help text
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


<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/1.4.5/numeral.min.js"></script>
<link href="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/theme-default.min.css"
      rel="stylesheet" type="text/css" />

<script>
    $.validate({

    });
</script>


<!-- footer -->
<?php echo $this->element('admin_footer'); ?>
<!-- end of footer -->
</body>



