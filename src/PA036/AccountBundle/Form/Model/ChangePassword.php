<?php

namespace PA036\AccountBundle\Form\Model;

use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;
use Symfony\Component\Validator\Constraints as Assert;

class ChangePassword {

    /**
     * @SecurityAssert\UserPassword(
     *     message = "Wrong value for your current password"
     * )
     */
    protected $oldPassword;

    /**
     * @Assert\Length(
     *     min = 4,
     *     minMessage = "Password should by at least 6 chars long"
     * )
     */
    protected $newPassword;

    public function getOldPassword() {
        return $this->oldPassword;
    }

    public function setOldPassword($oldPassword) {
        $this->oldPassword = $oldPassword;
    }

    public function getNewPassword() {
        return $this->newPassword;
    }

    public function setNewPassword($newPassword) {
        $this->newPassword = $newPassword;
    }


}

