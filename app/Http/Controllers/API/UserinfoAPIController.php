<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateUserinfoAPIRequest;
use App\Http\Requests\API\UpdateUserinfoAPIRequest;
use App\Models\Userinfo;
use App\Repositories\UserinfoRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class UserinfoController
 * @package App\Http\Controllers\API
 */

class UserinfoAPIController extends AppBaseController
{
    /** @var  UserinfoRepository */
    private $userinfoRepository;

    public function __construct(UserinfoRepository $userinfoRepo)
    {
        $this->userinfoRepository = $userinfoRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/userinfos",
     *      summary="Get a listing of the Userinfos.",
     *      tags={"Userinfo"},
     *      description="Get all Userinfos",
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
     *                  @SWG\Items(ref="#/definitions/Userinfo")
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
        $this->userinfoRepository->pushCriteria(new RequestCriteria($request));
        $this->userinfoRepository->pushCriteria(new LimitOffsetCriteria($request));
        $userinfos = $this->userinfoRepository->all();

        return $this->sendResponse($userinfos->toArray(), 'Userinfos retrieved successfully');
    }

    /**
     * @param CreateUserinfoAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/userinfos",
     *      summary="Store a newly created Userinfo in storage",
     *      tags={"Userinfo"},
     *      description="Store Userinfo",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Userinfo that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Userinfo")
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
     *                  ref="#/definitions/Userinfo"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateUserinfoAPIRequest $request)
    {
        $input = $request->all();

        $userinfos = $this->userinfoRepository->create($input);

        return $this->sendResponse($userinfos->toArray(), 'Userinfo saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/userinfos/{id}",
     *      summary="Display the specified Userinfo",
     *      tags={"Userinfo"},
     *      description="Get Userinfo",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Userinfo",
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
     *                  ref="#/definitions/Userinfo"
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
        /** @var Userinfo $userinfo */
        $userinfo = $this->userinfoRepository->findWithoutFail($id);

        if (empty($userinfo)) {
            return $this->sendError('Userinfo not found');
        }

        return $this->sendResponse($userinfo->toArray(), 'Userinfo retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateUserinfoAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/userinfos/{id}",
     *      summary="Update the specified Userinfo in storage",
     *      tags={"Userinfo"},
     *      description="Update Userinfo",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Userinfo",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Userinfo that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Userinfo")
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
     *                  ref="#/definitions/Userinfo"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateUserinfoAPIRequest $request)
    {
        $input = $request->all();

        /** @var Userinfo $userinfo */
        $userinfo = $this->userinfoRepository->findWithoutFail($id);

        if (empty($userinfo)) {
            return $this->sendError('Userinfo not found');
        }

        $userinfo = $this->userinfoRepository->update($input, $id);

        return $this->sendResponse($userinfo->toArray(), 'Userinfo updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/userinfos/{id}",
     *      summary="Remove the specified Userinfo from storage",
     *      tags={"Userinfo"},
     *      description="Delete Userinfo",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Userinfo",
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
        /** @var Userinfo $userinfo */
        $userinfo = $this->userinfoRepository->findWithoutFail($id);

        if (empty($userinfo)) {
            return $this->sendError('Userinfo not found');
        }

        $userinfo->delete();

        return $this->sendResponse($id, 'Userinfo deleted successfully');
    }
}
