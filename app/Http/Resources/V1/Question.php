<?php

namespace App\Http\Resources\V1;

use App\Http\Requests\ApiRequest;
use Illuminate\Http\Resources\Json\Resource;
use App\Question as ModelQuestion;

class Question extends Resource
{
    const ID = 'id';
    const USER_ID = 'user_id';
    const TITLE = 'title';
    const SLUG = 'slug';
    const DESCRIPTION = 'description';
    const FEATURED = 'featured';
    const STICKY = 'sticky';
    const SOLVED = 'solved';
    const UP_VOTE = 'up_vote';
    const DOWN_VOTE = 'down_vote';

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            self::ID => $this->{ModelQuestion::REFERENCE},
            self::USER_ID => $this->{ModelQuestion::USER_ID},
            self::TITLE => $this->{ModelQuestion::TITLE},
            self::SLUG => $this->{ModelQuestion::SLUG},
            self::DESCRIPTION => $this->{ModelQuestion::DESCRIPTION},
            $this->mergeWhen($request->query(ApiRequest::QUERY_PARAM_FIELDS) === ApiRequest::QUERY_PARAM_FIELDS_ALL, [
                self::FEATURED => $this->{ModelQuestion::FEATURED},
                self::STICKY => $this->{ModelQuestion::STICKY},
                self::SOLVED => $this->{ModelQuestion::SOLVED},
                self::UP_VOTE => $this->{ModelQuestion::UP_VOTE},
                self::DOWN_VOTE => $this->{ModelQuestion::DOWN_VOTE},
            ]),
            'answers' => Answer::collection($this->whenLoaded(ModelQuestion::RELATION_ANSWERS)),
            'user' => new User($this->whenLoaded(ModelQuestion::RELATION_USER)),
            'tags' => Tag::collection($this->whenLoaded(ModelQuestion::RELATION_TAGS)),
        ];
    }
}