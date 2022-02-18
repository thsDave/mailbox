</div>

<!-- ./wrapper -->

<footer class="main-footer">
  <strong><?= APP_NAME ?> <?= YEAR ?> | <a href="#"><?= DEVOPS['team'] ?></a>.</strong>
  <div class="float-right d-none d-sm-inline-block">
    <b>Version</b> <?= VERSION ?>
  </div>
</footer>

<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- <script src="plugins/sweetalert2/sweetalert2.min.js"></script> -->

<script>
	$(document).ready(function () {
		$('[data-toggle="tooltip"]').tooltip();

		$('[data-toggle="popover"]').popover({ container: 'body' });
	});
</script>