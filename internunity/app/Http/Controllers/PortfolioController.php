<?php

namespace App\Http\Controllers;

use App\Http\Requests\PortfolioCreateRequest;
use App\Models\Project;
use App\Services\File;

class PortfolioController extends Controller
{
    private $per_page = 15;
    protected $user;
    protected $user_service;
    public function __construct(\App\Models\User $user) {
        $this->user = $user->getUser();
        $this->user_service = $user;
    }
    public function get(): mixed {
        if(request()->user) {
            return Project::where("user_id",request()->user)->orderBy("created_at", "DESC")->paginate($this->per_page)->withQueryString();
        }
        return $this->user->projects()->orderBy("created_at", "DESC")->paginate($this->per_page);
    }
    public function store(PortfolioCreateRequest $request, File $file) {
        $fileName = $file->upload($request->file("project_file"));
        $this->user->projects()->create([ ...$request->validated(), "to" => now(), "from" => now(), "project_pic" => $fileName ]);
        return 1;
    }
    public function edit(PortfolioCreateRequest $request, Project $project, File $file) {
        if(!$this->user_service->isOwnerOf($project)) abort(403);

        $fileName = null;
        if($request->hasFile("project_file"))
            $fileName = $file->replace($project->project_pic, $request->file("project_file"));
        $project->update([ ...$request->validated(), "to" => now(), "from" => now(), "project_pic" => $fileName ?: $project->project_pic ]);
        return 1;
    }
    public function destroy(Project $project) {
        if(!$this->user_service->isOwnerOf($project)) abort(403);
        $project->delete();
        return 1;
    }
}
