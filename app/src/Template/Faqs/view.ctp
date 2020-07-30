<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Faq $faq
 */
?>
<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Item[]|\Cake\Collection\CollectionInterface $items
 */
?>



<?php
/**
 * @var \App\View\AppView $this
 * @var $properties
 */
?>

<!-- load DataTables formatting files -->
<?php
echo $this->Html->css('navbar.css');
echo $this->Html->script('https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js');
echo $this->Html->css(['https://cdn.datatables.net/v/ju/jqc-1.12.4/dt-1.10.18/b-1.5.6/b-print-1.5.6/r-2.2.2/rg-1.1.0/sc-2.0.0/sl-1.3.0/datatables.min.css']);
echo $this->Html->script(['https://cdn.datatables.net/v/ju/jqc-1.12.4/dt-1.10.18/b-1.5.6/b-print-1.5.6/r-2.2.2/rg-1.1.0/sc-2.0.0/sl-1.3.0/datatables.min.js']);
?>
<script src='https://kit.fontawesome.com/a076d05399.js'></script>

<!-- jquery ui dialog -->
<!--<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
-->
<!-- head of the page -->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQs | Admin</title>
    <?php $this->assign("title","NAIM Admin | Content Management"); ?>
</head>
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

    #archiveButton{
        color: white;
        background-color: dimgrey;
    }

    #restoreButton{
        color: white;
        background-color: deepskyblue;
    }

    #interviewButton{
        color: white;
        background-color: #ed969e;
    }

    .pending {
        background-color:#FFC600;
        padding-left:5px;
        border-radius: 5px;
    }

    .interviewing {
        background-color:#ffff00;
        padding-left:5px;
        border-radius: 5px;
    }

    .approved {
        background-color:greenyellow;
        opacity: 80%;
        padding-left:5px;
        border-radius: 5px;
    }

    .archived{
        background-color:lightgrey;
        padding-left:5px;
        border-radius: 5px;
    }

    #popup_form{
        display: none;
    }

</style>

<!-- top nav bar -->
<?php echo $this->element('admin_topbar'); ?>
<!-- end of top nav bar -->



<div class ="wrapper">
    <div class ="container">
        <div class="tab-wrap">

            <input type="radio" id="tab1" name="tabGroup1" class="tab" onclick="window.location='frontcontents';">
            <label for="tab1">Frontend Content</label>

            <input type="radio" id="tab3" name="tabGroup1" class="tab" checked>
            <label for="tab3">FAQ Content</label>

            <!--Features Management-->
            <!-- adding new feature -->

            <div class="tab__content"></div>

            <!-- existing features -->
            <div class="tab__content">

                <br>
                <div style="text-align: center">
                    <div class="inline_field" style="">
                        <h2>Front-End FAQ Management</h2>
                    </div>
                </div>
                <div style="text-align:center">


                    <div >
                        <button class="button btn-large btn-success" id="THISISADD"  data-toggle="modal" data-target="#create_feature">Add an FAQ entry</button>
                    </div>
                </div>
                <div style="text-align:center">
                    <span>The FAQ you added here will be shown on the front-end to your potential tenants.</span>
                </div>
                <br>

                <div class="module">
                    <div class="form-horizontal row-fluid">
                        <!-- datatable start -->
                        <table id="faq" class="display table table-striped table-hover ">
                            <thead>
                            <tr>
                                <th>Question</th>
                                <th>Answer</th>
                                <th>Actions</th>
                            </tr>
                            </thead>

                            <?php
                            foreach ($faqs as $faq)
                            { ?>
                                <tr>
                                    <td style="word-break: break-word;"><?php echo $faq->question; ?></td>
                                    <td style="word-break: break-word;"><?php echo $faq->answer; ?></td>
                                    <td>
                                        <!-- edit -->

                                        <div class="btn-box-row row-fluid">

                                            <!-- generate button by jquery -->
                                            <?php
                                            echo $this->Html->link(
                                                '<p style="padding-bottom:0;margin-bottom:0;" class="fas fa-edit"></p><span> Edit</span>',
                                                ['controller' => 'Faqs', 'action' => 'edit', $faq->id],
                                                [
                                                   'escape'=>false, 'class' => 'btn btn-large span4  btn-warning ',
                                                    'style' => 'width:90px; bottom:3px; border-radius: 35px; top:1px; margin-bottom:5px;']
                                            );
                                            ?>

                                            <!-- <button
                                                    id= "<?php echo $faq->id.".".$faq->question.".".$faq->answer.".THISISEDITMODAL"; ?>"
                                                    class="btn btn-large span4  btn-warning fas fa-edit"
                                                    style="width:75px; top:1px; border-radius: 35px; bottom:3px;"
                                                    data-toggle= "modal"
                                                    data-target="#edit_feature"
                                            >Edit</button> -->

                                            <?php
                                            echo $this->Form->postButton(
                                                '<p style="padding-bottom:0;margin-bottom:0;" class=" fas fa-trash-alt"></p><span> Delete</span>',
                                                ['controller' => 'Faqs', 'action' => 'delete', $faq->id],
                                                ['confirm' => 'Are you sure to delete this FAQ entry?\nThis action is not revertible.',
                                                    'class' => 'btn btn-large span3 btn-danger',
                                                    'style' => 'width:90px; bottom:3px; border-radius: 35px; top:1px; margin-bottom: 5px;']
                                            );
                                            ?>

                                        </div>

                                    </td>
                                </tr>

                                <?php
                            }

                            ?>
                        </table>
                    </div>
                </div>
            </div>

        </div>

        <!--  --><?php
        /*        $this->extend('add');
                */?>

    </div>


