<body>
	<?php echo mensajes::getFlash(); ?>	
	<div id="content">
		<?php echo migas::getMigas(); ?>
		
		<!--<h1>Validar excel</h1>-->

		<form name="form_generador_validar" method="post" action="index.php?c=generador&e=generarImagenes" id="form_generador_validar">

		<div style="text-align:center"><input type="submit" name="generar" value="Generar imágenes" /></div>

		<table id="tab_generador_validar">
			<thead>
				<tr>
					<th><input type="checkbox" name="todos" id="todos" checked /></th>
					<th>Nombre y apellidos</th>
					<th>Cargo</th>
					<th>Funcion</th>
					<th>Dirección postal</th>
					<th>Teléfono</th>
					<th>Fax</th>
					<th>Móvil</th>
					<th>Ext</th>
					<th>Correo electrónico</th>
					<th>Web corporativa</th>
					<th>Aviso legal</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($var['excel'] AS $id => $excel): ?>
				<tr>
					<td><input type="checkbox" name="empleados[]" value="<?php echo $id; ?>" checked /></td>
					<td><?php echo $excel['Nombre']; ?></td>
					<td><?php echo $excel['Cargo']; ?></td>
					<td><?php echo $excel['Funcion']; ?></td>
					<td><?php echo $excel['Direccion']; ?></td>
					<td><?php echo $excel['Telefono']; ?></td>
					<td><?php echo $excel['Fax']; ?></td>
					<td><?php echo $excel['Movil']; ?></td>
					<td><?php echo $excel['Ext']; ?></td>
					<td><?php echo $excel['Email']; ?></td>
					<td><?php echo $excel['Web']; ?></td>
					<td><?php echo $excel['Aviso']; ?></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>

		</form>

	</div>
</body>