<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Userstatus;

use Flash;
use Response;
use Auth;
use DB;
use DataTables;

use App\Classes\fileUploadClass;

class UsersController extends Controller
{
    public function dwData($data)
    {
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('rgnev', function($data) { return $data->rgnev; })
            ->addColumn('action', function($row){
                $btn = '<a href="' . route('userEdit', [$row->id]) . '"
                             class="edit btn btn-success btn-sm editProduct" title="Módosítás"><i class="fa fa-paint-brush"></i></a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }


    /**
     * Display a listing of the Users.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        if( Auth::check() ){

            if ($request->ajax()) {

                $data = DB::table('users as t1')
                    ->join('userstatus as t2', 't2.id', '=', 't1.userstatus_id')
                    ->select('t1.*', 't2.name as rgnev')
                    ->whereNull('t1.deleted_at')
                    ->whereNull('t2.deleted_at')
                    ->get();
                return $this->dwData($data);

            }

            return view('users.index');
        }
    }

    public function edit($id) {
        $user = User::find($id);

        if (empty($user)) {
            return redirect(route('userIndex'));
        }

        return view('users.edit')->with('users', $user);

    }

    public static function userStatusDDW() {
        return [" "] + Userstatus::orderBy('name')->pluck('name', 'id')->toArray();
    }


    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (empty($user)) {
            return redirect(route('userIndex'));
        }

        $input = $request->all();
        if (isset($input['image_url'])) {
            if (file_exists($user->image_url)) {
                unlink($user->imaeg_url);
            }
            $name = $this->fileUpload->fileUpload($input['image_url']);
            $input['image_url'] = 'public/docs/' . $name;
        }

        $user->image_url  = isset($input['image_url']) ? $input['image_url'] : $user->image_url;
        $user->commit = $input['commit'];
        $user->userstatus_id = $input['userstatus_id'];
        $user->update();

        return redirect(route('userIndex'));
    }

}
