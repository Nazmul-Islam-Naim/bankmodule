<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\Identifier;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Sliders\CreateRequest;
use App\Http\Requests\Sliders\UpdateRequest;
use App\Http\Requests\Sliders\UpdateStatusRequest;
use App\Http\Resources\Sliders\SliderResource;
use App\Http\Resources\Sliders\SliderResourcesCollection;
use App\Services\SliderService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class SliderController extends ApiController
{

    public function __init__(){
        $this->service = new SliderService();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $this->authorized('index')->setMessage();
            $sliders = $this->service->index(
                [
                    "filters"    =>  $request->query() ? Arr::only($request->query(), ['search','trashed']) : []
                ],
                true,
                50,
                $request->query("page")
            );
            return $this->respond(new SliderResourcesCollection($sliders));
        } catch (\Exception $exception) {

            return $this->exceptionRespond($exception);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(CreateRequest $request)
    {
        try {
            return $this->authorized("store")->setMessage()
                ->respond($this->dispatchService->store($request->all()));
        } catch (\Exception $exception) {
            return $this->exceptionRespond($exception);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   public function show(Identifier $slider, $filters = [])
    {
        try {
            $this->authorized('show')->setMessage();
            return $this->respond(new SliderResource($this->service->show($slider)));
        } catch (\Exception $exception) {
            return $this->exceptionRespond($exception);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Identifier $slider)
    {
        try {
            return $this->authorized("update")->setMessage()
                ->respond(new SliderResource($this->dispatchService->update($slider, $request->all())));
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
    public function statusUpdate(UpdateStatusRequest $request, Identifier $id)
    {

        try {
            return $this->authorized("update")->setMessage()
                ->respond($this->dispatchService->updateStatus($id, $request->all()));
        } catch (\Exception $exception) {
            return $this->exceptionRespond($exception);
        }
    }
}
