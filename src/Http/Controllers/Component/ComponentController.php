<?php

namespace Motor\CMS\Http\Controllers\Component;

use Illuminate\Http\JsonResponse;
use Motor\Backend\Http\Controllers\Controller;

/**
 * Class ComponentController
 */
class ComponentController extends Controller
{
    protected $form;

    /**
     * @param  array  $options
     */
    protected function getFormData($route, $options = []): object
    {
        $object = new \stdClass;
        $object->route = $route;
        $object->options = $options;
        $object->fields = [];
        foreach ($this->form->getFields() as $field) {
            $fieldConfig = new \stdClass;
            if (method_exists($field, 'getData')) {
                $fieldConfig->options = array_merge($field->getOptions(), $field->getData());
            } else {
                $fieldConfig->options = $field->getOptions();
            }
            $fieldConfig->type = $field->getType();
            $object->fields[] = $fieldConfig;
        }

        return $object;
    }

    protected function isValid(): bool
    {
        return true;
    }

    protected function respondWithValidationError(): JsonResponse
    {
        return response()->json(['error'], 406);
    }
}
