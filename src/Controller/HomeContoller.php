<?php
/**
 * Created by PhpStorm.
 * User: Sony
 * Date: 24/02/2019
 * Time: 14:17
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class HomeContoller extends AbstractController
{

	/**
	 * @var Environment
	 */
	private $twig;

	public function __construct(Environment $twig)
{
	$this->twig = $twig;
}

	/**
	 * @Route("/", name="home")
	 * @return Response
	 */
public function index(): Response
{
	return $this->render('pages/home.html.twig');
}


}