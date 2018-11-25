<?php

namespace Motor\CMS\Http\Controllers\Component;

use Motor\Backend\Http\Controllers\Controller;

use Motor\CMS\Http\Requests\Backend\PageRequest;
use Motor\CMS\Services\Component\ComponentService;

class ComponentController extends Controller
{

    protected $form;


    protected function getFormData($route, $options = [])
    {
        $object          = new \stdClass();
        $object->route   = $route;
        $object->options = $options;
        $object->fields  = [];
        foreach ($this->form->getFields() as $field) {
            $f = new \stdClass();
            if (method_exists($field, 'getData')) {
                $f->options = array_merge($field->getOptions(), $field->getData());
            } else {
                $f->options = $field->getOptions();
            }
            $f->type          = $field->getType();
            $object->fields[] = $f;
        }

        return $object;
    }


    protected function isValid()
    {
        return true;
    }


    protected function respondWithValidationError()
    {
        return response()->json(['error'], 406);
    }
}
