<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Candidate;


class CandidateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct()
    {
        $this->middleware('permission:candidate-list|candidate-create|candidate-edit|candidate-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:candidate-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:candidate-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:candidate-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $candidates = Candidate::latest()->paginate(5);
        return view('candidate.index', compact('candidates'))
               ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('candidate.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $edu = ['SMU', 'Associate Degree', 'Bachelor\'s Degree', 'Masters Degree', 'Doctorate'];
        $request->validate([
            'name' => ['required'], 
            'education' => ['required', Rule::in($edu)],
            'birthday'  => ['required',['date']],
            'experience' => ['required', 'numeric','min:1','max:15'],
            'last_position' => ['required'],
            'applied_position' => ['required'],
            'skils' => ['required'],
            'email' => ['required', 'unique:candidate'],
            'phone' => ['required', 'numeric', 'digits_between:10,12', 'unique:candidate'],
            'resume' => ['required', 'mimes:pdf', 'max:2048'],
        ]);

        $input = $request->all();

        if ($resume = $request->file('resume')) {
            $destinationPath = 'resume/';
            $resumeFile = date('YmdHis') . "." .$resume->getClientOriginalExtension();
            $resume->move($destinationPath, $resumeFile);
            $input['resume'] ="$resumeFile";   
        }

        Candidate::create($input);
        
        return redirect()->route('candidate.index')
               ->with('success', 'New Candidate has been successfully added.');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $candidates = Candidate::findOrFail($id);
        return view('candidate.show', compact('candidates'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $candidates = Candidate::findOrFail($id);
        return view('candidate.edit', compact('candidates'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $edu = ['SMU', 'Associate Degree', 'Bachelor\'s Degree', 'Masters Degree', 'Doctorate'];

        $request->validate([
            'name' => ['required'], 
            'education' => ['required', Rule::in($edu)],
            'birthday'  => ['required'],
            'experience' => ['required', 'numeric','min:1','max:15'],
            'last_position' => ['required'],
            'applied_position' => ['required'],
            'skils' => ['required'],
            'email' => ['required', Rule::unique('candidate')->ignore($id)],
            'phone' => ['required', 'numeric', 'digits_between:10,12', Rule::unique('candidate')->ignore($id)],
            'resume' => ['mimes:pdf', 'max:2048'],
        ]);

        $input = $request->all();
        if ($resume = $request->file('resume')) {
            $destinationPath = 'resume/';
            $resumeFile = date('YmdHis') . "." .$resume->getClientOriginalExtension();
            $resume->move($destinationPath, $resumeFile);
            $input['resume'] ="$resumeFile";   
        }else{
            unset($input['resume']);
        }

        $candidate =Candidate::findOrFail($id);
        $candidate->update($input);

        return redirect()->route('candidate.index')
               ->with('success', 'Candidate '.$input['name'].' has been successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $candidate = Candidate::findOrFail($id);
        unlink('resume/'.$candidate->resume);
        $candidate->delete();
        return redirect()->route('candidate.index')
               ->with('success', 'Record has been remove');
    }
}
