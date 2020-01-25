<?php

namespace Motor\CMS\Services;

use Motor\Backend\Http\Requests\Request;
use Motor\Backend\Services\BaseService;
use Motor\CMS\Models\PageVersionComponent;
use Motor\Media\Models\FileAssociation;

/**
 * Class ComponentBaseService
 * @package Motor\CMS\Services
 */
class ComponentBaseService extends BaseService
{

    /**
     * @param PageVersionComponent $pageComponent
     *
     * @return object
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public static function render(PageVersionComponent $pageComponent)
    {
        $container = app();

        $controller = $container->make(
            config('motor-cms-page-components.components.'.$pageComponent->component_name.'.component_class'),
            [
                'pageVersionComponent' => $pageComponent,
                'component'            => ($pageComponent->component_id == null ? null : $pageComponent->component)
            ]
        );

        return $container->call([ $controller, 'index' ]);
    }


    /**
     * @param Request $request
     */
    public static function createPageComponent(Request $request): void
    {
        // Create the page component
        $pageComponent = new PageVersionComponent();
        $pageComponent->page_version_id = $request->get('page_version_id');
        $pageComponent->container = $request->get('container');
        $pageComponent->component_name = $request->get('component_name');
        $pageComponent->sort_position = PageVersionComponent::where(
                'page_version_id',
                $request->get('page_version_id')
            )->where('container', $request->get('container'))->count() + 1;
        $pageComponent->save();
    }


    public function beforeCreate(): void
    {
    }


    public function afterCreate(): void
    {
        // Create the page component
        $pageComponent = new PageVersionComponent();
        $pageComponent->page_version_id = $this->request->get('page_version_id');
        $pageComponent->container = $this->request->get('container');
        $pageComponent->component_name = $this->name;
        $pageComponent->sort_position = PageVersionComponent::where(
                'page_version_id',
                $this->request->get('page_version_id')
            )
                ->where('container', $this->request->get('container'))
                ->count() + 1;
        $this->record->component()->save($pageComponent);
    }


    public function afterUpdate(): void
    {
        // Delete file associations
        if (isset($this->record->file_associations)) {
            foreach ($this->record->file_associations()->get() as $fileAssociation) {
                if ($this->request->get($fileAssociation->identifier) != '' || $this->request->get($fileAssociation->identifier) == 'deleted') {
                    $fileAssociation->delete();
                }
            }
        }
    }


    /**
     * @param $field
     */
    protected function addFileAssociation($field, $customProperties = []): void
    {
        if ($this->request->get($field) == '' || $this->request->get($field) == 'deleted') {
            // Update file association in case we already have one
            if (count($customProperties) > 0) {
                foreach ($this->record->file_associations()->where('identifier', $field)->get() as $fileAssociation) {
                    $fileAssociation->custom_properties = $customProperties;
                    $fileAssociation->save();
                }
            }
            return;
        }

        $file = json_decode($this->request->get($field));

        // Create file association
        $fileAssociation = new FileAssociation();
        $fileAssociation->file_id = $file->id;
        $fileAssociation->model_type = get_class($this->record);
        $fileAssociation->model_id = $this->record->id;
        $fileAssociation->identifier = $field;
        if (count($customProperties) > 0) {
            $fileAssociation->custom_properties = $customProperties;
        }
        $fileAssociation->save();
    }
}
