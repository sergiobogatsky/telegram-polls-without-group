<?php

namespace SergioBogatsky\TelegramPollsWithoutGroup\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use SergioBogatsky\TelegramPollsWithoutGroup\Telegram;
use Illuminate\Database\Eloquent\Builder;

class Question extends Model
{
    protected $fillable = [
        'poll_id',
        'text',
        'type'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(Poll::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function responses()
    {
        return $this->hasMany(Response::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function clients()
    {
        return $this->belongsToMany(Client::class)->withTimestamps();
    }

    /**
     * Unique response for the question
     * @param Request $request
     * @param $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function unique(Request $request, $data)
    {
        $response = Response::findOrFail($data->id);
        $response->total = $response->total + 1;
        $response->save();

        $client = Client::where('id_telegram', $request->input('callback_query.from.id'))->first();
        $client->responses()->syncWithoutDetaching($response->id);

        Telegram::sendText($request->input('callback_query.from.id'), trans('polls::messages.your response has been added'));
        return Telegram::deleteMessage($request->input('callback_query.message.chat.id'), $request->input('callback_query.message.message_id'));
    }

    /**
     * Multiple response for the question
     * @param Request $request
     * @param $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function multiple(Request $request, $data)
    {
        if (property_exists($data, 'command')) {

            Telegram::sendText($request->input('callback_query.from.id'), trans('polls::messages.multiple answers have been added'));
            return Telegram::deleteMessage($request->input('callback_query.message.chat.id'), $request->input('callback_query.message.message_id'));
        }
        else {

            $client = Client::where('id_telegram', $request->input('callback_query.from.id'))->first();

            foreach ($client->responses as $response) {
                if ($response->id == $data->id) {
                    return Telegram::sendText($request->input('callback_query.from.id'), trans('polls::messages.response already have been added'));
                }
            }

            $response = Response::findOrFail($data->id);
            $response->total = $response->total + 1;
            $response->save();

            $client->questions()->syncWithoutDetaching($data->question_id);
            $client->responses()->syncWithoutDetaching($response->id);
            return Telegram::sendText($request->input('callback_query.from.id'), trans('polls::messages.response added'));
        }
    }

    /**
     * Only text response for the question
     * @param Request $request
     * @param $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function text(Request $request, $data)
    {
        if (property_exists($data, 'command')) {
            $question = Question::findOrFail($data->question_id);

            $response = $question->responses()->create([
                'text' => 'waiting for response',
                'callback_data' => 'waiting for response' //dont change it
            ]);

            $client = Client::where('id_telegram', $request->input('callback_query.from.id'))->first();
            $client->responses()->syncWithoutDetaching($response->id);

            Telegram::deleteMessage($request->input('callback_query.message.chat.id'), $request->input('callback_query.message.message_id'));
            return Telegram::sendText($request->input('callback_query.from.id'), trans('polls::messages.write the response below: '));
        }
    }

    /**
     * Sort response for the question
     * @param Request $request
     * @param $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function sort(Request $request, $data)
    {
        $question = Question::withCount('responses')->findOrFail($data->question_id);

        $client = Client::withCount(['responses' => function (Builder $query) use ($question) {
            $query->where('question_id', $question->id);
        }])->where('id_telegram', $request->input('callback_query.from.id'))->first();

        if ($question->responses_count > $client->responses_count) {

            $response = Response::findOrFail($data->id);

            if ($client->responses->contains($response)) {

                return Telegram::sendText($request->input('callback_query.from.id'), trans('polls::messages.you have already added this position'));
            }
            else {

                $response->total = $response->total + 1;
                $response->save();
                $client->questions()->syncWithoutDetaching($data->question_id);
                $client->responses()->syncWithoutDetaching([$response->id => ['sort_position' => $client->responses_count + 1]]);

                if ($question->responses_count == $client->responses_count + 1) {

                    Telegram::deleteMessage($request->input('callback_query.message.chat.id'), $request->input('callback_query.message.message_id'));
                    return Telegram::sendText($request->input('callback_query.from.id'), trans('polls::messages.sort question resolved'));
                }
                else {

                    return Telegram::sendText($request->input('callback_query.from.id'), trans('polls::messages.position :position to sort added', ['position' => $client->responses_count + 1]));
                }
            }
        }
    }
}
