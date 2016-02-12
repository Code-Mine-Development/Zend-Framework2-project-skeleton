<?php
namespace Api\Documentation;

use Zend\Filter\AbstractFilter;
use Zend\InputFilter\BaseInputFilter;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilterPluginManager;
use Zend\Validator\InArray;
use Zend\Validator\StringLength;
use ZF\Apigility\Documentation\Api;
use ZF\Apigility\Documentation\ApiFactory;
use ZF\Apigility\Documentation\Field;
use ZF\Apigility\Documentation\Operation;
use ZF\Apigility\Documentation\Service;

/**
 * Class ApiDocumentationFactory
 * @package Api
 * @author  Tomasz Osadnik <tomek@code-mine.com>
 */
class ApiDocumentationFactory extends ApiFactory
{
    /**
     * @var \Zend\InputFilter\InputFilterPluginManager
     */
    private $inputFilterManager;

    /**
     * @param \Zend\InputFilter\InputFilterPluginManager $manager
     */
    public function setInputFilterManager(InputFilterPluginManager $manager)
    {
        $this->inputFilterManager = $manager;
    }

    /**
     * @param string $apiName
     * @param int    $apiVersion
     *
     * @return \ZF\Apigility\Documentation\Api
     */
    public function createApi($apiName, $apiVersion = 1)
    {
        $api = parent::createApi($apiName, $apiVersion);

        // Logout
        $this->changeOAuthServiceName($api);

        // Login
        $this->addLoginService($api);

        return $api;
    }

    /**
     * @param \ZF\Apigility\Documentation\Api $api
     */
    private function changeOAuthServiceName(Api $api)
    {
        foreach ($api->getServices() as $key => $service) {
            if ('Oauth' === $service->getName()) {
                $service->setName('Logout');
                break;
            }
        }
    }

