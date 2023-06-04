<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\Identifier;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Roles\CreateRequest;
use App\Http\Requests\Roles\UpdateRequest;
use App\Http\Resources\Roles\Moduleresource;
use App\Http\Resources\Roles\RoleResource;
use App\Http\Resources\Roles\RoleResources;
use App\Http\Resources\Roles\RoleResourcesCollection;
use App\Http\Resources\Roles\RoleSelectResources;
use App\Services\AuthorizationService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class AuthorizationController extends ApiController
{

    public function __init__()
    {
        $this->service = new AuthorizationService();
    }


    /**
     * [Description for getModulesForSelect]
     *
     * @param Request $request
     * @param mixed $type
     * 
     * @return [type]
     * 
     */
    public function getModulesForSelect(Request $request){
        try {
            $modules=$this->service->getModulesForSelect();
            return $this->authorized("select")->setMessage("Module list for select")
            ->respond(Moduleresource::collection($modules));
         } catch ( \Exception $exception) {
             return $this->exceptionRespond($exception);
        }
    }

    /**
     * [Description for getForSelect]
     *
     * @param Request $request
     *
     * @return [type]
     *
     */
    public function getRolesForSelect(Request $request){
        try {
            $this->authorized("select");
            $roles=$this->service->index();
            return  $this->setMessage()->respond(RoleSelectResources::collection($roles));
         } catch ( \Exception $exception) {
             return $this->exceptionRespond($exception);
        }
    }

    /**
     * [Description for index]
     *
     * @param Request $request
     *
     * @return [type]
     *
     */
    public function index(Request $request)
    {
        try {
            $this->authorized("index")->setMessage();
            $roles=$this->service->index(
                [
                    "filters"    =>  $request->query()?Arr::only($request->query(),['search','trashed']):[],
                ],
                true,
                10,
                $request->query("page")
            );
            return $this->respond(new RoleResourcesCollection($roles));
         } catch ( \Exception $exception) {
             return $this->exceptionRespond($exception);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        try {
            return $this->authorized("create")->setMessage()
            ->respond(new RoleResource($this->dispatchService->store($request->all())));
         } catch ( \Exception $exception) {
             return $this->exceptionRespond($exception);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Identifier $role, $filters=[])
    {
        try {
            return $this->authorized("show")->setMessage()
            ->respond(new RoleResource($this->service->show($role)));
         } catch ( \Exception $exception) {
             return $this->exceptionRespond($exception);
        }
    }

    /**
     * [Description for update]
     *
     * @param RoleUpdateRequest $request
     * @param mixed $id
     * 
     * @return [type]
     * 
     */
    public function update(UpdateRequest $request, Identifier $role)
    {   
        try {
            return $this->authorized("update")->setMessage()
            ->respond(new RoleResources($this->dispatchService->update($role, $request->all())));
         } catch ( \Exception $exception) {
             return $this->exceptionRespond($exception);
        }
    }


}