<?php
/**
 * Created by PhpStorm.
 * User: Sony
 * Date: 24/02/2019
 * Time: 17:58
 */

namespace App\Controller\Admin;


use App\Entity\CB;
use App\Entity\Organisation;
use App\Form\CbType;
use App\Repository\CBRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
	 * @param PaginatorInterface $paginator
	 * @return Response
	 */
	public function index(PaginatorInterface $paginator, Request $request): Response
	{
		$cbs = $paginator->paginate(
			$this->repository->findAll(),
			$request->query->getInt('page', 1)/*page number*/,
			10/*limit per page*/
		);

		return $this->render('Admin/CB/index.html.twig', [
			'cbs' => $cbs,
			'current_menu' => 'CB'

		]);
	}

	/**
	 * @Route("/admin/cb/{slug}.{id}", name="cb.show", requirements={"slug": "[a-z0-9\-]*"})
	 * @param CB $CB
	 * @return Response
	 */
	public function show(CB $CB, string $slug):Response
	{
		if ($CB->getSlug() !== $slug)
		{
			return $this->redirectToRoute('cb.show', [
				'id' => $CB->getId(),
				'slug' => $CB->getSlug()
			], 301);
		}

		return $this->render('Admin/CB/show.html.twig', [
			'cb' => $CB,
			'current_menu' => 'CB'

		]);

	}



	/**
	 * @Route("/admin/cb/create", name="admin.cb.new")
	 */
	public function new(Request $request)
	{
		$cb = new CB();
		$form = $this->createForm(CbType::class, $cb);
		$form->handleRequest($request);

		if($form->isSubmitted() && $form->isValid())
		{
			$this->em->persist($cb);
			$this->em->flush();
			$this->addFlash('success','Certification Body Created' );

			return $this->redirectToRoute('admin.cblist.index');
		}
		return $this->render('Admin/CB/edit.html.twig',  [
			'property' => $cb,
			'form' => $form->createView()
		]);
	}



	/**
	 * @Route("/admin/cb/{id}", name="admin.cb.edit")
	 * @param CB $cb
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function edit(CB $cb, Request $request)
	{
		$form =$this->createForm(CbType::class, $cb);

		$form->handleRequest($request);

		if($form->isSubmitted() && $form->isValid())
		{
			$this->em->flush();
			$this->addFlash('success','Ceritification Body Edited' );
			return $this->redirectToRoute('admin.cblist.index');
		}

		return $this->render('Admin/CB/edit.html.twig',  [
			'property' => $cb,
			'form' => $form->createView() ]);
	}


	/**
	 * @Route("/admin/CB/{id}", name="admin.cb.delete", methods="DELETE")
	 * @param CB $cb
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse
	 */
	public function delete(CB $cb, Request $request)
	{
		if ($this->isCsrfTokenValid('delete' . $cb->getId(), $request->get('_token')))
		{
			$this->em->remove($cb);
			$this->em->flush();
			$this->addFlash('success','Certification Body  removed' );

		}


		return $this->redirectToRoute('admin.cblist.index');
	}






}