<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Application $application
 */
?>

<head>
    <?php $this->assign('title','Application | NAIM'); ?>
</head>

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/jquery-ui.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">



<section id = "myHead">
    <?= $this->Html->css('my_front') ?>
    <?php echo $this->element('front_topbar'); ?>
</section>
<section  class="hero-section home-page set-bg" data-setbg="">
    <!-- <section class="hero-section home-page set-bg" data-setbg="/img/ie/toppage.jpg"> -->
</section>

<style>
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

<!-- information begin -->
<?php
$rid = $room->id;
$pid = $property->id;
$red = $room->rental_end_date;

if ($red == null){
    $red = \Cake\I18n\Time::now();
}

$r_name = $room->room_name;
$cap = $room->room_capacity;
$addr = $property->street.', '.$property->suburb.', '.$property->state.' '.$property->postcode;


?>
<!-- informaiton end -->


<!-- Availability -->
<?php
    $matrix = array();
    $resArray = array();
    // init res array
    for ($i=0; $i<365; $i++){ $resArray[$i] = null; }

    function getCurrent(){
        $currentDate = \Cake\I18n\Time::now();
        $currentDate->setTimezone(new \DateTimeZone('Australia/Melbourne'));
        return $currentDate;
    }

    function FrozenToDate($FrozenDate){
        $Date = new \Cake\I18n\Time($FrozenDate);
        return $Date;
    }

    function getRentalRoomBeds($rental_room_beds, $rental){
        /*
         * Return Rental_Room_Bed where RentalID = this Rental (Beds Occupied by this rental)
         */
        $rentalRoomBeds = Array(); $i=0;
        foreach ($rental_room_beds as $rental_room_bed){
            if ($rental_room_bed->rental_id == $rental->id){
                $rentalRoomBeds[$i] = $rental_room_bed;
                $i += 1;
            }
        }
        return $rentalRoomBeds;
    }

    function getCapacityAndBeds($rentalRoomBeds, $room_beds){
        /*
         *  Return Capacity of this rental and the beds its occupied
         */
        $res = array();
        $res[0] = 0;
        $res[1] = array();
        $i = 0;
        foreach ($rentalRoomBeds as $rentalRoomBed) {
            $this_bed = null;
            foreach ($room_beds as $room_bed){
                if ($room_bed->id == $rentalRoomBed->bed_room_id){
                    $this_bed = $room_bed;                                                                               // get the beds info for each bed occupied
                }
            }
            $res[0] += $this_bed->capacity;
            $res[1][$i] = $this_bed;
            $i += 1;
        }
        return $res;
    }

    $currentDate = getCurrent();
    $counter = 0;
    foreach ($rentals as $rental){                                                                                      //  Active Rentals
        $matrix[$counter] = array();
        for($i=0; $i<365; $i++){ $matrix[$counter][$i] = null; }                                                        // add rental column to matrix

        $start = FrozenToDate($rental->start_date);                                                                     // Rent Info
        $end = FrozenToDate($rental->end_date);
        $rentalRoomBeds = getRentalRoomBeds($rental_room_beds, $rental);

        if ($start <= $currentDate && $end >= $currentDate){                                                             // Start before CurrentDate
            $startIndex = 0;
            $endIndex = $currentDate->diffInDays($end);
            if ($endIndex >= 365){                                                                                       // Start before CurrentDate && Ends after a year
                $res = getCapacityAndBeds($rentalRoomBeds, $room_beds);
                $cap = $res[0];
                $bedArray = $res[1];

                for ($i=0; $i < 365; $i++){
                    $matrix[$counter][$i][0] = $cap;
                    $matrix[$counter][$i][1] = $bedArray;
                }
            }else{                                                                                                       // Start before CurretDate && Ends within a year
                //debug($counter);
                $res = getCapacityAndBeds($rentalRoomBeds, $room_beds);
                $cap = $res[0];
                $bedArray = $res[1];

                for ($i=0; $i < $endIndex; $i++){
                    $matrix[$counter][$i][0] = $cap;
                    $matrix[$counter][$i][1] = $bedArray;
                }
                //debug($matrix);
            }
        }
        if ($start > $currentDate){                                                                                      // Start after currentDate
            $startIndex = $currentDate->diffInDays($start);
            $endIndex = $currentDate->diffInDays($end);
            $dur = $start->diffInDays($end);

            if ($endIndex >= 365){                                                                                       // Start after CurrentDate && End after a year
                $res = getCapacityAndBeds($rentalRoomBeds, $room_beds);
                $cap = $res[0];
                $bedArray = $res[1];

                for ($i=$startIndex; $i<365; $i++){
                    $matrix[$counter][$i][0] = $cap;
                    $matrix[$counter][$i][1] = $bedArray;
                }
            }else{                                                                                                       // Start after CurrentDate && End within a year
                $res = getCapacityAndBeds($rentalRoomBeds, $room_beds);
                $cap = $res[0];
                $bedArray = $res[1];

                for ($i=$startIndex; $i < $endIndex; $i++){
                    $matrix[$counter][$i][0] = $cap;
                    $matrix[$counter][$i][1] = $bedArray;
                }
            }
        }
        $counter += 1;
    }

    foreach ($matrix as $row){                                                                                          // For each rental
        for ($i=0; $i<365; $i++){                                                                                        // for 365
            if ($resArray[$i] == Null && $row[$i] == Null){                                                             // Rental and resArray both Null
                continue;
            }
            if ($row[$i] != Null){                                                                                      // Rental not Null
                if ($resArray[$i] == Null) {                                                                            // Rental not Null && resArray is Null
                    $resArray[$i][0] = $row[$i][0];
                    $resArray[$i][1] = $row[$i][1];
                }
                else{                                                                                                   // Rental not Null && resArray is Not Null
                    $resArray[$i][0] += $row[$i][0];
                    foreach ($row[$i][1] as $a_bed){
                        array_push($resArray[$i][1], $a_bed);
                    }
                }
            }
        }
    }
