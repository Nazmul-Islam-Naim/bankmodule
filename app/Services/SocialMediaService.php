<?php

namespace App\Services;

use App\Contracts\Repositories\SocialMediaRepositoryInterface;
use App\Exceptions\GeneralException;
use Exception;
use Illuminate\Support\Arr;

class SocialMediaService extends CoreService
{
    public $encryptedId = true;
    protected $name = "Social Media";

    public function __construct()
    {
        $this->repository = app()->make(SocialMediaRepositoryInterface::class);
    }


    /**
     * [Store SocialMedia]
     *
     * @param array $data
     *
     * @return SocialMedia $socialMedia
     *
     */
    public function store($data)
    {
        try {

            if (Arr::has($data, 'icon')) {
                $data['icon'] = $this->upload(Arr::pull($data, 'icon'), 'social-media');
            }

            return Parent::store($data);
        } catch (Exception $exception) {
            throw new GeneralException($exception, "Failed to store social media");
        }
    }


    /**
     * [Update SocialMedia]
     *
     * @param array $data
     *
     * @return SocialMedia $socialMedia
     *
     */
    public function update($identifier, $data, $options = [], $callback = null)
    {   
        try {

            if (Arr::has($data, 'icon')) {
                $data['icon'] = $this->upload(Arr::pull($data, 'icon'), 'social-media');
            }
            return Parent::update($identifier, $data);
        } catch (Exception $exception) {
            throw new GeneralException($exception, "Failed to update social media");
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
