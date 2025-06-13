<?php 
namespace App\Controllers;

class Home extends BaseController
{
    /*public function index(): string
    {
        return view('principal.html');
    }
 */
    public function index()
	{
		echo view('head_view');
		echo view('navbar_view');
		echo view('principal_view');
		echo view('footer_view');
		
	}

	public function testdb()
{
    $db = \Config\Database::connect();
    echo $db->connect() ? '✅ ¡Conexión exitosa!' : '❌ No se pudo conectar.';
}

	
    public function quienes_somos()
	{
		echo view('head_view');
		echo view('navbar_view');
		echo view('quienes_somos');
		echo view('footer_view');
	}

	public function Contacto()
	{
		echo view('head_view');
		echo view('navbar_view');
		echo view('Contacto');
		echo view('footer_view');
	}


	
    public function Comercializacion()
	{
		echo view('head_view');
		echo view('navbar_view');
		echo view('Comercializacion');
		echo view('footer_view');
	}

	public function termino_usos()
	{
		echo view('head_view');
		echo view('navbar_view');
		echo view('termino_usos');
		echo view('footer_view');
	}

	public function Catalogo()
	{
		echo view('head_view');
		echo view('navbar_view');
		echo view('catalogo_view');
		echo view('footer_view');
	}

	public function login(){
	echo view('head_view');
    echo view('navbar_view');
    echo view('login');
    echo view('footer_view');
	}

	public function registerForm()
	{
		echo view('head_view');
		echo view('navbar_view');
		echo view('bodyregister');
		echo view('footer_view');
	}


}