?>
<!-- end Availability -->

<!-- Page Content Begin -->
<body>
<section class="contact-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="contact-form">
                    <h3>Express of Interest Form</h3>
                    <br>
                    <h4 style="margin-bottom:20px;">Step 1 - Choose a Time Slot</h4>
                    <div>

                        <?php
                        echo $this->Html->link(
                            'Back to this Room\'s Information',
                            ['controller' => 'Rooms', 'action' => 'detail', $rid],
                            ['confirm' =>  'Are you sure to leave this page?\nYour application will NOT be submitted',
                                'style' => 'text-align:center',
                                'class' => 'btn btn-primary']
                        )
                        ?>
                    </div>
                    <hr>
                    <span>The room accepts application that starts from the current date within the 12 months.</span>








                </div>
            </div>
            <div class="col-lg-4">
                <div class="contact-info" id="myCard">
                    <h5>The Room Enquired:</h5>
                    <br>
                    <ul class="contact-addr">
                        <li>
                            <?php
                            echo $this->Html->image('house.svg', [
                                'style' => 'max-width:7%;height:auto;padding-right:0;',
                            ])
                            ?>
                            <span style="margin-left:0;"> <?php echo " ".$addr; ?></span>
                        </li>
                        <li><?php echo "<span>".$property->number_of_bedroom." bedrooms, ".$property->number_of_bathroom." bathrooms, ".$property->number_of_toilet." toilets"."</span>"?></li>
                        <li>
                            <?php
                            echo $this->Html->image('bed.svg', [
                                'style' => 'max-width:5%;height:auto;padding-right:0;',
                            ])
                            ?>
                            <span style=margin-left:0;"><?php echo " ".$room->room_name; ?></span>
                        </li>
                        <?php
                        if ($room->type == 0){
                            $r_t = 'Private';
                            if ($room->room_type_desc != null || $room->room_type_desc != ''){
                                $r_t = $r_t."&nbsp;-&nbsp;".$room->room_type_desc;
                            }
                        }else{
                            $r_t = 'Sharing';
                            if ($room->room_type_desc != null || $room->room_type_desc != ''){
                                $r_t = $r_t."&nbsp;-&nbsp;".$room->room_type_desc;
                            }
                        }

                        ?>

                    </ul>
                    <div id="carddatepicker"></div>
                </div>
            </div>

        </div>
    </div>
</section>

<!--Footer  -->
<?php echo $this->element('front_footer'); ?>
</body>
<!-- Page Content End -->









