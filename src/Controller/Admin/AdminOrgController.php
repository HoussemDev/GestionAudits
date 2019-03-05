<?php
/**
 * Created by PhpStorm.
 * User: Sony
 * Date: 26/02/2019
 * Time: 22:30
 */

namespace App\Controller\Admin;


use App\Entity\CB;
use App\Entity\Organisation;
use App\Form\OrganisationType;
use App\Repository\OrganisationRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
	 * AdminOrgController constructor.
	 * @param OrganisationRepository $repository
	 * @param ObjectManager $em
	 * @param \Twig_Environment $twig
	 */
	public function __construct(OrganisationRepository $repository, ObjectManager $em, \Twig_Environment $twig)
	{
		$this->repository = $repository;
		$this->em = $em;
		$this->twig = $twig;
	}

	/**
	 * @Route("/admin/organisations", name="admin.organlist.index")
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function index()
	{
		$orgs = $this->repository->findAll();
		return $this->render('Admin/Organisation/index.html.twig', compact('orgs'));
	}

	/**
	 * @Route("/admin/organisation/{slug}.{id}", name="org.show", requirements={"slug": "[a-z0-9\-]*"})
	 * @param Organisation $organisation
	 * @return Response
	 */
	public function show(Organisation $organisation, string $slug):Response
	{
		if ($organisation->getSlug() !== $slug)
		{
			return $this->redirectToRoute('org.show', [
				'id' => $organisation->getId(),
				'slug' => $organisation->getSlug()
			], 301);
		}

		return $this->render('Admin/Organisation/show.html.twig', [
			'org' => $organisation,
			'current_menu' => 'org'

		]);

	}


	/**
	 * @Route("/admin/organisation/create", name="admin.org.new")
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
	 */
	public function new(Request $request)
	{
		$org = new Organisation();
		$form = $this->createForm(OrganisationType::class, $org);
		$form->handleRequest($request);

		if($form->isSubmitted() && $form->isValid())
		{
			$this->em->persist($org);
			$this->em->flush();
			$this->addFlash('success','Organisation Created' );

			return $this->redirectToRoute('admin.organlist.index');
		}
		return $this->render('Admin/Organisation/edit.html.twig',  [
			'property' => $org,
			'form' => $form->createView()
		]);
	}

	/**
	 * @Route("/admin/organisation/{id}", name="admin.org.edit")
	 * @param Organisation $organisation
	 * @param Request $request
	 * @return Response
	 */
	public function edit(Organisation $organisation, Request $request)
	{
		$form =$this->createForm(OrganisationType::class, $organisation);

		$form->handleRequest($request);

		if($form->isSubmitted() && $form->isValid())
		{
			$this->em->flush();
			$this->addFlash('success','Organisation was Edited' );
			return $this->redirectToRoute('admin.organlist.index');
		}

		return $this->render('Admin/Organisation/edit.html.twig',  [
			'org' => $organisation,
			'form' => $form->createView() ]);
	}


	/**
	 * @Route("/admin/organisation/{id}", name="admin.org.delete", methods="DELETE")
	 * @param Organisation $organisation
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse
	 */
	public function delete(Organisation $organisation, Request $request)
	{
		if ($this->isCsrfTokenValid('delete' . $organisation->getId(), $request->get('_token')))
		{
			$this->em->remove($organisation);
			$this->em->flush();
			$this->addFlash('success','Organisation was removed' );

		}


		return $this->redirectToRoute('admin.organlist.index');
	}


	/**
	 * @Route("/admin/{name}", name="cb.organisations")
	 * @param CB $cborganisation
	 * @return Response
	 */
	public function cbOrganisation (CB $cborganisation)
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