</div>


<!-- Modal  ADD -->
<div class="modal fade" id="create_feature" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true"  data-backdrop="" style="display:none;">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding-right:10px; padding-top:10px;">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLongTitle" style="text-align:center">Add an FAQ entry</h3>
                <div style="text-align:center">
                    <span>The FAQ you added here will be shown on the front-end to your potential tenants.</span>
                </div>
            </div>

            <div class="modal-body">
                <?php echo $this->Form->create('Faq', ['action' => 'add']) ?>
                <fieldset>
                    <div style=" text-align:center">
                        <?php
                        echo $this->Form->control('question',
                            ['label'=>'FAQ Question',
                                'type' => 'textarea',
                                'required' => 'required',
                                'class' => 'span5',
                                'style'=>'height:40px;',
                                'data-validation' => 'length alphanumeric',
                                'data-validation-length' => 'max500',
                                'data-validation-allowing' => " ?():,.&;/=!",
                                'data-validation-error-msg-alphanumeric' => 'FAQ Question should not include invalid character or be empty',
                                'data-validation-error-msg' =>  'FAQ Question has exceeded 500 words limit'
                            ]);
                        ?>
                    </div>
                    <div style=" text-align:center">
                        <?php
                        echo $this->Form->control('answer',
                            ['label'=>'FAQ Answer',
                                'type' => 'textarea',
                                'required' => 'required',
                                'class' => 'span5',
                                'style'=>'height:40px;',
                                'data-validation' => 'length alphanumeric',
                                'data-validation-length' => 'max500',
                                'data-validation-allowing' => " ?():,.&;/=!",
                                'data-validation-error-msg-alphanumeric' => 'FAQ Answer should not include invalid character or be empty',
                                'data-validation-error-msg' =>  'FAQ Answer has exceeded 500 words limit'])
                        ?>
                        <!--'data-validation' => 'alphanumeric',
                        'data-validation-error-msg' => "Please enter a valid feature name. Possible format: 'with Smoking Area'.",
                        'data-validation-allowing' => " ().,!'\"-+=@#$%^&*|][{}:;/?" -->
                    </div>

                </fieldset>

            </div>
            <div class="modal-footer" style="padding-bottom: 0;">
                <button type="button" class="button btn-inverse btn-large" data-dismiss="modal">Close</button>
                <button type="submit" class="button btn-success btn-large">Create this FAQ Entry</button>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>



<!-- Modal EDIT  -->
<div class="modal fade" id="edit_feature" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true"  data-backdrop="" style="display:none;">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding-right:10px; padding-top:10px;">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLongTitle" style="text-align: center;">Edit FAQ Entry</h3>
                <div style="text-align:center">
                    <span>The FAQ you added here will be shown on the front-end to your potential tenants.</span>
                </div>
            </div>

            <div class="modal-body" id="ref" style="text-align: center;">
                <?php
                echo $this->Form->create('Faq', ['action' => 'edit', 'id'=>'e_f']); ?>

                <?php
                echo $this->Form->control('question',
                    ['label'=>'FAQ Question',
                        'type' => 'textarea',
                        'id' => 'faq_q',
                        'value' => "",
                        'required' => 'required',
                        'class' => 'span6',
                        'style'=>'height:40px;']);
                ?>




                <?php

                echo $this->Form->control('answer',
                    ['label'=>'FAQ Answer',
                        'type' => 'textarea',
                        'required' => 'required',
                        'class' => 'span6',
                        'style'=>'height:40px;',
                        'value' => "",
                        'id' => 'faq_a']);
                ?>



            </div>

            <div class="modal-footer" style="padding-bottom: 0;">
                <div class="inline_field">
                    <button type="button" class="button btn-inverse btn-large inline_field" data-dismiss="modal">Close</button>
                </div>
                <div id="sub_ref" class="inline_field">
                    <?php
                    echo $this->Form->postButton(
                        ' Save this FAQ Entry',
                        ['controller' => 'Faqs', 'action' => 'edit'],
                        [
                            'id' => 'but_3',
                            'type' => 'submit',
                            'class' => 'button btn-success btn-large inline_field',
                            'style' => '']
                    );
                    ?>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>




