<?php

declare(strict_types=1);

namespace App\Modules\Admin\Forms;

use \stdClass;
use Nette\Application\UI\Form AS UIFor;
use Nette\Forms\Form AS BaseForm;
use Nette\Security\User;
use Nette\SmartObject;


final class SignInFormFactory
{
    use SmartObject;

    public function __construct(
        private FormFactory $factory,
        private User $user
    ) {
    }

    public function create(callable $onSuccess): UIFor
    {
        $form = $this->factory->create();
        $form->addText('username', 'Username:')
            ->setDefaultValue('project')
            ->setRequired('Please enter your username.');

        $form->addPassword('password', 'Password:')
            ->setDefaultValue('project')
            ->setRequired('Please enter your password.');

        $form->addCheckbox('remember', 'Keep me signed in');

        $form->addSubmit('send', 'Sign in');

        $form->onSuccess[] = function (BaseForm $form, stdClass $values) use ($onSuccess): void {
            try {
                $this->user->setExpiration($values->remember ? '14 days' : '20 minutes');
                $this->user->login($values->username, $values->password);
            } catch (\Nette\Security\AuthenticationException $e) {
                $form->addError('The username or password you entered is incorrect.');
                return;
            }
            $onSuccess();
        };

        return $form;
    }
}
