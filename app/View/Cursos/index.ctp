<div class="cursos index">
    <h2><?php echo __('Mantenedor de Cursos'); ?></h2>
    <table id="tablaCursos" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th><?php echo __('ID'); ?></th>
                <th><?php echo __('Nombre'); ?></th>
                <th><?php echo __('Descripción'); ?></th>
                <th><?php echo __('Fecha de Inicio'); ?></th>
                <th><?php echo __('Fecha de Fin'); ?></th>
                <th><?php echo __('Acciones'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cursos as $curso): ?>
            <tr>
                <td><?php echo h($curso['Curso']['id']); ?></td>
                <td><?php echo h($curso['Curso']['nombre']); ?></td>
                <td><?php echo h($curso['Curso']['descripcion']); ?></td>
                <td><?php echo h($curso['Curso']['fecha_inicio']); ?></td>
                <td><?php echo h($curso['Curso']['fecha_fin']); ?></td>
                <td>
                    <?php echo $this->Html->link(__('Editar'), array('action' => 'editar', $curso['Curso']['id']), array('class' => 'btn btn-warning')); ?>
                    <?php echo $this->Form->postLink(__('Eliminar'), array('action' => 'eliminar', $curso['Curso']['id']), array('class' => 'btn btn-danger'), __('¿Estás seguro de eliminar el curso %s?', $curso['Curso']['nombre'])); ?>
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
    $('#tablaCursos').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/Spanish.json"
        },
        "searching": true, // Habilitar el buscador
        "paging": true, // Habilitar paginación
        "ordering": true, // Habilitar ordenamiento
        "info": true // Mostrar información de la tabla
    });
    
});
</script>