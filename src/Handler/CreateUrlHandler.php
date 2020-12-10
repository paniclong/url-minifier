<?php

declare(strict_types=1);

namespace UrlMinifier\Handler;

use Exception;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Throwable;
use UrlMinifier\Entity\UrlEntity;
use UrlMinifier\Helper\Response\CreatedUrlResponseHelper;
use UrlMinifier\Helper\UuidGenerateHelper;
use UrlMinifier\Repository\UrlRepository;

final class CreateUrlHandler implements HandlerInterface
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
        try {
            $parsedBody = $request->getQueryParams();

            $url = new UrlEntity();
            $url->setUuid($this->generateUuid());

            if (empty($parsedBody['url'])) {
                $this->logger->error('Url not transferred');

                return new JsonResponse(['status' => 'error'], HttpCodesInterface::HTTP_BAD_REQUEST);
            }

            $url->setUrl((string)$parsedBody['url']);

            if (isset($parsedBody['expires_at'])) {
                $url->setExpiresAt((int)$parsedBody['expires_at']);
            }

            $url->save();

            return new JsonResponse(
                CreatedUrlResponseHelper::fromUuid($url->getUuid()),
                HttpCodesInterface::HTTP_CREATED
            );
        } catch (Throwable $ex) {
            $this->logger->error($ex->getMessage(), ['trace' => $ex->getTraceAsString()]);
        }

        return new JsonResponse(['status' => 'error'], HttpCodesInterface::HTTP_NOT_FOUND);
    }

    /**
     * @return string
     *
     * @throws Exception
     */
    private function generateUuid(): string
    {
        do {
            $uuid = UuidGenerateHelper::generate();
            $result = $this->urlRepository->findOneBy(['uuid' => $uuid]);
        } while ($result !== null);

        return $uuid;
    }
}
