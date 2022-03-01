<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\ModelNotFoundException;

class ApiCandidate extends Model
{
    use HasFactory;

    protected $table="candidate";

    /**
     * @return Candidate[]\Illuminate\Database\Eloquent\Collection
     * 
     */
    public function getsCandidates()
    {
        $candidates = $this::all();
        return $candidates;
    }

}
