<?php

namespace Motor\CMS\Http\Controllers\Component;

use Illuminate\Http\JsonResponse;
use Motor\Backend\Http\Controllers\Controller;

/**
 * Class ComponentController
 * @package Motor\CMS\Http\Controllers\Component
 */
class ComponentController extends Controller
{

    /**
     * @var
     */
    protected $form;


    /**
     * @param       $route
     * @param array $options
     *
     * @return object
     */
    protected function getFormData($route, $options = []): object
    {
        $object          = new \stdClass();
        $object->route   = $route;
        $object->options = $options;
        $object->fields  = [];
        foreach ($this->form->getFields() as $field) {
            $fieldConfig = new \stdClass();
            if (method_exists($field, 'getData')) {
                $fieldConfig->options = array_merge($field->getOptions(), $field->getData());
            } else {
                $fieldConfig->options = $field->getOptions();
            }
            $fieldConfig->type = $field->getType();
            $object->fields[]  = $fieldConfig;
        }

        return $object;
    }


    /**
     * @return bool
     */
    protected function isValid(): bool
    {
        return true;
    }


    /**
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithValidationError(): JsonResponse
    {
        return response()->json([ 'error' ], 406);
    }
}
