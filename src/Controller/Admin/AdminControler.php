<?php
/**
 * Created by PhpStorm.
 * User: Sony
 * Date: 24/02/2019
 * Time: 17:58
 */

namespace App\Controller\Admin;


use App\Entity\CB;
use App\Form\CbType;
use App\Repository\CBRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminControler extends AbstractController
{


	/**
	 * @var CBRepository
	 */
	private $repository;
	/**
	 * @var ObjectManager
	 */
	private $em;

	public function __construct(CBRepository $repository, ObjectManager $em)
	{
		$this->repository = $repository;
		$this->em = $em;
	}


	/**
	 * @Route("/admin/cb", name="admin.cblist.index")
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function index()
	{
		$cbs = $this->repository->findAll();
		return $this->render('Admin/CB/index.html.twig', compact('cbs'));
	}

	/**
	 * @Route("/admin/{id}", name="admin.cb.edit")
	 * @param CB $cb
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function edit(CB $cb)
	{
		$form =$this->createForm(CbType::class, $cb);
		return $this->render('Admin/CB/edit.html.twig',  [
			'property' => $cb,
			'form' => $form->createView() ]);
	}




}