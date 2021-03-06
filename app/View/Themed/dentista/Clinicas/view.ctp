<?php $this->set( 'title_for_layout', 'Informacion de '.$clinica['Clinica']['nombre'] ); ?>
<div class="decorado2 index">
	<div class="titulo1">Informacion de <?php echo $clinica['Clinica']['nombre']; ?></div><br />
	<dl>
		<dt>Nombre</dt>
		<dd>
			<?php echo h($clinica['Clinica']['nombre']); ?>
			&nbsp;
		</dd>
		<dt>Direcci&oacute;n</dt>
		<dd>
			<?php echo h($clinica['Clinica']['direccion']); ?>
			&nbsp;
		</dd>
		<?php if( !empty( $clinica['Clinica']['email'] ) )  {?>
		<dt>Email:</dt>
		<dd>
			<?php echo $this->Html->link( h($clinica['Clinica']['email']), h($clinica['Clinica']['email']) ); ?>
			&nbsp;
		</dd>
		<?php } 
		if( !empty( $clinica['Clinica']['telefono'] ) )  {?>
		<dt>Tel&eacute;fono:</dt>
		<dd>
			<?php echo h($clinica['Clinica']['telefono']); ?>
			&nbsp;
		</dd>
		<?php } ?>
		<dt>Consultorios</dt>
		<dd>
			<?php
			foreach( $clinica['Consultorios'] as $consultorio ) {
				 echo h( $consultorio['nombre'] ).  "\n" ;
			} ?>
			&nbsp;
		</dd>
	</dl>
	<table>
	 <tbody>
	  <tr>
	<?php
	if( isset( $clinica['Medicos'] ) && !empty( $clinica['Medicos'] ) ) {
	?>
	   <td>
		<div class="titulo2">Medicos que atienden en esta clinica</div>
			<table>
			 <tbody>
			<?php
				foreach( $clinica['Medicos'] as $medico ) {
					echo "<tr><td>";
					//echo h( $medico['id_medico'] );
					echo "nombre del medico aqui";
					echo "</tr></td>";
				}
			?>
			 </tbody>
			</table>
	   </td>
	<?php
	}
	if( isset( $clinica['Especialidades'] ) && !empty( $clinica['Especialidades'] )	 ) {
	?>
	   <td>
		<div class="titulo2">Especialidades Disponibles</div>
			<table>
			 <tbody>
			<?php
				foreach( $clinica['Especialidades'] as $especialidad ) {
					echo "<tr><td>";
					echo h( $especialidad['Especialidad']['nombre'] );
					echo "</tr></td>";
				}
			?>
			 </tbody>
			</table>
	   </td>
	<?php } ?>
	  </tr>
	 </tbody>
	</table>
</div>
<div class="actions">
	<?php
	if( !empty( $clinica['Clinica']['logo'] ) ) {
		echo "<h3>";
		echo $this->Html->image( $clinica['Clinica']['logo'], array( 'border' => 0, 'alt' => $clinica['Clinica']['nombre'] ) );
		echo "</h3>";
	}
	?>
	<h3>Acciones</h3>
	<ul>
		<li><?php echo $this->Html->link( 'Pedir turno aqui', array( 'controller' => 'turnos', 'action' => 'nuevo' ) ); ?></li>
		<li><?php echo $this->Html->link( 'Ver todas las clinicas', array( 'controller' => 'clinicas', 'action' => 'index' ) ); ?></li>
	</ul>
</div>
<?php //pr( $clinica ); ?>
