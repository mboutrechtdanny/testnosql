<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TagsController extends Controller {

	public function __construct() {
		$this->middleware('auth');
	}

	public function index() {
		return view('tags');
	}

	public function changeTags($slotId) {

		$tags = \DB::table('slots_tags')
			->where('slot_id', '=', $slotId)
			->join('tags', 'slots_tags.tag_id', '=', 'tags.id')
			->get();

		$all_tags = \DB::table('tags')->get();

		return view('tags-change', ['tags' => $tags, 'all_tags' => $all_tags]);

	}

	public function changeTagsStore(Request $request, $slotId) {

		\DB::table('slots_tags')->insert([
			'slot_id' => $slotId,
			'tag_id' => $request->get('new_tag')
		]);

		return redirect()->back();
	}

	public function changeTagsDelete(Request $request, $slotId) {

			\DB::table('slots_tags')->where([
			'slot_id' => $slotId,
			'tag_id' => $request->get('tag_id')
		])->delete();

		return redirect()->back();
	}

}
