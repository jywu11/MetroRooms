
<?php
echo $this->Html->css([
    'admin_tem/bootstrap/bootstrap.min',
    'admin_tem/bootstrap/bootstrap-responsive.min.css',
    'admin_tem/theme.css',
    'admin_tem/font-awesome.css']);
echo $this->Html->css('http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600');
?>

<!-- footer of the page -->
<div class="footer">
    <div class="container">
        Developed by<b class="copyright"> &copy; 2019-s2 MONASH-IE-team107-We're_working_on_IT</b> All rights reserved.<br>
        Template powered by<b class="copyright"> &copy; 2014 Edmin - EGrappler.com </b> All rights reserved.
    </div>
</div>
<!-- end of footer -->


<?php
echo $this->Html->script([
    'admin_tem/jquery-ui-1.10.1.custom.min.js',
    'admin_tem/bootstrap/bootstrap.min.js',
    'admin_tem/flot/jquery.flot.js', 'admin_tem/flot/jquery.flot.resize.js',
    'admin_tem/datatables/jquery.dataTables.js']);

?>