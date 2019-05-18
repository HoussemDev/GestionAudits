<?php
/**
 * Created by PhpStorm.
 * User: Sony
 * Date: 07/05/2019
 * Time: 22:41
 */

namespace App\Security;


use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class UserVoter extends Voter
{
	const EDIT = 'edit';
	const DELETE = 'delete';

	private $decisionManager;

	public function __construct(AccessDecisionManagerInterface $decisionManager)
	{
		$this->decisionManager = $decisionManager;
	}

	/**
	 * Determines if the attribute and subject are supported by this voter.
	 *
	 * @param string $attribute An attribute
	 * @param mixed $subject The subject to secure, e.g. an object the user wants to access or any other PHP type
	 *
	 * @return bool True if the attribute and subject are supported, false otherwise
	 */
	protected function supports($attribute, $subject)
	{
		if (!in_array($attribute, [self::EDIT, self::DELETE])) {
			return false;
		}
//		if (!$subject instanceof User) {
//			return false;
//		}
		return true;
	}

	/**
	 * Perform a single access check operation on a given attribute, subject and token.
	 * It is safe to assume that $attribute and $subject already passed the "supports()" method check.
	 *
	 * @param string $attribute
	 * @param mixed $subject
	 * @param TokenInterface $token
	 *
	 * @return bool
	 */
	protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
	{
		if($this->decisionManager->decide($token, [User::ROLE_ADMIN]))
		{
			return true;
		}
		if($this->decisionManager->decide($token, [User::ROLE_CBADMIN]))
		{
			return true;
		}if($this->decisionManager->decide($token, [User::ROLE_AUDITOR]))
		{
			return true;
		}
		return false;
	}
}