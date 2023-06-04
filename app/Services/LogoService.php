<?php

namespace App\Services;

use App\Contracts\Repositories\LogoRepositoryInterface;
use App\Exceptions\GeneralException;
use Exception;
use Illuminate\Support\Arr;

class LogoService extends CoreService
{
    public $encryptedId = true;
    protected $name = "Logo";

    public function __construct()
    {
        $this->repository = app()->make(LogoRepositoryInterface::class);
    }


    /**
     * [Store Logo]
     *
     * @param array $data
     *
     * @return Logo $logo
     *
     */
    public function store($data)
    {
        try {

            if (Arr::has($data, 'fav_icon')) {
                $data['fav_icon'] = $this->upload(Arr::pull($data, 'fav_icon'), 'logos/fav-icon');
            }

            if (Arr::has($data, 'header_logo')) {
                $data['header_logo'] = $this->upload(Arr::pull($data, 'header_logo'), 'logos/header-logo');
            }

            if (Arr::has($data, 'footer_logo')) {
                $data['footer_logo'] = $this->upload(Arr::pull($data, 'footer_logo'), 'logos/footer-logo');
            }
            return Parent::store($data);
        } catch (Exception $exception) {
            throw new GeneralException($exception, "Failed to store Logo");
        }
    }


    /**
     * [Update Logo]
     *
     * @param array $data
     *
     * @return Logo $logo
     *
     */
    public function update($identifier, $data, $options = [], $callback = null)
    {   
        try {

            if (Arr::has($data, 'fav_icon')) {
                $data['fav_icon'] = $this->upload(Arr::pull($data, 'fav_icon'), 'logos/fav-icon');
            }

            if (Arr::has($data, 'header_logo')) {
                $data['header_logo'] = $this->upload(Arr::pull($data, 'header_logo'), 'logos/header-logo');
            }

            if (Arr::has($data, 'footer_logo')) {
                $data['footer_logo'] = $this->upload(Arr::pull($data, 'footer_logo'), 'logos/footer-logo');
            }

            return Parent::update($identifier, $data);
        } catch (Exception $exception) {
            throw new GeneralException($exception, "Failed to update Logo");
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
