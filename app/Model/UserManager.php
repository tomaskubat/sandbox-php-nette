<?php

declare(strict_types=1);

namespace App\Model;

use Nette;
use Nette\Security\Passwords;
use Nette\Security\SimpleIdentity;
use Tracy\Debugger;


final class UserManager implements Nette\Security\Authenticator
{
    use Nette\SmartObject;

    public function __construct(
        private Nette\Database\Explorer $database,
        private Passwords $passwords
    ) {
    }

    /**
     * @throws Nette\Security\AuthenticationException
     */
    public function authenticate(string $user, string $password): SimpleIdentity
    {
        $row = $this->database->table('users')
            ->where('username', $user)
            ->fetch();

        if ( ! $row) {
            throw new Nette\Security\AuthenticationException('The username is incorrect.', self::IDENTITY_NOT_FOUND);
        } elseif ( ! $this->passwords->verify($password, $row['password'])) {
            throw new Nette\Security\AuthenticationException('The password is incorrect.', self::INVALID_CREDENTIAL);
        } elseif ($this->passwords->needsRehash($row['password'])) {
            Debugger::barDump('Password rehashed now');
            $row->update(
                [
                    'password' => $this->passwords->hash($password),
                ]
            );
        }

        $arr = $row->toArray();
        unset($arr['password']);
        return new SimpleIdentity($row['id'], null, $arr);
    }

}

