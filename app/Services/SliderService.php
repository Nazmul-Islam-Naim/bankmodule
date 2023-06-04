<?php

namespace App\Services;

use App\Contracts\Repositories\SliderRepositoryInterface;
use App\Exceptions\GeneralException;
use Exception;
use Illuminate\Support\Arr;

class SliderService extends CoreService
{
    public $encryptedId = true;
    protected $name = "Slider";

    public function __construct()
    {
        $this->repository = app()->make(SliderRepositoryInterface::class);
    }


    /**
     * [Store Slider]
     *
     * @param array $data
     *
     * @return Slider $slider
     *
     */
    public function store($data)
    {
        try {

            if (Arr::has($data, 'slider_image')) {
                $data['slider_image'] = $this->upload(Arr::pull($data, 'slider_image'), 'sliders');
            }

            return Parent::store($data);
        } catch (Exception $exception) {
            throw new GeneralException($exception, "Failed to store Slider");
        }
    }


    /**
     * [Update Slider]
     *
     * @param array $data
     *
     * @return Slider $slider
     *
     */
    public function update($identifier, $data, $options = [], $callback = null)
    {
        try {

            if (Arr::has($data, 'slider_image')) {
                $data['slider_image'] = $this->upload(Arr::pull($data, 'slider_image'), 'sliders');
            }
            return Parent::update($identifier, $data);
        } catch (Exception $exception) {
            throw new GeneralException($exception, "Failed to update Slider");
        }
    }

    
    /**
     * updateStatus
     *
     * @param  mixed $identifier
     * @param  mixed $data
     * @param  mixed $options
     * @param  mixed $callback
     * @return void
     */
    public function updateStatus($identifier, $data, $options = [], $callback = null)
    {
        $data['status'] = Arr::pull($data, 'status');
        $model = Parent::update($identifier, $data, $options, $callback = null);
        return $model!=null;
    }

}