    /**
     * @param \ZF\Apigility\Documentation\Api $api
     */
    private function addLoginService(Api $api)
    {
        $oauthService = new Service();
        $oauthService->setName('Login');
        $oauthService->setRoute('/oauth');
        $oauthService->setDescription('Get Access Token');
        $operation = new Operation();
        $operation->setHttpMethod('POST');
        $operation->setDescription(
            'Fields `client_id` and `client_secret` can be sent in Authorization header as Basic credentials
            Format: base64_encode(client_id:client_secret).'
        );
        $operation->setRequestDescription(
            '{
    "client_id": "client_id",
    "client_secret": "client_secret",
    "username": "email@domain.com",
    "password": "pass",
    "grant_type": "password"
}'
        );
        $operation->setResponseDescription(
            '{
  "access_token": "f8e1f4d5bc2ab328b2fc1059072aa1b3f9b04397",
  "expires_in": 3600,
  "token_type": "Bearer",
  "scope": null,
  "refresh_token": "7ff66f54a942033136fd8dca3b3dfd7e1fdf60ac"
}'
        );
        $operation->setResponseStatusCodes(
            [
                [
                    'code'    => '200',
                    'message' => 'OK',
                ],
                [
                    'code'    => '400',
                    'message' => 'Invalid Client',
                ],
                [
                    'code'    => '401',
                    'message' => 'Invalid User credentials',
                ],
            ]
        );

        $operations   = $oauthService->getOperations();
        $operations[] = $operation;

        $oauthService->setOperations($operations);
        $oauthService->setRequestAcceptTypes(['application/json']);
        $oauthService->setRequestContentTypes(['application/json']);

        $api->addService($oauthService);
    }

    /**
     * Create documentation details for a given service in a given version of
     * an API module
     *
     * @param string     $apiName
     * @param int|string $apiVersion
     * @param string     $serviceName
     *
     * @return Service
     */
    public function createService(Api $api, $serviceName)
    {
        $service = new Service();
        $service->setApi($api);

        $serviceData = NULL;
        $isRest      = FALSE;
        $isRpc       = FALSE;
        $hasSegments = FALSE;
        $hasFields   = FALSE;

        foreach ($this->config['zf-rest'] as $serviceClassName => $restConfig) {
            if ((strpos($serviceClassName, $api->getName() . '\\') === 0)
                && isset($restConfig['service_name'])
                && ($restConfig['service_name'] === $serviceName)
                && (strstr($serviceClassName, '\\V' . $api->getVersion() . '\\') !== FALSE)
            ) {
                $serviceData = $restConfig;
                $isRest      = TRUE;
                $hasSegments = TRUE;
                break;
            }
        }

        if (!$serviceData) {
            foreach ($this->config['zf-rpc'] as $serviceClassName => $rpcConfig) {
                if ((strpos($serviceClassName, $api->getName() . '\\') === 0)
                    && isset($rpcConfig['service_name'])
                    && ($rpcConfig['service_name'] === $serviceName)
                    && (strstr($serviceClassName, '\\V' . $api->getVersion() . '\\') !== FALSE)
                ) {
                    $serviceData           = $rpcConfig;
                    $serviceData['action'] = $this->marshalActionFromRouteConfig(
                        $serviceName,
                        $serviceClassName,
                        $rpcConfig
                    );
                    $isRpc                 = TRUE;
                    break;
                }
            }
        }

        if (!$serviceData || !isset($serviceClassName)) {
            return FALSE;
        }

        $authorizations = $this->getAuthorizations($serviceClassName);

        $docsArray = $this->getDocumentationConfig($api->getName());

        $service->setName($serviceData['service_name']);
        if (isset($docsArray[$serviceClassName]['description'])) {
            $service->setDescription($docsArray[$serviceClassName]['description']);
        }

        $route = $this->config['router']['routes'][$serviceData['route_name']]['options']['route'];
        $service->setRoute(str_replace('[/v:version]', '', $route)); // remove internal version prefix, hacky
        if ($isRpc) {
            $hasSegments = $this->hasOptionalSegments($route);
        }

        if (isset($serviceData['route_identifier_name'])) {
            $service->setRouteIdentifierName($serviceData['route_identifier_name']);
        }

        $fields      = [];
        $httpMethods = ['input_filter'];
        if (isset($serviceData['collection_http_methods'])) {
            $httpMethods = array_merge($httpMethods, $serviceData['collection_http_methods']);
        }
        if (isset($serviceData['entity_http_methods'])) {
            $httpMethods = array_merge($httpMethods, $serviceData['entity_http_methods']);
        }

        foreach ($httpMethods as $httpMethod) {
            if (isset($this->config['zf-content-validation'][$serviceClassName][$httpMethod])) {
                // get input filter name
                $validatorName = $this->config['zf-content-validation'][$serviceClassName][$httpMethod];

                // isset input_filter_specs?
                if (isset($this->config['input_filter_specs'][$validatorName])) {
                    foreach ($this->config['input_filter_specs'][$validatorName] as $fieldData) {
                        $fields[$httpMethod][] = $this->getField($fieldData);
                    }
                    $hasFields = TRUE;
                } // try to get inputs from input filter class
                else if (NULL !== $this->inputFilterManager) {

                    // input filter
                    $inputFilter = $this->inputFilterManager->get($validatorName);
                    if (TRUE === $inputFilter instanceof BaseInputFilter) {
                        /** @var BaseInputFilter $inputFilter */
                        $inputs = $inputFilter->getInputs();
                        foreach ($inputs as $input) {
                            $field = new Field();
                            $field->setName($input->getName());
                            $field->setRequired($input->isRequired());

                            $description = '';

                            // get filters
//                            $filters = [];
//                            foreach ($input->getFilterChain()->getFilters() as $filter) {
//                                /** @var AbstractFilter $filter */
//                                $filters[] = get_class($filter);
//                            }
//                            $description .= implode('<br/>', $filters);
//
//                            if ($description) {
//                                $description .= '<br/><br/>';
//                            }

                            // get validators
                            $validators = [];
                            foreach ($input->getValidatorChain()->getValidators() as $validator) {
                                $validatorDescription = get_class($validator['instance']);
                                if (TRUE === $validator['instance'] instanceof InArray) {
                                    $elements = implode(', ', $validator['instance']->getHaystack());
                                    $validatorDescription .= ' (' . $elements . ')';
                                } else if (TRUE === $validator['instance'] instanceof StringLength) {
                                    $validatorDescription .= sprintf(
                                        ' [%s-%s]',
                                        $validator['instance']->getMin(),
                                        $validator['instance']->getMax()
                                    );
                                }
                                $validators[] = $validatorDescription;
                            }
                            $description .= implode('<br/>', $validators);

                            $field->setDescription($description);

                            $fields[$httpMethod][] = $field;
                        }
                    }
                }
            }
        }
        $service->setFields($fields);

        $baseOperationData = (isset($serviceData['collection_http_methods']))
            ? $serviceData['collection_http_methods']
            : $serviceData['http_methods'];

        $ops = [];
        foreach ($baseOperationData as $httpMethod) {
            $op = new Operation();
            $op->setHttpMethod($httpMethod);

            if ($isRest) {
                $description = isset($docsArray[$serviceClassName]['collection'][$httpMethod]['description'])
                    ? $docsArray[$serviceClassName]['collection'][$httpMethod]['description']
                    : '';
                $op->setDescription($description);

                $requestDescription = isset($docsArray[$serviceClassName]['collection'][$httpMethod]['request'])
                    ? $docsArray[$serviceClassName]['collection'][$httpMethod]['request']
                    : '';
                $op->setRequestDescription($requestDescription);

                $responseDescription = isset($docsArray[$serviceClassName]['collection'][$httpMethod]['response'])
                    ? $docsArray[$serviceClassName]['collection'][$httpMethod]['response']
                    : '';

                $op->setResponseDescription($responseDescription);
                $op->setRequiresAuthorization(
                    isset($authorizations['collection'][$httpMethod])
                        ? $authorizations['collection'][$httpMethod]
                        : FALSE
                );

                $op->setResponseStatusCodes(
                    $this->getStatusCodes(
                        $httpMethod,
                        FALSE,
                        $hasFields,
                        $op->requiresAuthorization()
                    )
                );
            }

            if ($isRpc) {
                $description = isset($docsArray[$serviceClassName][$httpMethod]['description'])
                    ? $docsArray[$serviceClassName][$httpMethod]['description']
                    : '';
                $op->setDescription($description);

                $requestDescription = isset($docsArray[$serviceClassName][$httpMethod]['request'])
                    ? $docsArray[$serviceClassName][$httpMethod]['request']
                    : '';
                $op->setRequestDescription($requestDescription);

                $responseDescription = isset($docsArray[$serviceClassName][$httpMethod]['response'])
                    ? $docsArray[$serviceClassName][$httpMethod]['response']
                    : '';
                $op->setResponseDescription($responseDescription);

                $op->setRequiresAuthorization(
                    isset($authorizations['actions'][$serviceData['action']][$httpMethod])
                        ? $authorizations['actions'][$serviceData['action']][$httpMethod]
                        : FALSE
                );
                $op->setResponseStatusCodes(
                    $this->getStatusCodes(
                        $httpMethod,
                        $hasSegments,
                        $hasFields,
                        $op->requiresAuthorization()
                    )
                );
            }

            $ops[] = $op;
        }

        $service->setOperations($ops);

        if (isset($serviceData['entity_http_methods'])) {
            $ops = [];
            foreach ($serviceData['entity_http_methods'] as $httpMethod) {
                $op = new Operation();
                $op->setHttpMethod($httpMethod);

                $description = isset($docsArray[$serviceClassName]['entity'][$httpMethod]['description'])
                    ? $docsArray[$serviceClassName]['entity'][$httpMethod]['description']
                    : '';
                $op->setDescription($description);

                $requestDescription = isset($docsArray[$serviceClassName]['entity'][$httpMethod]['request'])
                    ? $docsArray[$serviceClassName]['entity'][$httpMethod]['request']
                    : '';
                $op->setRequestDescription($requestDescription);

                $responseDescription = isset($docsArray[$serviceClassName]['entity'][$httpMethod]['response'])
                    ? $docsArray[$serviceClassName]['entity'][$httpMethod]['response']
                    : '';
                $op->setResponseDescription($responseDescription);

                $op->setRequiresAuthorization(
                    isset($authorizations['entity'][$httpMethod])
                        ? $authorizations['entity'][$httpMethod]
                        : FALSE
                );
                $op->setResponseStatusCodes(
                    $this->getStatusCodes(
                        $httpMethod,
                        TRUE,
                        $hasFields,
                        $op->requiresAuthorization()
                    )
                );
                $ops[] = $op;
            }
            $service->setEntityOperations($ops);
        }

        if (isset($this->config['zf-content-negotiation']['accept_whitelist'][$serviceClassName])) {
            $service->setRequestAcceptTypes(
                $this->config['zf-content-negotiation']['accept_whitelist'][$serviceClassName]
            );
        }

        if (isset($this->config['zf-content-negotiation']['content_type_whitelist'][$serviceClassName])) {
            $service->setRequestContentTypes(
                $this->config['zf-content-negotiation']['content_type_whitelist'][$serviceClassName]
            );
        }

        return $service;
    }

    /**
     * @param array  $fields
     * @param string $prefix To unwind nesting of fields
     *
     * @return array
     */
    private function mapFields(array $fields, $prefix = '')
    {
        if (isset($fields['name'])) {
            /// detect usage of "name" as a field group name
            if (is_array($fields['name']) && isset($fields['name']['name'])) {
                return $this->mapFields($fields['name'], 'name');
            }

            if ($prefix) {
                $fields['name'] = sprintf('%s/%s', $prefix, $fields['name']);
            }

            return [$fields];
        }

        $flatFields = [];

        foreach ($fields as $idx => $field) {
            if (isset($field['type']) && is_subclass_of($field['type'], 'Zend\InputFilter\InputFilterInterface')) {
                $filteredFields = array_diff_key($field, ['type' => 0]);
                $fullindex      = $prefix ? sprintf('%s/%s', $prefix, $idx) : $idx;
                $flatFields     = array_merge($flatFields, $this->mapFields($filteredFields, $fullindex));
                continue;
            }

            $flatFields = array_merge($flatFields, $this->mapFields($field, $prefix));
        }

        return $flatFields;
    }

    /**
     * @param array $fieldData
     *
     * @return Field
     */
    private function getField(array $fieldData)
    {
        $field = new Field();

        $field->setName($fieldData['name']);
        if (isset($fieldData['description'])) {
            $field->setDescription($fieldData['description']);
        }

        if (isset($fieldData['type'])) {
            $field->setType($fieldData['type']);
        }

        $required = isset($fieldData['required']) ? (bool)$fieldData['required'] : FALSE;
        $field->setRequired($required);

        return $field;
    }
}