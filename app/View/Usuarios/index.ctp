<div class="usuarios index">
    <h2><?php echo __('Mantenedor de Usuarios'); ?></h2>
   
    <table id="tablaUsuarios" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th><?php echo __('ID'); ?></th>
                <th><?php echo __('Email'); ?></th>
                <th><?php echo __('Nombre'); ?></th>
                <th><?php echo __('Perfil'); ?></th>
                <th><?php echo __('Activo'); ?></th>
                <th><?php echo __('Acciones'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $usuario): ?>
            <tr>
                <td><?php echo h($usuario['Usuario']['id']); ?></td>
                <td><?php echo h($usuario['Usuario']['email']); ?></td>
                <td><?php echo h($usuario['Usuario']['nombre']); ?></td>
                <td><?php echo h($usuario['Usuario']['perfil']); ?></td>
                <td><?php echo h($usuario['Usuario']['activo'] ? 'Sí' : 'No'); ?></td>
                <td>
                    <?php echo $this->Html->link(__('Editar'), array('action' => 'editar', $usuario['Usuario']['id']), array('class' => 'btn btn-warning')); ?>
                    <?php echo $this->Form->postLink(__('Eliminar'), array('action' => 'eliminar', $usuario['Usuario']['id']), array('class' => 'btn btn-danger'), __('¿Estás seguro de eliminar a %s?', $usuario['Usuario']['email'])); ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
   
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
        <li><?php echo $this->Html->link('Nuevo Curso', array('controller' => 'cursos', 'action' => 'agregar')); ?></li>
        <li><?php echo $this->Html->link(__('Lista Cursos'), array('controller' => 'cursos', 'action' => 'index')); ?> </li>

		<li><?php echo $this->Html->link(__('Lista Usuarios'), array('controller' => 'usuarios', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nuevo Usuario'), array('controller' => 'usuarios', 'action' => 'agregar')); ?> </li>
	</ul>
</div>
<script>
$(document).ready(function() {
    var table = $('#tablaUsuarios').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/Spanish.json"
        },
        "searching": true, // Habilitar el buscador
        "paging": true, // Habilitar paginación
        "ordering": true, // Habilitar ordenamiento
        "info": true // Mostrar información de la tabla
    });

    // Conectar el input personalizado a DataTables
    $('#buscadorUsuarios').on('keyup', function() {
        table.search(this.value).draw();
    });
});
</script>