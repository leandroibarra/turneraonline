<?php
App::uses( 'AppController', 'Controller' );
App::uses( 'Folder'       , 'Utility'    );
App::uses( 'File'         , 'Utility'    );
/**
 * ObrasSociales Controller
 *
 *
 */
class ObrasSocialesController extends AppController {

   /**
    * Modelos usados
    * @property ObraSocial $ObrasSocial
    */
	public $uses = 'ObraSocial';

   /**
    * Funcion llamada inicialmente
    * Setea los permisos de los métodos públicos
    * @return void
    */
	public function beforeFilter() {
		$this->Auth->allow( array( 'index', 'view' ) );
		AppController::beforeFilter();
	}

   /**
    * Función llamada para autorizar el uso de un método específico
    * @param $usario Usuario actual
    * @return bool Verdadero si tiene permisos o falso en caso contrario
    */
	public function isAuthorized( $usuario = null ) {
		switch( $usuario['grupo_id'] ) {
			case 1: // Administradores
			{
				return true;
				break;
			}
			case 2: // Médicos
			case 3: // Secretarias
			case 4: // Usuario normal
			{
				switch( $this->request->params['action'] ) {
					case 'administracion_index':
					case 'administracion_edit':
					case 'administracion_add':
					case 'administracion_delete':
					case 'administracion_view':
					{ return true; break; }
					default:
					{ return false; break; }
				}
				break;
			}
		}
		return false;
	}

	/**
	 * index method
	 *
	 * @return void
	 * @author Esteban Zeller
	 */
	public function index() {
		$this->ObraSocial->recursive = 0;
		$this->set('obrasSociales', $this->ObraSocial->find( 'all' ) );
	}

	/**
	 * view method
	 *
	 * @param string $id Identificador de la obra social
	 * @return void
	 */
	public function view($id = null) {
		$this->ObraSocial->id = $id;
		if (!$this->ObraSocial->exists()) {
			throw new NotFoundException(__('Invalid obras sociale'));
		}
		$this->set('obrasSociale', $this->ObraSocial->read(null, $id));
	}

	/**
	 * administracion_index method
	 *
	 * @return void
	 */
	public function administracion_index() {
		$this->layout = 'administracion';
		$this->ObraSocial->recursive = 0;
		$this->set('obrasSociales', $this->paginate());
	}

	/**
	 * administracion_view method
	 *
	 * @param string $id Identificador de la obra social
	 * @return void
	 */
	public function administracion_view($id = null) {
		$this->layout = 'administracion';
		$this->ObraSocial->id = $id;
		if (!$this->ObraSocial->exists()) {
			throw new NotFoundException( 'Obra social invalida' );
		}
		$this->set( 'obrasSociale', $this->ObraSocial->read( null, $id ) );
	}

	/**
	 * administracion_add method
	 *
	 * @return void
	 */
	public function administracion_add() {
		$this->layout = 'administracion';
		if ($this->request->is('post')) {
			$this->ObraSocial->create();
			if ($this->ObraSocial->save($this->request->data)) {
				$this->Session->correcto( 'La nueva obra social ha sido guardada correctamente.' );
				$this->redirect( array( 'action' => 'index' ) );
			} else {
				$this->Session->incorrecto( 'La obra social no pudo ser guardada. Verifique los datos ingresados e intente nuevamente.' );
			}
		}
	}

	/**
	 * administracion_edit method
	 *
	 * @param string $id
	 * @return void
	 */
	public function administracion_edit($id = null) {
		$this->layout = 'administracion';
		$this->ObraSocial->id = $id;
		if (!$this->ObraSocial->exists()) {
			throw new NotFoundException( 'Obra social inválida' );
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->ObraSocial->save($this->request->data)) {
				$this->Session->correcto( 'La obra social ha sido modificada correctamente.' );
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->correcto( 'Los datos no pudieron ser modificados. Intente nuevamente' );
			}
		} else {
			$this->request->data = $this->ObraSocial->read(null, $id);
		}
	}

	/**
	 * administracion_delete method
	 *
	 * @param string $id
	 * @return void
	 */
	public function administracion_delete($id = null) {
		$this->layout = 'administracion';
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->ObraSocial->id = $id;
		if (!$this->ObraSocial->exists()) {
			throw new NotFoundException( 'La obra social no existe' );
		}
		$this->loadModel( 'Usuario' );
		if( $this->Usuario->find( 'count', array( 'conditions' => array( 'obra_social_id' => $id ) ) ) > 0 ) {
			$this->Session->peligro( "Existe algún paciente con esta obra social. No se eliminará" );
			$this->redirect( array( 'action' => 'index' ) );
		}
		if ($this->ObraSocial->delete()) {
			$this->Session->correcto( 'Se eliminó correctamente la obra social' );
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->incorrecto( 'La obra social no se pudo eliminar' );
		$this->redirect( array( 'action' => 'index' ) );
	}
}
