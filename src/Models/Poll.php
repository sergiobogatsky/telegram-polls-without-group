<?php

namespace SergioBogatsky\TelegramPollsWithoutGroup\Models;

use Illuminate\Database\Eloquent\Model;
use SergioBogatsky\TelegramPollsWithoutGroup\Telegram;
use Illuminate\Http\Request;

class Poll extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @param $poll
     */
    public function storeQuestionsAndResponses($poll)
    {
        foreach ($poll['questions'] as $question) {
            //add and save questions
            $modelQuestion = $this->questions()->create($question);
            //add and save responses
            $modelQuestion->responses()->createMany($question['responses']);
        }
    }

    /**
     * Send poll with questions to all clients of the bot
     */
    public function sendPoll()
    {
        $clients = Client::all();

        foreach ($clients as $client) {

            //send poll
            Telegram::sendText($client->id_telegram, "<b>". $this->title . "</b>" . "\n" . $this->description);

            //send questions
            foreach ($this->questions as $question) {

                $responses = [];
                foreach ($question->responses as $response) {
                    $responses['{"question_id": "'. $question->id .'", "id": "'. $response->id .'"}'] = $response->text;
                }

                if ($question->type == 'multiple') {
                    $responses['{"question_id": "'. $question->id .'", "command": "finish"}'] = trans('polls::messages.finish question');
                }
                else if ($question->type == 'text') {
                    $responses['{"question_id": "'. $question->id .'", "command": "answer"}'] = trans('polls::messages.answer the question');
                }

                Telegram::sendInlineButtons($client->id_telegram, $responses, $question->text);
            }
        }
    }


    /**
     * @param Request $request
     * @return false|\Illuminate\Http\JsonResponse
     */
    static function checkAndSavePollAnswer (Request $request)
    {
        if ($request->has('message.text')) {
            try {
                $client = Client::where('id_telegram', $request->input('message.from.id'))->firstOrFail();
            }
            catch (\Exception $exception) {
                try {
                    return Telegram::sendText($request->input('message.from.id'), 'Error. It seems like no client found: ' . $exception->getMessage());
                }
                catch (\Exception $e) {
                    return Telegram::sendText($request->input('callback_query.from.id'), 'Error. It seems like no client found: '. $exception->getMessage());
                }
            }

            foreach ($client->responses as $response) {

                if ($response->question->type == 'text' && $response->text == 'waiting for response') {

                    $response->text = $request->input('message.text');
                    $response->save();
                    Telegram::deleteMessage($request->input('message.from.id'), $request->input('message.message_id'));
                    return Telegram::sendText($request->input('message.from.id'), trans('polls::messages.your answer to the poll question has been added'));
                }
            }
        }
        else if ($request->has('callback_query')) {
            $data = json_decode($request->input('callback_query.data'));
            //Telegram::sendText($request->input('callback_query.from.id'), $data);
            if ($data) {
                $question = Question::findOrFail($data->question_id);

                $type = $question->type;
                return $question->$type($request, $data);
            }
        }
        else {
            return false;
        }
    }
}
