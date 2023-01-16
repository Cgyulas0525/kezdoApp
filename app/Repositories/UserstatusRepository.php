<?php

namespace App\Repositories;

use App\Models\Userstatus;
use App\Repositories\BaseRepository;

/**
 * Class UserstatusRepository
 * @package App\Repositories
 * @version January 16, 2023, 11:47 am UTC
*/

class UserstatusRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'commit'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Userstatus::class;
    }
}
