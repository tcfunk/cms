<?php
namespace Blocks;

/**
 *
 */
class SecurityService extends Component
{
	private $_iterationCount;

	/**
	 *
	 */
	public function __construct()
	{
		parent::init();
		$this->_iterationCount = b()->config->getItem('phpPass-iterationCount');
	}

	/**
	 * @return int
	 */
	public function getMinimumPasswordLength()
	{
		return 6;
	}

	/**
	 * @param $password
	 * @return string
	 */
	public function hashPassword($password)
	{
		$passwordHasher = new \PasswordHash($this->_iterationCount, false);
		$hashAndType = $passwordHasher->hashPassword($password);
		$check = $passwordHasher->checkPassword($password, $hashAndType['hash']);

		if (!$check)
		{
			$passwordHasher = new \PasswordHash($this->_iterationCount, false);
			$hashAndType = $passwordHasher->hashPassword($password);
			$check = $passwordHasher->checkPassword($password, $hashAndType['hash']);
		}

		if ($check)
			return $hashAndType;

		throw new Exception('Could not hash the given password.');
	}

	/**
	 * @param $password
	 * @param $storedHash
	 * @return bool
	 */
	public function checkPassword($password, $storedHash)
	{
		$passwordHasher = new \PasswordHash($this->_iterationCount, false);
		$check = $passwordHasher->checkPassword($password, $storedHash);

		return $check;
	}

	/**
	 * @param $code
	 * @return mixed
	 */
	public function getUserByActivationCode($code)
	{
		return User::model()->findByAttributes(array(
			'activationcode' => $code,
		));
	}

	/**
	 * @param $code
	 * @return mixed
	 * @throws Exception
	 */
	public function validateUserRegistration($code)
	{
		$user = $this->_validateActivationRequest($code);
		return $user !== null;
	}

	/**
	 * @param $code
	 * @return mixed
	 * @throws Exception
	 */
	private function _validateActivationRequest($code)
	{
		$user = $this->getUserByActivationCode($code);

		if ($user == null)
		{
			Blocks::log('Unable to find activation code:'.$code);
			throw new Exception('Unable to validate this activation code.');
		}

		if (DateTimeHelper::currentTime() > $user->activationcode_expire_date)
		{
			Blocks::log('Activation: '.$code.' has already expired.');
			throw new Exception('Unable to validate this activation code.');
		}

		return $user;
	}
}
