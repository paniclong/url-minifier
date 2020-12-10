<?php

declare(strict_types=1);

namespace UrlMinifier\Handler;

use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use UrlMinifier\Repository\UrlRepository;

final class ReceiveUrlHandler
{
    private UrlRepository $urlRepository;
    private LoggerInterface $logger;

    /**
     * @param LoggerInterface $logger
     * @param UrlRepository $urlRepository
     */
    public function __construct(LoggerInterface $logger, UrlRepository $urlRepository)
    {
        $this->urlRepository = $urlRepository;
        $this->logger = $logger;
    }

    /**
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $uuid = $request->getAttributes()['uuid'] ?? '';

        if (empty($uuid)) {
            $this->logger->error('Uuid not transferred');

            return new JsonResponse(['status' => 'error'], HttpCodesInterface::HTTP_BAD_REQUEST);
        }

        $url = $this->urlRepository->findOneBy(['uuid' => $uuid]);

        if ($url === null) {
            $this->logger->error(sprintf('Url entity by uuid `%s` not found', $uuid));

            return new JsonResponse(['status' => 'error'], HttpCodesInterface::HTTP_NOT_FOUND);
        }

        if ($url->isExpired()) {
            $this->logger->error(sprintf('Url entity by uuid `%s` is expired', $uuid));

            return new JsonResponse(['status' => 'is expired'], HttpCodesInterface::HTTP_NOT_FOUND);
        }

        return new RedirectResponse($url->getUrl());
    }
}
