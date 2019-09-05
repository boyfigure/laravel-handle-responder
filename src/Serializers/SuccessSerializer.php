<?php

namespace Offspring\Responder\Serializers;

use League\Fractal\Serializer\ArraySerializer;


class SuccessSerializer extends ArraySerializer
{
    /**
     * Serialize collection resources.
     *
     * @param  string $resourceKey
     * @param  array  $data
     * @return array
     */
    public function collection($resourceKey, array $data)
    {
        return ['data' => $data];
    }

    /**
     * Serialize item resources.
     *
     * @param  string $resourceKey
     * @param  array  $data
     * @return array
     */
    public function item($resourceKey, array $data)
    {
        return ['data' => $data];
    }

    /**
     * Serialize null resources.
     *
     * @return array
     */
    public function null()
    {
        return ['data' => null];
    }

    /**
     * Format meta data.
     *
     * @param  array $meta
     * @return array
     */
    public function meta(array $meta)
    {
        return $meta;
    }



    /**
     * Merge includes into data.
     *
     * @param  array $transformedData
     * @param  array $includedData
     * @return array
     */
    public function mergeIncludes($transformedData, $includedData)
    {
        foreach (array_keys($includedData) as $key) {
            $includedData[$key] = $includedData[$key]['data'];
        }

        return array_merge($transformedData, $includedData);
    }
}
