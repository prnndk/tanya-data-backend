<?php

namespace App\Http\Controllers;

use App\Models\TalkDetail;
use App\Http\Requests\StoreTalkDetailRequest;
use App\Http\Requests\UpdateTalkDetailRequest;
use Illuminate\Http\JsonResponse;

class TalkDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTalkDetailRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(TalkDetail $talkDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TalkDetail $talkDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTalkDetailRequest $request, TalkDetail $talkDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TalkDetail $talkDetail)
    {
        //
    }
}
