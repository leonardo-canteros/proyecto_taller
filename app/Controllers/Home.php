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
	
    public function quienes_somos()
	{
		echo view('head_view');
		echo view('navbar_view');
		echo view('quienes_somos');
		echo view('footer_view');
	}



	/*
    public function acerca_de()
	{
		echo view('front/head_view');
		echo view('front/navbar_view');
		echo view('front/acerca_de');
		echo view('front/footer_view');
	}

	public function registro()
	{
		echo view('front/head_view');
		echo view('front/navbar_view');
		echo view('front/registro');
		echo view('front/footer_view');
	}

	public function login()
	{
		echo view('front/head_view');
		echo view('front/navbar_view');
		echo view('front/login');
		echo view('front/footer_view');
	}

*/


}
