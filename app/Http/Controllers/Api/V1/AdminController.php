<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\Identifier;
use App\Helpers\Helper;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Admins\CreateRequest;
use App\Http\Requests\Admins\UpdateRequest;
use App\Http\Requests\Admins\UpdateStatusRequest;
use App\Http\Resources\Admins\AdminResource;
use App\Http\Resources\Admins\AdminResources;
use App\Http\Resources\Admins\AdminResourcesCollection;
use App\Services\AdminService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class AdminController extends ApiController
{

    public function __init__()
    {
        $this->service = new AdminService();
    }

    /**
     * [ge status]
     *
     * @param Request $request
     *
     * @return [type]
     *
     */
    public function getStatus(Request $request)
    {
        try {
            $this->authorized("index")->setMessage('Status Fetched');
            $status = $this->service->getStatus();
            return $this->respond($status);
        } catch (\Exception $exception) {
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

            $admins = $this->service->index(
                [
                    "filters"  =>  $request->query() ? Arr::only($request->query(), ['search', 'trashed','status']) : []
                ],
                true,
                50,
                $request->query("page")
            );
            return $this->respond(new AdminResourcesCollection($admins));
        } catch (\Exception $exception) {
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
        // logger()->error("hllow");
        try {
            return $this->authorized("store")->setMessage()
                ->respond(new AdminResource($this->dispatchService->store($request->all())));
        } catch (\Exception $exception) {
            return $this->exceptionRespond($exception);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Identifier $admin, $filters = [])
    {
        try {
            return $this->authorized("show")->setMessage()
                ->respond(new AdminResource($this->service->show($admin)));
        } catch (\Exception $exception) {
            return $this->exceptionRespond($exception);
        }
    }

    /**
     * [Description for update]
     *
     * @param UpdateRequest $request
     * @param mixed $id
     *
     * @return [type]
     *
     */
    public function update(UpdateRequest $request, Identifier $admin)
    {

        try {
            return $this->authorized("update")->setMessage()
                ->respond(new AdminResource($this->dispatchService->update($admin, $request->all())));
        } catch (\Exception $exception) {
            return $this->exceptionRespond($exception);
        }
    }

    /**
     * statusUpdate
     *
     * @param  mixed $request
     * @param  mixed $admin
     * @return void
     */
    public function statusUpdate(UpdateStatusRequest $request, Identifier $admin)
    {

        try {
            return $this->authorized("update")->setMessage()
                ->respond($this->dispatchService->updateStatus($admin, $request->all()));
        } catch (\Exception $exception) {
            return $this->exceptionRespond($exception);
        }
    }
}
