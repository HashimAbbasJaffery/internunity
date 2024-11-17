<?php

namespace App\Http\Controllers;

use App\Http\Requests\PortfolioCreateRequest;
use App\Models\Project;
use App\Services\File;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class PortfolioController extends Controller
{
    private $per_page = 15;
    public function get(Request $request) {
        $token = PersonalAccessToken::findToken($request->bearerToken());
        return $token->tokenable->projects()->orderBy("created_at", "DESC")->paginate($this->per_page);
    }
    public function store(PortfolioCreateRequest $request, File $file) {
        $token = PersonalAccessToken::findToken($request->bearerToken());
        $fileName = $file->upload($request->file("project_file"));
        $token->tokenable->projects()->create([ ...$request->validated(), "to" => now(), "from" => now(), "project_pic" => $fileName ]);
        return 1;
    }
    public function edit(PortfolioCreateRequest $request, Project $project, File $file) {
        $fileName = null;
        if($request->hasFile("project_file"))
            $fileName = $file->replace($project->project_pic, $request->file("project_file"));
        $project->update([ ...$request->validated(), "to" => now(), "from" => now(), "project_pic" => $fileName ?: $project->project_pic ]);
        return 1;
    }
    public function destroy(Project $project) {
        $project->delete();
        return 1;
    }
}
