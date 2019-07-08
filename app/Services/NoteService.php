<?php

namespace App\Services;

use App\Note;
use App\Http\Resources\NoteResource as NoteResource;
use Validator;

class NoteService
{
    public function findAll()
    {
        return Note::all();
    }

    public function findById($id)
    {
        return Note::findOrFail($id);
    }
 
    public function update($noteSpec, $id)
    {
        Note::whereId($id)->update($noteSpec);
    }

    public function delete($id)
    {
        $note = Note::findOrFail($id);
        $note -> delete();
    }
    
    public function create($noteSpec, $loggedUser){
        $note = new Note;

        $validator = Validator::make($noteSpec->all(), [ 
            'name' => 'required', 
            'note' => 'required' 
        ]);

        if ($validator->fails()) {           
            return $validator;
        }

        $note->name = $noteSpec->name;
        $note->note = $noteSpec->note;
        $note->owner = $loggedUser['id'];

        $note->save();

        return $note;
        
    }
}
