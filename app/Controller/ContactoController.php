<?php

App::import( 'Utility', 'Validation' );
App::uses('CakeEmail', 'Network/Email');

class ContactoController extends AppController {

	public function beforeFilter() {
    	$this->Auth->allow(array('formulario'));
		parent::beforeFilter();
    }

	public function formulario() {}

	public function enviar() {
		if( $this->request->isPost() ) {
			// Verifico la dirección de email
			if( !Validation::email( $this->request->data['contacto']['email'], true ) ) {
				$this->Session->incorrecto( "La dirección de email ingresado no es válida." );
				$this->redirect( array( 'action' => 'formulario' ) );
			} else {
				$email = new CakeEmail();
				$email->from( array( $this->request->data['contacto']['email'] => $this->request->data['contacto']['nombre'] ) );
				$email->to('esteban.zeller@gmail.com');
				$email->subject( 'Contacto de turnosonline' );
				$email->send('Ha tenido un nuevo contacto a través del sitio de turnosonline: \n'.$this->request->data['contacto']['texto'] );
				$this->Session->correcto( "Su mensaje ha sido enviado correctamente. Gracias por contactarse con nosotros!" );
				$this->redirect( '/' );
			}
		} else {
			throw new NotFoundException( "Metodo de envío no encontrado" );
		}
	}

    public function administracion_error() {
    	$this->layout = 'administracion';
        if( $this->request->isPost() ) {
            // Verifico la dirección de email
            if( !empty( $this->request->data['contacto']['email'] ) && !Validation::email( $this->request->data['contacto']['email'], true ) ) {
                $this->Session->incorrecto( "La dirección de email ingresado no es válida." );
                $this->redirect( array( 'action' => 'formulario' ) );
            } else {
                $email = new CakeEmail();
                if( empty( $this->request->data['contacto']['email'] ) ) {
                    $email->from( array( 'noreply@turnossantafe.com.ar' => "No responder!" ) );
                } else {
                    $email->from( array( $this->request->data['contacto']['email'] => $this->request->data['contacto']['nombre'] ) );
                }
                $email->to('esteban.zeller@gmail.com');
                $email->subject( 'Informe de error de turnosonline' );
                $texto = 'Ha tenido un nuevo contacto a través del sitio de turnosonline: \n'
                             .$this->request->data['contacto']['descripcion_corta'].' \n'
                             .$this->request->data['contacto']['detalle'].' \n';
				$email->send($texto);
                $this->Session->correcto( "Su mensaje ha sido enviado correctamente. Gracias por contactarse con nosotros!" );
                $this->redirect( array( 'controller' => 'usuarios', 'action' => 'cpanel' ) );
            }
        }
		// Averiguo el referer
		$this->set( 'direccion_error', $this->referer() );
    }

    public function administracion_sugerencia() {
    	$this->layout = 'administracion';
        if( $this->request->isPost() ) {
            $email = new CakeEmail();
			$user = $this->Auth->user();
            $email->from( array( $user['email'] => $user['razonsocial'] ) );
            $email->to('esteban.zeller@gmail.com');
            $email->subject( 'Nueva sugerencia para turnosonline' );
            $texto = 'Ha tenido un nuevo contacto a través del sitio de turnosonline: \n'
                         .$this->request->data['contacto']['descripcion_corta'].'\n\n'
                         .$this->request->data['contacto']['detalle'].'\n'
                         .'Deseo mantenerme informado de este error: ';
            if( $this->request->data['contacto']['contactar'] == 1 ) {
                $texto .= " Si.\n";
                $texto .= " Nombre y direccion: ".$user['razonsocial']." - ".$user['email'];
            } else {
                $texto .= " No.";
            }
            $email->send( $texto );
            $this->Session->correcto( "Su mensaje ha sido enviado correctamente. Gracias por contactarse con nosotros!" );
            $this->redirect( array( 'controller' => 'usuarios', 'action' => 'cpanel' ) );
        }
    }

}
?>