<!-- footer -->
<?php echo $this->element('admin_footer'); ?>
<!-- end of footer -->



<!-- format url -->
<script>
    $(document).ready(function(){
        window.onload = function(){
            var tab1 = document.getElementById("tab1");
            var tab2 = document.getElementById("tab2");

            var my_url = window.location.href;
            if (my_url.includes("faqs/")){
                // alert("here index");
                tab1.setAttribute("onclick", "window.location='frontcontents';");
            }else{
                // alert("here no index");
                tab1.setAttribute("onclick", "window.location='frontcontents/index';");
            }
        };
    });

</script>
<!-- end format url -->




<script>

    $(document).ready( function () {
        //need to change
        $('#faq').DataTable({
            "language": {
                "emptyTable": "There is no item currently stored in the system, please create one with the green button."
            },
            "search": {
                "smart": false,
            },
            "searching": true,
            "pageLength":8,
            "bLengthChange": false,
           // responsive: true
        });
    } );
</script>


<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
<link href="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/theme-default.min.css"
      rel="stylesheet" type="text/css" />
<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/1.4.5/numeral.min.js"></script>


<!-- data validation -->
<script>
    $.validate({});
    $.validate({
        modules : 'toggleDisabled',
        disabledFormFilter : 'toggle-disabled',
        showErrorDialogs : false
    });

    /*   $('#contact_email').on('input', function(){
          var dumb = 1;f
       });*/

</script>
<!-- end data validation -->


