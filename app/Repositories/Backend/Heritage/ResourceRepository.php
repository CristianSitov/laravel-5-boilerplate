<?php

namespace App\Repositories\Backend\Heritage;

use App\Http\Requests\Request;
use App\Models\Heritage\HeritageResource;
use App\Models\Heritage\ResourceClassificationType;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use App\Events\Backend\Heritage\ResourceCreated;
use App\Events\Backend\Access\User\UserDeleted;
use App\Events\Backend\Access\User\UserUpdated;
use App\Events\Backend\Access\User\UserRestored;
use App\Events\Backend\Access\User\UserDeactivated;
use App\Events\Backend\Access\User\UserReactivated;
use App\Events\Backend\Access\User\UserPasswordChanged;
use App\Repositories\Backend\Access\Role\RoleRepository;
use App\Events\Backend\Access\User\UserPermanentlyDeleted;
use App\Notifications\Frontend\Auth\UserNeedsConfirmation;

/**
 * Class ResourceRepository.
 */
class ResourceRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = HeritageResource::class;

    /**
     * @param int  $status
     * @param bool $trashed
     *
     * @return mixed
     */
    public function getForDataTable($status = 1, $trashed = false)
    {
        $dataTableQuery = $this->query()
            ->get();

        if ($trashed == 'true') {
            return $dataTableQuery->onlyTrashed();
        }

        return $dataTableQuery;
    }

    /**
     * @param Model $input
     */
    public function create($input)
    {
        $data = $input['data'];

        $resourceClassName = self::MODEL;
        $resource = $resourceClassName::create([
            'name' => $data['name'],
            'description' => $data['description']
        ]);

        $type = ResourceClassificationType::where('type', '=', 'edifice')->first();
        if (!$type instanceof ResourceClassificationType) {
            $type = new ResourceClassificationType(['type' => 'edifice']);
        }

        if ($resource->has_type()->save($type)) {
            event(new ResourceCreated($resource));

            return true;
        }
    }
}
