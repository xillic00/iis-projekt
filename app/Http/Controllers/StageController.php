<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StageController extends Controller {

    public function add($festivalId)
    {
        return view('stage.add', compact('festivalId'));
    }

    public function sent(Request $data, int $festivalId)
    {
        $data = $data->validate(['name' => 'required|string|max:255']);
        $data['festivalId'] = $festivalId;
        iisStageRepository()->insertGetId($data);

        return redirect(route('festival.show', $festivalId));
    }

    public function editForm($festivalId, $stageId)
    {
        $stageItem = iisStageRepository()->getItemById($stageId);
        return view('stage.edit', compact('festivalId', 'stageItem'));
    }

    public function edit(Request $data, $festivalId, $stageId)
    {
        $data = $data->validate(['name' => 'required|string|max:255']);
        $data['festivalId'] = $festivalId;
        if(iisStageRepository()->getItemById($stageId)) {
            iisStageRepository()->updateById($data, $stageId);
        }
        return redirect(route('festival.show', $festivalId));
    }

    public function delete($festivalId, $stageId)
    {
        iisInterpretAtStageRepository()->deleteByStageId($stageId);
        iisStageRepository()->deleteById($stageId);
        return redirect(route('festival.show', $festivalId));
    }

    public function addInterpret($festivalId, $stageId)
    {
        $interpretItems = iisInterpretRepository()->getAllItems();

        return view('stage.addInterpret', compact('festivalId', 'stageId', 'interpretItems'));
    }

    public function sentInterpret(Request $data, int $festivalId, int $stageId)
    {
        $data = $this->addInterpretValidator($data);
        $data['stageId'] = $stageId;
        if (iisStageRepository()->getItemById($stageId) && iisConcertRepository()->getItemById($data['interpretId']))
        {
            iisInterpretAtStageRepository()->insertGetId($data);
        }
        return redirect(route('festival.show', $festivalId));
    }

    public function deleteInterpret(int $festivalId, int $stageId, int $stageInterpretId)
    {
        iisInterpretAtStageRepository()->deleteById($stageInterpretId);
        return redirect(route('festival.show', $festivalId));
    }

    protected function addInterpretValidator(Request $data)
    {
        return $data->validate([
            'interpretId' => 'required|integer',
            'date'        => 'required|date',
        ]);
    }
}
