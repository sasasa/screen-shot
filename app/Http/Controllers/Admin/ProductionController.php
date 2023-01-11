<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProductionRequest;
use App\Models\Production;
use Illuminate\Http\Request;

class ProductionController extends Controller
{
    public function index()
    {
        return view('admin.production.index', [
            'productions' => Production::query()->withTrashed()->withCount('sites', 'inquiries')->latest()->paginate(10),
        ]);
    }

    public function edit(Production $production)
    {
        return view('admin.production.edit', compact('production'));
    }

    public function update(UpdateProductionRequest $request, Production $production)
    {
        $production->fill($request->validated());
        $production->save();
        return redirect()->route('system_admin.productions.index')->with([
            'status' => "success",
            'message' => "{$production->name} を修正しました。",
        ]);
    }

    public function restore(int $id)
    {
        // 論理削除されたレコードを復元する
        $production = Production::withTrashed()->find($id);
        $production->restore();
        return redirect()->route('system_admin.productions.index')->with([
            'status' => "success",
            'message' => "{$production->name} を復元しました。",
        ]);
    }

    public function destroy(Production $production)
    {
        $production->delete();

        return redirect()->route('system_admin.productions.index')->with([
            'status' => "success",
            'message' => "{$production->name} を削除しました。",
        ]);
    }
}
