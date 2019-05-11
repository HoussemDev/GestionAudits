<?php
/**
 * Created by PhpStorm.
 * User: Sony
 * Date: 24/02/2019
 * Time: 14:28
 */

namespace App\Controller;


use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{


	/**
	 * @var UserRepository
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

	public function __construct(UserRepository $repository, ObjectManager $em, \Twig_Environment $twig)
	{


		$this->repository = $repository;
		$this->em = $em;
		$this->twig = $twig;
	}
	/**
	 * @Route("/admin/user", name="admin_users_index")
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function index()
	{
		$users = $this->repository->findAll();
		return $this->render('Admin/User/index.html.twig', compact('users'));
	}

	/**
	 * @Route("/admin/user/profile/{slug}.{id}", name="user_show", requirements={"slug": "[a-z0-9\-]*"})
	 * @param User $User
	 * @return Response
	 */
	public function show(User $User, string $slug):Response
	{
		if ($User->getSlug() !== $slug)
		{
			return $this->redirectToRoute('user_show', [
				'id' => $User->getId(),
				'slug' => $User->getSlug()
			], 301);
		}

		return $this->render('Admin/User/show.html.twig', [
			'user' => $User,
//			'org' => $auditor->getOrg(),

			'current_menu' => 'audit'

		]);
	}



	/**
	 * @Route("/user/create", name="admin_user_new")
	 */
	public function new(Request $request, UserPasswordEncoderInterface $passwordEncoder )
	{
		$User = new User();
		$form = $this->createForm(UserType::class, $User);
		$form->handleRequest($request);

		if($form->isSubmitted() && $form->isValid())
		{
			$password = $passwordEncoder->encodePassword($User, $User->getPassword());
			$User->setRoles( array('ROLE_ADMIN') );

			$User->setPasswword($password);
			$this->em->persist($User);

			$this->em->flush();
			$this->addFlash('success','User Created' );

			return $this->redirectToRoute('admin_users_index');
		}
		return $this->render('Admin/User/edit.html.twig',  [
			'user' => $User,
			'form' => $form->createView()
		]);
	}

	/**
	 * @Route("/user/edit/{id}", name="admin_user_edit")
	 * @param User $User
	 * @param Request $request
	 * @return Response
	 */
	public function edit(User $User, Request $request)
	{
		$form =$this->createForm(UserType::class, $User);

		$form->handleRequest($request);

		if($form->isSubmitted() && $form->isValid())
		{
			$this->em->flush();
			$this->addFlash('success','User profile Edited' );
			return $this->redirectToRoute('admin_users_index');
		}

		return $this->render('Admin/User/edit.html.twig',  [
			'user' => $User,
			'form' => $form->createView() ]);
	}

	/**
	 * @Route("/user/{id}", name="admin_user_delete", methods="DELETE")
	 * @param User $User
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse
	 */
	public function delete(User $User, Request $request)
	{
		if ($this->isCsrfTokenValid('delete' . $User->getId(), $request->get('_token')))
		{
			$this->em->remove($User);
			$this->em->flush();
			$this->addFlash('success','User removed' );

		}


		return $this->redirectToRoute('admin_users_index');
	}


}