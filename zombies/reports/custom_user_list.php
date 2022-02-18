<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<title>Lista usuarios</title>
		<?php include 'styles_css.php'; ?>
	</head>
	<body>
		<div class="row">
			<div class="col-12">
				<img src="<?= URL ?>dist/img/logo.png" width="120" height="83">
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<h1><?= LANG['user_report'] ?></h1>
			</div>
		</div>
		<div class="row mt-4">
			<div class="col-12">
				<?php if (!isset($_SESSION['custom_users_fields'])): ?>
				<h4><?= LANG['empty_table'] ?></h4>
				<?php else: ?>
					<?php $users_array = $sudo_m->datareport('users'); ?>
					<?php if ($users_array): ?>
					<?php
					$users_indexes = [];
					foreach ($users_array as $key => $value) { $users_indexes[] = $key; }
					$datable = [];
					foreach ($_SESSION['custom_users_fields'] as $field) {
						if (in_array($field, $users_indexes)) {
							$datable['fields'][] = $field;
							$datable[$field] = $users_array[$field];
						}
					}
					?>
					<?php if (!empty($datable)): ?>
						<table class="table table-bordered table-striped">
							<thead>
								<tr><?php foreach ($datable['fields'] as $val){ ?><th><?= $val ?></th><?php } ?></tr>
							</thead>
							<tbody>
								<?php foreach ($datable[$datable['fields'][0]] as $key => $value): ?>
								<tr>
									<?php foreach ($datable['fields'] as $field): ?>
										<?php if ($field != 'fields'): ?>
											<?php if ($field == 'imagen'): ?>
												<td><img src='data:image/png;base64,<?= base64_encode($datable[$field][$key]) ?>' width='50' alt='User profile picture'></td>
											<?php else: ?>
												<td><?= $datable[$field][$key] ?></td>
											<?php endif ?>
										<?php endif ?>
									<?php endforeach ?>
								</tr>
								<?php endforeach ?>
							</tbody>
						</table>
					<?php else: ?>
					<h4><?= LANG['empty_table'] ?></h4>
					<?php endif ?>
					<?php else: ?>
					<h4><?= LANG['empty_table'] ?></h4>
					<?php endif ?>
				<?php endif ?>
			</div>
		</div>
</html>