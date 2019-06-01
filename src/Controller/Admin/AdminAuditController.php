<?php
/**
 * Created by PhpStorm.
 * User: Sony
 * Date: 27/02/2019
 * Time: 22:20
 */

namespace App\Controller\Admin;


use App\Entity\Audit;
use App\Entity\AuditSearch;
use App\Entity\Organisation;
use App\Form\AuditSearchType;
use App\Form\AuditType;
use App\Repository\AuditRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
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
	 * @Route("/audit", name="admin.auditlist.index")
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function index(PaginatorInterface $paginator, Request $request)
	{
		$search = new AuditSearch();
		$form = $this->createForm(AuditSearchType::class, $search);
		$form->handleRequest($request);

		$audits = $paginator->paginate(
			$this->repository->findAllVisibleQuery($search),
			$request->query->getInt('page', 1),
			12
		);



		return $this->render('Admin/Audit/index.html.twig', [
			'audits' => $audits,
			'current_menu' => 'audit',
			'form' => $form->createView()

		]);

	}


	/**
	 * @Route("/audit/profile/{slug}.{id}", name="audit.show", requirements={"slug": "[a-z0-9\-]*"})
	 * @param Audit $audit
	 * @return Response
	 */
	public function show(Audit $audit, string $slug): Response
	{
		if ($audit->getSlug() !== $slug) {
			return $this->redirectToRoute('audit.show', [
				'id' => $audit->getId(),
				'slug' => $audit->getSlug()
			], 301);
		}

		return $this->render('Admin/Audit/show.html.twig', [
			'audits' => $audit,
			'org' => $audit->getOrg(),

			'current_menu' => 'audit'

		]);
	}


	/**
	 * @Route("/audit/create/{name}", name="admin.audit.new")
	 */
	public function new(Request $request, $name)
	{
		$audit = new Audit();
		$form = $this->createForm(AuditType::class, $audit);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$audit->setOrg($this->em->getRepository(Organisation::class)->findOneBy(array("name" => $name)));
			$this->em->persist($audit);
			$this->em->flush();
			$msgAddAudit = $this->addFlash('success', 'Audit Created');

			return $this->redirectToRoute('audits_org2', array("name" => $name, "success" => $msgAddAudit));
		}
		return $this->render('Admin/Audit/edit.html.twig', [
			'audit' => $audit,
			'org' => $audit->getOrg(),
			'form' => $form->createView()
		]);
	}


	/**
	 * @Route("/audit/{id}", name="admin.audit.delete", methods="DELETE")
	 * @param Audit $audit
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse
	 */
	public function delete(Audit $audit, Request $request)
	{
		if ($this->isCsrfTokenValid('delete' . $audit->getId(), $request->get('_token'))) {
			$this->em->remove($audit);
			$this->em->flush();
			$this->addFlash('success', 'Audit removed');

		}


		return $this->redirectToRoute('admin.auditlist.index');
	}


	/**
	 * @Route("/audit/edit/{id}", name="admin.audit.edit")
	 * @param Audit $audit
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function edit(Audit $audit, Request $request)
	{
		$form = $this->createForm(AuditType::class, $audit);

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$this->em->flush();
			$this->addFlash('success', 'Audit  Edited');
			return $this->redirectToRoute('audit.show', [
				'id' => $audit->getId(),
				'slug' => $audit->getSlug()
			], 301);
		}

		return $this->render('Admin/Audit/edit.html.twig', [
			'audit' => $audit,
			'audits'=>$audit,
			'form' => $form->createView()]);
	}


	/**
	 * @Route("/audit/Certlist/{id}.{slug}", name="certs_audit")
	 * @param Audit $audit
	 * @return Response
	 */
	public function AuditCertificates(Audit $audit)
	{
//		dump(Audit);
//		die();
		$html = $this->twig->render('Admin/Certificate/CertlistinAudit.html.twig',
			[
//				'organisations' => $this->$cborganisation->findBy(
//					['cb' => $cborganisation],
//					['time' => 'DESC']
//				),
//				'cbs' => $cborganisation,
				'certs' => $audit->getCertificates(),
				'id' => $audit->getId(),
				'slug' => $audit->getSlug(),
				'audit' => $audit->getTitle(),
				'audits' => $audit,
				'org' => $audit->getOrg()


			]);
		return new Response($html);

	}

	/**
	 * @Route("/audit/findingslist/{id}.{slug}", name="finds_audit")
	 * @param Audit $audit
	 * @return Response
	 */
	public function AuditFinding(Audit $audit)
	{
//		dump($audit);
//		die();
		$html = $this->twig->render('Admin/Finding/FindinglistinAudit.html.twig',
			[
//				'organisations' => $this->$cborganisation->findBy(
//					['cb' => $cborganisation],
//					['time' => 'DESC']
//				),
				'Findings' => $audit->getFindings(),
				'id' => $audit->getId(),
				'slug' => $audit->getSlug(),
				'audit' => $audit->getTitle(),
				'audits' => $audit,
				'org' => $audit->getOrg()

			]);
//
//		dump($audit->getFindings());
//		die();
		return new Response($html);

	}

	/**
	 * @Route("/audit/generalimp/{id}.{slug}", name="generalimp_audit")
	 * @param Audit $audit
	 * @return Response
	 */
	public function AuditGeneralimp(Audit $audit)
	{
//		dump($audit);
//		die();
		$html = $this->twig->render('Admin/GeneralImp/GeneralImplistinAudit.html.twig',
			[
//				'organisations' => $this->$cborganisation->findBy(
//					['cb' => $cborganisation],
//					['time' => 'DESC']
//				),
				'generalimps' => $audit->getAuditgeneralimp(),
				'id' => $audit->getId(),
				'slug' => $audit->getSlug(),
				'audit' => $audit->getTitle(),
				'audits' => $audit,
				'org' => $audit->getOrg()

			]);
//
//		dump($audit->getFindings());
//		die();
		return new Response($html);

	}


}