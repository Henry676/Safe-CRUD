<?php
    include("conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
	<title>Datos de empleados</title>
 
	<!-- Bootstrap -->
	<link href="../../css/bootstrap.css" rel="stylesheet">
	<!--<link href="css/style_nav.css" rel="stylesheet">-->
 
	<style>
		.content {
			margin-top: 80px;
		}
	</style>
 
</head>
<body>
	<?php include('nav.php');?>
	<div class="container">
		<div class="content">
			<h2>Lista de empleados</h2>
			<hr />
 
			<?php
			if(isset($_GET['aksi']) == 'delete'){
				// escaping, additionally removing everything that could be (html/javascript-) code
				$nik = mysqli_real_escape_string($con,(strip_tags($_GET["nik"],ENT_QUOTES)));
				$cek = mysqli_query($con, "SELECT * FROM empleados WHERE codigo='$nik'");
				if(mysqli_num_rows($cek) == 0){
					echo '<div class="alert alert-info alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> No se encontraron datos.</div>';
				}else{
					$delete = mysqli_query($con, "DELETE FROM empleados WHERE codigo='$nik'");
					if($delete){
						echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Datos eliminado correctamente.</div>';
					}else{
						echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Error, no se pudo eliminar los datos.</div>';
					}
				}
			}
			?>
 
			<form class="form-inline" method="get">
				<div class="form-group">
					<select name="filter" class="form-control" onchange="form.submit()">
						<option value="0">Filtros de datos de empleados</option>
						<?php $filter = (isset($_GET['filter']) ? strtolower($_GET['filter']) : NULL);  ?>
						<option value="1" <?php if($filter == 'Tetap'){ echo 'selected'; } ?>>Fijo</option>
						<option value="2" <?php if($filter == 'Kontrak'){ echo 'selected'; } ?>>Contratado</option>
                        <option value="3" <?php if($filter == 'Outsourcing'){ echo 'selected'; } ?>>Outsourcing</option>
					</select>
				</div>
			</form>
			<br />
			<div class="table-responsive">
			<table class="table table-striped table-hover">
				<tr>
                    <th>No</th>
					<th>Código</th>
					<th>Nombre</th>
					<th>Correo</th>
					<th>Contraseña</th>
                    <th>Lugar de nacimiento</th>
                    <th>Fecha de nacimiento</th>
					<th>Teléfono</th>
					<th>Cargo</th>
					<th>Estado</th>
                    <th>Acciones</th>
				</tr>
				<?php
				if($filter){
					$sql = mysqli_query($con, "SELECT * FROM empleados ORDER BY codigo ASC");
				}else{
					$sql = mysqli_query($con, "SELECT * FROM empleados ORDER BY codigo ASC");
				}
				if(mysqli_num_rows($sql) == 0){
					echo '<tr><td colspan="11">No hay datos.</td></tr>';
				}else{
					$no = 1;
					while($row = mysqli_fetch_assoc($sql)){
						echo '
						<tr>
							<td>'.$no.'</td>
							<td>'.$row['codigo'].'</td>
							<td><a href="profile.php?nik='.$row['codigo'].'"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> '.$row['nombres'].'</a></td>
							<td>'.$row['email'].'</td>
							<td>********</td> <!-- Ocultamos la contraseña por seguridad -->
                            <td>'.$row['lugar_nacimiento'].'</td>
                            <td>'.$row['fecha_nacimiento'].'</td>
							<td>'.$row['telefono'].'</td>
                            <td>'.$row['puesto'].'</td>
							<td>';
							if($row['estado'] == '1'){
								echo '<span class="label label-success">Fijo</span>';
							}
                            else if ($row['estado'] == '2' ){
								echo '<span class="label label-info">Contratado</span>';
							}
                            else if ($row['estado'] == '3' ){
								echo '<span class="label label-warning">Outsourcing</span>';
							}
						echo '
							</td>
							<td>
 
								<a href="edit.php?nik='.$row['codigo'].'" title="Editar datos" class="btn btn-primary btn-sm"><i class="bi bi-person-badge-fill	" role="img" aria-label="GitHub"></i></a>
								<a href="index.php?aksi=delete&nik='.$row['codigo'].'" title="Eliminar" onclick="return confirm(\'Esta seguro de borrar los datos '.$row['nombres'].'?\')" class="btn btn-danger btn-sm"><i class="bi bi-x-circle" role="img" aria-label="GitHub"></i></a>
								<a href="roles.php?nik='.$row['codigo'].'" title="Asignar roles" class="btn btn-dark btn-sm"><i class="bi bi-key-fill" role="img" aria-label="GitHub"></i></a>

							</td>
						</tr>
						';
						$no++;
					}
				}
				?>
			</table>
			</div>
		</div>
	</div><center>
	<p>&copy; Sistemas Web <?php echo date("Y");?></p
		</center>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="../../js/bootstrap.min.js"></script>
</body>
</html>