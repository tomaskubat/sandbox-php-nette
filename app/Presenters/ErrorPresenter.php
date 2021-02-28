<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette\Application\Helpers;
use Nette\Application\IPresenter;
use Nette\Application\Request;
use Nette\Application\Response;
use Nette\Application\Responses\CallbackResponse;
use Nette\Application\Responses\ForwardResponse;
use Nette\Http;
use Tracy\ILogger;
use Nette\SmartObject;

final class ErrorPresenter implements IPresenter
{
    use SmartObject;

    public function __construct(
        private ILogger $logger
    ) {
    }

    public function run(Request $request): Response
    {
        $e = $request->getParameter('exception');

        if ($e instanceof \Nette\Application\BadRequestException) {
            // $this->logger->log("HTTP code {$e->getCode()}: {$e->getMessage()} in {$e->getFile()}:{$e->getLine()}", 'access');
            [$module, , $sep] = Helpers::splitName($request->getPresenterName());
            $errorPresenter = $module.$sep.'Error4xx';
            return new ForwardResponse($request->setPresenterName($errorPresenter));
        }

        $this->logger->log($e, ILogger::EXCEPTION);

        return new CallbackResponse(
            function (Http\IRequest $httpRequest, Http\IResponse $httpResponse): void {
                if (preg_match('#^text/html(?:;|$)#', (string)$httpResponse->getHeader('Content-Type'))) {
                    require __DIR__.'/templates/Error/500.phtml';
                }
            }
        );
    }
}
