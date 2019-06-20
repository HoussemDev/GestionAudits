<?php
/**
 * Created by PhpStorm.
 * User: Sony
 * Date: 26/02/2019
 * Time: 22:30
 */

namespace App\Controller\Admin;


use App\Entity\AuditSearch;
use App\Entity\CB;
use App\Entity\Organisation;
use App\Entity\OrganisationSearch;
use App\Form\AuditSearchType;
use App\Form\OrganisationSearchType;
use App\Form\OrganisationType;
use App\Repository\OrganisationRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Intl\Intl;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * @property  twig
 */
class AdminOrgController extends AbstractController
{

	/**
	 * @var OrganisationRepository
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
	/**
	 * @var AuthorizationCheckerInterface
	 */
	private $authorizationChecker;


	/**
	 * AdminOrgController constructor.
	 * @param OrganisationRepository $repository
	 * @param ObjectManager $em
	 * @param \Twig_Environment $twig
	 */
	public function __construct(OrganisationRepository $repository, ObjectManager $em,
								\Twig_Environment $twig, AuthorizationCheckerInterface $authorizationChecker)
	{
		$this->repository = $repository;
		$this->em = $em;
		$this->twig = $twig;
		$this->authorizationChecker = $authorizationChecker;
	}

	/**
	 * @Route("/organisation", name="admin.organlist.index")
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function index(Request $request, PaginatorInterface $paginator)
	{

		$search = new OrganisationSearch();
		$form = $this->createForm(OrganisationSearchType::class, $search);
		$form->handleRequest($request);


		if ($this->authorizationChecker->isGranted('ROLE_ADMIN')) {


			$orgs = $paginator->paginate(
				$this->repository->findAllVisibleQuery($search),
				$request->query->getInt('page', 1),
				12
			);

			return $this->render('Admin/Organisation/index.html.twig',
				[
					'orgs' => $orgs,
					'current_menu' => 'organisation',
					'form' => $form->createView()

				]);

		}

		if 	 ($this->authorizationChecker->isGranted('ROLE_AUDITOR')) {
			$a = $this->getUser();
			$id = $a->usercb;
			$id = $id->getid();

			$orgs = $paginator->paginate(
				$this->repository->findBy(array('cb' => $id)),
				$request->query->getInt('page', 1),
				12
			);

			//$orgs = $this->repository->findBy(array('cb' => $id));
			return $this->render('Admin/Organisation/index.html.twig',
				[
					'orgs' => $orgs,
					'current_menu' => 'organisation',
					'form' => $form->createView()

				]);


		}



		//return $this->render('Admin/Organisation/index.html.twig', compact('orgs'));
	}

	/**
	 * @Route("/organisation/profile/{slug}.{id}", name="org.show", requirements={"slug": "[a-z0-9\-]*"})
	 * @param Organisation $organisation
	 * @return Response
	 */
	public function show(Organisation $organisation, string $slug): Response
	{

		if ($organisation->getSlug() !== $slug) {
			return $this->redirectToRoute('org.show', [
				'id' => $organisation->getId(),
				'slug' => $organisation->getSlug()
			], 301);
		}
		$Country = Intl::getRegionBundle()->getCountryName($organisation->getCountry());

		return $this->render('Admin/Organisation/show.html.twig', [
			'org' => $organisation,
			'cb' => $organisation->getCb(),
			'Country' => $Country,

			'current_menu' => 'org'

		]);

	}


