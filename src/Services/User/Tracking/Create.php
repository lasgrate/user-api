<?php

namespace App\Services\User\Tracking;

use App\Entity\Tracking;
use App\Services\Validator;
use Psr\Log\LoggerInterface;
use Ramsey\Uuid\Uuid;
use App\Models\User as UserModel;
use App\Models\Tracking as TrackingModel;
use App\Services\User\Base as BaseUserService;

class Create extends BaseUserService
{
    /**
     * @var TrackingModel
     */
    private $trackingModel;

    public function __construct(
        LoggerInterface $logger,
        UserModel $userModel,
        TrackingModel $trackingModel
    ) {
        parent::__construct($logger, $userModel);

        $this->trackingModel = $trackingModel;
    }

    final protected function validate(array $params): array
    {
        $rules = [
            'source_label' => ['required', 'string', 'not_empty', ['max_length' => 64]],
            'id_user' => ['required', 'string', ['max_length' => 64]],
        ];

        return Validator::validate($params, $rules);
    }

    final protected function execute(array $validated): array
    {
        $tracking = new Tracking([
            'id_user' => $validated['id_user'] ?: Uuid::uuid4(),
            'source_label' => $validated['source_label']
        ]);

        $this->trackingModel->insert($tracking);

        return [
            'status' => 1,
            'is_authorize' => $validated['id_user'] ? 1 : 0,
            'id_user' => $tracking->getUserId()
        ];
    }
}