<script>
    // generate modal
    $("button").click(function(e){
        var idClicked = e.target.id;


        if (idClicked.includes("THISISADD") == true){
            var add = document.getElementById("create_feature");
            add.setAttribute("style", "");
        }
        if (idClicked.includes('THISISEDITMODAL') == true){
            // $('#cur').remove();
            // $('#cur_3').remove();
            // $('#cur_2').remove();
            // $('.cur_c_re').remove();

            var modal = document.getElementById("edit_feature");
            modal.setAttribute("style", "");


            var d = idClicked.split('.');
            var id = d[0];
            var question = d[1];
            var answer = d[2];

            /*var modal = document.getElementById("edit_feature");
            modal.setAttribute("class", "model fade in");
            modal.setAttribute("aria-hidden", "false");*/

            var ref = document.getElementById("e_f");
            ref.setAttribute("action", "/Faqs/edit/"+id);


            // var fs_1 = document.createElement("fieldset");

            /*  var div_7 = document.createElement("div");
              div_7.setAttribute("class", "input text required");
  */
            /* var label_1 = document.createElement("label");
             label_1.setAttribute("for", "name");
             label_1.innerHTML = "Feature Name";
 */
            //var in_1 = document.createElement("input");


            var in_1 = document.getElementById("faq_q");
            /* in_1.setAttribute("type", "text");
             in_1.setAttribute("name", "name");
             in_1.setAttribute("required", "required");
             in_1.setAttribute("maxlength", "30");
             in_1.setAttribute("id", "name");*/

            $("textarea#faq_q").val(question);
            $("textarea#faq_a").val(answer);
            /* in_1.setAttribute("value", question);
             in_1.text(question);

             /!*in_1.setAttribute("class", "span3 cur_c_re");
             in_1.setAttribute("style", "height:40px;");*!/
             var in_2 = document.getElementById("faq_a");
             in_2.text(answer);
             in_2.setAttribute("value", answer);*/
            // div_7.appendChild(label_1);
            //div_7.appendChild(in_1);
            //fs_1.appendChild(div_7);

            // ref.appendChild(fs_1);







            var but_3 = document.getElementById("but_3");
            //  var but_3 = document.createElement("button");
            // but_3.setAttribute("type", "submit");
            // but_3.innerHTML = "Save this Feature";
            but_3.setAttribute("action", "features/edit/"+id);
            //  but_3.setAttribute("class", "button btn-success btn-large");
            //  but_3.setAttribute("id", "cur_3");



            /*var but_2 = document.createElement("button");
            but_2.setAttribute("type", "button");
            but_2.setAttribute("class", "button btn-inverse btn-large");
            but_2.setAttribute("data-dismiss", "modal");
            but_2.setAttribute("id", "cur_2");
            but_2.innerHTML = "Close";*/



            //ref.appendChild(but_2);
            //  ref.appendChild(but_3);







            /*var form_1 = document.createElement("form");
            form_1.setAttribute("method", "post");
            form_1.setAttribute("accept-charset", "utf-8");
            form_1.setAttribute("action", "/features/edit/"+id);
            form_1.setAttribute("id", "cur");


*/
            /*
              form_1.appendChild(fs_1);*/

            /*var div_8 = document.createElement("div");
            div_8.setAttribute("class", "modal-footer");
            div_8.setAttribute("style", "padding-bottom:0;");



            div_8.appendChild(but_2);
            div_8.appendChild(but_3);

            form_1.appendChild(div_8);

            ref.appendChild(form_1);
*/
            //var sub_ref = document.getElementById("sub_ref");


            /*var but_3 = document.createElement("button");
            but_3.setAttribute("type", "submit");
            but_3.innerHTML = "Save this Feature";
            // but_3.setAttribute("action", "features/edit/"+id);
            but_3.setAttribute("class", "button btn-success btn-large");*/










        }
    });

    /*   var div_1 = document.createElement("div");
          div_1.setAttribute('class', 'modal fade');
          div_1.setAttribute('id', 'edit_feature');
          div_1.setAttribute('tabindex', '-1');
          div_1.setAttribute('role', 'dialog');
          div_1.setAttribute('aria-labelledby', 'exampleModalCenterTitle');
          div_1.setAttribute('aria-hidden', 'true');
          div_1.setAttribute('data-backdrop', '');

          var div_2 = document.createElement("div");
          div_2.setAttribute('class', 'modal-dialog modal-dialog-centered');
          div_2.setAttribute('role', 'document');

          var div_3 = document.createElement("div");
          div_3.setAttribute('class', 'modal-content');

          var but_1 = document.createElement("button");
          but_1.setAttribute('type', 'button');
          but_1.setAttribute('class', 'close');
          but_1.setAttribute('data-dismiss', 'modal');
          but_1.setAttribute('aria-label', 'Close');
          but_1.setAttribute('style', 'padding-right:10px; padding-top:10px;');

          var span_1 = document.createElement("span");
          span_1.setAttribute('aria-hidden', 'true');
          span_1.innerHTML = "&times;";

          var div_4 = document.createElement("div");
          div_4.setAttribute('class', 'modal-header');

          var h3_1 = document.createElement("h3");
          h3_1.setAttribute('class', 'modal-title');
          h3_1.setAttribute('id', 'exampleModalLongTitle');
          h3_1.setAttribute('style', 'text-align:center;');
          h3_1.innerHTML = "Edit Feature Name";

          var div_5 = document.createElement("div");
          div_5.setAttribute('style', 'text-align:center');

          var span_2 = document.createElement("span");
          span_2.innerHTML = "The name of the feature will be changed in general.";

          var div_6 = document.createElement("div");
          div_6.setAttribute("class", "modal-body");
          div_6.setAttribute("style", "text-align:center;");

          var form_1 = document.createElement("form");
          form_1.setAttribute("method", "post");
          form_1.setAttribute("accept-charset", "utf-8");
          form_1.setAttribute("action", "/features/edit/"+id);

          var fs_1 = document.createElement("fieldset");

          var div_7 = document.createElement("div");
          div_7.setAttribute("class", "input text required");

          var label_1 = document.createElement("label");
          label_1.setAttribute("for", "name");
          label_1.innerHTML = "\"Feature Name\" ::after";

          var in_1 = document.createElement("input");
          in_1.setAttribute("type", "text");
          in_1.setAttribute("name", "name");
          in_1.setAttribute("required", "required");
          in_1.setAttribute("maxlength", "30");
          in_1.setAttribute("id", "name");
          in_1.setAttribute("value", name);


          var div_8 = document.createElement("div");
          div_8.setAttribute("class", "modal-footer");
          div_8.setAttribute("style", "padding-bottom:0;");

          var but_2 = document.createElement("button");
          but_2.setAttribute("type", "button");
          but_2.setAttribute("class", "button btn-inverse btn-large");
          but_2.setAttribute("data-dismiss", "modal");
          but_2.innerHTML = "Close";

          var but_3 = document.createElement("button");
          but_3.setAttribute("type", "submit");
          but_3.innerHTML = "Save this Feature";
          but_3.setAttribute("action", "features/edit/"+id);
          but_3.setAttribute("class", "button btn-success btn-large");


          div_8.appendChild(but_2);
          div_8.appendChild(but_3);

          div_7.appendChild(label_1);
          div_7.appendChild(in_1);
          fs_1.appendChild(div_7);
          form_1.appendChild(fs_1);
          div_6.appendChild(form_1);

          div_5.appendChild(span_2);
          div_4.appendChild(h3);
          div_4.appendChild(div_5);

          but_1.appendChild(span_1);

          div_3.appendChild.appendChild(but_1);
          div_3.appendChild.appendChild(div_4);
          div_3.appendChild.appendChild(div_6);
          div_3.appendChild.appendChild(div_8);

          div_2.appendChild(div_3);

          div_1.append(div_2);*/
</script>