<!-- script -->
<script>
    $(document).ready(function(){
        // my jquery methods
        $("#number-of-people").change(updateForm);
        window.onload = function() {
            updateForm();
        };

        function updateForm(){
            var ele = document.getElementById('cap');
            var new_num = document.getElementById('number-of-people').value;
            var ref = document.getElementById('ref_child');


            // remove old fields
            $('.added').remove();


            // get new number of people, generate form
            for (let i=0; i < new_num; i++){
                var row = document.createElement("div"); // fieldset
                row.setAttribute('class', 'added');
                var card_div = document.createElement("div");       // card div
                card_div.setAttribute('class', 'card border-warning');
                var card_header = document.createElement("h6");    // card header div
                card_header.setAttribute('class', 'card-header');
                card_header.append('Details of Applicant ', i+1);
                var card_body = document.createElement('div');
                card_body.setAttribute('class', 'card-body');       // card body div
                var row_1 = document.createElement("div");          // ROW 1
                row_1.setAttribute('class', 'row');
                // first name div
                var fn_div_div = document.createElement("div");
                fn_div_div.setAttribute('class', 'col-lg-4');
                var fn_div = document.createElement("div");
                fn_div.setAttribute('class', 'input text required');
                fn_div.innerHTML = "" +
                    "<label for=\"first-name\">First Name</label>" +
                    "<input type=\"text\" " +
                    "name=\"applicants["+i.toString()+"][first_name]\"  " +
                    "placeholder=\"First Name\" " +
                    "required=\"required\" " +
                    "maxlength=\"255\" " +
                    "id=\"applicants-"+i.toString()+"-first-name\" " +
                    "data-validation=\"custom\"" +
                    " data-validation-regexp=\"^([A-Za-z]+)$\"" +
                    " data-validation-error-msg = \"Please enter a valid first name\">";
                fn_div_div.appendChild(fn_div);
                // last name div
                var ln_div_div = document.createElement("div");
                ln_div_div.setAttribute('class', 'col-lg-4');
                var ln_div = document.createElement("div");
                ln_div.setAttribute('class', 'input text required');
                ln_div.innerHTML = "" +
                    "<label for=\"last-name\">Last Name</label>" +
                    "<input type=\"text\" name=\"applicants["+i.toString()+"][last_name]\" " +
                    "placeholder=\"Last Name\" " +
                    "required=\"required\" " +
                    "maxlength=\"255\" " +
                    "id=\"applicants-"+i.toString()+"-last-name\" " +
                    "data-validation=\"custom\" " +
                    "data-validation-regexp=\"^([A-Za-z]+)$\"" +
                    " data-validation-error-msg = \"Please enter a valid last name\">";
                ln_div_div.appendChild(ln_div);
                // preferred name div
                var pn_div_div = document.createElement("div");
                pn_div_div.setAttribute('class', 'col-lg-4');
                var pn_div = document.createElement("div");
                pn_div.setAttribute('class', 'input text');
                pn_div.innerHTML = "" +
                    "<label for=\"preferred-name\">Preferred Name</label>" +
                    "<input type=\"text\" " +
                    "name=\"applicants["+i.toString()+"][preferred_name]\" " +
                    "placeholder=\"Preferred Name\" " +
                    "maxlength=\"255\" " +
                    "id=\"applicants-"+i.toString()+"preferred-name\" " +
                    "data-validation=\"custom\" " +
                    "data-validation-regexp=\"^([A-Za-z ]+)$\"" +
                    " data-validation-error-msg = \"Please enter a valid preferred name if you have one. Please leave it blank if you do not.\" " +
                    "data-validation-optional=\"true\"" +
                    ">";
                pn_div_div.appendChild(pn_div);
                row_1.appendChild(fn_div_div);
                row_1.appendChild(ln_div_div);
                row_1.appendChild(pn_div_div);

                var row_2 = document.createElement("div");          // ROW 2
                row_2.setAttribute('class', 'row');
                var g_div_div = document.createElement("div");     // gender div
                g_div_div.setAttribute('class', 'col-lg-4');
                var g_div = document.createElement("div");
                g_div.setAttribute('class', 'input select required');
                g_div.innerHTML = "" +
                    "<label for=\"gender\">Gender</label>" +
                    "<select name=\"applicants["+i.toString()+"][gender]\" required=\"required\" id=\"applicants-"+i.toString()+"-gender\">" +
                    "<option value=\"0\" selected=\"selected\">Male</option>" +
                    "<option value=\"1\">Female</option>" +
                    "<option value=\"2\">Other</option></select>";
                g_div_div.appendChild(g_div);
                var ac_div_div = document.createElement("div");     // aus citizen div
                ac_div_div.setAttribute('class', 'col-lg-4');
                var ac_div = document.createElement("div");
                ac_div.setAttribute('class', 'input select required');
                ac_div.innerHTML = "" +
                    "<label for=\"australian-citizen\">Is Australian Citizen</label>" +
                    "<select name=\"applicants["+i.toString()+"][australian_citizen]\" required=\"required\" id=\"applicants-"+i.toString()+"-australian-citizen\">" +
                    "<option value=\"0\" selected=\"selected\">Yes</option>" +
                    "<option value=\"1\">No</option></select>";
                ac_div_div.appendChild(ac_div);
                row_2.appendChild(g_div_div);
                row_2.appendChild(ac_div_div);

                var row_3 = document.createElement("div");          // ROW 3
                row_3.setAttribute('class', 'row');
                var pc_div_div = document.createElement("div");     // personal contact div
                pc_div_div.setAttribute('class', 'col-lg-12');
                var pc_div = document.createElement("div");
                pc_div.setAttribute('class', 'input select');
                pc_div.innerHTML = "" +
                    "<label for=\"personal-contact-phone\">Personal Contact Phone</label>" +
                    "<input type=\"text\"   " +
                    "name=\"applicants["+i.toString()+"][personal_contact_phone]\" " +
                    "placeholder=\"04\" " +
                    " "+
                    "id=\"applicants-"+i.toString()+"-personal-contact-phone\" " +
                    "data-validation-optional=\"true\" " +
                    "data-validation=\"number length\" " +
                    "data-validation-length=\"10\"" +
                    " data-validation-error-msg = \"Please enter a valid phone number if you have one, the format should be: 04aabbbccc.Please leave it blank if you do not.\">";
                pc_div_div.appendChild(pc_div);
                row_3.appendChild(pc_div_div);

                // merge
                card_div.appendChild(card_header);
                card_body.appendChild(row_1);
                card_body.appendChild(row_2);
                var next_line = document.createElement("br");
                card_body.appendChild(next_line);
                card_body.appendChild(row_3);
                card_div.appendChild(card_body);

                row.appendChild(card_div);
                var br = document.createElement("br");
                row.appendChild(br);
                ref.parentNode.appendChild(row);
                $.validate({});
            }
        }
    });
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
        disabledFormFilter : 'myform.toggle-disabled',
        showErrorDialogs : false
    });

    /*   $('#contact_email').on('input', function(){
          var dumb = 1;
       });*/

