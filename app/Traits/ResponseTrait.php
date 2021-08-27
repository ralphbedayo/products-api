<?php

namespace App\Traits;

use App\Exceptions\ResourceNotFoundException;
use Illuminate\Support\Facades\Log;
use League\Fractal\TransformerAbstract;
use Spatie\Fractal\Fractal as Fractal;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Collection;
use ReflectionClass;
use ReflectionException;

/**
 * Class ResponseTrait
 *
 * This is a very useful trait modified from file in Apiato https://github.com/apiato/apiato/blob/8.0/app/Ship/core/Traits/ResponseTrait.php
 *
 *
 * @author  Mahmoud Zalt  <mahmoud@zalt.me>
 * @author  Ralph Lawrence S. Bedayo  <ralphbedayo009@gmail.com>
 */
trait ResponseTrait
{

    /**
     * @var  array
     */
    protected $metaData = [];

    /**
     * @param       $data
     * @param null $transformerName The transformer (e.g., Transformer::class or new Transformer()) to be applied
     * @param array $includes additional resources to be included
     * @param array $meta additional meta information to be applied
     * @return array
     * @throws ResourceNotFoundException
     */
    public function transform(
        $data,
        $transformerName = null,
        array $includes = [],
        array $meta = []
    ) {
        // first, we need to create the transformer
        if ($transformerName instanceof TransformerAbstract) {
            // check, if we have provided a respective TRANSFORMER class
            $transformer = $transformerName;
        }
        else {
            // of if we just passed the classname
            $transformer = new $transformerName;
        }

        // now, finally check, if the class is really a TRANSFORMER
        if (! ($transformer instanceof TransformerAbstract)) {
            Log::error('Transformer ' . $transformerName . 'is invalid.');
            throw new ResourceNotFoundException();
        }

        // add specific meta information to the response message
        $this->metaData = [
            'include' => $transformer->getAvailableIncludes(),
            'custom'  => $meta,
        ];

        $fractal = Fractal::create($data, $transformer)->addMeta($this->metaData);

        // read includes passed via query params in url
        $requestIncludes = $this->parseRequestedIncludes();

        // merge the requested includes with the one added by the transform() method itself
        $requestIncludes = array_unique(array_merge($includes, $requestIncludes));

        // and let fractal include everything
        $fractal->parseIncludes($requestIncludes);

        // apply request filters if available in the request
        if ($requestFilters = request()->get('filter')) {
            $result = $this->filterResponse($fractal->toArray(), explode(';', $requestFilters));
        } else {
            $result = $fractal->toArray();
        }

        return $result;
    }


    /**
     * @param $data
     *
     * @return  $this
     */
    public function withMeta($data)
    {
        $this->metaData = $data;

        return $this;
    }

    /**
     * @param       $message
     * @param int   $status
     * @param array $headers
     * @param int   $options
     *
     * @return  JsonResponse
     */
    public function json($message, $status = 200, array $headers = [], $options = 0)
    {
        return new JsonResponse($message, $status, $headers, $options);
    }

    /**
     * @param null  $message
     * @param int   $status
     * @param array $headers
     * @param int   $options
     *
     * @return JsonResponse
     */
    public function created($message = null, $status = 201, array $headers = [], $options = 0)
    {
        return new JsonResponse($message, $status, $headers, $options);
    }

    /**
     * @param null  array or string $message
     * @param int   $status
     * @param array $headers
     * @param int   $options
     *
     * @return  JsonResponse
     */
    public function accepted($message = null, $status = 202, array $headers = [], $options = 0)
    {
        return new JsonResponse($message, $status, $headers, $options);
    }


    /**
     * @param int $status
     *
     * @return  JsonResponse
     */
    public function noContent($status = 204)
    {
        return new JsonResponse(null, $status);
    }


    /**
     * @param array $responseArray
     * @param array $filters
     *
     * @return array
     */
    private function filterResponse(array $responseArray, array $filters)
    {
        foreach ($responseArray as $k => $v) {
            if (in_array($k, $filters, true)) {
                // we have found our element - so continue with the next one
                continue;
            }

            if (is_array($v)) {
                // it is an array - so go one step deeper
                $v = $this->filterResponse($v, $filters);
                if (empty($v)) {
                    // it is an empty array - delete the key as well
                    unset($responseArray[$k]);
                } else {
                    $responseArray[$k] = $v;
                }
                continue;
            } else {
                // check if the array is not in our filter-list
                if (!in_array($k, $filters)) {
                    unset($responseArray[$k]);
                    continue;
                }
            }
        }

        return $responseArray;
    }

    /**
     * @return array
     */
    protected function parseRequestedIncludes()
    {
        return explode(',', request()->get('include'));
    }

}
