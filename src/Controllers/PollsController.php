<?php

namespace SergioBogatsky\TelegramPollsWithoutGroup\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use SergioBogatsky\TelegramPollsWithoutGroup\Models\Poll;

class PollsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     *
     */
    public function index()
    {
        $polls = Poll::all()->load('questions');

        return response()->json($polls, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'poll.title' => 'required|max:255',
            'poll.description' => 'required|max:255',
            'poll.questions.*.text' => 'required|max:255',
            'poll.questions.*.type' => 'in:unique,multiple,text,sort|required',
            'poll.questions.*.responses' => 'required_unless:poll.questions.*.type,text',
            'poll.questions.*.responses.*.text' => 'required_unless:poll.questions.*.type,text|max:255',
            'poll.questions.*.responses.*.callback_data' => 'required_unless:poll.questions.*.type,text|max:255',
        ]);

        $poll = Poll::create($request->poll);

        $poll->storeQuestionsAndResponses($request->poll);

        $poll->sendPoll();

        return response()->json([
            'message'=> 'poll created and sent',
            'id' => $poll->id
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $poll = Poll::find($id)->load(['questions' => function ($query) {
            $query->with(['responses' => function ($query) {
                $query->with('clients');
            }, 'clients']);
        }]);
        return response()->json($poll, 200);
    }

    /**
     * Test API for the polls
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function test (Request $request)
    {
        Poll::checkAndSavePollAnswer($request);

        return response('ok', 200);
    }

}
