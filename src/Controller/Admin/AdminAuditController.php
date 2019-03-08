<?php
/**
 * Created by PhpStorm.
 * User: Sony
 * Date: 27/02/2019
 * Time: 22:20
 */

namespace App\Controller\Admin;


use App\Entity\Audit;
use App\Entity\Organisation;
use App\Form\AuditType;
use App\Repository\AuditRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminAuditController extends AbstractController
{

	/**
	 * @var AuditRepository
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

	public function __construct(AuditRepository $repository, ObjectManager $em, \Twig_Environment $twig)
	{
		$this->repository = $repository;
		$this->em = $em;
		$this->twig = $twig;
	}


	/**
	 * @Route("/admin/audit", name="admin.auditlist.index")
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function index()
	{
		$audits = $this->repository->findAll();
		return $this->render('Admin/Audit/index.html.twig', compact('audits'));
	}





	/**
	 * @Route("/admin/audit/{slug}.{id}", name="audit.show", requirements={"slug": "[a-z0-9\-]*"})
	 * @param Audit $audit
	 * @return Response
	 */
	public function show(Audit $audit, string $slug):Response
	{
		if ($audit->getSlug() !== $slug)
		{
			return $this->redirectToRoute('audit.show', [
				'id' => $audit->getId(),
				'slug' => $audit->getSlug()
			], 301);
		}

		return $this->render('Admin/Audit/show.html.twig', [
			'audits' => $audit,
			'current_menu' => 'audit'

		]);
}


	/**
	 * @Route("/admin/audit/create", name="admin.audit.new")
	 */
	public function new(Request $request)
	{
		$audit = new Audit();
		$form = $this->createForm(AuditType::class, $audit);
		$form->handleRequest($request);

		if($form->isSubmitted() && $form->isValid())
		{
			$this->em->persist($audit);
			$this->em->flush();
			$this->addFlash('success','Audit Created' );

			return $this->redirectToRoute('admin.auditlist.index');
		}
		return $this->render('Admin/Audit/edit.html.twig',  [
			'audit' => $audit,
			'form' => $form->createView()
		]);
	}



	/**
	 * @Route("/admin/audit/{id}", name="admin.audit.delete", methods="DELETE")
	 * @param Audit $audit
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse
	 */
	public function delete(Audit $audit, Request $request)
	{
		if ($this->isCsrfTokenValid('delete' . $audit->getId(), $request->get('_token')))
		{
			$this->em->remove($audit);
			$this->em->flush();
			$this->addFlash('success','Audit removed' );

		}


		return $this->redirectToRoute('admin.auditlist.index');
	}


	/**
	 * @Route("/admin/audit/{id}", name="admin.audit.edit")
	 * @param Audit $audit
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function edit(Audit $audit, Request $request)
	{
		$form =$this->createForm(AuditType::class, $audit);

		$form->handleRequest($request);

		if($form->isSubmitted() && $form->isValid())
		{
			$this->em->flush();
			$this->addFlash('success','Audit  Edited' );
			return $this->redirectToRoute('admin.auditlist.index');
		}

		return $this->render('Admin/Audit/edit.html.twig',  [
			'audit' => $audit,
			'form' => $form->createView() ]);
	}









}