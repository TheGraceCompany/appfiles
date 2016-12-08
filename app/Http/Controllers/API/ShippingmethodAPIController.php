<?php



namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Criteria\LimitOffsetCriteria;
use App\Http\Requests\API\CreateShippingmethodAPIRequest;
use App\Http\Requests\API\UpdateShippingmethodAPIRequest;
use App\Models\Shippingmethod;
use App\Repositories\ShippingmethodRepository;
use Illuminate\Http\Request;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class ShippingmethodController.
 */
class ShippingmethodAPIController extends AppBaseController
{
    /** @var ShippingmethodRepository */
    private $shippingmethodRepository;

    public function __construct(ShippingmethodRepository $shippingmethodRepo)
    {
        $this->shippingmethodRepository = $shippingmethodRepo;
    }

    /**
     * @param Request $request
     *
     * @return Response
     *
     * @SWG\Get(
     *      path="/shippingmethods",
     *      summary="Get a listing of the Shippingmethods.",
     *      tags={"Shippingmethod"},
     *      description="Get all Shippingmethods",
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
     *                  @SWG\Items(ref="#/definitions/Shippingmethod")
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
        $this->shippingmethodRepository->pushCriteria(new RequestCriteria($request));
        $this->shippingmethodRepository->pushCriteria(new LimitOffsetCriteria($request));
        $shippingmethods = $this->shippingmethodRepository->all();

        return $this->sendResponse($shippingmethods->toArray(), 'Shippingmethods retrieved successfully');
    }

    /**
     * @param CreateShippingmethodAPIRequest $request
     *
     * @return Response
     *
     * @SWG\Post(
     *      path="/shippingmethods",
     *      summary="Store a newly created Shippingmethod in storage",
     *      tags={"Shippingmethod"},
     *      description="Store Shippingmethod",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Shippingmethod that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Shippingmethod")
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
     *                  ref="#/definitions/Shippingmethod"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateShippingmethodAPIRequest $request)
    {
        $input = $request->all();

        $shippingmethods = $this->shippingmethodRepository->create($input);

        return $this->sendResponse($shippingmethods->toArray(), 'Shippingmethod saved successfully');
    }

    /**
     * @param int $id
     *
     * @return Response
     *
     * @SWG\Get(
     *      path="/shippingmethods/{id}",
     *      summary="Display the specified Shippingmethod",
     *      tags={"Shippingmethod"},
     *      description="Get Shippingmethod",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Shippingmethod",
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
     *                  ref="#/definitions/Shippingmethod"
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
        /** @var Shippingmethod $shippingmethod */
        $shippingmethod = $this->shippingmethodRepository->findWithoutFail($id);

        if (empty($shippingmethod)) {
            return $this->sendError('Shippingmethod not found');
        }

        return $this->sendResponse($shippingmethod->toArray(), 'Shippingmethod retrieved successfully');
    }

    /**
     * @param int                            $id
     * @param UpdateShippingmethodAPIRequest $request
     *
     * @return Response
     *
     * @SWG\Put(
     *      path="/shippingmethods/{id}",
     *      summary="Update the specified Shippingmethod in storage",
     *      tags={"Shippingmethod"},
     *      description="Update Shippingmethod",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Shippingmethod",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Shippingmethod that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Shippingmethod")
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
     *                  ref="#/definitions/Shippingmethod"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateShippingmethodAPIRequest $request)
    {
        $input = $request->all();

        /** @var Shippingmethod $shippingmethod */
        $shippingmethod = $this->shippingmethodRepository->findWithoutFail($id);

        if (empty($shippingmethod)) {
            return $this->sendError('Shippingmethod not found');
        }

        $shippingmethod = $this->shippingmethodRepository->update($input, $id);

        return $this->sendResponse($shippingmethod->toArray(), 'Shippingmethod updated successfully');
    }

    /**
     * @param int $id
     *
     * @return Response
     *
     * @SWG\Delete(
     *      path="/shippingmethods/{id}",
     *      summary="Remove the specified Shippingmethod from storage",
     *      tags={"Shippingmethod"},
     *      description="Delete Shippingmethod",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Shippingmethod",
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
        /** @var Shippingmethod $shippingmethod */
        $shippingmethod = $this->shippingmethodRepository->findWithoutFail($id);

        if (empty($shippingmethod)) {
            return $this->sendError('Shippingmethod not found');
        }

        $shippingmethod->delete();

        return $this->sendResponse($id, 'Shippingmethod deleted successfully');
    }
}
