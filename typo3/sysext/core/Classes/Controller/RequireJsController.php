<?php
namespace TYPO3\CMS\Core\Controller;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\Response;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Handling requirejs client requests.
 */
class RequireJsController
{
    /**
     * @var PageRenderer
     */
    protected $pageRenderer;

    public function __construct()
    {
        $this->pageRenderer = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Page\\PageRenderer');
    }

    /**
     * Retrieves additional requirejs configuration for a given module name or module path.
     *
     * The JSON result e.g. could look like:
     * {
     *   "shim": {
     *     "vendor/module": ["exports" => "TheModule"]
     *   },
     *   "paths": {
     *     "vendor/module": "/public/web/path/"
     *   },
     *   "packages": {
     *     [
     *       "name": "module",
     *       ...
     *     ]
     *   }
     * }
     *
     * Parameter name either could be the module name ("vendor/module") or a
     * module path ("vendor/module/component") belonging to a module.
     *
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function retrieveConfiguration($request)
    {
        $name = isset($request->getQueryParams()['name']) ? $request->getQueryParams()['name'] : null;
        if (empty($name) || !is_string($name)) {
            return $this->createJsonResponse(null, 404);
        }
        $configuration = $this->findConfiguration($name);
        return  $this->createJsonResponse($configuration, !empty($configuration) ? 200 : 404);
    }

    /**
     * @param string $name
     * @return array
     */
    protected function findConfiguration($name)
    {
        $relevantConfiguration = [];
        $this->pageRenderer->loadRequireJs();
        $configuration = $this->pageRenderer->getRequireJsConfig(PageRenderer::REQUIREJS_SCOPE_RESOLVE);

        $shim = isset($configuration['shim']) ? $configuration['shim'] : [];
        foreach ($shim as $baseModuleName => $baseModuleConfiguration) {
            if (strpos($name . '/', $baseModuleName . '/') === 0) {
                $relevantConfiguration['shim'][$baseModuleName] = $baseModuleConfiguration;
            }
        }

        $paths = isset($configuration['paths']) ? $configuration['paths'] : [];
        foreach ($paths as $baseModuleName => $baseModulePath) {
            if (strpos($name . '/', $baseModuleName . '/') === 0) {
                $relevantConfiguration['paths'][$baseModuleName] = $baseModulePath;
            }
        }

        $packages = isset($configuration['packages']) ? $configuration['packages'] : [];
        foreach ($packages as $package) {
            if (!empty($package['name'])
                && strpos($name . '/', $package['name'] . '/') === 0
            ) {
                $relevantConfiguration['packages'][] = $package;
            }
        }

        return $relevantConfiguration;
    }

    /**
     * @param array|null $configuration
     * @param int $statusCode
     * @return Response
     */
    protected function createJsonResponse($configuration, $statusCode)
    {
        $response = (new Response())
            ->withStatus($statusCode)
            ->withHeader('Content-Type', 'application/json; charset=utf-8');

        if (!empty($configuration)) {
            $options = JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_UNESCAPED_SLASHES;
            $response->getBody()->write(json_encode(!empty($configuration) ? $configuration : null, $options));
            $response->getBody()->rewind();
        }

        return $response;
    }
}
