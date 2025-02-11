<div class="cursos form">
<?php echo $this->Form->create('Curso'); ?>
	<fieldset>
		<legend><?php echo __('Agregar Curso'); ?></legend>
	<?php
		echo $this->Form->input('nombre');
		echo $this->Form->input('descripcion');
		echo $this->Form->input('fecha_inicio', array(
			'class' => 'form-control datepicker w-25',
			'type' => 'text',
			'label' => 'Fecha de Inicio',
			'div' => array('class' => 'form-group')
		));
		echo $this->Form->input('fecha_fin', array(
			'class' => 'form-control datepicker w-25',
			'type' => 'text',
			'label' => 'Fecha de Fin',
			'div' => array('class' => 'form-group')
		));
		
	?>
	</fieldset>

	<div class="usuarios-curso">
	<h3><?php echo __('Asignar Usuarios al Curso'); ?></h3>
<table id="tablaUsuarios" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Asignar</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($usuarios as $usuarioId => $usuarioNombre): ?>
            <tr>
                <td><?php echo h($usuarioNombre); ?></td>
                <td>
                    <?php echo $this->Form->checkbox('Usuario.usuarios.' . $usuarioId, array(
                        'hiddenField' => false,
                        'value' => $usuarioId
                    )); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
	
<?php
echo $this->Form->submit('Guardar Curso y Asignar Usuarios', array('class' => 'btn btn-primary'));
echo $this->Form->end();
?>
</div>
</div>




<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Lista Cursos'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('Lista Usuarios'), array('controller' => 'usuarios', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nuevo Usuario'), array('controller' => 'usuarios', 'action' => 'agregar')); ?> </li>
	</ul>
</div>

<script>
$(document).ready(function() {
    // Inicializar el datepicker
    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd', // Formato de fecha
        language: 'es', // Idioma en español
        autoclose: true, // Cerrar automáticamente después de seleccionar una fecha
        todayHighlight: true // Resaltar la fecha actual
    });


	 // Inicializar DataTables
	 var table = $('#tablaUsuarios').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/Spanish.json"
        },
        "searching": true,
        "paging": true,
        "ordering": true,
        "info": true
    });

 
});
</script>