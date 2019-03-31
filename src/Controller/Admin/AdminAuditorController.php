<?php
/**
 * Created by PhpStorm.
 * User: Sony
 * Date: 24/03/2019
 * Time: 15:04
 */

namespace App\Controller\Admin;


use App\Entity\Auditor;
use App\Form\AuditorType;
use App\Repository\AuditorRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminAuditorController extends AbstractController
{

	/**
	 * @var AuditorRepository
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

	public function __construct(AuditorRepository $repository, ObjectManager $em, \Twig_Environment $twig)
	{

		$this->repository = $repository;
		$this->em = $em;
		$this->twig = $twig;
	}
	/**
	 * @Route("/admin/auditor", name="admin.auditorlist.index")
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function index()
	{
		$auditors = $this->repository->findAll();
		return $this->render('Admin/Auditor/index.html.twig', compact('auditors'));
	}


	/**
	 * @Route("/admin/auditor/profile/{slug}.{id}", name="auditor.show", requirements={"slug": "[a-z0-9\-]*"})
	 * @param Auditor $auditor
	 * @return Response
	 */
	public function show(Auditor $auditor, string $slug):Response
	{
		if ($auditor->getSlug() !== $slug)
		{
			return $this->redirectToRoute('auditor.show', [
				'id' => $auditor->getId(),
				'slug' => $auditor->getSlug()
			], 301);
		}

		return $this->render('Admin/Auditor/show.html.twig', [
			'auditor' => $auditor,
//			'org' => $auditor->getOrg(),

			'current_menu' => 'audit'

		]);
	}

	/**
	 * @Route("/admin/auditor/create", name="admin.auditor.new")
	 */
	public function new(Request $request, UserPasswordEncoderInterface $passwordEncoder )
	{
		$auditor = new Auditor();
		$form = $this->createForm(AuditorType::class, $auditor);
		$form->handleRequest($request);

		if($form->isSubmitted() && $form->isValid())
		{
			$password = $passwordEncoder->encodePassword($auditor, $auditor->getPassword());
			$auditor->setPassword($password);
			$this->em->persist($auditor);
			$this->em->flush();
			$this->addFlash('success','Auditor Created' );

			return $this->redirectToRoute('admin.auditorlist.index');
		}
		return $this->render('Admin/Auditor/edit.html.twig',  [
			'auditor' => $auditor,
//			'org' => $audit->getOrg(),
			'form' => $form->createView()
		]);
	}


	/**
	 * @Route("/admin/auditor/{id}", name="admin.auditor.delete", methods="DELETE")
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse
	 */
	public function delete(Auditor $auditor, Request $request)
	{
		if ($this->isCsrfTokenValid('delete' . $auditor->getId(), $request->get('_token')))
		{
			$this->em->remove($auditor);
			$this->em->flush();
			$this->addFlash('success','Auditor removed' );

		}


		return $this->redirectToRoute('admin.auditorlist.index');
	}


	/**
	 * @Route("/admin/auditor/edit/{id}", name="admin.auditor.edit")
	 * @param Auditor $auditor
	 * @return Response
	 */
	public function edit(Auditor $auditor, Request $request)
	{
		$form =$this->createForm(AuditorType::class, $auditor);

		$form->handleRequest($request);

		if($form->isSubmitted() && $form->isValid())
		{
			$this->em->flush();
			$this->addFlash('success','Auditor profile Edited' );
			return $this->redirectToRoute('admin.auditorlist.index');
		}

		return $this->render('Admin/Auditor/edit.html.twig',  [
			'auditor' => $auditor,
			'form' => $form->createView() ]);
	}


}