	/**
	 * @Route("/organisationlist/create/{name}", name="admin.org.new")
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
	 */
	public function new(Request $request, $name)
	{
		$org = new Organisation();

		$form = $this->createForm(OrganisationType::class, $org);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$org->setCb($this->em->getRepository(CB::class)->findOneBy(array("name" => $name)));

			$this->em->persist($org);
			$this->em->flush();
			$msgAddOrg = $this->addFlash('success', 'Organisation Created');

			return $this->redirectToRoute('cb.organisations', array("name" => $name, "success" => $msgAddOrg));
		}
		return $this->render('Admin/Organisation/edit.html.twig', [
			'org' => $org,
			'form' => $form->createView()
		]);
	}

	/**
	 * @Route("/organisation/edit/{id}", name="admin.org.edit")
	 * @param Organisation $organisation
	 * @param Request $request
	 * @return Response
	 */
	public function edit(Organisation $organisation, Request $request)
	{
		$form = $this->createForm(OrganisationType::class, $organisation);

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$this->em->flush();
			$this->addFlash('success', 'Organisation was Edited');
			return $this->redirectToRoute('admin.organlist.index');
		}

		return $this->render('Admin/Organisation/edit.html.twig', [
			'org' => $organisation,
			'form' => $form->createView()]);
	}


	/**
	 * @Route("/organisation/delete/{id}", name="admin.org.delete", methods="DELETE")
	 * @param Organisation $organisation
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse
	 */
	public function delete(Organisation $organisation, Request $request)
	{
		if ($this->isCsrfTokenValid('delete' . $organisation->getId(), $request->get('_token'))) {
			$this->em->remove($organisation);
			$this->em->flush();
			$this->addFlash('success', 'Organisation was removed');

		}


		return $this->redirectToRoute('admin.organlist.index');
	}

	/**
	 * @Route("/organisation/auditlist/{name}", name="audits_org2")
	 * @param Organisation $audits
	 * @return Response
	 */
	public function orgAudits(Organisation $audits)
	{
		$html = $this->twig->render('Admin/Organisation/AuditslistinOrg.html.twig',
			[
//				'organisations' => $this->$cborganisation->findBy(
//					['cb' => $cborganisation],
//					['time' => 'DESC']
//				),
//				'cbs' => $cborganisation,
				'audits' => $audits->getAudits(),
				'id' => $audits->getId(),
				'slug' => $audits->getSlug(),
				'organisation' => $audits,
				'org' => $audits

			]);
		return new Response($html);

	}

	/**
	 * @Route("/Audits-list", name="admin_audit_index")
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function AuditMenuList(Request $request, PaginatorInterface $paginator)
	{

//		if ($this->authorizationChecker->isGranted('ROLE_ADMIN'))
//		{
//			$orgs = $this->repository->findAll();
//			return $this->render('Admin/Organisation/index.html.twig', compact('orgs'));
//
//		}
		$search = new AuditSearch();
		$form = $this->createForm(AuditSearchType::class, $search);
		$form->handleRequest($request);


		if ($this->authorizationChecker->isGranted('ROLE_AUDITOR')) {
			$a = $this->getUser();
			$id = $a->usercb;
			$id = $id->getid();


			$orgs = $paginator->paginate(
				$this->repository->findBy(array('cb' => $id)),
				$request->query->getInt('page', 1),
				12
			);




		}


		return $this->render('Admin/Audit/index_auditList.html.twig', [
			'orgs' => $orgs,
			'current_menu' => 'audit',
			'form' => $form->createView()

		]);
	}


	/**
	 * @Route("/organisation/Certlist/{name}", name="Certs_org")
	 * @param Organisation $audits
	 * @return Response
	 */
	public function orgCerts(Organisation $audits)
	{

		$html = $this->twig->render('Admin/Organisation/CertlistinOrg.html.twig',
			[
//				'organisations' => $this->$cborganisation->findBy(
//					['cb' => $cborganisation],
//					['time' => 'DESC']
//				),
//				'cbs' => $cborganisation,
				'audits' => $audits->getAudits(),
				'id' => $audits->getId(),
				'slug' => $audits->getSlug(),
				'organisation' => $audits,
				'org' => $audits,
				'certs' => $audits->getAudits(),

			]);
		return new Response($html);

	}

	/**
	 * @Route("/organisation/Findinglist/{name}", name="finds_org")
	 * @param Organisation $audits
	 * @return Response
	 */
	public function orgFinding(Organisation $audits)
	{

		$html = $this->twig->render('Admin/Organisation/FindinglistinOrg.html.twig',
			[
//				'organisations' => $this->$cborganisation->findBy(
//					['cb' => $cborganisation],
//					['time' => 'DESC']
//				),
//				'cbs' => $cborganisation,
				'audits' => $audits->getAudits(),
				'id' => $audits->getId(),
				'slug' => $audits->getSlug(),
				'organisation' => $audits,
				'org' => $audits,
				'finds' => $audits->getAudits(),


			]);
		return new Response($html);

	}


	/**
	 * @Route("/organisationlist/{name}", name="cb.organisations")
	 * @param CB $cborganisation
	 * @return Response
	 */
	public function cbOrganisation(CB $cborganisation)
	{
		$html = $this->twig->render('Admin/CB/cborg.html.twig',
			[
//				'organisations' => $this->$cborganisation->findBy(
//					['cb' => $cborganisation],
//					['time' => 'DESC']
//				),
//				'cbs' => $cborganisation,
				'organisations' => $cborganisation->getOrganisations(),
//				'id' => $cborganisation->getId(),
//				'slug' => $cborganisation->getSlug(),
				'cb' => $cborganisation


			]);
		return new Response($html);

	}


}