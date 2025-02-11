<div class="cursos index">
    <h2><?php echo __('Mis Cursos'); ?></h2>
    <?php if (!empty($cursos)): ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th><?php echo $this->Paginator->sort('nombre', 'Nombre del Curso'); ?></th>
                    <th><?php echo $this->Paginator->sort('descripcion', 'Descripción'); ?></th>
                    <th><?php echo $this->Paginator->sort('fecha_inicio', 'Fecha de Inicio'); ?></th>
                    <th><?php echo $this->Paginator->sort('fecha_fin', 'Fecha de Fin'); ?></th>
                    <th class="actions"><?php echo __('Acciones'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cursos as $curso): ?>
                    <tr>
                        <td><?php echo h($curso['Curso']['nombre']); ?></td>
                        <td><?php echo h($curso['Curso']['descripcion']); ?></td>
                        <td><?php echo h($curso['Curso']['fecha_inicio']); ?></td>
                        <td><?php echo h($curso['Curso']['fecha_fin']); ?></td>
                        <td class="actions">
                            <?php echo $this->Html->link(
                                '<span class="glyphicon glyphicon-eye-open"></span> Ver',
                                array('action' => 'vercurso', $curso['Curso']['id']),
                                array('class' => 'btn btn-primary btn-sm', 'escape' => false)
                            ); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info">
            <p><?php echo __('No estás inscrito en ningún curso.'); ?></p>
        </div>
    <?php endif; ?>
</div>