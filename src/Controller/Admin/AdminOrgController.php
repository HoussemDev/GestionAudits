<?php
/**
 * Created by PhpStorm.
 * User: Sony
 * Date: 26/02/2019
 * Time: 22:30
 */

namespace App\Controller\Admin;


use App\Entity\Organisation;
use App\Form\OrganisationType;
use App\Repository\OrganisationRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

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


	public function __construct(OrganisationRepository $repository, ObjectManager $em)
	{
		$this->repository = $repository;
		$this->em = $em;
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


}