</script>
<!-- end data validation -->

<!-- sticky -->
<script>

    // When the user scrolls the page, execute myFunction
    window.onscroll = function() {myFunction()};

    // Get the header
    var header = document.getElementById("myCard");

    // Get the offset position of the navbar
    var head = document.getElementById("myHead");
    var sticky = head.offsetTop;

    // Add the sticky class to the header when you reach its scroll position. Remove "sticky" when you leave the scroll position
    function myFunction() {
        var windowWidth = $(window).width();

        if (windowWidth > 996) {
            if (window.pageYOffset > sticky) {
                header.classList.add("sticky");
            } else {
                header.classList.remove("sticky");
            }
        }
    }
</script>
<!-- sticky end -->

<script>
    $( function() {
        var DaysToRentEnd = document.getElementById('DaysToRentEnd').value;
        $( "#carddatepicker" ).datepicker({
            minDate: DaysToRentEnd,
        });
    } );
</script>

<script>
    $( function() {
        var DaysToRentEnd = document.getElementById('DaysToRentEnd').value;
        $( "#datepicker" ).datepicker({
            changeMonth: true,
            changeYear: true,
            minDate: DaysToRentEnd,
            showWeek: true,
            firstDay: 1,
            anim: 'blind',
            dateFormat: "mm/dd/yy"
        });

    } );
</script>



