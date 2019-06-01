<?php
/**
 * Created by PhpStorm.
 * User: Sony
 * Date: 18/05/2019
 * Time: 16:53
 */

namespace App\Controller\Admin;


use App\Entity\Audit;
use App\Entity\GeneralImp;
use App\Form\GeneralImpType;
use App\Form\GenrEmpType;
use App\Repository\GeneralImpRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GeneralImpController extends AbstractController
{

	/**
	 * @var GeneralImpRepository
	 */
	private $repository;
	/**
	 * @var ObjectManager
	 */
	private $em;
	/**
	 * @var \Twig_Environment
	 */
	private $twig;

	public function __construct(GeneralImpRepository $repository, ObjectManager $em, \Twig_Environment $twig)
	{
		$this->repository = $repository;
		$this->em = $em;
		$this->twig = $twig;
	}


	/**
	 * @Route("/admin/generalimp", name="admin_generalimp_index")
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function index()
	{
		$genralimps = $this->repository->findAll();
		return $this->render('Admin/GeneralImp/index.html.twig', compact('genralimps'));
	}


	/**
	 * @Route("/admin/generalimp/profile/{slug}.{id}", name="genimp_show", requirements={"slug": "[a-z0-9\-]*"})
	 * @param GeneralImp $generalImp
	 * @param string $slug
	 * @return Response
	 */
	public function show(GeneralImp $generalImp, string $slug): Response
	{
		if ($generalImp->getSlug() !== $slug) {
			return $this->redirectToRoute('genimp_show', [
				'id' => $generalImp->getId(),
				'slug' => $generalImp->getSlug()
			], 301);
		}

		return $this->render('Admin/GeneralImp/show.html.twig', [
			'generalimp' => $generalImp,
			'audits' => $generalImp->getGeneralimpaudit(),

			'current_menu' => 'audit'

		]);
	}


	/**
	 * @Route("/admin/generalimp/create/{title}", name="admin_generalimp_new")
	 */
	public function new(Request $request, $title)
	{
		$generalimp = new GeneralImp();
		$form = $this->createForm(GenrEmpType::class, $generalimp);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$generalimp->setTitlegeneralimp('General Impression');
			$generalimp->setGeneralimpaudit($this->em->getRepository(Audit::class)->findOneBy(array("Title" => $title)));


			$this->em->persist($generalimp);
			$this->em->flush();
			$this->addFlash('success', 'General Impression Created');

			return $this->redirectToRoute('genimp_show', [
				'id' => $generalimp->getId(),
				'slug' => $generalimp->getSlug()
			], 301);
		}
		return $this->render('Admin/GeneralImp/edit.html.twig', [
			'generalimp' => $generalimp,
			'form' => $form->createView()
		]);
	}

	/**
	 * @Route("/generalimp/delete/{id}", name="admin_generalim_delete", methods="DELETE")
	 * @param GeneralImp $generalImp
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse
	 */
	public function delete(GeneralImp $generalImp, Request $request)
	{
		if ($this->isCsrfTokenValid('delete' . $generalImp->getId(), $request->get('_token')))
		{
			$this->em->remove($generalImp);
			$this->em->flush();
			$this->addFlash('success','General Impresison removed' );

		}

		return $this->render('pages/accessdenied.html.twig');

//		return $this->redirect('pages/accessdenied.html.twig');
	}

	/**
	 * @Route("/admin/generalimp/edit/{id}", name="admin_generalimp_edit")
	 * @return Response
	 */
	public function edit(GeneralImp $generalImp, Request $request)
	{
		$form =$this->createForm(GenrEmpType::class, $generalImp);

		$form->handleRequest($request);

		if($form->isSubmitted() && $form->isValid())
		{
			$this->em->flush();
			$this->addFlash('success','General Impression Edited' );
			return $this->redirectToRoute('genimp_show', [
				'id' => $generalImp->getId(),

				'slug' => $generalImp->getSlug()
			], 301);
		}

		return $this->render('Admin/GeneralImp/edit.html.twig',  [
			'generalimp' => $generalImp,
			'audits' => $generalImp->getGeneralimpaudit(),

			'form' => $form->createView() ]);
	}


}