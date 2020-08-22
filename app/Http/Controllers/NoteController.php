<?php

namespace App\Http\Controllers;

use Exception;
use App\Note;
use Illuminate\Http\Request;

class NoteController extends Controller {

    private function isNameUnique($id, $parentId, $name) {
        return !$brothers = Note::where([
            ['id', '!=', $id],
            ['parent_id', '=', $parentId],
            ['name', '=', $name]
        ])->exists();
    }

    private function createUpdateNote(Request $request, Note $element) {
        if ($request->has('name')) {
            $element->name = $request->input('name');
        }
        if ($request->has('thumbnailUrl')) {
            $element->thumbnail_url = $request->input('thumbnailUrl');
        }
        if ($request->has('url')) {
            $element->url = $request->input('url');
        }
        if ($request->has('content')) {
            $element->content = $request->input('content');
        }
        if ($request->has('parentId') && !empty($request->input('parentId'))) {
            $parent = Note::find($request->input('parentId'));
            $parent ->has_children = true;
            $parent->save();

            $element->parent_id = $parent->id;
        }
        else if ($request->has('parentName') && !empty($request->input('parentName'))) {
            $parent = Note::where('name', $request->input('parentName'))->first();
            $parent->has_children = true;
            $parent->save();

            $element->parent_id = $parent->id;
        }
        
        $element->save();

        if ($request->has('tags')) {
            $element->tags()->detach();
            foreach ($request->input('tags') as $tag) {
                $element->tags()->attach($tag['id']);
            }
        }
    }
    // TODO: try catch
    public function add(Request $request) {
        $element = new Note();

        if(!$this->isNameUnique(null, $request->input('parentId'), $request->input('name'))) {
            return response()->json(['message' => 'Name must be unique in folder.'], 422);
        }

            $this->createUpdateNote($request, $element);

        return response()->json([
            'message' => 'Element added successfully.',
            'result' => $element]
            , 200);
    }

    public function update(Request $request, $id) {
        $element = Note::find($id);

        if(!$this->isNameUnique($element->id, $request->input('parentId'), $request->input('name'))) {
            return response()->json(['message' => 'Name must be unique in folder.'], 422);
        }

        try {
            $this->createUpdateNote($request, $element);
        } catch (Exception $e) {
            return response()->json(['message' => 'Error : '.$e->getMessage()], $e->getCode());
        }

        return response()->json([
            'message' => 'Element updated successfully.',
            'result' => $element]
            , 200);
        
    }

    public function getParentTree(Request $request, $id) {
        $actual = Note::find($id);
        $parentTree = array();
        $rootReach = false;

        while(!$rootReach) {
            array_unshift($parentTree, $actual);
            if (!is_null($actual->parent_id)) {
                $actual = Note::find($actual->parent_id);
            } else {
                $rootReach = true;
            }
        }
        return response()->json($parentTree, 200);
    }

    public function remove(Request $request, $id) {
        Note::destroy($id); 
        return response()->json(['message' => 'Element removed successfully.'], 200);
    }

    public function getAll(Request $request) {
        return response()->json(Note::all(), 200);
    }

    public function getById(Request $request, $id) {
        return response()->json(Note::find($id), 200);
    }

    public function getRoot(Request $request) {
        return response()->json(Note::where('parent_id', NULL)->orderBy('updated_at', 'desc')->get(), 200);
    }
    public function getChildrens(Request $request, $id) {
        $parent = Note::find($id);
        if (Note::where('parent_id', $parent->id)->count() == 0) {
            $parent->has_children = false;
            $parent->save();
        }
        return response()->json($parent->children, 200);
    }

    public function search(Request $request) {
        if ($request->has('hasChildren')) {
            return response()->json(Note::where([
                ['name', 'LIKE', '%'.$request->input('name').'%'],
                ['has_children', '=', true]
            ])->first(), 200);
        }
        return response()->json(Note::where('name', 'LIKE', '%'.$request->input('name').'%')->get(), 200);
    }
}
