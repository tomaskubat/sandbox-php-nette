<?php

declare(strict_types=1);

namespace App\Modules\Admin\Presenters;

use App\Modules\Admin\Forms\SignInFormFactory;
use Nette\Application\UI\Form;


final class SignPresenter extends BasePresenter
{
    /** @persistent */
    public string $backlink = '';

    public function __construct(
        private SignInFormFactory $signInFactory
    ) {
        parent::__construct();
    }

    protected function createComponentSignInForm(): Form
    {
        return $this->signInFactory->create(
            function (): void {
                $this->restoreRequest($this->backlink);
                $this->redirect(':Front:Homepage:default');
            }
        );
    }

    public function actionOut(): void
    {
        $this->getUser()->logout();
        $this->redirect(':Front:Homepage:default');
    }
}
