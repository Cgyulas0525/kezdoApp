<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserstatusRequest;
use App\Http\Requests\UpdateUserstatusRequest;
use App\Repositories\UserstatusRepository;
use App\Http\Controllers\AppBaseController;

use App\Models\Userstatus;

use Illuminate\Http\Request;
use Flash;
use Response;
use Auth;
use DB;
use DataTables;

class UserstatusController extends AppBaseController
{
    /** @var UserstatusRepository $userstatusRepository*/
    private $userstatusRepository;

    public function __construct(UserstatusRepository $userstatusRepo)
    {
        $this->userstatusRepository = $userstatusRepo;
    }

    public function dwData($data)
    {
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = '<a href="' . route('userstatuses.edit', [$row->id]) . '"
                             class="edit btn btn-success btn-sm editProduct" title="Módosítás"><i class="fa fa-paint-brush"></i></a>';
                $btn = $btn.'<a href="' . route('beforeDestroys', ['Userstatus', $row["id"], 'userstatuses']) . '"
                                 class="btn btn-danger btn-sm deleteProduct" title="Törlés"><i class="fa fa-trash"></i></a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }


    /**
     * Display a listing of the Userstatus.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        if( Auth::check() ){

            if ($request->ajax()) {

                $data = $this->userstatusRepository->all();
                return $this->dwData($data);

            }

            return view('userstatuses.index');
        }
    }

    /**
     * Show the form for creating a new Userstatus.
     *
     * @return Response
     */
    public function create()
    {
        return view('userstatuses.create');
    }

    /**
     * Store a newly created Userstatus in storage.
     *
     * @param CreateUserstatusRequest $request
     *
     * @return Response
     */
    public function store(CreateUserstatusRequest $request)
    {
        $input = $request->all();

        $userstatus = $this->userstatusRepository->create($input);

        return redirect(route('userstatuses.index'));
    }

    /**
     * Display the specified Userstatus.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $userstatus = $this->userstatusRepository->find($id);

        if (empty($userstatus)) {
            return redirect(route('userstatuses.index'));
        }

        return view('userstatuses.show')->with('userstatus', $userstatus);
    }

    /**
     * Show the form for editing the specified Userstatus.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $userstatus = $this->userstatusRepository->find($id);

        if (empty($userstatus)) {
            return redirect(route('userstatuses.index'));
        }

        return view('userstatuses.edit')->with('userstatus', $userstatus);
    }

    /**
     * Update the specified Userstatus in storage.
     *
     * @param int $id
     * @param UpdateUserstatusRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUserstatusRequest $request)
    {
        $userstatus = $this->userstatusRepository->find($id);

        if (empty($userstatus)) {
            return redirect(route('userstatuses.index'));
        }

        $userstatus = $this->userstatusRepository->update($request->all(), $id);

        return redirect(route('userstatuses.index'));
    }

    /**
     * Remove the specified Userstatus from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $userstatus = $this->userstatusRepository->find($id);

        if (empty($userstatus)) {
            return redirect(route('userstatuses.index'));
        }

        $this->userstatusRepository->delete($id);

        return redirect(route('userstatuses.index'));
    }

        /*
         * Dropdown for field select
         *
         * return array
         */
        public static function DDDW() : array
        {
            return [" "] + userstatus::orderBy('name')->pluck('name', 'id')->toArray();
        }
}



