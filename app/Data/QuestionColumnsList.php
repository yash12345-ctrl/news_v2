<?php

namespace App\Data;

/**
 * QuestionColumnsList
 */
class QuestionColumnsList
{
	const REQUIRED_COLUMN_INDICES = [
        0 => "question",
        1 => "set_number",
        2 => "point",
        3 => "question_time",
        12 => "correct_option",
        "question"       => 0,
        "set_number"     => 1,
        "point"     => 2,
        "question_time"     => 3,
        "correct_option" => 12,
    ];

    const OPTIONAL_COLUMN_INDICES = [
        4 => "option_1",
        5 => "option_2",
        6 => "option_3",
        7 => "option_4",
        8 => "option_5",
        9 => "option_6",
        10 => "option_7",
        11 => "option_8",
        "option_1"       => 4,
        "option_2"       => 5,
        "option_3"       => 6,
        "option_4"       => 7,
        "option_5"       => 8,
        "option_6"       => 9,
        "option_7"       => 10,
        "option_8"       => 11,
    ];
}