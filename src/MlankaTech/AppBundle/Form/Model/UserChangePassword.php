<?php

namespace MlankaTech\AppBundle\Form\Model;

use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * UserChangePassword.
 *
 * @author Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
 * @package MlankaTechAppBundle
 * @subpackage Form\Model
 * @version 0.0.1
 */
class UserChangePassword
{
    /**
     * @SecurityAssert\UserPassword(
     *     message = "Wrong value for your current password",
     *     groups={"change_password"}
     * )
     */
    protected $oldPassword;

    /**
     * @Assert\Length(
     *      min = "6",
     *      max = "20",
     *      minMessage = "Password must have at least {{ limit }} characters",
     *      maxMessage = "Password has a limit of {{ limit }} characters",
     *      groups={"change_password"}
     * )
     */
    protected $newPassword;

    /**
     * @return mixed
     */
    public function getOldPassword()
    {
        return $this->oldPassword;
    }

    /**
     * @param mixed $oldPassword
     */
    public function setOldPassword($oldPassword)
    {
        $this->oldPassword = $oldPassword;
    }

    /**
     * @return mixed
     */
    public function getNewPassword()
    {
        return $this->newPassword;
    }

    /**
     * @param mixed $newPassword
     */
    public function setNewPassword($newPassword)
    {
        $this->newPassword = $newPassword;
    }
}
