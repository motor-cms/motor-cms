<?php

namespace Motor\CMS\Transformers\Frontend;

use Illuminate\Support\Str;
use League\Fractal;
use League\Fractal\Manager;
use League\Fractal\Serializer\ArraySerializer;
use Motor\CMS\Models\Page;
use Motor\CMS\Models\PageVersion;

/**
 * Class PageTransformer
 * @package Motor\CMS\Transformers\Frontend
 */
class PageVersionTransformer extends Fractal\TransformerAbstract
{

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [];


    /**
     * Transform record to array
     *
     * @param PageVersion $record
     *
     * @return array
     */
    public function transform(PageVersion $record)
    {
        $data = [];

        foreach ($record->components()->orderBy('container')->orderBy('sort_position')->get() as $pageComponent) {
            //if (! isset($data[$pageComponent->container])) {
            //    $data[$pageComponent->container] = [];
            //}

            $componentTransformerClass = config('motor-cms-page-components.components.'.$pageComponent->component_name.'.transformer_class');

            if (class_exists($componentTransformerClass)) {
                $resource = $this->item($pageComponent, new $componentTransformerClass);
                $manager = new Manager();
                $manager->setSerializer(new ArraySerializer());
                $data[] = $manager->createData($resource)->toArray();
            }
        }

        return $data;
    }
}
