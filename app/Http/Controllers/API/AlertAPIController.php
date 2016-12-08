<?php

/*
 * @author Phillip Madsen
 */

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\CreateAlertAPIRequest;
use App\Http\Requests\API\UpdateAlertAPIRequest;
use App\Models\Alert;
use App\Repositories\AlertRepository;
use Illuminate\Http\Request;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class AlertController.
 */
class AlertAPIController extends AppBaseController
{
    /** @var AlertRepository */
    private $alertRepository;

    public function __construct(AlertRepository $alertRepo)
    {
        $this->alertRepository = $alertRepo;
    }

    /**
     * @param Request $request
     *
     * @return Response
     *
     * @SWG\Get(
     *      path="/alerts",
     *      summary="Get a listing of the Alerts.",
     *      tags={"Alert"},
     *      description="Get all Alerts",
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
     *                  @SWG\Items(ref="#/definitions/Alert")
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request)
    {
        $this->alertRepository->pushCriteria(new RequestCriteria($request));
        $this->alertRepository->pushCriteria(new LimitOffsetCriteria($request));
        $alerts = $this->alertRepository->all();

        return $this->sendResponse($alerts->toArray(), 'Alerts retrieved successfully');
    }

    /**
     * @param CreateAlertAPIRequest $request
     *
     * @return Response
     *
     * @SWG\Post(
     *      path="/alerts",
     *      summary="Store a newly created Alert in storage",
     *      tags={"Alert"},
     *      description="Store Alert",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Alert that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Alert")
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
     *                  ref="#/definitions/Alert"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateAlertAPIRequest $request)
    {
        $input = $request->all();

        $alerts = $this->alertRepository->create($input);

        return $this->sendResponse($alerts->toArray(), 'Alert saved successfully');
    }

    /**
     * @param int $id
     *
     * @return Response
     *
     * @SWG\Get(
     *      path="/alerts/{id}",
     *      summary="Display the specified Alert",
     *      tags={"Alert"},
     *      description="Get Alert",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Alert",
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
     *                  ref="#/definitions/Alert"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($id)
    {
        /** @var Alert $alert */
        $alert = $this->alertRepository->findWithoutFail($id);

        if (empty($alert)) {
            return $this->sendError('Alert not found');
        }

        return $this->sendResponse($alert->toArray(), 'Alert retrieved successfully');
    }

    /**
     * @param int                   $id
     * @param UpdateAlertAPIRequest $request
     *
     * @return Response
     *
     * @SWG\Put(
     *      path="/alerts/{id}",
     *      summary="Update the specified Alert in storage",
     *      tags={"Alert"},
     *      description="Update Alert",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Alert",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Alert that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Alert")
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
     *                  ref="#/definitions/Alert"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateAlertAPIRequest $request)
    {
        $input = $request->all();

        /** @var Alert $alert */
        $alert = $this->alertRepository->findWithoutFail($id);

        if (empty($alert)) {
            return $this->sendError('Alert not found');
        }

        $alert = $this->alertRepository->update($input, $id);

        return $this->sendResponse($alert->toArray(), 'Alert updated successfully');
    }

    /**
     * @param int $id
     *
     * @return Response
     *
     * @SWG\Delete(
     *      path="/alerts/{id}",
     *      summary="Remove the specified Alert from storage",
     *      tags={"Alert"},
     *      description="Delete Alert",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Alert",
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
     */
    public function destroy($id)
    {
        /** @var Alert $alert */
        $alert = $this->alertRepository->findWithoutFail($id);

        if (empty($alert)) {
            return $this->sendError('Alert not found');
        }

        $alert->delete();

        return $this->sendResponse($id, 'Alert deleted successfully');
    }
}
