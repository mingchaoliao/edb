<?php

namespace App\Http\Controllers;

use App\Species;
use Illuminate\Http\Request;

use App\Scheme;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SpeciesController extends Controller
{
    /**
     * Display a listing of the species.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$speciesArr = DB::select("
		select id, species_name
		from species
		inner join 
			(select oid, max(version) as mv
			from species
			where is_approved = 1
			group by oid) maxt
		on (species.oid = maxt.oid and species.version = maxt.mv)
		where is_approved = 1
		");

		return view('species.index', ['speciesArr' => $speciesArr]);
    }

    /**
     * Show the page for creating a new species.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$schemeArr = Scheme::get();
		return view('species.create', ['schemeArr' => $schemeArr]);
    }

    /**
     * Store a newly created species in species table.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$data = $request->all();
		unset($data['_token']);

		Species::createWithCurrentUser($data);
		return view('home');
    }

    /**
     * Display the specified species by id.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
		$schemeArr = Scheme::get();

		$species = Species::where('id', $id)->first();

		return view('species.show', ['species' => $species, 'schemeArr' => $schemeArr]);
    }

    /**
     * Show the form for editing the specified species.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		$schemeArr = Scheme::get();
        $species = Species::where('is_approved', 1)->where('id', $id)->firstOrFail();

		return view('species.edit', ['species' => $species, 'schemeArr' => $schemeArr]);
    }

    /**
     * Update the specified species in species table.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
		$data = $request->all();
		unset($data['_token']);

		$lastInsertedId = Species::updateWithCurrentUser($id, $data);
		return redirect(route('species.index'));
    }

    /**
     * Remove the specified species from species table.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $species = Species::find($id)->select('oid')->first();
		Species::where(['oid' => $species->oid])->delete();
		return redirect(route('species.index'));
    }

	/**
	 * Display a listing of history for specified species and attribute.
	 *
	 * @param  int  $id
	 * @param  string  $key
	 * @return \Illuminate\Http\Response
	 */
	public function history($id, $key)
	{
		$oid = Species::find($id)->oid;
		$speciesArr = Species::select([$key, 'species.created_at', 'users.name'])->join('users', 'species.user_id', 'users.id')->where('oid', $oid)->where('is_approved', 1)->orderBy('version', 'desc')->get()->toArray();
		$isFirst = true;
		$oldData = '';

		for($i = count($speciesArr) - 1; $i >= 0; $i--) {
			if($isFirst) {
				$isFirst = false;
			} else {
				if($speciesArr[$i][$key] == $oldData) {
					unset($speciesArr[$i]);
					continue;
				}
			}
			$oldData = $speciesArr[$i][$key];
		}
		$speciesArr = array_values($speciesArr);
		for($i = 0; $i < count($speciesArr); $i++) {
			if($i == 0) $speciesArr[$i]['version'] = 'latest';
			elseif($i == count($speciesArr) - 1) $speciesArr[$i]['version'] = 'Origin';
			else $speciesArr[$i]['version'] = count($speciesArr) - $i;
		}

		return view('species.history', ['speciesArr' => $speciesArr, 'key' => $key]);
	}
}
