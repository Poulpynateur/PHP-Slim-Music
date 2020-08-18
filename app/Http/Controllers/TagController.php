<?php

namespace App\Http\Controllers;

use Validator;
use App\Tag;
use Illuminate\Http\Request;

class TagController extends Controller {

    // TODO: try catch
    public function add(Request $request) {
        $element = new Tag();

        $validator = Validator::make($request->all(), array(
            'name' => 'required | unique:tags',
        ));

        if ($validator->fails()) {
            return response()->json(['message' => 'Name must be unique.'], 422);
        }

        try {
            $element->name = $request->input('name');
            $element->save();
        } catch (Exception $e) {
            return response()->json(['message' => 'Error with database.'], 500);
        }

        return response()->json([
            'message' => 'Element added successfully.',
            'result' => $element]
            , 200);
    }

    public function remove(Request $request, $id) {
        Tag::destroy($id);
        return response()->json(['message' => 'Element removed successfully.'], 200);
    }

    public function getAll(Request $request) {
        return response()->json(Tag::all(), 200);
    }

    // Basically every elements withour parents
    public function getRoot(Request $request) {
        return response()->json(Tag::all(), 200);
    }
    public function search(Request $request) {
        return response()->json(Tag::where('parent_id'), 200);
    }
    public function getChildrens(Request $request, $id) {
        return response()->json(Tag::all(), 200);
    }
}
