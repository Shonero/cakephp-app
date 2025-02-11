<?php
App::uses('AppModel', 'Model');
/**
 * Curso Model
 *
 * @property Usuario $Usuario
 */
class Curso extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'nombre' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' => 'El nombre del curso es obligatorio.'
            ),
            'isUnique' => array(
                'rule' => 'isUnique',
                'message' => 'Este nombre de curso ya está registrado. Use otro nombre.'
            )
        ),
        'descripcion' => array(
            'rule' => 'notBlank',
            'message' => 'La descripción es obligatoria.'
        ),
        'fecha_inicio' => array(
            'rule' => 'date',
            'message' => 'Ingrese una fecha válida.'
        ),
        'fecha_fin' => array(
            'rule' => 'date',
            'message' => 'Ingrese una fecha válida.'
        )
    );


	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
public $hasMany = array(
	'UsuariosCurso' => array(
		'className' => 'UsuariosCurso',
		'foreignKey' => 'curso_id'
	)
);

public $hasAndBelongsToMany = array(
	'Usuario' => array(
		'className' => 'Usuario',
		'joinTable' => 'usuarios_cursos',
		'foreignKey' => 'curso_id',
		'associationForeignKey' => 'usuario_id'
	)
);

}
