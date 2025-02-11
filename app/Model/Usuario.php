<?php
App::uses('AppModel', 'Model');
/**
 * Usuario Model
 *
 * @property Curso $Curso
 */
class Usuario extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */

 public $name = 'Usuario';

 // Campos que se recuperarán durante la autenticación
 public $authFields = array('id', 'nombre', 'email', 'perfil', 'activo');

 public function beforeFind($queryData) {
	 // Asegurarse de que se recuperen todos los campos necesarios
	 if (isset($queryData['conditions']['Usuario.email'])) {
		 $queryData['fields'] = $this->authFields;
	 }
	 return $queryData;
 }
 public function find($type = 'first', $query = array()) {
    if ($type == 'first' && isset($query['conditions']['Usuario.email'])) {
        $query['fields'] = $this->authFields;
    }
    return parent::find($type, $query);
}
 
	public $validate = array(
		'email' => array(
			'email' => array(
				'rule' => array('email'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'isUnique' => array(
                'rule' => 'isUnique',
                'message' => 'Este email ya está registrado. Intente con otro.'
            )
		),
		'password' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'activo' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	public function getRoleByEmail($email) {
		
		return $this->field('perfil', array('email' => $email));
	}
	public function getIdByEmail($email) {
		
		return $this->field('id', array('email' => $email));
	}

	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Curso' => array(
			'className' => 'Curso',
			'joinTable' => 'usuarios_cursos',
			'foreignKey' => 'usuario_id',
			'associationForeignKey' => 'curso_id',
			'unique' => 'true',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		)
	);


	public function paginateCount($conditions = null, $recursive = 0, $extra = array()) {
		return $this->find('count', compact('conditions', 'recursive'));
	}

}
