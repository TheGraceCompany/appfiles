<?php

/*
 * @author Phillip Madsen
 */

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Criteria\LimitOffsetCriteria;
use App\Http\Requests\API\CreateLocationAPIRequest;
use App\Http\Requests\API\UpdateLocationAPIRequest;
use App\Models\Location;
use App\Repositories\LocationRepository;
use Illuminate\Http\Request;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class LocationController.
 */
class LocationAPIController extends AppBaseController
{
    /**
     * @var LocationRepository
     */
    private $locationRepository;

    public function __construct(LocationRepository $locationRepo)
    {
        $this->locationRepository = $locationRepo;
    }

    /**
     * @SWG\Get(
     *      path="/locations",
     *      summary="Get a listing of the Locations.",
     *      tags={"Location"},
     *      description="Get all Locations",
     *      produces={"application/json"},
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="array",
     *                  @SWG\Items(ref="#/definitions/Location")
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $this->locationRepository->pushCriteria(new RequestCriteria($request));
        $this->locationRepository->pushCriteria(new LimitOffsetCriteria($request));
        $locations = $this->locationRepository->all();

        return $this->sendResponse($locations->toArray(), 'Locations retrieved successfully');
    }

    /**
     * @SWG\Post(
     *      path="/locations",
     *      summary="Store a newly created Location in storage",
     *      tags={"Location"},
     *      description="Store Location",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Location that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Location")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Location"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     *
     * @param CreateLocationAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateLocationAPIRequest $request)
    {
        $input = $request->all();

        $locations = $this->locationRepository->create($input);

        return $this->sendResponse($locations->toArray(), 'Location saved successfully');
    }

    /**
     * @SWG\Get(
     *      path="/locations/{id}",
     *      summary="Display the specified Location",
     *      tags={"Location"},
     *      description="Get Location",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Location",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Location"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /**
         * @var Location
         */
        $location = $this->locationRepository->findWithoutFail($id);

        if (empty($location)) {
            return $this->sendError('Location not found');
        }

        return $this->sendResponse($location->toArray(), 'Location retrieved successfully');
    }

    /**
     * @SWG\Put(
     *      path="/locations/{id}",
     *      summary="Update the specified Location in storage",
     *      tags={"Location"},
     *      description="Update Location",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Location",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Location that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Location")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Location"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     *
     * @param int                      $id
     * @param UpdateLocationAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLocationAPIRequest $request)
    {
        $input = $request->all();

        /**
         * @var Location
         */
        $location = $this->locationRepository->findWithoutFail($id);

        if (empty($location)) {
            return $this->sendError('Location not found');
        }

        $location = $this->locationRepository->update($input, $id);

        return $this->sendResponse($location->toArray(), 'Location updated successfully');
    }

    /**
     * @SWG\Delete(
     *      path="/locations/{id}",
     *      summary="Remove the specified Location from storage",
     *      tags={"Location"},
     *      description="Delete Location",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Location",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="string"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /**
         * @var Location
         */
        $location = $this->locationRepository->findWithoutFail($id);

        if (empty($location)) {
            return $this->sendError('Location not found');
        }

        $location->delete();

        return $this->sendResponse($id, 'Location deleted successfully');
    }
}
