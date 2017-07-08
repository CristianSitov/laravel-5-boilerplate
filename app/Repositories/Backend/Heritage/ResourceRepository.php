<?php

namespace App\Repositories\Backend\Heritage;

use App\Http\Requests\Request;
use App\Models\Heritage\Description;
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
use Sgpatil\Orientphp\Batch\Query;
use Webpatser\Uuid\Uuid;

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
//        $dataTableQuery = $this->query()
//            ->with(['HasClassificationType']) // .ResourceClassificationType
//            ->get();
//            ->carry(['HasClassificationType' => 'ResourceClassificationType'])
//        $dataTableQuery = HeritageResource::all();

        $client = new \Sgpatil\Orientphp\Client("localhost", 2480, "hot");
        $client->getTransport()
            ->setAuth("root", "root");
        $query = new Query($client, "select * from `HeritageResources`", []);
        $result = $client->executeBatchQuery($query)->getData();
        dd($result);

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
        $resource = $resourceClassName::create();

        $type = ResourceClassificationType::where('uuid', '=', $data['ResourceClassificationType'])->first();
        $description = Description::create([
            'uuid' => Uuid::generate(4),
            'description' => $data['description'],
        ]);

        if ($resource->hasClassificationType()->save($type)) {
            if ($resource->hasNote()->save($description)) {
                event(new ResourceCreated($resource));
            }

            return true;
        }
    }
}
