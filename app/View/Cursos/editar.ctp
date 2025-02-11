
<div class="actions">
    <h3><?php echo __('Acciones'); ?></h3>
    <ul>
        <li><?php echo $this->Form->postLink(__('Eliminar Curso'), array('action' => 'eliminar', $this->Form->value('Curso.id')), array('confirm' => __('¿Estás seguro que quieres eliminar # %s?', $this->Form->value('Curso.id')))); ?></li>
        <li><?php echo $this->Html->link(__('Lista Cursos'), array('action' => 'index')); ?></li>
        <li><?php echo $this->Html->link(__('Lista Usuarios'), array('controller' => 'usuarios', 'action' => 'index')); ?></li>
        <li><?php echo $this->Html->link(__('Nuevo Usuario'), array('controller' => 'usuarios', 'action' => 'agregar')); ?></li>
    </ul>
</div>
<div class="cursos form">
    <?php echo $this->Form->create('Curso'); ?>
    <fieldset>
        <legend><?php echo __('Editar Curso'); ?></legend>
        <?php
            echo $this->Form->input('id');
            echo $this->Form->input('nombre', array('class' => 'form-control'));
            echo $this->Form->input('descripcion', array('class' => 'form-control'));
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
    <?php echo $this->Form->end(__('Guardar')); ?>



    <div class="usuarios-curso">
    <h3><?php echo __('Usuarios'); ?></h3>
    <?php if (!empty($usuarios)): ?>
        <table id="tablaUsuarios" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th><input type="checkbox" id="seleccionarTodos"></th>
                    <th><?php echo __('Nombre'); ?></th>
                    <th><?php echo __('Email'); ?></th>
                    <th><?php echo __('Inscrito'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td>
                            <?php if ($usuario['Usuario']['inscrito']): ?>
                                <input type="checkbox" class="seleccionarUsuario" name="data[Usuario][eliminar][]" value="<?php echo h($usuario['Usuario']['id']); ?>">
                            <?php else: ?>
                                <input type="checkbox" class="seleccionarUsuario" name="data[Usuario][agregar][]" value="<?php echo h($usuario['Usuario']['id']); ?>">
                            <?php endif; ?>
                        </td>
                        <td><?php echo h($usuario['Usuario']['nombre']); ?></td>
                        <td><?php echo h($usuario['Usuario']['email']); ?></td>
                        <td><?php echo $usuario['Usuario']['inscrito'] ? 'Sí' : 'No'; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button id="agregarSeleccionados"  class="btn btn-success">Agregar Seleccionados</button>
        <button id="eliminarSeleccionados" class="btn btn-danger">Eliminar Seleccionados</button>
    <?php else: ?>
        <p>No hay usuarios disponibles.</p>
    <?php endif; ?>
</div>
</div>

<script>$(document).ready(function() {
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

    // Conectar el buscador a DataTables
    $('#buscadorUsuarios').on('keyup', function() {
        table.search(this.value).draw();
    });

    // Seleccionar/Deseleccionar todos los checkboxes
    $('#seleccionarTodos').on('click', function() {
        var rows = table.rows({ 'search': 'applied' }).nodes();
        $('input[type="checkbox"]', rows).prop('checked', this.checked);
    });

    // Eliminar usuarios seleccionados
    $('#eliminarSeleccionados').on('click', function() {
        var seleccionados = $('.seleccionarUsuario:checked').map(function() {
            return $(this).val();
        }).get();

        if (seleccionados.length > 0) {
            if (confirm('¿Estás seguro de eliminar los usuarios seleccionados?')) {
                $.ajax({
                    url: '<?php echo $this->Html->url(array('action' => 'removeSelectedUsers', $curso['Curso']['id'])); ?>',
                    type: 'POST',
                    data: { usuarios: seleccionados },
                    success: function(response) {
                        location.reload(); // Recargar la página después de eliminar
                    },
                    error: function() {
                        alert('Ocurrió un error al eliminar los usuarios.');
                    }
                });
            }
        } else {
            alert('Selecciona al menos un usuario para eliminar.');
        }
    });

    // Agregar usuarios seleccionados
    $('#agregarSeleccionados').on('click', function() {
        
        var seleccionados = $('.seleccionarUsuario:checked').map(function() {
            return $(this).val();
        }).get();

        if (seleccionados.length > 0) {
            if (confirm('¿Estás seguro de agregar los usuarios seleccionados?')) {
                $.ajax({
                    url: '<?php echo $this->Html->url(array('action' => 'addSelectedUsers', $curso['Curso']['id'])); ?>',
                    type: 'POST',
                    data: { usuarios: seleccionados },
                    success: function(response) {
                        
                        location.reload(); // Recargar la página después de eliminar
                    },
                    error: function() {
                        alert('Ocurrió un error al agregar los usuarios.');
                    }
                });
            }
        } else {
            alert('Selecciona al menos un usuario para agregar.');
        }
    });
});
</script>