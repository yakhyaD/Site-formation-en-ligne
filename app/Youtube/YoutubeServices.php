<?php

namespace App\Youtube;

use DateInterval;
use Illuminate\Support\Facades\Http;

use function PHPUnit\Framework\matches;

class YoutubeServices {

    private $key = null;

    public function __construct(string $key)
    {
        $this->key = $key;
    }

    public function handleYoutubeVideoDuration(string $video_url): ?int
    {
        //recuperer l'id de la video
        preg_match('/embed\/(.+)/', $video_url, $matches);

        $id = $matches[1];

        //appeler l'api de youtube
        $response = Http::get("https://www.googleapis.com/youtube/v3/videos?key={$this->key}&id={$id}&part=contentDetails");


        $duration = (json_decode($response))->items[0]->contentDetails->duration;

        //convertir la duree en secondes
        $interval = new DateInterval($duration);

        return ($interval->s + $interval->i * 60 + $interval->h *3600);
    }
}


//https://www.googleapis.com/youtube/v3
