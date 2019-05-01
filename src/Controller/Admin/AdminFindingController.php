<?php
/**
 * Created by PhpStorm.
 * User: Sony
 * Date: 31/03/2019
 * Time: 16:11
 */

namespace App\Controller\Admin;


use App\Entity\Audit;
use App\Entity\Finding;
use App\Form\FindingType;
use App\Repository\FindingRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminFindingController extends AbstractController
{


	/**
	 * @var FindingRepository
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

	public function __construct(FindingRepository $repository, ObjectManager $em, \Twig_Environment $twig)
	{


		$this->repository = $repository;
		$this->em = $em;
		$this->twig = $twig;
	}


	/**
	 * @Route("/finding", name="admin.findinglist.index")
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function index()
	{
		$findings = $this->repository->findAll();
		return $this->render('Admin/Finding/index.html.twig', compact('findings'));
	}

	/**
	 * @Route("/finding/profile/{slug}.{id}", name="finding_show", requirements={"slug": "[a-z0-9\-]*"})
	 * @param Finding $finding
	 * @return Response
	 */
	public function show(Finding $finding, string $slug):Response
	{
		if ($finding->getSlug() !== $slug)
		{
			return $this->redirectToRoute('finding_show', [
				'id' => $finding->getId(),
				'slug' => $finding->getSlug(),
				'audits' => $finding->getAuditInFinding()


			], 301);
		}
//		dump($finding->getAuditInFinding());
//		die();

		return $this->render('Admin/Finding/show.html.twig', [
			'finding' => $finding,
			'audits' => $finding->getAuditInFinding(),

			'current_menu' => 'audit',


		]);

	}

	/**
	 * @Route("/finding/create/{title}", name="admin_finding_new")
	 */
	public function new(Request $request, $title)
	{
		$finding = new Finding();
		$form = $this->createForm(FindingType::class, $finding);
		$form->handleRequest($request);

		if($form->isSubmitted() && $form->isValid())
		{
			$finding->setAuditInFinding($this->em->getRepository(Audit::class)->findOneBy(array("Title" => $title)));

			$this->em->persist($finding);
			$this->em->flush();
			$msgAddCert = $this->addFlash('success','Finding Created' );

			$id = $finding->getId();
			$slug = $finding->getSlug();

			return $this->redirectToRoute('finding_show', array("id" => $id, "slug"=> $slug, "success" => $msgAddCert ));
		}
		return $this->render('Admin/Finding/edit.html.twig',  [
			'finding' => $finding,
			'form' => $form->createView()
		]);
	}


	/**
	 * @Route("/finding/edit/{id}", name="admin_finding_edit")
	 * @param Finding $finding
	 * @param Request $request
	 * @return Response
	 */
	public function edit(Finding $finding, Request $request)
	{
		$form =$this->createForm(FindingType::class, $finding);

		$form->handleRequest($request);

		if($form->isSubmitted() && $form->isValid())
		{
			$this->em->flush();
			$this->addFlash('success','Finding Edited' );
			return $this->redirectToRoute('admin.findinglist.index');
		}

		return $this->render('Admin/Finding/edit.html.twig',  [
			'finding' => $finding,
			'audits' => $finding->getAuditInFinding(),
			'form' => $form->createView() ]);
	}

	/**
	 * @Route("/finding/delete/{id}", name="admin_finding_delete", methods="DELETE")
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse
	 */
	public function delete(Finding $finding, Request $request)
	{
		if ($this->isCsrfTokenValid('delete' . $finding->getId(), $request->get('_token')))
		{
			$this->em->remove($finding);
			$this->em->flush();
			$this->addFlash('success','Finding  removed' );

		}


		return $this->redirectToRoute('admin.findinglist.index');
	}



}