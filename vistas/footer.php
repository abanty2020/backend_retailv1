<footer class="main-footer">
  <!-- To the right -->
  <div class="pull-right hidden-xs">
    Anything you want
  </div>
  <!-- Default to the left -->
  <strong>Copyright &copy; 2016 <a href="#">Company</a>.</strong> All rights reserved.
</footer>
</div>
<!-- REQUIRED JS SCRIPTS -->
<!-- jQuery 3 -->
<script src="../public/js/jquery.min.js"></script>
<script src="../public/js/jquery-ui.min.js"></script>
<script>
$(function(){
var url = window.location;
// for sidebar menu but not for treeview submenu
$('ul.sidebar-menu a').filter(function() {
    return this.href == url;
}).parent().siblings().removeClass('active').end().addClass('active');
// for treeview which is like a submenu
$('ul.treeview-menu a').filter(function() {
    return this.href == url;
}).parentsUntil(".sidebar-menu > .treeview-menu").siblings().removeClass('active menu-open').end().addClass('active menu-open');
});
</script>
<script type="text/javascript" src="../public/js/datatables/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../public/js/datatables/dataTables.bootstrap.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script type="text/javascript" src="../public/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script type="text/javascript" src="../public/js/adminlte.js"></script>
<!-- Color Picker -->
<!-- <script src="//unpkg.com/bootstrap@4.3.1/dist/js/bootstrap.bundle.min.js"></script> -->
<script type="text/javascript" src="../public/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.js"></script>
<!-- Bootstrap slider -->
<script type="text/javascript" src="../public/js/bootstrap-slider.js"></script>
<!-- Bootstrap Select BOX -->
<script type="text/javascript" src="../public/js/bootstrap-select.min.js"></script>
<!-- CHECKBOX BOOTSTRAP -->
<script type="text/javascript" src="../public/js/bootstrap-checkbox.js"></script>
<!-- iCheck 1.0.1 -->
<script type="text/javascript" src="../public/js/icheck.min.js"></script>
<!-- Notify -->
<script type="text/javascript" src="../public/js/notify.min.js"></script>
<!-- Confirm js -->
<script type="text/javascript" src="../public/js/jquery-confirm.min.js"></script>
<!-- Mask js -->
<script type="text/javascript" src="../public/js/jquery.maskMoney.js"></script>
<!-- Amaran js -->
<script src="../public/js/jquery.amaran.min.js"></script>
<script src="../public/js/swiper.min.js"></script>
<script type="text/javascript" src="../public/js/datatables/jszip.min.js"></script>
<script type="text/javascript" src="../public/js/datatables/pdfmake.min.js"></script>
<script type="text/javascript" src="../public/js/datatables/vfs_fonts.js"></script>
<script type="text/javascript" src="../public/js/datatables/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="../public/js/datatables/buttons.bootstrap.min.js"></script>
<script type="text/javascript" src="../public/js/datatables/buttons.colVis.min.js"></script>
<script type="text/javascript" src="../public/js/datatables/buttons.flash.min.js"></script>
<script type="text/javascript" src="../public/js/datatables/buttons.html5.min.js"></script>
<script type="text/javascript" src="../public/js/datatables/buttons.print.min.js"></script>
</body>
</html>
