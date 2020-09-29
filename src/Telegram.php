<?php


namespace SergioBogatsky\TelegramPollsWithoutGroup;


use phpDocumentor\Reflection\Types\Self_;

class Telegram
{
    protected const telegramBotToken = 'services.telegram.general-telegram-bot-token';

    //https://api.telegram.org/bot652175166:AAHvH7FRcfLYHVU91KbSD2KPf15IIrUEzWM/setWebhook?url=https://20f5a525076c.ngrok.io/api/polls/test //ariste464366834

    /**
     * @param $telegramId
     * @param $postfields
     * @return \Illuminate\Http\JsonResponse
     */
    public static function sendMessage ($telegramId, $postfields)
    {
        $postfields['chat_id'] = $telegramId;
        return self::sendCurl(
            $postfields,
            'https://api.telegram.org/bot'.config(self::telegramBotToken).'/sendMessage'
        );
    }

    /**
     * @param $telegramId
     * @param $text
     * @return \Illuminate\Http\JsonResponse
     */
    public static function sendText ($telegramId, $text)
    {
        $postfields = array(
            'chat_id' => "$telegramId",
            'parse_mode'=> 'HTML',
            'text' => "$text",
        );

        return self::sendCurl(
            $postfields,
            'https://api.telegram.org/bot'.config(self::telegramBotToken).'/sendMessage'
        );
    }


    /**
     * @param $telegramId
     * @param $arrayTextButtons
     * @param $text
     * @return \Illuminate\Http\JsonResponse
     */
    public static function sendButtons ($telegramId, $arrayTextButtons, $text)
    {
        $buttons = [];

        //how many buttons in one line:
        $columns = 2;

        foreach ($arrayTextButtons as $textButton) {
            // at the moment we do it without the links and without the second part
            //counting the last position of array:
            if (empty($buttons)) {
                $buttons[] = [['text'=>$textButton]];
            }
            else if (count($buttons[count($buttons) - 1]) == $columns-1) {
                array_push($buttons[count($buttons) - 1], ['text'=>$textButton]);
            }
            else {
                $buttons[] = [['text'=>$textButton]];
            }
        }

        $keyboard = array(
            "keyboard" => $buttons,
            "one_time_keyboard" => true,
            "resize_keyboard" => true
        );

        $postfields = array(
            'chat_id' => "$telegramId",
            'text' => "$text",
            'reply_markup' => json_encode($keyboard)
        );

        return self::sendCurl(
            $postfields,
            'https://api.telegram.org/bot'.config(self::telegramBotToken).'/sendMessage'
        );
    }


    /**
     * @param $telegramId
     * @param $arrayTextButtons
     * @param $text
     * @param string $callback_data
     * @return \Illuminate\Http\JsonResponse
     */
    public static function sendInlineButtons ($telegramId, $arrayTextButtons, $text, $callback_data = 'callback_data')
    {
        $buttons = [];

        //how many buttons in one line:
        $columns = 2;

        foreach ($arrayTextButtons as $key => $value) {
            if (empty($buttons)) {
                $buttons[] = [['text'=>$value, $callback_data=>$key]];
            }
            //counting the last position of array:
            else if (count($buttons[count($buttons) - 1]) == $columns-1) {
                array_push($buttons[count($buttons) - 1], ['text'=>$value, $callback_data=>$key]);
            }
            else {
                $buttons[] = [['text'=>$value, $callback_data=>$key]];
            }
        }

        $keyboard = array(
            "inline_keyboard" => $buttons
        );

        $postfields = array(
            'chat_id' => "$telegramId",
            'text' => "$text",
            "parse_mode" => "HTML",
            'reply_markup' => json_encode($keyboard)
        );

        return self::sendCurl(
            $postfields,
            'https://api.telegram.org/bot'.config(self::telegramBotToken).'/sendMessage'
        );
    }

    /**
     * @param $fileId
     * @return string
     */
    public static function getFileUrl ($fileId)
    {
        //we get the file information
        $json_file = file_get_contents("https://api.telegram.org/bot" . config(self::telegramBotToken) . "/getFile?file_id=" . $fileId);
        $array_file = json_decode($json_file, true);

        //we get the route where the photo is
        $rute_file = $array_file['result']['file_path'];

        //we compose the complete url of our photo
        $file_path = 'https://api.telegram.org/file/bot' . config(self::telegramBotToken) . '/' . $rute_file;

        return $file_path;
    }

    /**
     * @param $telegramId
     * @param $question
     * @param $options
     * @return \Illuminate\Http\JsonResponse
     */
    public static function sendPoll ($telegramId, $question, $options)
    {
        $postfields = array(
            'chat_id' => "$telegramId",
            'question' => "$question",
            'is_anonymous' => false,
            'options' => json_encode($options),
        );

        return self::sendCurl(
            $postfields,
            'https://api.telegram.org/bot'.config(self::telegramBotToken).'/sendPoll'
        );
    }

    /**
     * @param $chatId
     * @param $messageId
     * @return \Illuminate\Http\JsonResponse
     */
    public static function deleteMessage ($chatId, $messageId)
    {

        $postfields = array(
            'chat_id' => $chatId,
            'message_id' => $messageId,
        );

        return self::sendCurl(
            $postfields,
            'https://api.telegram.org/bot'.config(self::telegramBotToken).'/deleteMessage'
        );
    }

    /**
     * @param $postfields
     * @param $url
     * @return \Illuminate\Http\JsonResponse
     */
    public static function sendCurl ($postfields, $url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec ($ch);
        $httpcode = curl_getinfo($ch)['http_code'];
        curl_close ($ch);
        return response()->json($data, $httpcode);
    }

}
